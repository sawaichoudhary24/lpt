<?php require_once __DIR__.'/../config.php';
$cats=q("SELECT * FROM categories ORDER BY sort_order,id");
$cartCount=array_sum($_SESSION['cart']??[]);
$u=$_SESSION['user']??null; ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=e($title??'LPT Store')?></title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Outfit',sans-serif;color:#222;background:#fff;font-size:15px}
a{text-decoration:none;color:inherit}
.wrap{width:min(1180px,92%);margin:0 auto}
.hd{border-bottom:1px solid #e8e8ec;background:#fff;position:sticky;top:0;z-index:50}
.hd-in{display:flex;align-items:center;gap:18px;height:62px}
.logo{background:#fff200;color:#e5252a;font-weight:700;font-size:30px;font-family:Impact,'Outfit',sans-serif;padding:0 8px;line-height:38px;letter-spacing:1px;border-radius:2px}
.catbtn{position:relative;border:1px solid #bbb;border-radius:6px;padding:8px 14px;font-size:14px;cursor:pointer;background:#fff}
.catmenu{display:none;position:absolute;top:100%;left:0;background:#fff;box-shadow:0 6px 20px rgba(0,0,0,.15);border-radius:8px;min-width:180px;padding:6px 0;margin-top:4px}
.catbtn:hover .catmenu,.catbtn:focus .catmenu{display:block}
.catmenu a{display:block;padding:8px 16px}.catmenu a:hover{background:#f5f5f7;color:#e5252a}
.search{flex:1;max-width:520px;margin:0 auto;display:flex;border:1px solid #e3e3e8;border-radius:8px;padding:0 12px;height:40px;align-items:center}
.search input{flex:1;border:0;outline:0;font-family:inherit;font-size:13px}.search button{background:none;border:0;cursor:pointer}
.hd-r{display:flex;gap:12px;align-items:center}
.hbtn{display:flex;align-items:center;gap:8px;border:1px solid #eee;border-radius:8px;padding:8px 14px;font-weight:500;box-shadow:0 1px 4px rgba(0,0,0,.05);position:relative;font-size:15px}
.hbtn svg{color:#e5252a}
.badge{background:#e5252a;color:#fff;border-radius:50%;font-size:11px;min-width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center}
.loginbtn{background:#e5252a;color:#fff;padding:10px 20px;border-radius:8px;font-weight:500;display:inline-block}
.umenu{position:relative}.umenu .drop{display:none;position:absolute;right:0;top:100%;background:#fff;box-shadow:0 6px 20px rgba(0,0,0,.15);border-radius:8px;min-width:140px;margin-top:0}
.umenu:hover .drop{display:block}.drop a{display:block;padding:10px 16px}.drop a:hover{background:#f5f5f7}
@media(max-width:1024px){.wrap{width:94%}.hd-in{gap:12px}.hd-r{gap:8px}.hbtn{padding:8px 10px}}
@media(max-width:800px){.search{display:none}.hbtn span.t{display:none}.hd-in{gap:8px}.hd-r{gap:7px}}
@media(max-width:480px){.hd-in{height:auto;min-height:54px;gap:7px;padding:7px 0}.logo{font-size:25px;line-height:32px;padding:0 6px}.catbtn{font-size:12px;padding:7px 8px}.hd-r{margin-left:auto;gap:5px}.hbtn{padding:8px;border-radius:7px}.hbtn svg{width:15px;height:15px}.loginbtn{padding:9px 11px;font-size:12px;border-radius:7px}.wrap{width:92%}}
@media(max-width:360px){.catbtn{display:none}.hd-in{gap:6px}.logo{font-size:23px}.hbtn{padding:7px}.loginbtn{padding:8px 9px}}
</style>
<style><?=$pageCss??''?></style></head><body>
<header class="hd"><div class="wrap hd-in">
<a href="index.php" class="logo">LPT</a>
<div class="catbtn" tabindex="0">Categories ⌄<div class="catmenu"><?php foreach($cats as $c):?><a href="products.php?cat=<?=e($c['slug'])?>"><?=e($c['name'])?></a><?php endforeach;?></div></div>
<form class="search" action="products.php"><input name="q" placeholder="Search Product" value="<?=e($_GET['q']??'')?>"><button><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#222" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></button></form>
<div class="hd-r">
<a class="hbtn" href="my-order.php"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8 12 3 3 8v8l9 5 9-5zM3 8l9 5 9-5M12 13v8"/></svg><span class="t">My Order</span></a>
<a class="hbtn" href="cart.php"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.6 12h11l2-8H6.5"/></svg><span class="t">My Cart</span><span class="badge" id="cartBadge" <?=$cartCount?'':'style="display:none"'?>><?=$cartCount?></span></a>
<?php if($u):?><div class="umenu"><a class="loginbtn" href="#"><?=e(explode(' ',$u['name'])[0])?> ⌄</a><div class="drop"><a href="my-order.php">My Order</a><a href="logout.php">Logout</a></div></div>
<?php else:?><a class="loginbtn" href="login.php">Login</a><?php endif;?>
</div></div></header>
