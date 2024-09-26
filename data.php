<?php 
   
   $dsn = "mysql:host=localhost;dbname=invoice_manager";
   $username = "root";
   $password = "";

   try {
       $db = new PDO($dsn, $username, $password);
   } catch (PDOException $e) {
       $error_message = $e->getMessage();
       echo "Error connecting to database: $error_message";
       exit();
   }

  $sql = "SELECT * FROM invoices INNER JOIN statuses ON invoices.status_id = statuses.id";
  $result = $db->query($sql);
  $invoices = $result->fetchAll();

  $sql = "SELECT status FROM statuses";
  $result = $db->query($sql);
  $statusesArr = $result->fetchAll();
  $statuses = [];
  foreach ($statusesArr as $status) {
    $statuses[] = $status['status'];
  }
  

