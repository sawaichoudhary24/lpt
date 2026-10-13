<?php include '_top.php';
if(isset($_GET['del'])){q("DELETE FROM blogs WHERE id=?",[(int)$_GET['del']]);flash('Blog delete ho gaya');header('Location: blogs.php');exit;}
$rows=q("SELECT * FROM blogs ORDER BY id DESC"); ?>
<h1>Blogs <a class="btn" style="float:right;font-size:14px" href="blog-form.php">+ Add Blog</a></h1>
<div class="card sc"><table><tr><th>Image</th><th>Title</th><th>Date</th><th></th></tr>
<?php foreach($rows as $r):?><tr><td><img src="<?=e(img($r['image']))?>"></td><td><?=e($r['title'])?></td><td><?=date('d M Y',strtotime($r['created_at']))?></td>
<td><a class="btn s b" href="blog-form.php?id=<?=$r['id']?>">Edit</a> <a class="btn s" href="?del=<?=$r['id']?>" onclick="return confirm('Delete karna hai?')">Delete</a></td></tr><?php endforeach;?></table></div>
<?php include '_bottom.php';
