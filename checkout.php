<?php
require_once 'config.php';
if(empty($_SESSION['user'])){header('Location: login.php?next=checkout.php');exit;}
if(empty($_SESSION['cart'])){header('Location: cart.php');exit;}
$items=[];$total=0;
foreach($_SESSION['cart'] as $id=>$n){$p=one("SELECT * FROM products WHERE id=? AND in_stock=1",[$id]);if($p){$p['qty']=$n;$total+=$p['price']*$n;$items[]=$p;}else unset($_SESSION['cart'][$id]);}
if(!$items){header('Location: cart.php');exit;}
$u=one("SELECT * FROM users WHERE id=?",[$_SESSION['user']['id']]);
if(!$u){unset($_SESSION['user']);header('Location: login.php?next=checkout.php');exit;}
$err=$_GET['err']??'';
$title='Checkout';
$pageCss=<<<'CSS'
h1{font-size:24px;margin:30px 0 20px;padding-left:12px;border-left:3px solid #e5252a;line-height:24px}
.g{display:grid;grid-template-columns:1fr 380px;gap:26px;align-items:start}
.box{border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.09);padding:24px}
.box h3{margin-bottom:16px;font-size:18px}
label{display:block;font-size:13px;font-weight:500;margin:12px 0 5px}
.box input,.box textarea{width:100%;padding:11px 12px;border:1px solid #ddd;border-radius:8px;font-family:inherit;font-size:14px}
.two{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.it{display:flex;gap:12px;margin-bottom:14px;font-size:14px;align-items:center}.it img{width:54px;height:54px;border-radius:8px;object-fit:cover}.it span{flex:1}
.tot{border-top:1px solid #eee;padding-top:14px;display:flex;justify-content:space-between;font-size:18px;font-weight:600}
.btn{width:100%;background:#e5252a;color:#fff;border:0;padding:14px;border-radius:8px;font-size:16px;font-weight:500;cursor:pointer;margin-top:18px;font-family:inherit}
.err{background:#ffe9ea;color:#c0171c;padding:10px 14px;border-radius:8px;margin-bottom:12px}
.pay{display:flex;gap:10px;align-items:center;border:1px solid #e5252a;background:#fff6f6;border-radius:8px;padding:12px;margin-top:14px;font-size:14px}.box .pay input{width:auto}
@media(max-width:850px){.g{grid-template-columns:1fr}.two{grid-template-columns:1fr}}
@media(max-width:480px){h1{font-size:22px;margin:22px 0 16px}.box{padding:16px;border-radius:12px}.box h3{font-size:17px}.it{gap:9px;align-items:flex-start;flex-wrap:wrap}.it img{width:46px;height:46px}.it b{white-space:nowrap}.tot{font-size:16px}.btn{padding:13px;font-size:15px}.pay{font-size:13px}}
CSS;
include 'includes/header.php'; ?>
<main class="wrap"><h1>Checkout</h1>
<form method="post" action="place-order.php" class="g">
<div class="box"><h3>Delivery Address</h3><?php if($err):?><div class="err"><?=e($err)?></div><?php endif;?>
<div class="two"><div><label>Full Name</label><input name="name" required value="<?=e($u['name'])?>"></div><div><label>Phone</label><input name="phone" required pattern="[0-9]{10}" maxlength="10" value="<?=e($u['phone'] ?? '')?>"></div></div>
<label>Email</label><input type="email" name="email" required value="<?=e($u['email'] ?? '')?>">
<label>Address</label><textarea name="address" rows="3" required></textarea>
<div class="two"><div><label>City</label><input name="city" required></div><div><label>State</label><input name="state" required></div></div>
<label>Pincode</label><input name="pincode" required pattern="[0-9]{6}" maxlength="6">
<div class="pay"><input type="radio" checked> Cash on Delivery (COD)</div></div>
<div class="box"><h3>Order Summary</h3><?php foreach($items as $p):?><div class="it"><img src="<?=e(img($p['image']))?>"><span><?=e(mb_strimwidth($p['name'],0,50,'...'))?> × <?=$p['qty']?></span><b><?=money($p['price']*$p['qty'])?></b></div><?php endforeach;?>
<div class="it"><span>Delivery</span><b style="color:#1f9d5a">FREE</b></div><div class="tot"><span>Total</span><span><?=money($total)?></span></div>
<button class="btn">Place Order</button></div></form></main>
<?php include 'includes/footer.php';
