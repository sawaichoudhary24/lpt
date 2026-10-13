<?php include '_top.php';
$id=(int)($_GET['id']??0);$p=$id?one("SELECT * FROM products WHERE id=?",[$id]):null;
if(isset($_GET['delimg'])){q("DELETE FROM product_images WHERE id=?",[(int)$_GET['delimg']]);header("Location: product-form.php?id=$id");exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $d=[(int)$_POST['category_id'],trim($_POST['name']),trim($_POST['short_desc']),$_POST['description'],(float)$_POST['price'],(float)$_POST['mrp'],(float)$_POST['rating'],trim($_POST['rating_text']),(int)$_POST['sold'],trim($_POST['language']),$_POST['ptype'],isset($_POST['frequency'])?'monthly':'',isset($_POST['in_stock'])?1:0,(int)$_POST['stock_qty']];
  $main=save_upload($_FILES['image']??[]);
  if($p){
    $slug=uniq_slug('products',$d[1],$id);
    q("UPDATE products SET category_id=?,name=?,short_desc=?,description=?,price=?,mrp=?,rating=?,rating_text=?,sold=?,language=?,ptype=?,frequency=?,in_stock=?,stock_qty=?,slug=? WHERE id=?",array_merge($d,[$slug,$id]));
    if($main)q("UPDATE products SET image=? WHERE id=?",[$main,$id]);
  }else{
    q("INSERT INTO products(category_id,name,short_desc,description,price,mrp,rating,rating_text,sold,language,ptype,frequency,in_stock,stock_qty,slug,image) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array_merge($d,[uniq_slug('products',$d[1]),$main]));
    $id=$db->insert_id;
  }
  if(!empty($_FILES['gallery']['name'][0])){foreach($_FILES['gallery']['name'] as $i=>$nm){
    $f=['name'=>$nm,'tmp_name'=>$_FILES['gallery']['tmp_name'][$i],'error'=>$_FILES['gallery']['error'][$i]];
    if($x=save_upload($f))q("INSERT INTO product_images(product_id,image) VALUES(?,?)",[$id,$x]);}}
  flash('Product save ho gaya');header('Location: products.php');exit;
}
$cats=q("SELECT * FROM categories ORDER BY sort_order,id");$gal=$id?q("SELECT * FROM product_images WHERE product_id=?",[$id]):[];
$v=fn($k,$d='')=>e($p[$k]??$d); ?>
<h1><?=$p?'Edit':'Add'?> Product</h1>
<form method="post" enctype="multipart/form-data" class="card">
<div class="g2"><div><label>Category</label><select name="category_id" required><?php foreach($cats as $c):?><option value="<?=$c['id']?>" <?=($p['category_id']??0)==$c['id']?'selected':''?>><?=e($c['name'])?></option><?php endforeach;?></select></div>
<div><label>Product Type</label><select name="ptype"><?php foreach(['Books','Bookset','Combo Pack','Magazine','Mock Tests','Other'] as $t):?><option <?=($p['ptype']??'')==$t?'selected':''?>><?=$t?></option><?php endforeach;?></select></div></div>
<label>Product Name</label><input name="name" required value="<?=$v('name')?>">
<label>Short Description</label><textarea name="short_desc" rows="3"><?=$v('short_desc')?></textarea>
<label>Full Description / Overview (HTML allowed)</label><textarea name="description" rows="10"><?=$v('description')?></textarea>
<div class="g3"><div><label>Selling Price (₹)</label><input type="number" step="0.01" name="price" required value="<?=$v('price')?>"></div><div><label>MRP (₹)</label><input type="number" step="0.01" name="mrp" required value="<?=$v('mrp')?>"></div><div><label>Language</label><input name="language" value="<?=$v('language','English')?>"></div></div>
<div class="g3"><div><label>Rating (0-5)</label><input type="number" step="0.1" min="0" max="5" name="rating" value="<?=$v('rating','5.0')?>"></div><div><label>Rating Count (e.g. 23k)</label><input name="rating_text" value="<?=$v('rating_text')?>"></div><div><label>Sold Count</label><input type="number" name="sold" value="<?=$v('sold',0)?>"></div></div>
<div class="g3"><div><label>Stock Quantity (0 = limit nahi)</label><input type="number" name="stock_qty" value="<?=$v('stock_qty',0)?>"></div><div><label>&nbsp;</label><label style="margin:0"><input type="checkbox" name="in_stock" <?=($p['in_stock']??1)?'checked':''?>> In Stock</label></div><div><label>&nbsp;</label><label style="margin:0"><input type="checkbox" name="frequency" <?=($p['frequency']??'')=='monthly'?'checked':''?>> Monthly product (magazine)</label></div></div>
<label>Main Image</label><input type="file" name="image" accept="image/*"><?php if($p&&$p['image']):?><div class="gal"><div><img src="<?=e(img($p['image']))?>">Current</div></div><?php endif;?>
<label>More Images (gallery - multiple select)</label><input type="file" name="gallery[]" accept="image/*" multiple>
<?php if($gal):?><div class="gal"><?php foreach($gal as $g):?><div><img src="<?=e(img($g['image']))?>"><a style="color:#e5252a" href="?id=<?=$id?>&delimg=<?=$g['id']?>">Remove</a></div><?php endforeach;?></div><?php endif;?>
<br><button class="btn">Save Product</button> <a class="btn d" href="products.php">Cancel</a></form>
<?php include '_bottom.php';
