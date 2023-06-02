<?php
session_start();
require "data.php";

if(isset($_POST['number'])){
    $number = $_POST['number'];
    $index = array_key_first(array_filter($invoices, function ($invoice) use ($number) {
        return $invoice['number'] == $number;
    }));
    if ($index !== null) {
        
        unset($invoices[$index]);
        
        
        $invoices = array_values($invoices);

        
        $_SESSION['invoices'] = $invoices;

    //unset($_SESSION['invoices'][$index]);
    }
}
header("Location: index.php");
?> 