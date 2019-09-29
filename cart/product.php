<?php
require_once('connMysql.php');
require_once('mycart.php');
session_start();
$cart = &$_SESSION['cart'];
if(!is_object($cart)) $cart = new myCart();
if(isset($_POST['cartaction']) and $_POST['cartaction']=='add'){
  $cart->add_item($_POST['id'],$_POST['qty'],$_POST['price'],$_POST['name']);
  header('Location: cart.php');
}
$query_product = "SELECT * FROM product WHERE productid=?";
$stmt = $db_link->prepare($query_product);
$stmt->bind_param('i',$_GET['id']);
$stmt->execute();
$product = $stmt->get_result();
$row_product = $product->fetch_assoc();

$query_category = "SELECT category.categoryid, category.categoryname, category.categorysort, count(product.productid) as totalNum
FROM category LEFT JOIN product
ON category.categoryid = product.categoryid
GROUP BY category.categoryid, category.categoryname, category.categorysort
ORDER BY category.categorysort ASC";
$category = $db_link->query($query_category);

$query_total = "SELECT count(productid) as totalNum FROM product";
$total = $db_link->query($query_total);
$row_total = $total->fetch_assoc();
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
         <td width="200" class="tdrline">
             <div class="boxtl"></div>
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
             <p class="heading"><img src="img/16-cube-orange.png" width="16" height="16" align="absmiddle"> 產品目錄 <span class="smalltext">Category</span></p>
             <ul>
               <li><a href="index.php?">所有產品 <span class="categorycount">(<?php echo $row_total["totalNum"];?>)</span></a></li>
 			           <?php	while($row_category = $category->fetch_assoc()){ ?>
               <li><a href="index.php?cid=<?php echo $row_category["categoryid"];?>"><?php echo $row_category["categoryname"];?> <span class="categorycount">(<?php echo $row_category["productNum"];?>)</span></a></li>
               <?php }?>
             </ul>
           </div>
           <div class="boxbl"></div>
           <div class="boxbr"></div></td>
         <td><div class="subjectDiv"> <span class="heading"><img src="img/16-cube-green.png" width="16" height="16" align="absmiddle"></span> 產品詳細資料</div>
           <div class="actionDiv"><p align='right'><a href="cart.php">我的購物車</a></p></div>
           <div class="albumDiv">
             <div class="picDiv">
               <?php if($row_product["productimages"]==""){?>
               <img src="img/nopic.png" alt="暫無圖片" width="120" height="120" border="0" />
               <?php }else{?>
               <img src="proimg/<?php echo $row_product["productimages"];?>" alt="<?php echo $row_product["productname"];?>" width="135" height="135" border="0" />
               <?php }?>
             </div>
           </div>
           <div class="titleDiv"><strong><?php echo $row_product["productname"];?></strong></div>
           <div class="albuminfo"><span class="smalltext">特價 </span><span class="redword"><?php echo $row_product["productprice"];?></span><span class="smalltext"> 元</span></div>
           <div class="dataDiv">
             <p><?php echo nl2br($row_product["description"]);?></p>
             <hr width="100%" size="1" />
             <form name="form3" method="post" action="">
               <input name="id" type="hidden" id="id" value="<?php echo $row_product["productid"];?>">
               <input name="name" type="hidden" id="name" value="<?php echo $row_product["productname"];?>">
               <input name="price" type="hidden" id="price" value="<?php echo $row_product["productprice"];?>">
               <input name="qty" type="hidden" id="qty" value="1">
               <input name="cartaction" type="hidden" id="cartaction" value="add">
               <input type="submit" name="button3" id="button3" value="加入購物車">
               <input type="button" name="button4" id="button4" value="回上一頁" onClick="window.history.back();">
             </form>
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
