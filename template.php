<?php 
require "data.php";
//session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <title><?php echo $pageTitle; ?></title>
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
<!-- <p>"there are <?php  echo count($invoices)?>"</p> -->
<h1><?php echo $pageTitle; ?></h1>  
<div class="container">
 <table class="table table-hover">
  <tr>
    <th>number</th>
    <th>amount</th>
    <th>status</th>
    <th>client</th>
    <th>email</th>
  </tr>
<?php  $condition= array_filter($invoices, fn($invoice) => $invoice['status'] === $page)?>
<?php if($page === "all"){
  $condition = $invoices;
  }?>
  <?php foreach($condition as $invoice): ?>
   
    <tr>
        <td> <?php echo  $invoice['number']; ?> </td>
        <td> <?php echo  $invoice['amount']; ?> </td>
        <td> <?php echo  $invoice['status']; ?> </td>
        <td> <?php echo  $invoice['client']; ?> </td>
        <td> <?php echo  $invoice['email']; ?> </td>
        <td>
        <td>
          <a href="update.php?invoice_number=<?php echo $invoice['number']; ?>">Edit</a>
        </td>
        <td>
          <form method="post" action="index.php">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="number" value="<?php echo $invoice['number']; ?>">
              <button type="submit" class="delete-button">Delete</button>
          </form>
        </td>
    </tr>
  <?php endforeach; ?>
  
</table>

</body>
</html>