<?php
require_once 'config.php';
$title='Order Placed';
$pageCss=<<<'CSS'
.ok{text-align:center;padding:90px 0 40px}.ok .c{width:80px;height:80px;border-radius:50%;background:#e6f7ef;color:#1f9d5a;font-size:42px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px}
.ok h1{font-size:28px;margin-bottom:10px}.ok p{color:#666;margin-bottom:8px}.btn{display:inline-block;background:#e5252a;color:#fff;padding:12px 26px;border-radius:8px;margin:20px 6px 0}
CSS;
include 'includes/header.php'; ?>
<main class="wrap ok"><div class="c">✓</div><h1>Order Place Ho Gaya!</h1><p>Order No: <b><?=e($_GET['no']??'')?></b></p><p>Payment: Cash on Delivery</p>
<a class="btn" href="my-order.php">My Orders</a><a class="btn" style="background:#222" href="index.php">Continue Shopping</a></main>
<?php include 'includes/footer.php';
