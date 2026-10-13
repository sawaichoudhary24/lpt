<?php include '_top.php';
if(isset($_GET['del'])){$id=(int)$_GET['del'];q("DELETE FROM product_images WHERE product_id=?",[$id]);q("DELETE FROM products WHERE id=?",[$id]);flash('Product delete ho gaya');header('Location: products.php');exit;}
$rows=q("SELECT p.*,c.name cname FROM products p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC"); ?>
<h1>Products <a class="btn" style="float:right;font-size:14px" href="product-form.php">+ Add Product</a></h1>
<div class="card sc"><table><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Rating</th><th>Stock</th><th></th></tr>
<?php foreach($rows as $r):?><tr><td><img src="<?=e(img($r['image']))?>"></td><td><?=e(mb_strimwidth($r['name'],0,55,'...'))?></td><td><?=e($r['cname'])?></td><td><?=money($r['price'])?> <small><s><?=money($r['mrp'])?></s></small></td><td>★ <?=e($r['rating'])?> | <?=e($r['rating_text'])?></td><td><?=$r['in_stock']?'<span style="color:#1f9d5a">In Stock</span>':'<span style="color:#e5252a">Out</span>'?></td>
<td><a class="btn s b" href="product-form.php?id=<?=$r['id']?>">Edit</a> <a class="btn s" href="?del=<?=$r['id']?>" onclick="return confirm('Delete karna hai?')">Delete</a></td></tr><?php endforeach;?></table></div>
<?php include '_bottom.php';
