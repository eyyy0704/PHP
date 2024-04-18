<?php
include("setting.inc");
?>
<?php
if(isset($_SESSION["check"]))
{
    if($_SESSION["check"]=="Yes")
    {
        echo"";
    }
    else
    {
        echo"非法進入網頁";
        header("Location:fail.php");
    }
}
else
{
    echo"非法進入網頁";
    header("Location:fail.php");
}
?>
<?php
    $rDecision = $_POST["rDecision"];
    echo "論文評審決定:"." ".$rDecision."<br/>";
    $rComment = $_POST["rComment"];
    echo "論文評論評語:"." ".$rComment."<br/>";
?>
<?php
echo"<a href = 'logout.php'>登出</a>";
include("footer.inc");
?>