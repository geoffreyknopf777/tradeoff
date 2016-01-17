<?php session_start();?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >

<?php include "header_logout.php" ?>

<br />

<p style="text-align: center">
Thank you for using TradeOff! You have been logged out of your account. <br /> <br />
Come back soon.
</p>

<?php

session_start();

session_destroy();

?>

</html>