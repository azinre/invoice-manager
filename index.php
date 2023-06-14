<?php 
session_start();
require "data.php";

$pageTitle= 'All Invoices';
$page ='all';

if (!isset($_SESSION['invoices'])) {
    $_SESSION['invoices'] = []; 
}

if (isset($_GET['status'])){        
  if ($_GET['status'] != 'all') {
      $invoices = array_filter($invoices, function($invoice){
          return $invoice['status'] == lcfirst($_GET['status']);        
      });
  };        
};



if (isset($_GET['status'])) {
    switch ($_GET['status']) {
      case "draft.php":
        $page = 'draft';
        $pageTitle='draft Invoices';
        break;
      case "pending.php":
        $page='pending';
        $pageTitle='pending Invoices';
        break;
      case "paid.php":
        $page = 'paid';
        $pageTitle='paid Invoices';
        break;
    }
}

if(isset($_POST['status'])){
      //var_dump($_POST);
      //var_dump($_SERVER['REQUEST_METHOD']);
      //var_dump($errors);
    array_push($invoices,[
        'number' => generateInvoiceNumber(),
        'client' => $_POST['client'],
        'email' => $_POST['email'],
        'amount' => $_POST['amount'],
        'status' => $_POST['status']
    ]);

    $_SESSION['invoices'] = $invoices;

}

if(isset($_POST['number'])){
  $number = $_POST['number'];
  $sql = 'DELETE FROM invoices WHERE number = :number';
  $stmt = $db->prepare($sql);
  $stmt->execute([':number' => $number]);
  header("Location: index.php?status=" . $status);
}

 $invoices = $_SESSION['invoices'];
 //$invoices = isset($_SESSION['invoices']) ? $_SESSION['invoices'] : [];
include "template.php"



?>
