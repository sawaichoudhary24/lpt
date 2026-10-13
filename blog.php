<?php
require_once 'config.php';
$bs=q("SELECT * FROM blogs ORDER BY id DESC");$title='Blog';
$pageCss=<<<'CSS'
h1{font-size:24px;margin:30px 0 20px;padding-left:12px;border-left:3px solid #e5252a;line-height:24px}
.blogs{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.bl{border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,.1);overflow:hidden;background:#fff}
.bl img{width:100%;height:190px;object-fit:cover;background:#ececec;display:block}
.bl div{padding:14px}.bl h3{font-size:16px;margin-bottom:6px}.bl p{font-size:13px;color:#666;line-height:1.5}.bl small{color:#999}
@media(max-width:800px){.blogs{grid-template-columns:1fr}}
CSS;
include 'includes/header.php'; ?>
<main class="wrap"><h1>Blog</h1><div class="blogs"><?php foreach($bs as $b):?><a class="bl" href="blog-detail.php?slug=<?=e($b['slug'])?>"><img src="<?=e(img($b['image']))?>"><div><small><?=date('d M Y',strtotime($b['created_at']))?></small><h3><?=e($b['title'])?></h3><p><?=e($b['excerpt'])?></p></div></a><?php endforeach;?></div></main>
<?php include 'includes/footer.php';
