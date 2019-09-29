<?php
require_once('connMysql.php');
if(isset($_POST['customername']) and $_POST['customername'] != ''){
  require_once('mycart.php');
  session_start();
  $cart = &$_SESSION['cart'];
  if(!is_object($cart)) $cart = new myCart();

  $query = "INSERT INTO orders (total, deliverfee, grandtotal, customername, customeremail, customeraddress, customerphone, paytype)
  VALUES (?,?,?,?,?,?,?,?)";
  $stmt = $db_link->prepare($query);
  $stmt->bind_param('iiisssss',$cart->total,$cart->deliverfee,$cart->grandtotal,
  $_POST['customername'],$_POST['customeremail'],$_POST['customeraddress'],$_POST['customerphone'],$_POST['paytype']);
  $stmt->execute();
  $order_id = $stmt->insert_id;
  $stmt->close();
  if($cart->itemcount > 0){
    foreach($cart->get_contents() as $item){
      $query = "INSERT INTO orderdetail (orderid, productid, productname, unitprice, quantity)
        VALUES (?,?,?,?,?)";
      $stmt = $db_link->prepare($query);
      $stmt->bind_param('iisii',$order_id,$item['id'],$item['info'],$item['price'],$item['qty']);
      $stmt->execute();
      $stmt->close();
    }
  }
  $cname = $_POST['customername'];
  $cmail = $_POST['customeremail'];
  $cphone = $_POST['customerphone'];
  $caddress = $_POST['customeraddress'];
  $cpaytype = $_POST['paytype'];
  $total = $cart->grandtotal;
  $mailcontent=<<<msg
  親愛的 $cname 您好：
  感謝您的購買，
  本次消費明細如下：
  ------------------------------------------------
  訂單編號：$order_id
  姓名：$cname
  信箱：$cmail
  電話：$cphone
  住址：$caddress
  付款方式：$cpaytype
  消費金額：$total
  ------------------------------------------------
  此信件為系統自動發送，請勿回覆。
  如訂單內容有問題請至
  客服信箱：bigmama0718@gmail.com
  客服電話：02-29546288
  再次感謝您的購買，歡迎再度光臨。
  msg;

  $mailForm = "=?UTF-8?B?".base64_encode('XX購物網')."?=<bigmama0718@gmail.com>";
  $mailto = $_POST['customeremail'];
  $mailSubject = "=?UTF-8?B?".base64_encode('XX購物網訂單通知')."?=";
  $mailHeader = "From:".$mailForm."\r\n";
  $mailHeader .= "Content-type:text/html;charset=UTF-8";
  if(!@mail($mailto,$mailSubject,nl2br($mailcontent),$mailHeader)) die("郵件發送失敗");
  $cart->empty_cart();
}
 ?>
<script language="javascript">
  alert("感謝您的購買，XX購物網將會盡速為您處理。");
  window.location.href="index.php";
</script>
