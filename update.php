<?php
//session_start();
require "data.php";
require "functions.php";

$invoiceNumber = $_GET['invoice_number'] ?? '';

$invoice = null;
foreach ($invoices as $inv) {
    if ($inv['number'] === $invoiceNumber) {
        $invoice = $inv;
        break;
    }
}

if (!$invoice) {
    header("Location: index.php");
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];
    $client = $_POST['client'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];
    $text = isset($_FILES['text']) ? $_FILES['text'] : null;

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileExt = (pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        
    }

    if (empty($client)){
        $errors[] = 'Client name is required.';
    }elseif(!preg_match('/^[a-zA-Z ]+$/', $client)) {
        $errors[] = 'Client Name should only contain letters and spaces.';
    } elseif (strlen($client) > 255) {
        $errors[] = 'Client Name cannot be more than 255 characters.';
    }


    if (empty($email)) {
        $errors[] = 'Client Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Client Email is not a valid email address.';
    }


    if (empty($amount)) {
        $errors[] = 'Invoice Amount is required.';
    } elseif (!is_numeric($amount)) {
        $errors[] = 'Invoice Amount must be a number.';
    }


    if (empty($status)) {
        $errors[] = 'Invoice Status is required.';
    } elseif (!in_array($status, ['draft', 'pending', 'paid'])) {
        $errors[] = 'Invalid Invoice Status.';
    }

    if (empty($errors))
     {
        $status_id = id_match($status);
        foreach ($invoices as &$inv) {
            if ($inv['number'] === $invoiceNumber) {
                $inv['client'] = $client;
                $inv['email'] = $email;
                $inv['amount'] = $amount;
                $inv['status'] = $status;
                break;
            }
        }    
    //$_SESSION['invoices'] = $invoices;
    
    $sql = 'UPDATE invoices SET client = :client, amount = :amount, status_id = :status_id, email = :email WHERE number = :number';
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':client' => $client,
        ':amount' => $amount,
        ':status_id' => $status_id,
        ':email' => $email,
        ':number' => $invoiceNumber
    ]);
    $textFileName = saveText($invoiceNumber, $text);
    if ($status == 'all') {
        header("Location: index.php");
    } else {
        header("Location: index.php?status=" . $status);
    }
    
    exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Update Invoice</title>
</head>
<body>
    <nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
        </div>
        <ul class="nav navbar-nav">    
            <li class="active"><a class="nav-link" href="index.php?status=all">All</a></li>                     
            <?php foreach ($statuses as $status): ?>   
                <li><a class="nav-link" href='index.php?status=<?php echo "$status.php"?>'><?php echo ucfirst($status); ?></a></li>        
            <?php endforeach; ?> 
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="add.php"><span class="glyphicon glyphicon-user"></span> Add invoices</a></li>
        </ul>
    </div>
    </nav>
    <h1>Update Invoice</h1>
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <<form class="form" method="post" enctype="multipart/form-data">
        <label for="client">Client Name:</label>
        <input type="text" id="client" name="client" value="<?php echo $invoice['client']; ?>"><br><br>

        <label for="email">Client Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $invoice['email']; ?>"><br><br>

        <label for="amount">Invoice Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" value="<?php echo $invoice['amount']; ?>"><br><br>

        <label for="status">Invoice Status:</label>
        <select id="status" name="status">
            <option value="draft" <?php if ($invoice['status'] === 'draft') echo 'selected'; ?>>Draft</option>
            <option value="pending" <?php if ($invoice['status'] === 'pending') echo 'selected'; ?>>Pending</option>
            <option value="paid" <?php if ($invoice['status'] === 'paid') echo 'selected'; ?>>Paid</option>
        </select><br><br>
        <label for="text">Upload file (PDF only):</label>
       
        <input type="file" id="text" name="text" accept=".pdf" multiple><br><br>
       
        <button type="submit">Update Invoice</button>
    </form>
    
    <form class = "form" method="post" action="delete.php">
        <input type="hidden" name="number" value="<?php echo $invoice['number']; ?>">
        <button class="button danger"> Delete </button>
    </form>
</body>
</html>
