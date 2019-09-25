<?php
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

if(isset($_POST['action']) and $_POST['action']=='add'){
  require('connMysqlObj.php');
  $query_insert = "INSERT INTO board (boardname, boardsex, boardsubject,
    boardtime, boardmail, boardweb, boardcontent)
    VALUES (?,?,?,NOW(),?,?,?)";
  $stmt = $db_link->prepare($query_insert);
  $stmt->bind_param('ssssss',
   GetSQLValueString($_POST['boardname'],'string'),
   GetSQLValueString($_POST['boardsex'],'string'),
   GetSQLValueString($_POST['boardsubject'],'string'),
   GetSQLValueString($_POST['boardmail'],'email'),
   GetSQLValueString($_POST['boardweb'],'url'),
   GetSQLValueString($_POST['boardcontent'],'string'));
  $stmt->execute();
  $stmt->close();
  $db_link->close();
  header('Location: index.php');
}
 ?>

 <html>
   <head>
     <meta http-equiv='content-type' content='text/html; charset=utf-8' />
     <title>訪客留言版</title>
     <script language='javascript'>
       function checkForm(){
         if(document.formPost.boardsubject.value==''){
           alert('請填寫標題!');
           document.formPost.boardsubject.focus();
           return false;
         }
         if(document.formPost.boardname.value==''){
           alert('請填寫姓名!');
           document.formPost.boardname.focus();
           return false;
         }
         if(document.formPost.boardcontent.value==''){
           alert('請填寫留言!');
           document.formPost.boardcontent.focus();
           return false;
         }
         return confirm('確定送出嗎?');
       }

       function checkmail(myEmail){
         var filter = /^([a-zA-Z0-9 _ \.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
         if(filter.test(myEmail.value)){
           return true;
         }
         alert('信箱格式不正確!');
         return false;
       }
     </script>
   </head>
   <body>
     <form action="" method="post" name="formPost" id="formPost" onSubmit="return checkForm();">
       <table width='90%' border='0' align='center' cellpadding='4' cellspacing='0'>
         <tr valign='top'>
           <td width='80' align='center'> <img src="img/talk.jpg" alt="我要留言" width='80' height='80'> <span class="heading">留言</span> </td>
           <td>
             <p>標題 <input type="text" name="boardsubject" id="boardsubject"></p>
             <p>姓名 <input type="text" name="boardname" id="boardname"> </p>
             <p>性別 <input type="radio" name="boardsex" id="radio1" value="男" checked>男
              <input type="radio" name="boardsex" id="radio2" value="女" checked>女  </p>
             <p>信箱 <input type="text" name="boardmail" id="boardmail"> </p>
             <p>網站 <input type="text" name="boardweb" id="boardweb"> </p>
           </td>
           <td align='middle'>
             <p> <textarea name="boardcontent" id="boardcontent" rows="11" cols="40"></textarea></p>
           </td>
         </tr>
         <tr valign='top'>
           <td colspan='3' align='center' valign='middle'>
             <input type="hidden" name="action" id="action" value="add">
             <input type="submit" name="button1" id="button1" value="送出留言">
             <input type="reset" name="button2" id="button2" value="重新填寫">
             <input type="button" name="button3" id="button3" value="回上一頁" onclick="window.history.back();"></td>
         </tr>
       </table>
     </form>
   </body>
 </html>
