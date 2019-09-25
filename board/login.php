<?php
session_start();
//如果沒有登入session值或是session值為空則執行登入動作
if(!isset($_SESSION['loginMember']) and $_SESSION['loginMember']==''){
  if(isset($_POST['username'])and isset($_POST['passwd'])){
    require('connMysqlObj.php');
    $query = "SELECT * FROM admin";
    $result = $db_link->query($query);
    //取出帳號密碼的值
    $row_result = $result->fetch_assoc();
    $username = $row_result['username'];
    $passwd = $row_result['passwd'];
    $db_link->close();
    //比對帳號密碼，若登入成功則前往管理介面，否則退回主畫面
    if(($username==$_POST['username'])and($passwd==$_POST['passwd'])){
      $_SESSION['loginMember'] = $username;
      header('Location: admin.php');
    }else{
      header('Location: index.php');
    }
  }
}else{
  //若已經有登入session值則前往管理介面
  header('Location: admin.php');
}
 ?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>訪客留言版</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body bgcolor="#ffffff">
    <table width='700' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td>
          <table align='left' border='0' cellpadding='0' cellspacing='0' width='700'>
            <tr>
              <td><a href='index.php'>瀏覽留言</a><br><a href='post.php'>我要留言</a></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><div id='mainRegion'>
          <form action="" method="post" name="form1">
            <table border='0' align='center' cellpadding='4' cellspacing='0'>
              <tr valign='top'>
                <td colspan='2' align='center'>登入管理</td>
              </tr>
              <tr valign='top'>
                <td width='80' align='center'><img src="img/login.png" alt="我要登入" width='80' height='80'></td>
                <td valign='middle'> <p>管理帳號 <input type="text" name="username" id="username"> </p>
                <p>管理密碼 <input type="password" name="passwd" id="passwd"> </p>
                <p align='center'> <input type="submit" name="button1" value="登入管理" id='button1'>
                <input type="button" name="button3" value="回上一頁" id='button3' onClick="window.history.back();"> </p> </td>
              </tr>
            </table>
          </form>
        </div>
        </td>
      </tr>      
    </table>
  </body>
</html>
