<?php 

// session_start();
require "data.php";


$pageTitle= 'All Invoices';
$page ='all';

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
    array_push($invoices,[
        'number' => generateInvoiceNumber(),
        'client' => $_POST['client'],
        'email' => $_POST['email'],
        'amount' => $_POST['amount'],
        'status' => $_POST['status']
    ]);

    $_SESSION['invoices'] = $invoices;

}





// if (isset($_SESSION['invoices'])) {
//     $_SESSION['invoices'] = array(); 
// }

// $invoices = $_SESSION['invoices'];
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
//     $client = $_POST['client'];
//     $email = $_POST['email'];
//     $amount = $_POST['amount'];
//     $status = $_POST['status'];

//     $newInvoice = array(
//         'number' => generateInvoiceNumber(),
//         'amount' => $amount,
//         'status' => $status,
//         'client' => $client,
//         'email' => $email
//     );
//     $_SESSION['invoices'][] = $newInvoice;

//     header('Location: index.php?status=' . $status);
//     exit;
// }



function generateInvoiceNumber(){
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lenghth = 5;
    $number = '';
    for($i= 1; $i<$lenghth; $i++ ){
        $number .= $characters[rand(0, strlen($characters) - 1)];
    
    }
    return ($number);
}
 //$invoices = $_SESSION['invoices'];
$invoices = isset($_SESSION['invoices']) ? $_SESSION['invoices'] : [];
include "template.php"



?>
