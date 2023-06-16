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

function saveText($invoiceNumber, $text) {
    //$text= $_FILES['text'];

    if($text['error']===UPLOAD_ERR_OK);
    {
    //$ext = strtolower(pathinfo($text['name'], PATHINFO_EXTENSION));
    $ext = 'pdf';
    $filename = $invoiceNumber . '.' . $ext;

    if(!file_exists('texts/')){
        mkdir('texts/');
      }
    $dest = 'texts/' . $filename;

    if (move_uploaded_file($text['tmp_name'], $dest)) {
        return $filename; 
    }

    return false; 
}}
