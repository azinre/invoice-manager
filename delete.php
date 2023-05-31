<?php
require "data.php";

if(isset($_POST['number']))
    $index = array_key_first(array_filter($invoices, function ($invoice){
    return $invoice['number'] == $_POST['number'];
}));

//unset($_SESSION($movies, ))



?>