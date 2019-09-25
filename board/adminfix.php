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
function GetSQLValueString($theValue, $theType){
  switch($theType){
    case 'string':
    $theValue = ($theValue != '') ?filter_var($theValue, FILTER_SANITIZE_MAGIC_QUOTES) :'';
    break;
    case 'int':
    $theValue = ($theValue != '') ?filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) :'';
    break;
    case 'email':
    $theValue = ($theValue != '') ?filter_var($theValue, FILTER_VALIDATE_EMAIL) :'';
    break;
    case 'url':
    $theValue = ($theValue != '') ?filter_var($theValue, FILTER_VALIDATE_URL) :'';
    break;
  }
  return $theValue;
}
//執行更新動作
if(isset($_POST['action'])and $_POST['action']=='update'){
  $query_update = "UPDATE board SET boardname=?,boardsex=?,boardsubject=?,boardmail=?,boardweb=?,boardcontent=? WHERE boardid=?";
  $stmt = $db_link->prepare($query_update);
  $stmt->bind_param('ssssssi',
    GetSQLValueString($_POST['boardname'],'string'),
    GetSQLValueString($_POST['boardsex'],'string'),
    GetSQLValueString($_POST['boardsubject'],'string'),
    GetSQLValueString($_POST['boardmail'],'string'),
    GetSQLValueString($_POST['boardweb'],'string'),
    GetSQLValueString($_POST['boardcontent'],'string'),
    GetSQLValueString($_POST['boardid'],'int'));
  $stmt->execute();
  $stmt->close();
  header('Location: admin.php');
}
$query_RecBoard = "SELECT boardid, boardname, boardsex, boardsubject, boardmail, boardweb, boardcontent FROM board WHERE boardid=?";
$stmt = $db_link->prepare($query_RecBoard);
$stmt->bind_param('i',$_GET['id']);
$stmt->execute();
$stmt->bind_result($boardid, $boardname, $boardsex, $boardsubject, $boardmail, $boardweb, $boardcontent);
$stmt->fetch();
 ?>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>管理系統 - 修改</title>
  </head>
  <body>
    <form action="" method="post" name="form1">
      <table width='90%' border='0' align='center' cellpadding='4' cellspacing='0'>
        <tr valign='top'>
          <td colspan='2' class='heading'>更新訪客留言版資料</td>
        </tr>
        <tr valign='top'>
          <td>
            <p>標題 <input type="text" id="boardsubject" name="boardsubject" value="<?php echo $boardsubject; ?>"> </p>
            <p>姓名 <input type="text" id="boardname" name="boardname" value="<?php echo $boardname; ?>"> </p>
            <p>性別 <input type="radio" id="boardsex" name="boardsex" value="男" <?php if($boardsex=='男'){echo 'checked';} ?>>男
            <input type="radio" id="boardsex" name="boardsex" value="女" <?php if($boardsex=='女'){echo 'checked';} ?>>女 </p>
            <p>信箱 <input type="text" id="boardmail" name="boardmail" value="<?php echo $boardmail; ?>"> </p>
            <p>網站 <input type="text" id="boardweb" name="boardweb" value="<?php echo $boardweb; ?>"> </p>
          </td>
          <td align='right'>
            <p> <textarea id="boardcontent" name="boardcontent" rows="8" cols="50"></textarea><?php echo $boardcontent; ?>
            <p> <input type="hidden" id="boardid" name="boardid" value="<?php echo $boardid; ?>">
                <input type="hidden" id="action" name="action" value="update">
                <input type="submit" id="button1" name="button1" value="確認修改">
                <input type="button" id="button3" name="button3" value="回上一頁" onclick="window.history.back();"></p>
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php
$db_link->close();
 ?>
