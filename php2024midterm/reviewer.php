<html>
<center>
<?php
include("setting.inc");
?>
<?php
if(isset($_SESSION["check"]))
{
    if($_SESSION["check"]=="Yes")
    {
        echo" ";
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
<form action = "showreview.php" method = "post">
    <center>
    <h1>Reviewer您好，歡迎進入論文評論網頁</h1>
    論文評審決定:
    Accept<input type = "radio" name = "rDecision" value = "accept" checked>
    Minor Revision<input type = "radio" name = "rDecision" value = "minorRevision">
    Major Revision<input type = "radio" name = "rDecision" value = "majorRevision">
    Reject<input type = "radio" name = "rDecision" value = "reject">
    <br/>
    論文評論評語:
    <textarea name = "rComment" value = "" rows = "10" cols = "50">
    </textarea>
    <br/>
    <input type = "submit" value = "提交"><br/>
</form>

<?php
echo"<a href = 'logout.php'>登出</a>";
include("footer.inc");
?>
</html>