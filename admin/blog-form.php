<?php include '_top.php';
$id=(int)($_GET['id']??0);$b=$id?one("SELECT * FROM blogs WHERE id=?",[$id]):null;
if($_SERVER['REQUEST_METHOD']==='POST'){
  $t=trim($_POST['title']);$ex=trim($_POST['excerpt']);$co=$_POST['content'];$im=save_upload($_FILES['image']??[]);
  if($b){q("UPDATE blogs SET title=?,slug=?,excerpt=?,content=? WHERE id=?",[$t,uniq_slug('blogs',$t,$id),$ex,$co,$id]);if($im)q("UPDATE blogs SET image=? WHERE id=?",[$im,$id]);}
  else q("INSERT INTO blogs(title,slug,excerpt,content,image) VALUES(?,?,?,?,?)",[$t,uniq_slug('blogs',$t),$ex,$co,$im]);
  flash('Blog save ho gaya');header('Location: blogs.php');exit;
} ?>
<h1><?=$b?'Edit':'Add'?> Blog</h1>
<form method="post" enctype="multipart/form-data" class="card"><label>Title</label><input name="title" required value="<?=e($b['title']??'')?>">
<label>Short Excerpt</label><textarea name="excerpt" rows="2"><?=e($b['excerpt']??'')?></textarea>
<label>Content (HTML allowed)</label><textarea name="content" rows="14"><?=e($b['content']??'')?></textarea>
<label>Image</label><input type="file" name="image" accept="image/*"><?php if($b&&$b['image']):?><div class="gal"><div><img src="<?=e(img($b['image']))?>"></div></div><?php endif;?>
<br><button class="btn">Save Blog</button> <a class="btn d" href="blogs.php">Cancel</a></form>
<?php include '_bottom.php';
