<?php
session_start();
require "data.php";

if(isset($_POST['number'])){
    $number = $_POST['number'];
    $sql = 'DELETE FROM invoices WHERE number = :number';
    $stmt = $db->prepare($sql);
    $stmt->execute([':number' => $number]);
    header("Location: index.php?status=" . $status);
    // $index = array_key_first(array_filter($invoices, function ($invoice) use ($number) {
    //     return $invoice['number'] == $number;
    // }));
    // if ($index !== null) {
    //     unset($invoices[$index]);
    //     $invoices = array_values($invoices);
    //     $_SESSION['invoices'] = $invoices;
    // //unset($_SESSION['invoices'][$index]);
    // }
}
//header("Location: index.php");
?> 