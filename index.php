<?php
require_once 'config.php';
$title='LPT Store - Law Prep Tutorial Books';
$pageCss=<<<'CSS'
.cats{display:flex;gap:44px;padding:22px 0 18px 30px;overflow-x:auto}
.cat{text-align:center;font-size:13px;min-width:64px}
.cat span{display:flex;width:46px;height:46px;border-radius:14px;align-items:center;justify-content:center;margin:0 auto 8px}
.banner{display:block;border-radius:22px;overflow:hidden;margin:6px 0 40px;background:#f1f1f3}
.banner img{width:100%;display:block}
.sec-t{font-size:18px;font-weight:600;margin:0 0 18px;padding-left:12px;border-left:3px solid #e5252a;line-height:18px}
.sec{margin-bottom:46px}
@media(max-width:800px){.cats{gap:24px;padding-left:0}} 
@media(max-width:480px){.cats{gap:18px;padding:14px 0;scrollbar-width:thin}.cat{min-width:58px;font-size:12px}.cat span{width:40px;height:40px;border-radius:12px}.banner{border-radius:12px;margin:4px 0 28px}.sec{margin-bottom:32px}.sec-t{font-size:16px;margin-bottom:13px}.grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.ci{height:clamp(125px,38vw,180px)}.cb{padding:9px 9px 10px}.ct{font-size:12px;line-height:1.35;height:33px}.tagrow{margin-top:7px;height:18px}.off{font-size:10px;padding:2px 10px 2px 6px}.pr b{font-size:12px}.pr s{display:none}.cartb{width:30px;height:30px;border-radius:8px}.cartb svg{width:17px;height:17px}}
@media(max-width:360px){.grid{grid-template-columns:1fr;gap:14px}.ci{height:210px}.cb{padding:12px}.ct{font-size:13px;height:36px}.pr b{font-size:14px}.cats{gap:14px}}
.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.card{background:#fff;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.12);overflow:hidden;display:flex;flex-direction:column}
.ci{position:relative;display:block;background:#ececec;height:240px;overflow:hidden}
.ci img{width:100%;height:100%;object-fit:cover}
.rate{position:absolute;left:8px;bottom:8px;background:#fff;border-radius:6px;padding:2px 8px;font-size:12px;color:#666;display:flex;gap:5px;align-items:center}
.rate i{color:#f5333f;font-style:normal}.rate u{width:1px;height:12px;background:#ccc;display:inline-block}
.cb{padding:12px 14px 14px}
.ct{font-size:14px;line-height:1.4;height:40px;overflow:hidden;color:#222;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
.tagrow{margin-top:10px;height:20px}
.off{background:#2e9d63;color:#fff;font-size:12px;font-weight:600;padding:2px 16px 2px 8px;clip-path:polygon(0 0,100% 0,90% 50%,100% 100%,0 100%);display:inline-block}
.cf{display:flex;align-items:center;justify-content:space-between;margin-top:6px}
.pr b{font-size:15px;font-weight:600}.pr s{font-size:11px;color:#999;margin-left:6px}
.cartb{width:38px;height:38px;border:0;border-radius:10px;background:#f1f1f3;cursor:pointer;display:flex;align-items:center;justify-content:center}
.cartb:hover{background:#ffe3e4}.oos{font-size:12px;color:#e5252a;font-weight:500}
@media(max-width:900px){.grid{grid-template-columns:repeat(2,1fr)}.ci{height:190px}}

CSS;
include 'includes/header.php';
// Show every category in the top icon strip.
// Keep homepage product sections limited to CLAT UG, CLAT PG, and Judiciary.
$homeCats = $cats;
$homeProductKeywords = ['clat ug', 'clat pg', 'judiciary'];
$homeProductCats = array_values(array_filter($cats, function($c) use ($homeProductKeywords) {
    $name = strtolower(trim($c['name'] ?? ''));
    $slug = strtolower(trim($c['slug'] ?? ''));
    foreach ($homeProductKeywords as $keyword) {
        if ($name === $keyword || $slug === str_replace(' ', '-', $keyword) || $slug === str_replace(' ', '_', $keyword)) return true;
    }
    return false;
}));
$colors=['#fdf1e7','#e6f7ef','#e9ecff','#fdecf3','#fff4e5','#e6f7f4'];$ic=['#f08a3c','#2cae7a','#4a5be8','#e8478f','#f0a43c','#2cae9a'];
?>
<main class="wrap">
<div class="cats"><?php foreach($homeCats as $i=>$c):?>
<a class="cat" href="products.php?cat=<?=e($c['slug'])?>"><span style="background:<?=$colors[$i%6]?>"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="<?=$ic[$i%6]?>" stroke-width="1.8"><path d="M4 4h5v16H4zM9 4h5v16H9zM15 5l4.5-1 3 15-4.5 1z"/></svg></span><?=e($c['name'])?></a>
<?php endforeach;?></div>

<a class="banner" href="products.php"><img src="assets/images/banner.png" alt="Banner" onerror="this.parentNode.style.display='none'"></a>

<?php $n=0; foreach($homeProductCats as $c):
  $ps=q("SELECT * FROM products WHERE category_id=? ORDER BY id DESC LIMIT 4",[$c['id']]);
  if(!$ps) continue; $n++; ?>
<section class="sec"><h2 class="sec-t"><?=e($c['section_title']?:'Popular '.$c['name'].' Products')?></h2>
<div class="grid"><?php foreach($ps as $p) card($p);?></div></section>
<?php if($n==2):?><a class="banner" href="products.php"><img src="assets/images/banner1.png" alt="Banner" onerror="this.parentNode.style.display='none'"></a><?php endif;?>
<?php endforeach;?>

</main>
<?php include 'includes/footer.php';
