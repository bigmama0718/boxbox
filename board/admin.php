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
$pageRow_records = 5;
$num_pages = 1;
if(isset($_GET['page'])){
  $num_pages = $_GET['page'];
}
$startRow_records = ($num_pages-1)*$pageRow_records;
$query_RecBoard = "SELECT * FROM board ORDER BY boardtime DESC";
$query_limit_RecBoard = $query_RecBoard." LIMIT {$startRow_records},{$pageRow_records}";
$RecBoard = $db_link->query($query_limit_RecBoard);
$all_RecBoard = $db_link->query($query_RecBoard);
$total_records = $all_RecBoard->num_rows;
$total_pages = ceil($total_records/$pageRow_records);
 ?>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>訪客留言版管理系統</title>
  </head>
  <body>
    <table width='700' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td><div id="mainRegion">
          <?php while($row_RecBoard = $RecBoard->fetch_assoc()){ ?>
            <table width='90%' border='0' align='center' cellpadding='4' cellspacing='0'>
              <tr valign='top'>
                <td width='60' align='center'>
                  <?php if($row_RecBoard['boardsex']=='男'){ ?> <img src="img/male.jpg" alt="我是男生" width='49' height='49'>
                  <?php }else{ ?> <img src="img/female.jpg" alt="我是女生" width='49' height='49'><?php } ?>
                  <br>
                  <span><?php echo $row_RecBoard['boardname']; ?></span></td>
                <td>
                  <span>[<?php echo $row_RecBoard['boardid']; ?>]</span> <span class="heading"><?php echo $row_RecBoard['boardsubject']; ?></span>
                  <div class="actiondiv">
                    <a href="adminfix.php?id=<?php echo $row_RecBoard['boardid']; ?>">[修改]</a>&nbsp;<a href="admindel.php?id=<?php echo $row_RecBoard['boardid']; ?>">[刪除]</a>
                  </div>
                  <p><?php echo nl2br($row_RecBoard['boardcontent']); ?></p>
                  <p align='right'><?php echo $row_RecBoard['boardtime']; ?>
                  <?php if($row_RecBoard['boardmail']!=''){ ?>
                    <a href="mailto:<?php echo $row_RecBoard['boardmail']; ?>"> <img src="img/email-a.png" alt="信箱" width='16' height='16' border='0' align='absmiddle'> </a>
                  <?php } ?>
                  <?php if($row_RecBoard['boardweb']!=''){ ?>
                    <a href="<?php echo $row_RecBoard['boardweb']; ?>"> <img src="img/home-a.png" alt="個人網站" width='16' height='16' border='0' align='absmiddle'> </a>
                  <?php } ?>
                  </p>
                </td>
              </tr>
            </table>
          <?php } ?>
          <table width='90%' border='0' align='center' cellpadding='4' cellspacing='0'>
            <tr>
              <td valign='middle'> <p>資料比數:<?php echo $total_records; ?></p> </td>
              <td align='right'> <p><?php if($num_pages>1){ ?> <a href="?page=1">第一頁</a> <a href="?page=<?php echo $num_pages-1; ?>">上一頁</a><?php } ?>
              <?php if($num_pages<$total_pages){ ?> <a href="?page=<?php echo $num_pages+1; ?>">下一頁</a> <a href="?page=<?php echo $total_pages; ?>">最末頁</a><?php } ?>
              </p> </td>
            </tr>
          </table>
        </div> </td>
      </tr>
      <tr>
        <td> <table align='left' border='0' cellpadding='0' cellspacing='0' width='700'>
          <tr>
            <td> <a href="?logout=true"> <img name="logout" src="img/logout.jpg" alt="登出管理" width='77' height='31' border='0'> </a> </td>
          </tr>
        </table> </td>
      </tr>
    </table>
  </body>
</html>
<?php $db_link->close(); ?>
