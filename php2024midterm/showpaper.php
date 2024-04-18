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
    $aTitle = $_POST["aTitle"];
    echo "論文標題:"." ".$aTitle."<br/>";
    $aName = $_POST["aName"];
    echo "作者姓名:"." ".$aName."<br/>";
    $aEmail = $_POST["aEmail"];
    echo "作者Email:"." ".$aEmail."<br/>";
    $aHighlight = $_POST["aHighlight"];
    echo "論文摘要:"." ".$aHighlight."<br/>";
?>
<?php
echo"<a href = 'logout.php'>登出</a>";
include("footer.inc");
?>