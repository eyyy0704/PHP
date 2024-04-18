<html>
<center>
<?php
include("setting.inc");
?>
<?php
if($_SESSION["check"]=="No")
{
    echo"非法進入網頁，";
    echo "登入失敗"."<br/>";
    echo "三秒後回登入頁面";
    header("Refresh:3;url = index.php");
}

?>
</html>