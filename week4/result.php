<meta charset = utf8>

<?php
//姓名
$sName = $_POST["sName"];
echo "您的姓名:".$sName."<br/>";
//學號
$sId = $_POST["sId"];
echo "您的學號:".$sId."<br/>";
//電子郵件
$sEmail = $_POST["sEmail"];
echo "您的電子郵件:".$sEmail."<br/>";
//手機號碼
$sTel = $_POST["sTel"];
echo "您的手機號碼:".$sTel."<br/>";
//年級
$sGrade = $_POST["sGrade"];
echo "您的年級:".$sGrade."<br/>";
//安全與健康問題
$sHealthIssue = $_POST["sHealthIssue"];
echo "您的安全與健康問題:";
foreach($sHealthIssue as $value)
{
    echo $value."  ";
}
echo "<br/>";
//參加意願
$sInterest = $_POST["sInterest"];
echo "您的參加意願:".$sInterest."<br/>";
//喜歡的顏色
$sColor = $_POST["sColor"];
echo "您喜歡的顏色:".$sColor."<br/>";
//衣服尺寸
$sSize = $_POST["sSize"];
echo "您的衣服尺寸:".$sSize."<br/>";
//晚會曲目
$sFile = $_POST["sFile"];
echo "您上傳的晚會曲目:".$sFile."<br/>";
//活動滿意度
$sSatisfaction = $_POST["sSatisfaction"];
echo "您的對本次活動安排的滿意度:".$sSatisfaction."<br/>";
//備註
$sNote = $_POST["sNote"];
echo "您的備註:".$sNote."<br/>";
//期許
$sExpectation = $_POST["sExpectation"];
echo "您對本次活動的期許:".$sExpectation."<br/>";
?>