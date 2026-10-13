<?php
require_once 'config.php';
$p=one("SELECT p.*,c.name cname,c.slug cslug FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.slug=?",[$_GET['slug']??'']);
if(!$p){header('Location: products.php');exit;}
$extra=q("SELECT image FROM product_images WHERE product_id=? ORDER BY id",[$p['id']]);
$imgs=[$p['image']]; foreach($extra as $x)$imgs[]=$x['image'];
$title=$p['name']; $off=discount($p);
$pageCss=<<<'CSS'
body{background:#fff}
.hero{background:linear-gradient(#fdf3f3,#fff);padding-bottom:30px}
.bc{display:flex;gap:8px;align-items:center;padding:22px 0 16px;color:#666;font-size:14px}.bc b{color:#e5252a;font-weight:400;max-width:300px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.pd{display:grid;grid-template-columns:70px 450px 1fr;gap:18px;align-items:start}
.th{display:flex;flex-direction:column;gap:10px}
.th img{width:64px;height:64px;object-fit:cover;border-radius:8px;border:2px solid #e5e5e5;cursor:pointer;background:#ececec}.th img.on{border-color:#e5252a}
.main{position:relative;border-radius:16px;overflow:hidden;background:#ececec;height:450px}.main img{width:100%;height:100%;object-fit:cover}
.btns{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:22px;grid-column:2}
.btn{border-radius:6px;padding:12px;text-align:center;font-weight:500;font-size:16px;cursor:pointer;font-family:inherit;border:1px solid #ddd;background:#fff;display:block}
.btn.red{background:#e5352f;color:#fff;border-color:#e5352f}.btn:disabled{opacity:.5;cursor:not-allowed}
.info{background:#fff;padding:20px 0 20px 16px;grid-column:3;grid-row:1/span 2}
.info h1{font-size:25px;line-height:1.3;font-weight:600}
.sd{color:#666;line-height:1.7;margin:18px 0}
.sold{display:inline-flex;gap:10px;background:#f5f5f7;border-radius:8px;padding:12px 14px;font-size:14px;margin-bottom:18px}.stk{color:#1f9d5a;font-weight:500}.nstk{color:#e5252a;font-weight:500}
.price{border-top:1px solid #eee;padding-top:18px;display:flex;align-items:center;gap:12px}
.price b{font-size:34px;font-weight:600}.price s{color:#999;font-size:17px}
.pb{border:1px solid #1f9d5a;color:#1f9d5a;background:#eefaf3;border-radius:6px;padding:4px 10px;font-size:14px;font-weight:500}
.free{font-size:14px;color:#555;margin:10px 0 16px;padding-bottom:16px;border-bottom:1px solid #eee}
.lang{font-weight:500;margin-bottom:12px}.lg{display:inline-block;border:1px solid #e5252a;color:#e5252a;border-radius:8px;padding:8px 18px;background:#fff6f6}
.qty{display:flex;align-items:center;gap:10px;margin:18px 0 0;border-top:1px solid #eee;padding-top:16px;font-weight:500}
.qty input{width:70px;padding:8px;border:1px solid #ddd;border-radius:6px;font-family:inherit}
.rt{margin-top:16px;border-top:1px solid #eee;padding-top:16px}
.rate{background:#f5f5f7;border-radius:6px;padding:4px 10px;font-size:12px;color:#666;display:inline-flex;gap:6px;align-items:center}.rate i{color:#f5333f;font-style:normal}
.tabs{width:min(1000px,92%);margin:30px auto 0;border:1px solid #eee;border-radius:18px;box-shadow:0 2px 12px rgba(0,0,0,.05);overflow:hidden}
.tabs h6{font-size:15px;font-weight:500;color:#e5252a;padding:18px 28px 14px;border-bottom:1px solid #eee;display:inline-block;border-bottom:2px solid #e5252a;margin:0 0 0 0}
.tabw{border-bottom:1px solid #eee}
.desc{padding:26px 28px;line-height:1.75;color:#333}.desc p{margin-bottom:16px}.desc h3,.desc h4{margin:20px 0 10px;font-size:18px}.desc ul{margin:0 0 16px 24px}.desc li{margin-bottom:6px}
@media(max-width:1000px){.pd{grid-template-columns:1fr}.th{flex-direction:row;order:2}.btns,.info{grid-column:auto;grid-row:auto}.main{height:360px}}
CSS;
include 'includes/header.php'; ?>
<div class="hero"><div class="wrap"><div class="bc"><a href="index.php">⌂ Home</a> › <a href="products.php">Products</a> › <b><?=e($p['name'])?></b></div>
<div class="pd">
<div class="th"><?php foreach($imgs as $i=>$im):?><img src="<?=e(img($im))?>" class="<?=$i?'':'on'?>" onclick="sw(this)"><?php endforeach;?></div>
<div class="main"><img id="mi" src="<?=e(img($imgs[0]))?>"></div>
<div class="info"><h1><?=e($p['name'])?></h1><p class="sd"><?=e($p['short_desc'])?></p>
<div class="sold"><span><?=number_format($p['sold'])?>+ Sold</span><?=$p['in_stock']?'<span class="stk">In Stock</span>':'<span class="nstk">Out of Stock</span>'?></div>
<div class="price"><b><?=money($p['price'])?></b><?php if($p['mrp']>$p['price']):?><s><?=money($p['mrp'])?></s><span class="pb"><?=$off?>% OFF</span><?php endif;?></div>
<div class="free">🚚 FREE Delivery on this order</div>
<div class="lang">Language: <?=e($p['language'])?></div><span class="lg"><?=e($p['language'])?></span>
<?php if($p['in_stock']):?><div class="qty">Quantity <input type="number" id="qty" value="1" min="1" max="20"></div><?php endif;?>
<div class="rt"><span class="rate"><i>★</i><?=e($p['rating'])?><?=$p['rating_text']?' | '.e($p['rating_text']):''?></span></div></div>
<div class="btns"><button class="btn" <?=$p['in_stock']?'':'disabled'?> onclick="addCart(<?=$p['id']?>,qv())">🛒 Add to Cart</button>
<button class="btn red" <?=$p['in_stock']?'':'disabled'?> onclick="location='cart.php?add=<?=$p['id']?>&buy=1&qty='+qv()">Buy Now</button></div>
</div></div></div>
<div class="tabs"><div class="tabw"><h6>Overview</h6></div><div class="desc"><?=$p['description']?></div></div>
<script>function qv(){var q=document.getElementById('qty');return q?Math.max(1,parseInt(q.value)||1):1}
function sw(el){document.getElementById('mi').src=el.src;document.querySelectorAll('.th img').forEach(i=>i.classList.remove('on'));el.classList.add('on')}</script>
<?php include 'includes/footer.php';
