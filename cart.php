<?php
require_once 'config.php';
$_SESSION['cart']=$_SESSION['cart']??[];
if(isset($_GET['add'])){
  $id=(int)$_GET['add']; $qty=max(1,(int)($_GET['qty']??1)); $p=one("SELECT id,in_stock FROM products WHERE id=?",[$id]);
  $ok=$p&&$p['in_stock'];
  if($ok)$_SESSION['cart'][$id]=($_SESSION['cart'][$id]??0)+$qty;
  if(isset($_GET['ajax'])){header('Content-Type: application/json');echo json_encode(['count'=>array_sum($_SESSION['cart']),'msg'=>$ok?'Cart me add ho gaya':'Product stock me nahi hai']);exit;}
  header('Location: '.(isset($_GET['buy'])&&$ok?'checkout.php':'cart.php'));exit;
}
if(isset($_GET['remove'])){unset($_SESSION['cart'][(int)$_GET['remove']]);header('Location: cart.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){foreach($_POST['qty']??[] as $id=>$n){$n=(int)$n;if($n>0)$_SESSION['cart'][(int)$id]=$n;else unset($_SESSION['cart'][(int)$id]);}header('Location: cart.php');exit;}
$items=[];$total=0;
foreach($_SESSION['cart'] as $id=>$n){$p=one("SELECT * FROM products WHERE id=?",[$id]);if(!$p){unset($_SESSION['cart'][$id]);continue;}$p['qty']=$n;$total+=$p['price']*$n;$items[]=$p;}
$title='My Cart';
$pageCss=<<<'CSS'
h1{font-size:24px;margin:30px 0 20px;padding-left:12px;border-left:3px solid #e5252a;line-height:24px}
.row{display:grid;grid-template-columns:90px 1fr 120px 110px 40px;gap:16px;align-items:center;padding:16px;border-radius:14px;box-shadow:0 2px 10px rgba(0,0,0,.08);margin-bottom:14px}
.row img{width:90px;height:90px;object-fit:cover;border-radius:10px;background:#ececec}
.row input{width:70px;padding:8px;border:1px solid #ddd;border-radius:6px;font-family:inherit}
.x{color:#e5252a;font-size:20px}
.sum{margin-top:20px;padding:20px;border-radius:14px;box-shadow:0 2px 10px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px}
.sum b{font-size:24px}.btn{background:#e5252a;color:#fff;padding:12px 28px;border-radius:8px;font-weight:500;border:0;font-family:inherit;font-size:15px;cursor:pointer}
.btn.g{background:#fff;color:#222;border:1px solid #ddd}.empty{text-align:center;padding:70px 0;color:#777}
@media(max-width:700px){.row{grid-template-columns:70px 1fr;}.row img{width:70px;height:70px}}
CSS;
include 'includes/header.php'; ?>
<main class="wrap"><h1>My Cart</h1>
<?php if(!$items):?><div class="empty"><p>Aapka cart khali hai.</p><br><a class="btn" href="products.php">Shopping Karo</a></div>
<?php else:?><form method="post"><?php foreach($items as $p):?>
<div class="row"><img src="<?=e(img($p['image']))?>"><div><a href="product.php?slug=<?=e($p['slug'])?>"><?=e($p['name'])?></a><br><small style="color:#666"><?=money($p['price'])?> each</small></div>
<input type="number" min="1" name="qty[<?=$p['id']?>]" value="<?=$p['qty']?>"><b><?=money($p['price']*$p['qty'])?></b><a class="x" href="cart.php?remove=<?=$p['id']?>">✕</a></div>
<?php endforeach;?>
<div class="sum"><div>Total: <b><?=money($total)?></b><br><small style="color:#1f9d5a">FREE Delivery</small></div><div><button class="btn g">Update Cart</button> <a class="btn" href="checkout.php">Proceed to Checkout</a></div></div></form><?php endif;?></main>
<?php include 'includes/footer.php';
