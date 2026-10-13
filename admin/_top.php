<?php
require_once __DIR__.'/../config.php';
if(empty($_SESSION['admin'])){header('Location: login.php');exit;}
$cur=basename($_SERVER['PHP_SELF']);
function flash($m=null){if($m!==null){$_SESSION['flash']=$m;return;}$x=$_SESSION['flash']??'';unset($_SESSION['flash']);return $x;}
?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin - LPT Store</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}body{font-family:'Outfit',sans-serif;background:#f4f5f9;color:#222;font-size:14px;display:flex;min-height:100vh}
a{text-decoration:none;color:inherit}
.sb{width:230px;background:#131a2e;color:#cfd4e3;padding:20px 0;flex:none}
.sb .lg{background:#fff200;color:#e5252a;font-family:Impact,sans-serif;font-size:26px;display:inline-block;margin:0 22px 22px;padding:0 8px}
.sb a{display:block;padding:12px 22px;font-size:15px}.sb a:hover,.sb a.on{background:#1f2846;color:#fff;border-left:3px solid #e5252a;padding-left:19px}
.ct{flex:1;padding:26px;min-width:0}.ct h1{font-size:24px;margin-bottom:18px}
.card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 1px 6px rgba(0,0,0,.06);margin-bottom:20px}
table{width:100%;border-collapse:collapse}th,td{text-align:left;padding:10px;border-bottom:1px solid #eee;vertical-align:middle}th{font-size:12px;text-transform:uppercase;color:#777}
td img{width:48px;height:48px;object-fit:cover;border-radius:6px;background:#eee}
label{display:block;font-weight:500;margin:12px 0 5px}input,select,textarea{width:100%;padding:10px 12px;border:1px solid #d9dbe3;border-radius:8px;font-family:inherit;font-size:14px;background:#fff}
input[type=checkbox]{width:auto}.g2{display:grid;grid-template-columns:1fr 1fr;gap:14px}.g3{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
.btn{background:#e5252a;color:#fff;border:0;padding:10px 20px;border-radius:8px;cursor:pointer;font-family:inherit;font-size:14px;display:inline-block}.btn.s{padding:6px 12px;font-size:13px}.btn.b{background:#3b4bd8}.btn.d{background:#777}
.fl{background:#e6f7ef;color:#1f9d5a;padding:10px 14px;border-radius:8px;margin-bottom:16px}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}.stats .card b{font-size:30px;display:block}.stats .card span{color:#777}
.gal{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px}.gal div{text-align:center;font-size:12px}.gal img{width:70px;height:70px;object-fit:cover;border-radius:6px;display:block}
.sc{overflow-x:auto}
@media(max-width:800px){body{flex-direction:column}.sb{width:100%}.stats,.g2,.g3{grid-template-columns:1fr}}
</style></head><body>
<nav class="sb"><span class="lg">LPT</span>
<a href="index.php" class="<?=$cur=='index.php'?'on':''?>">Dashboard</a>
<a href="categories.php" class="<?=$cur=='categories.php'?'on':''?>">Categories</a>
<a href="products.php" class="<?=in_array($cur,['products.php','product-form.php'])?'on':''?>">Products</a>
<a href="orders.php" class="<?=$cur=='orders.php'?'on':''?>">Orders</a>
<a href="../index.php" target="_blank">View Website ↗</a><a href="logout.php">Logout</a></nav>
<div class="ct"><?php if($m=flash()):?><div class="fl"><?=e($m)?></div><?php endif;?>
