<?php
require_once 'config.php';
$slug = $_GET['cat'] ?? '';
$qs = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'latest';
$types = array_filter((array)($_GET['type'] ?? []));
$freq = !empty($_GET['freq']);
$allCats = q("SELECT * FROM categories ORDER BY sort_order,id");
$cur = null;
foreach ($allCats as $c) if ($c['slug'] === $slug) $cur = $c;
$w = ['1=1'];
$p = [];
if ($cur) {
  $w[] = 'category_id=?';
  $p[] = $cur['id'];
}
if ($qs !== '') {
  $w[] = '(name LIKE ? OR short_desc LIKE ?)';
  $p[] = "%$qs%";
  $p[] = "%$qs%";
}
if ($types) {
  $w[] = 'ptype IN (' . implode(',', array_fill(0, count($types), '?')) . ')';
  foreach ($types as $t) $p[] = $t;
}
if ($freq) $w[] = "frequency='monthly'";
$order = ['latest' => 'id DESC', 'low' => 'price ASC', 'high' => 'price DESC', 'popular' => 'sold DESC'][$sort] ?? 'id DESC';
$ps = q("SELECT * FROM products WHERE " . implode(' AND ', $w) . " ORDER BY $order", $p);
$head = $cur ? 'Best ' . $cur['name'] . ' Preparation Books For CLAT 2027/28' : ($qs !== '' ? 'Search results for "' . $qs . '"' : 'All Products');
if ($cur && stripos($cur['name'], 'clat') === false) $head = 'Best ' . $cur['name'] . ' Preparation Products';
$title = $head;
$pageCss = <<<'CSS'
.bc{display:flex;gap:8px;align-items:center;padding:22px 0 14px;color:#666;font-size:14px}.bc b{color:#e5252a;font-weight:400}
.top{display:flex;justify-content:space-between;align-items:center}
.sort{border:1px solid #ddd;border-radius:6px;padding:9px 14px;font-family:inherit;font-size:14px;color:#555;min-width:170px;background:#fff}
.lay{display:grid;grid-template-columns:260px 1fr;gap:26px;margin-top:6px;align-items:start}
.flt{border:1px solid #eee;border-radius:16px;padding:22px;box-shadow:0 1px 6px rgba(0,0,0,.05);position:sticky;top:80px}
.flt-h{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding-bottom:14px;margin-bottom:14px}
.flt-h h3{font-size:19px;font-weight:600}.flt-h a{color:#e5252a;font-size:14px}
.flt h5{font-size:13px;font-weight:600;letter-spacing:.3px;margin:8px 0 10px;text-transform:uppercase;color:#333}
.flt label{display:flex;align-items:center;gap:10px;font-size:14px;margin-bottom:14px;cursor:pointer}
.flt input{accent-color:#1a73e8;width:17px;height:17px}.flt hr{border:0;border-top:1px solid #eee;margin:10px 0 14px}
h1.h{font-size:21px;font-weight:600;margin:6px 0 16px}
.grid{grid-template-columns:repeat(3,1fr)}
.empty{padding:60px;text-align:center;color:#777}
@media(max-width:900px){.lay{grid-template-columns:1fr}.flt{position:static}.grid{grid-template-columns:repeat(2,1fr)}}
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

.grid{grid-template-columns:repeat(3,1fr)}@media(max-width:900px){.grid{grid-template-columns:repeat(2,1fr)}}
CSS;
include 'includes/header.php';
$typeList = ['Books', 'Bookset', 'Combo Pack', 'Magazine', 'Mock Tests'];
?>
<main class="wrap">
  <form method="get" id="f">
    <div class="top">
      <div class="bc"><a href="index.php">⌂ Home</a> › <a href="products.php">Products</a> › <b><?= e($cur['name'] ?? 'All') ?></b></div>
      <select class="sort" name="sort" onchange="f.submit()"><?php foreach (['latest' => 'Latest', 'popular' => 'Popular', 'low' => 'Price: Low to High', 'high' => 'Price: High to Low'] as $k => $v): ?><option value="<?= $k ?>" <?= $sort == $k ? 'selected' : '' ?>><?= $v ?></option><?php endforeach; ?></select>
    </div>
    <?php if ($qs !== ''): ?><input type="hidden" name="q" value="<?= e($qs) ?>"><?php endif; ?>
    <div class="lay">
      <aside class="flt">
        <div class="flt-h">
          <h3>Filter</h3><a href="products.php">Clear All</a>
        </div>
        <h5>Category</h5>
        <?php foreach ($allCats as $c): ?><label><input type="radio" name="cat" value="<?= e($c['slug']) ?>" <?= $slug === $c['slug'] ? 'checked' : '' ?> onchange="f.submit()"><?= e($c['name']) ?></label><?php endforeach; ?>
        <hr>
        <h5>Frequency</h5><label><input type="checkbox" name="freq" value="1" <?= $freq ? 'checked' : '' ?> onchange="f.submit()">Monthly</label>
        <hr>
        <h5>Product Type</h5>
        <?php foreach ($typeList as $t): ?><label><input type="checkbox" name="type[]" value="<?= e($t) ?>" <?= in_array($t, $types) ? 'checked' : '' ?> onchange="f.submit()"><?= e($t) ?></label><?php endforeach; ?>
      </aside>
      <section>
        <h1 class="h"><?= e($head) ?></h1>
        <?php if ($ps): ?><div class="grid"><?php foreach ($ps as $x) card($x); ?></div><?php else: ?><div class="empty">Koi product nahi mila.</div><?php endif; ?>
      </section>
    </div>
  </form>
</main>
<?php include 'includes/footer.php';
