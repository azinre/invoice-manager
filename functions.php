<?php 
if (!function_exists('generateInvoiceNumber')) {function generateInvoiceNumber(){
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lenghth = 5;
    $number = '';
    for($i= 1; $i<$lenghth; $i++ ){
        $number .= $characters[rand(0, strlen($characters) - 1)];
    
    }
    return ($number);
}
}
?>