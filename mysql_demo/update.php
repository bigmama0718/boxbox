<?php
require('connMysqlObj.php');
if(isset($_POST['action'])and $_POST['action']=='update'){
  $sql = 'UPDATE students SET cName=?, cSex=?, cBirthday=?, cEmail=?,
  cPhone=?, cAddr=? WHERE cID=?';
  $stmt = $db_link->prepare($sql);
  $stmt->bind_param('ssssssi',$_POST['cName'],$_POST['cSex'],$_POST['cBirthday'],
  $_POST['cEmail'],$_POST['cPhone'],$_POST['cAddr'],$_POST['cID']);
  $stmt->execute();
  $stmt->close();
  $db_link->close();
  header('Location: data.php');
}
$sql_select = 'SELECT cID,cName,cSex,cBirthday,cEmail,cPhone,cAddr FROM students
WHERE cID=?';
$stmt = $db_link->prepare($sql_select);
$stmt->bind_param('i',$_GET['id']);
$stmt->execute();
$stmt->bind_result($cid,$cname,$csex,$cbirthday,$cemail,$cphone,$caddr);
$stmt->fetch();
 ?>

<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
    <title>學生資料管理系統</title>
  </head>
  <body>
    <h1 align='center'>學生資料管理系統 - 修改資料</h1>
    <p align='center'><a href='data.php'>回主畫面</a></p>
    <form action="" method="post" name='formUpdate' id='formUpdate'>
      <table border='1' align='center' cellpadding='4'>
        <tr>
          <th>欄位</th>
          <th>資料</th>
        </tr>
        <tr>
          <td>姓名</td>
          <td> <input type="text" name="cName" id='cName' value="<?php echo $cname;?>"> </td>
        </tr>
        <tr>
          <td>性別</td>
          <td>
            <input type="radio" name="cSex" id='cSex' value="M" <?php if($csex=='M')echo 'checked';?>>男
            <input type="radio" name="cSex" id='cSex' value="F" <?php if($csex=='F')echo 'checked';?>>女
          </td>
        </tr>
        <tr>
          <td>生日</td>
          <td> <input type="text" name="cBirthday" id='cBirthday' value="<?php echo $cbirthday;?>"> </td>
        </tr>
        <tr>
          <td>信箱</td>
          <td> <input type="text" name="cEmail" id='cEmail' value="<?php echo $cemail;?>"> </td>
        </tr>
        <tr>
          <td>電話</td>
          <td> <input type="text" name="cPhone" id='cPhone' value="<?php echo $cphone;?>"> </td>
        </tr>
        <tr>
          <td>住址</td>
          <td> <input type="text" name="cAddr" id='cAddr' value="<?php echo $caddr;?>" size='40'> </td>
        </tr>
        <tr>
          <td colspan='2' align='center'>
            <input type="hidden" name="cID" value="<?php echo $cid;?>">
            <input type="hidden" name="action" value="update">
            <input type="submit" name="button1" value="更新資料">
            <input type="reset" name="button2" value="重新填寫">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php
$stmt->close();
$db_link->close();
 ?>
