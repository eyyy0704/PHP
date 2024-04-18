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
<form action = "showpaper.php" method = "post">
    <center>
    <h1>Author您好，歡迎進入論文投稿網頁</h1>
    <br/>論文標題:
    <input type = "text" name = "aTitle" value = ""><br/>
    作者姓名:<input type = "text" name = "aName" value = ""><br/>
    作者Email:<input type = "email" name = "aEmail" value = ""><br/>

    論文摘要:<br/>
    <textarea name = "aHighlight" value = "" rows = "10" cols = "50">
    </textarea>
    <br/>
    <input type = "submit" value = "提交"><br/>
</form>
<?php
echo"<a href = 'logout.php'>登出</a>";
include("footer.inc");
?>
</html>