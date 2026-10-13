<?php include '_top.php';
$c=fn($t)=>one("SELECT COUNT(*) n FROM $t")['n'];
$rev=one("SELECT COALESCE(SUM(total),0) n FROM orders WHERE status<>'Cancelled'")['n'];
$recent=q("SELECT * FROM orders ORDER BY id DESC LIMIT 6"); ?>
<h1>Dashboard</h1>
<div class="stats"><div class="card"><b><?=$c('products')?></b><span>Products</span></div><div class="card"><b><?=$c('categories')?></b><span>Categories</span></div><div class="card"><b><?=$c('orders')?></b><span>Orders</span></div><div class="card"><b><?=money($rev)?></b><span>Revenue</span></div></div>
<div class="card"><h3 style="margin-bottom:10px">Recent Orders</h3><div class="sc"><table><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr>
<?php foreach($recent as $o):?><tr><td>#<?=e($o['order_no'])?></td><td><?=e($o['name'])?></td><td><?=money($o['total'])?></td><td><?=e($o['status'])?></td></tr><?php endforeach;?></table></div></div>
<?php include '_bottom.php';
