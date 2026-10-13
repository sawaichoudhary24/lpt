<?php include '_top.php';
if($_SERVER['REQUEST_METHOD']==='POST'){q("UPDATE orders SET status=? WHERE id=?",[$_POST['status'],(int)$_POST['id']]);flash('Order status update ho gaya');header('Location: orders.php');exit;}
$rows=q("SELECT * FROM orders ORDER BY id DESC"); ?>
<h1>Orders</h1>
<?php foreach($rows as $o):?><div class="card"><div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px"><div><b>#<?=e($o['order_no'])?></b> • <?=date('d M Y h:i A',strtotime($o['created_at']))?><br><?=e($o['name'])?> • <?=e($o['phone'])?> • <?=e($o['email'])?><br><small><?=e($o['address'])?>, <?=e($o['city'])?>, <?=e($o['state'])?> - <?=e($o['pincode'])?></small></div>
<form method="post" style="display:flex;gap:8px;align-items:flex-start"><input type="hidden" name="id" value="<?=$o['id']?>"><select name="status" style="width:140px"><?php foreach(['Pending','Confirmed','Shipped','Delivered','Cancelled'] as $s):?><option <?=$o['status']==$s?'selected':''?>><?=$s?></option><?php endforeach;?></select><button class="btn s">Update</button></form></div>
<table style="margin-top:10px"><?php foreach(q("SELECT * FROM order_items WHERE order_id=?",[$o['id']]) as $i):?><tr><td><img src="<?=e(img($i['image']))?>"></td><td><?=e($i['name'])?></td><td>× <?=$i['qty']?></td><td><?=money($i['price']*$i['qty'])?></td></tr><?php endforeach;?></table>
<p style="text-align:right;margin-top:8px"><b>Total: <?=money($o['total'])?></b> (<?=e($o['payment'])?>)</p></div><?php endforeach;?>
<?php if(!$rows):?><div class="card">Abhi koi order nahi hai.</div><?php endif;?>
<?php include '_bottom.php';
