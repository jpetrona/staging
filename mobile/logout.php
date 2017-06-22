<?php
session_start();
session_destroy();
echo "Sing out succesfull";
echo "<Script>window.location.href='index.php';</script>";
?>