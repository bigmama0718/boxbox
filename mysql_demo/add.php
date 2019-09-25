<?php
if(isset($_POST['action'])and $_POST['action'] == 'add'){
  require('connMysqlObj.php');
  $sql = 'INSERT INTO students (cName, cSex, cBirthday, cEmail, cPhone, cAddr)
          VALUES (?,?,?,?,?,?)';
  $stmt = $db_link->prepare($sql);
  $stmt->bind_param('ssssss',$_POST['cName'],$_POST['cSex'],$_POST['cBirthday'],
                    $_POST['cEmail'],$_POST['cPhone'],$_POST['cAddr']);
  $stmt->execute();
  $stmt->close();
  $db_link->close();
  header('Location: data.php');
}
 ?>

<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>學生資料管理系統</title>
  </head>
  <body>
    <h1 align='center'>學生資料管理系統 - 新增資料</h1>
    <p align='center'><a href='data.php'>回主畫面</a></p>
    <form action='' method='post' name='formAdd' id='formAdd'>
      <table border='1' align='center' cellpadding='4'>
        <tr>
          <th>欄位</th>
          <th>資料</th>
        </tr>
        <tr>
          <td>姓名</td>
          <td>
            <input type='text' name='cName' id='cName'>
          </td>
        </tr>
        <tr>
          <td>性別</td>
          <td>
            <input type="radio" name="cSex" value="M" id='cSex' checked>男
            <input type="radio" name="cSex" value="F" id='cSex'>女
          </td>
        </tr>
        <tr>
          <td>生日</td>
          <td>
            <input type="text" name="cBirthday" id="cBirthday">EX:YYYY-MM-DD
          </td>
        </tr>
        <tr>
          <td>信箱</td>
          <td>
            <input type="text" name="cEmail" id="cEmail">
          </td>
        </tr>
        <tr>
          <td>電話</td>
          <td>
            <input type="text" name="cPhone" id="cPhone">
          </td>
        </tr>
        <tr>
          <td>住址</td>
          <td>
            <input type="text" name="cAddr" id="cAddr" size='40'>
          </td>
        </tr>
        <tr>
          <td colspan='2' align='center'>
            <input type="hidden" name="action" value="add">
            <input type="submit" name="button1" value="新增資料">
            <input type="reset" name="button2" value="重新填寫">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
