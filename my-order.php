<?php
require_once 'config.php';
if(empty($_SESSION['user'])){header('Location: login.php?next=my-order.php');exit;}
$orders=q("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC",[$_SESSION['user']['id']]);
$title='My Orders';
$pageCss=<<<'CSS'
h1{font-size:24px;margin:30px 0 20px;padding-left:12px;border-left:3px solid #e5252a;line-height:24px}
.o{border-radius:14px;box-shadow:0 2px 10px rgba(0,0,0,.08);margin-bottom:18px;overflow:hidden}
.oh{display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px;background:#f7f7f9;padding:14px 18px;font-size:14px}
.st{padding:3px 12px;border-radius:20px;font-size:12px;font-weight:600;background:#fff3cd;color:#8a6d00}.st.Delivered{background:#e6f7ef;color:#1f9d5a}.st.Cancelled{background:#ffe9ea;color:#c0171c}.st.Shipped,.st.Confirmed{background:#e9ecff;color:#3b4bd8}
.it{display:flex;gap:14px;align-items:center;padding:12px 18px;border-top:1px solid #eee;font-size:14px}.it img{width:56px;height:56px;border-radius:8px;object-fit:cover}.it span{flex:1}
.empty{text-align:center;padding:70px 0;color:#777}
CSS;
include 'includes/header.php'; ?>
<main class="wrap"><h1>My Orders</h1>
<?php if(!$orders):?><div class="empty">Abhi tak koi order nahi hai.</div><?php endif;?>
<?php foreach($orders as $o):?><div class="o"><div class="oh"><span>Order <b>#<?=e($o['order_no'])?></b> • <?=date('d M Y',strtotime($o['created_at']))?></span><span><b><?=money($o['total'])?></b> • <?=e($o['payment'])?></span><span class="st <?=e($o['status'])?>"><?=e($o['status'])?></span></div>
<?php foreach(q("SELECT * FROM order_items WHERE order_id=?",[$o['id']]) as $i):?><div class="it"><img src="<?=e(img($i['image']))?>"><span><?=e($i['name'])?> × <?=$i['qty']?></span><b><?=money($i['price']*$i['qty'])?></b></div><?php endforeach;?></div><?php endforeach;?></main>
<?php include 'includes/footer.php';
