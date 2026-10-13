<?php include '_top.php';
if(isset($_GET['del'])){q("DELETE FROM categories WHERE id=?",[(int)$_GET['del']]);flash('Category delete ho gayi');header('Location: categories.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $id=(int)($_POST['id']??0);$n=trim($_POST['name']);$st=trim($_POST['section_title']);$so=(int)$_POST['sort_order'];
  if($id){q("UPDATE categories SET name=?,slug=?,section_title=?,sort_order=? WHERE id=?",[$n,uniq_slug('categories',$n,$id),$st,$so,$id]);flash('Category update ho gayi');}
  else{q("INSERT INTO categories(name,slug,section_title,sort_order) VALUES(?,?,?,?)",[$n,uniq_slug('categories',$n),$st,$so]);flash('Category add ho gayi');}
  header('Location: categories.php');exit;
}
$edit=isset($_GET['edit'])?one("SELECT * FROM categories WHERE id=?",[(int)$_GET['edit']]):null;
$rows=q("SELECT c.*,(SELECT COUNT(*) FROM products WHERE category_id=c.id) pc FROM categories c ORDER BY sort_order,id"); ?>
<h1>Categories</h1>
<div class="card"><h3><?=$edit?'Edit':'Add'?> Category</h3><form method="post"><input type="hidden" name="id" value="<?=$edit['id']??0?>">
<div class="g3"><div><label>Name</label><input name="name" required value="<?=e($edit['name']??'')?>"></div><div><label>Home Section Title</label><input name="section_title" placeholder="Popular CLAT UG Books" value="<?=e($edit['section_title']??'')?>"></div><div><label>Sort Order</label><input type="number" name="sort_order" value="<?=e($edit['sort_order']??0)?>"></div></div>
<br><button class="btn"><?=$edit?'Update':'Add Category'?></button> <?php if($edit):?><a class="btn d" href="categories.php">Cancel</a><?php endif;?></form></div>
<div class="card sc"><table><tr><th>#</th><th>Name</th><th>Slug</th><th>Products</th><th>Order</th><th></th></tr>
<?php foreach($rows as $r):?><tr><td><?=$r['id']?></td><td><?=e($r['name'])?></td><td><?=e($r['slug'])?></td><td><?=$r['pc']?></td><td><?=$r['sort_order']?></td>
<td><a class="btn s b" href="?edit=<?=$r['id']?>">Edit</a> <a class="btn s" href="?del=<?=$r['id']?>" onclick="return confirm('Delete karna hai?')">Delete</a></td></tr><?php endforeach;?></table></div>
<?php include '_bottom.php';
