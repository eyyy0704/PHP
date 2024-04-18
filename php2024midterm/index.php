<html>
<?php
    include("setting.inc");
?>

<head>
<title>高大資管論文投稿系統</title>
</head>

<center>
<h1><b>高大資管論文投稿系統</b></h1>

<form action = "check.php" method = "post">

帳號：<input type = "text" name = "uId" value = <?php echo $_COOKIE["userName"] ?>><br/>
密碼：<input type = "password" name = "uPwd"><br/>
<br/><input type = "submit"><br/>
</form>

<?php
include("footer.inc");
?>

</html>