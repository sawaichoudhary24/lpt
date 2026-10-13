<?php
require_once 'config.php';
$b=one("SELECT * FROM blogs WHERE slug=?",[$_GET['slug']??'']);if(!$b){header('Location: blog.php');exit;}
$title=$b['title'];
$pageCss=<<<'CSS'
.art{width:min(820px,92%);margin:30px auto}.art h1{font-size:30px;line-height:1.3;margin-bottom:8px}.art small{color:#888}
.art img.hero{width:100%;border-radius:16px;margin:20px 0;max-height:420px;object-fit:cover}
.body{line-height:1.8;color:#333}.body p{margin-bottom:16px}.body h2,.body h3{margin:22px 0 10px}.body ul{margin:0 0 16px 24px}
CSS;
include 'includes/header.php'; ?>
<article class="art"><a href="blog.php" style="color:#e5252a">← All Blogs</a><h1 style="margin-top:14px"><?=e($b['title'])?></h1><small><?=date('d M Y',strtotime($b['created_at']))?></small>
<?php if($b['image']):?><img class="hero" src="<?=e(img($b['image']))?>"><?php endif;?><div class="body"><?=$b['content']?></div></article>
<?php include 'includes/footer.php';
