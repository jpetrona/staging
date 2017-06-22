
<?php 
/* 
Template Name: Template - Email test
*/
//$email_to = 'jitendrashakya777@gmail.com';
//$email_subject = "test";
//$message = "test";
//$headers = ""; 
//$send_mail = wp_mail($email_to, $email_subject, $message, $headers);//
//echo 'testing';
?>

<?php //phpinfo();

$filename = "/var/lib/php5";
if (is_writable($filename)) {
    echo 'The file is writable';
} else {
    echo 'The file is not writable';
}

 ?>

