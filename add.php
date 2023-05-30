<?php 
require "data.php";
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

    <h1></h1>
    <form action="index.php" method="post">
        <label for="client">Client Name:</label>
        <input type="text" id="client" name="client" ><br><br>
        
        <label for="email">Client Email:</label>
        <input type="email" id="email" name="email" ><br><br>

        <label for="amount">Invoice Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" ><br><br>

        <label for="status">Invoice Status:</label>
        <select id="status" name="status" >
            <option value="">Select a Status</option>
            <?php foreach($statuses as $status): ?>
            <option value="<?php echo $status ; ?>">
            <?php echo $status?>
              </option>
            <?php endforeach; ?>
        </select><br><br>
        <button type="submit">Add Invoice</button>
    </form>
    
</body>
</html>