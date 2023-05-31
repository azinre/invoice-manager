<?php 
require "data.php";
require "functions.php";
//require "index.php";
//session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD']=== 'POST'){
    $client = $_POST['client'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];

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

    if (empty($errors)) {
        array_push($invoices, [
            'number' => generateInvoiceNumber(),
            'client' => $client,
            'email' => $email,
            'amount' => $amount,
            'status' => $status
        ]);
        
        $_SESSION['invoices'] = $invoices;
        header("Location: index.php");
        exit();
    }

}

// $formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
// $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];

// // Clear the session variables
// unset($_SESSION['form_data']);
// unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Add Invoice</title>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    </div>
    <ul class="nav navbar-nav">
    <?php foreach ($statuses as $status): ?>
      <li class="active">
          <?php if($status ==='all'): ?>
              <a class="nav-link" href="index.php">All Invoices</a>             
          <?php else :?>           
           <a class="nav-link" href='index.php?status=<?php echo "$status.php"?>'><?php echo ucfirst($status); ?></a>
           <?php endif; ?>        
        </li>        
        <?php endforeach; ?> 
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="add.php"><span class="glyphicon glyphicon-user"></span> Add invoices</a></li>
    </ul>
  </div>
</nav>
<h1>Add Invoice</h1>
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form action="add.php" method="post">                       
    <label for="client">Client Name:</label>
    <input type="text" id="client" name="client" value="<?php echo isset($_POST['client']) ? $_POST['client'] : ''; ?>"><br><br>
    <label for="email">Client Email:</label>
    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br><br>
    <label for="amount">Invoice Amount:</label>
    <input type="number" id="amount" name="amount" step="0.01" value="<?php echo isset($_POST['amount']) ? $_POST['amount'] : ''; ?>"><br><br>
    <label for="status">Invoice Status:</label>
    <select id="status" name="status">
        <option value="" selected>Select a Status</option>
        <?php foreach ($statuses as $statusOption): ?>
            <?php if ($statusOption !== 'all'): ?>
                <?php if ($statusOption === $_POST['status']): ?>
                    <option value="<?php echo $statusOption; ?>" selected><?php echo $statusOption; ?></option>
                <?php else: ?>
                    <option value="<?php echo $statusOption; ?>"><?php echo $statusOption; ?></option>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </select><br><br>
    <button type="submit">Add Invoice</button>
</form> 
<script src="path/to/bootstrap.min.js"></script>   
</body>
</html>