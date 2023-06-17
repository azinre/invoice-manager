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
    $text = $_FILES['text'];
    if($text['error']===UPLOAD_ERR_OK)
    {
    $ext = pathinfo($text['name'], PATHINFO_EXTENSION);
    //$ext = 'pdf';
    $filename = $invoiceNumber . '.' . $ext;

    if(!file_exists('texts/')){
        mkdir('texts/');
      }
    $dest = 'texts/' . $filename;

    
        return move_uploaded_file($text['tmp_name'], $dest);
    }

    return false; 
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

  if (!function_exists('sanitize')){
    function sanitize($data) {
      return array_map(function ($value) {
        return htmlspecialchars(stripslashes(trim($value)));
      }, $data);
    }
  }
  