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
  
  if (!function_exists('sanitize')){
  function sanitize($data) {
    return array_map(function ($value) {
      return htmlspecialchars(stripslashes(trim($value)));
    }, $data);
  }
}


  $status = '';
  if (isset($_GET['status'])) {
      $status = $_GET['status'];
      $_SESSION['status'] = $status;
  } else {
      if (isset($_SESSION['status'])) {
          $status = $_SESSION['status'];
      }
  }

  if (!function_exists('id_match')){
  function id_match($status) {
    switch ($status) {
        case 'draft':
            $id = 1;
            break;
        case 'pending':
            $id = 2;
            break;
        case 'paid':
            $id = 3;
            break;
        default:
            $id = 0; 
            break;
    }
    
    return $id;
}}