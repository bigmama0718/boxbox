<?php
require('connMysqlObj.php');
//預設每頁筆數
$pageRow_records = 5;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if(isset($_GET['page'])){
  $num_pages = $_GET['page'];
}
//本頁開始紀錄筆數=(頁數-1)*每頁筆數
$startRow_records = ($num_pages-1)*$pageRow_records;
//未加限制顯示筆數的SQL敘述
$query_RecBoard = 'SELECT * FROM board ORDER BY boardtime DESC';
//加上限制顯示比數的SQL敘述，由本頁開始記錄筆數，每頁顯示預設筆數
$query_limit_RecBoard = $query_RecBoard." LIMIT {$startRow_records},{$pageRow_records}";
//以加上限制顯示比數的SQL敘述查詢資料到$RecBoard中
$RecBoard = $db_link->query($query_limit_RecBoard);
//以未加上限制顯示筆數的SQL敘述查詢資料到$all_RecBoard中
$all_RecBoard = $db_link->query($query_RecBoard);
//計算總筆數
$total_records = $all_RecBoard->num_rows;
//計算總頁數 = (總筆數/每頁筆數)後無條件進位
$total_pages = ceil($total_records/$pageRow_records);
?>
<html>
  <head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8' />
    <title>留言板</title>
  </head>
  <body>
    <h1 align='center'>留言板</h1>
    <table width='90%' border='0' align='center' cellpadding='4' cellspacing='0'>
      <tr>
        <td align='right'> <p> <a href="login.php?>">管理者登入</a> </p> </td>
      </tr>
    </table>
    <?php while($row_RecBoard = $RecBoard->fetch_assoc()){?>
      <table width='90%' border='0' align='center' cellpadding='4' cellspacing='0'>
        <tr valign='top'>
          <td width='60' align='center'>
            <?php if($row_RecBoard['boardsex']=='男'){?>
            <img src="img/male.jpg" alt="我是男生" width='49' height='49'>
            <?php }else{ ?>
            <img src="img/female.jpg" alt="我是女生" width='49' height='49'>
            <?php } ?>
            <br>
            <span><?php echo $row_RecBoard['boardname']; ?></span>
          </td>
          <td>
            <span>[<?php echo $row_RecBoard['boardid']; ?>]</span>
            <span><?php echo $row_RecBoard['boardsubject']; ?></span>
            <p><?php echo nl2br($row_RecBoard['boardcontent']); ?></p>
            <p align='right' class='smalltext'>
            <?php echo $row_RecBoard['boardtime']; ?>
            <?php if($row_RecBoard['boardmail']!=''){ ?>
            <a href="mailto:<?php $row_RecBoard['boardmail']; ?>"><img src="img/email-a.png" alt="信箱" width='16' height='16' border='0' align='absmiddle'></a>
            <?php } ?>
            <?php if($row_RecBoard['boardweb']!=''){ ?>
            <a href="<?php echo $row_RecBoard['boardweb']; ?>"><img src="img/home-a.png" alt="個人網站" width='16' height='16' border='0' align='absmiddle'></a>
            <?php } ?>
            </p>
          </td>
        </tr>
      </table>
    <?php } ?>
      <table width='90%' border='0' align='center' cellpadding='4' cellspacing='0'>
        <tr>
          <td> <p> <a href="post.php">我要留言</a> </p> </td>
        </tr>
        <tr>
          <td valign='middle'> <p>資料筆數:<?php echo $total_records; ?></p> </td>
          <td align='right'> <p>
          <?php if($num_pages>1){ //若不是第一頁則顯示 ?>
            <a href="?page=1">第一頁</a>
            <a href="?page=<?php echo $num_pages-1; ?>">上一頁</a>
          <?php } ?>
          <?php if($num_pages<$total_pages){ //若非最末頁則顯示 ?>
            <a href="?page=<?php echo $num_pages+1; ?>">下一頁</a>
            <a href="?page=<?php echo $total_pages; ?>">最末頁</a>
          <?php } ?>
          </p></td>
        </tr>
      </table>
  </body>
</html>
