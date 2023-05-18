<?php 
require "data.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">  
      <ul class="navbar-nav">        
        <?php foreach ($statuses as $status): ?>
        <li class="nav-item">
          <?php if($status ==='all'): ?>
              <a class="nav-link" href="index.php">All</a>             
          <?php else :?>           
           <a class="nav-link" href='<?php echo "$status.php"?>'><?php echo ucfirst($status); ?></a>
           <?php endif; ?>
        </li>
        <?php endforeach; ?>                    
      </ul>      
    </div>
  </div>
</nav>
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
  </tr>
  <?php endforeach; ?>
</table>

</body>
</html>