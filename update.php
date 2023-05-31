<?php
session_start();
require "data.php";

// Get the invoice number from the query string
$invoiceNumber = $_GET['invoice_number'] ?? '';

// Find the invoice by its number
$invoice = null;
foreach ($invoices as $inv) {
    if ($inv['number'] === $invoiceNumber) {
        $invoice = $inv;
        break;
    }
}

// Redirect back to index.php if the invoice is not found
if (!$invoice) {
    header("Location: index.php");
    exit;
}

// Update the invoice if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform validation here

    // Update the invoice data
    $invoice['client'] = $_POST['client'];
    $invoice['email'] = $_POST['email'];
    $invoice['amount'] = $_POST['amount'];
    $invoice['status'] = $_POST['status'];

    // Update the invoice in the $invoices array
    foreach ($invoices as &$inv) {
        if ($inv['number'] === $invoiceNumber) {
            $inv = $invoice;
            break;
        }
    }

    // Update the invoices in the session
    $_SESSION['invoices'] = $invoices;

    // Redirect back to index.php
    header("Location: index.php");
    exit;
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
    <h1>Update Invoice</h1>

    <form action="" method="post">
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

        <button type="submit">Update Invoice</button>
    </form>
    <form class = "form" method="post" action="delete.php">
          <input type="hidden" name="number" value="<?php $invoice['number']; ?>">
          <button class="button danger"> Delete Button</button>
    </form>
</body>
</html>
