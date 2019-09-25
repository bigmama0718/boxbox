<?php
require_once('connMysqlObj.php');
session_start();
if(!isset($_SESSION['loginMember'])and $_SESSION['loginMember']==''){
  header('Location: index.php');
}
if(isset($_GET['logout'])and $_GET['logout']=='true'){
  unset($_SESSION['loginMember']);
  header('Location: index.php');
}
if(isset($_POST['action'])and $_POST['action']=='delete'){
  $sql_query = "DELETE FROM board WHERE boardid=?";
  $stmt = $db_link->prepare($sql_query);
  $stmt->bind_param('i',$_POST['boardid']);
  $stmt->execute();
  $stmt->close();
  header('Location: admin.php');
}
$query_RecBoard = "SELECT boardid, boardname, boardsex, boardsubject, boardmail, boardweb, boardcontent FROM board WHERE boardid=?";
$stmt = $db_link->prepare($query_RecBoard);
$stmt->bind_param('i',$_GET['id']);
$stmt->execute();
$stmt->bind_result($boardid,$boardname,$boardsex,$boardsubject,$boardmail,$boardweb,$boardcontent);
$stmt->fetch();
 ?>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>管理系統 - 刪除</title>
  </head>
  <body>
    <form action="" method="post" name="form1">
      <table width='90%' border='0' align='center' cellpadding='4' cellspacing='0'>
        <tr valign='top'>
          <td class='heading'>刪除訪客留言版資料</td>
        </tr>
        <tr valign='top'>
          <td>
            <p> <strong>標題</strong>:<?php echo $boardsubject; ?> <strong>姓名</strong>:<?php echo $boardname; ?> <strong>性別</strong>:<?php echo $boardsex; ?> </p>
            <p> <strong>信箱</strong>:<?php echo $boardmail; ?> <strong>網站</strong>:<?php echo $boardweb; ?> </p>
            <p>內容:</p>
            <p><?php echo nl2br($boardcontent); ?></p>
          </td>
        </tr>
        <tr align='top'>
          <td align='center'> <p>
            <input type="hidden" id="boardid" name="boardid" value="<?php echo $boardid; ?>">
            <input type="hidden" id="action" name="action" value="delete">
            <input type="submit" id="button1" name="button1" value="確認刪除">
            <input type="button" id="button3" name="button3" value="回上一頁" onclick="window.history.back();">
          </p> </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php $db_link->close(); ?>
