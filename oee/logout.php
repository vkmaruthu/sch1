<?php
session_start();

unset($_SESSION['schAdminSession']);
unset($_SESSION['schAdminRole']);
session_destroy();
session_start();
echo "<script> window.location='login/';</script>";
?>	