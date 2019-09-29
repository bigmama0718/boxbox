<?php
require_once('connMysql.php');
$pageRow = 6;
$num_pages = 1;
if(isset($_GET['page'])){
  $num_pages = $_GET['page'];
}
$startRow = ($num_pages - 1) * $pageRow;
// 若有分類關鍵字時未加限制顯示筆數的SQL敘述
if(isset($_GET['cid'])and $_GET['cid']!=''){
  $query_product = "SELECT * FROM product WHERE categoryid = ? ORDER BY productid DESC";
  $stmt = $db_link->prepare($query_product);
  $stmt->bind_param('i',$_GET['cid']);
// 若有搜尋關鍵字時未加限制顯示筆數的SQL敘述
}elseif(isset($_GET['keyword'])and $_GET['keyword'] != ''){
  $query_product = "SELECT * FROM product WHERE productname LIKE ? OR description LIKE ? ORDER BY productid DESC";
  $stmt = $db_link->prepare($query_product);
  $keyword = "%".$_GET['keyword']."%";
  $stmt->bind_param('ss',$keyword,$keyword);
//若有價格區間關鍵字時未加限制顯示筆數的SQL敘述
}elseif(isset($_GET['price1']) and isset($_GET['price2']) and ($_GET['price1'] <= $_GET['price2'])){
  $query_product = "SELECT * FROM product WHERE productprice BETWEEN ? AND ? ORDER BY productid DESC";
  $stmt = $db_link->prepare($query_product);
  $stmt->bind_param('ii',$_GET['price1'],$_GET['price2']);
// 預設情況下未加限制顯示筆數的SQL敘述
}else{
  $query_product = "SELECT * FROM product ORDER BY productid DESC";
  $stmt = $db_link->prepare($query_product);
}
$stmt->execute();
$product = $stmt->get_result();
$total_records = $product->num_rows;
$total_pages = ceil($total_records / $pageRow);

$query_category = "SELECT category.categoryid, category.categoryname, category.categorysort, count(product.productid) as productNum
FROM category LEFT JOIN product
ON category.categoryid = product.categoryid
GROUP BY category.categoryid, category.categoryname, category.categorysort
ORDER BY category.categorysort ASC";
$category = $db_link->query($query_category);
$query_total = "SELECT count(productid) as totalNum FROM product";
$total = $db_link->query($query_total);
$row_total = $total->fetch_assoc();
// foreach($row_total as $item=>$val){
//   echo $item.'='.$val.'<br>';
// }

function keepUrl(){
  $keepUrl = '';
  if(isset($_GET['keyword'])) $keepUrl.="&keyword=".urlencode($_GET['keyword']);
  if(isset($_GET['price1'])) $keepUrl.="&price1=".$_GET['price1'];
  if(isset($_GET['price2'])) $keepUrl.="&price2=".$_GET['price2'];
  if(isset($_GET['cid'])) $keepUrl.="&cid=".$_GET['cid'];
  return $keepUrl;
}
 ?>
 <html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>XX購物網</title>
 <link href="style.css" rel="stylesheet" type="text/css">
 </head>

 <body>
 <table width="780" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
   <tr>
     <td class="tdbline"><table width="100%" border="0" cellspacing="0" cellpadding="10">
         <tr valign="top">
           <td width="200" class="tdrline"><div class="boxtl"></div>
             <div class="boxtr"></div>
             <div class="categorybox">
               <p class="heading"><img src="img/16-cube-orange.png" width="16" height="16" align="absmiddle"> 產品搜尋 <span class="smalltext">Search</span></p>
               <form name="form1" method="get" action="index.php">
                 <p>
                   <input name="keyword" type="text" id="keyword" value="請輸入關鍵字" size="12" onClick="this.value='';">
                   <input type="submit" id="button" value="查詢">
                 </p>
               </form>
               <p class="heading"><img src="img/16-cube-orange.png" width="16" height="16" align="absmiddle"> 價格區間 <span class="smalltext">Price</span></p>
               <form action="index.php" method="get" name="form2" id="form2">
                 <p>
                   <input name="price1" type="text" id="price1" value="0" size="3">
                   -
                   <input name="price2" type="text" id="price2" value="0" size="3">
                   <input type="submit" id="button2" value="查詢">
                 </p>
               </form>
             </div>
             <div class="boxbl"></div>
             <div class="boxbr"></div>
             <hr width="100%" size="1" />
             <div class="boxtl"></div>
             <div class="boxtr"></div>
             <div class="categorybox">
               <p class="heading"><img src="img/16-cube-orange.png" width="16" height="16" align="absmiddle"> 產品分類 </p>
               <ul>
                 <li><a href="index.php">所有產品 <span class="categorycount">(<?php echo $row_total["totalNum"];?>)</span></a></li>
                 <?php	while($row_category=$category->fetch_assoc()){ ?>
                 <li><a href="index.php?cid=<?php echo $row_category["categoryid"];?>"><?php echo $row_category["categoryname"];?> <span class="categorycount">(<?php echo $row_category["productNum"];?>)</span></a></li>
                 <?php }?>
               </ul>
             </div>
             <div class="boxbl"></div>
             <div class="boxbr"></div></td>
             <td><div class="subjectDiv"> <span class="heading"><img src="img/16-cube-green.png" width="16" height="16" align="absmiddle"></span> 產品列表</div>
             <div class="actionDiv"><a href="cart.php">我的購物車</a></div>
             <?php
             $query_limit_product = $query_product." LIMIT {$startRow}, {$pageRow}";
             $stmt = $db_link->prepare($query_limit_product);
 			       if(isset($_GET["cid"]) and ($_GET["cid"]!="")){
 				     $stmt->bind_param("i", $_GET["cid"]);
 			       }elseif(isset($_GET["keyword"]) and ($_GET["keyword"]!="")){
 				     $keyword = "%".$_GET["keyword"]."%";
 				     $stmt->bind_param("ss", $keyword, $keyword);
             }elseif(isset($_GET["price1"]) and isset($_GET["price2"]) and ($_GET["price1"]<=$_GET["price2"])){
 				     $stmt->bind_param("ii", $_GET["price1"], $_GET["price2"]);
 			       }
             $stmt->execute();
             $product = $stmt->get_result();
             while($row_product=$product->fetch_assoc()){
             ?>
             <div class="albumDiv">
               <div class="picDiv"><a href="product.php?id=<?php echo $row_product["productid"];?>">
                 <?php if($row_product["productimages"]==""){?>
                 <img src="img/nopic.png" alt="暫無圖片" width="120" height="120" border="0" />
                 <?php }else{?>
                 <img src="proimg/<?php echo $row_product["productimages"];?>" alt="<?php echo $row_product["productname"];?>" width="135" height="135" border="0" />
                 <?php }?>
                 </a></div>
               <div class="albuminfo"><a href="product.php?id=<?php echo $row_product["productid"];?>"><?php echo $row_product["productname"];?></a><br />
                 <span class="smalltext">特價 </span><span class="redword"><?php echo $row_product["productprice"];?></span><span class="smalltext"> 元</span> </div>
             </div>
             <?php }?>
             <div class="navDiv">
               <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
               <a href="?page=1<?php echo keepUrl();?>">|&lt;</a> <a href="?page=<?php echo $num_pages-1;?><?php echo keepUrl();?>">&lt;&lt;</a>
               <?php }else{?>
               |&lt; &lt;&lt;
               <?php }?>
               <?php
   	           for($i=1;$i<=$total_pages;$i++){
   	  	          if($i==$num_pages){
   	  	  	          echo $i." ";
   	  	          }else{
   	  	              $urlstr = keepUrl();
   	  	              echo "<a href=\"?page=$i$urlstr\">$i</a> ";
   	  	          }
   	           }
   	           ?>
               <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
               <a href="?page=<?php echo $num_pages+1;?><?php echo keepUrl();?>">&gt;&gt;</a> <a href="?page=<?php echo $total_pages;?><?php echo keepUrl();?>">&gt;|</a>
               <?php }else{?>
               &gt;&gt; &gt;|
               <?php }?>
             </div></td>
         </tr>
       </table></td>
   </tr>
   <tr>
     <td height="30" align="center" background="img/album_r2_c1.jpg" class="trademark">© 2019 All Rights Reserved.</td>
   </tr>
 </table>
 </body>
 </html>
 <?php
 $stmt->close();
 $db_link->close();
 ?>
