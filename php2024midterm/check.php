<?php
include("setting.inc");
?>
<?php
$cId = "chair";
$cPwd = "123";
$rId = "reviewer";
$rPwd = "234";
$aId = "author";
$aPwd = "345";

$uId = $_POST["uId"];
$uPwd = $_POST["uPwd"];
$date = strtotime("+7 days",time());

if($cId == $uId && $cPwd == $uPwd)
{
    setcookie("userName",$uId,$date);
    $_SESSION["check"] = "Yes";
    header("Location:chair.php");
}
elseif($rId == $uId && $rPwd == $uPwd)
{
    setcookie("userName",$uId,$date);
    $_SESSION["check"] = "Yes";
    header("Location:reviewer.php");
}
elseif($aId == $uId && $aPwd == $uPwd)
{
    setcookie("userName",$uId,$date);
    $_SESSION["check"] = "Yes";
    header("Location:author.php");
}
else
{
    $_SESSION["check"] = "No";
    header("Location:fail.php");
}
?>
<?php
include("footer.inc");
?>
