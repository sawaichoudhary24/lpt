<?php
require_once 'config.php';
if (empty($_SESSION['user']) || empty($_SESSION['cart']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: cart.php');
  exit;
}
$f = [];
foreach (['name', 'phone', 'email', 'address', 'city', 'state', 'pincode'] as $k) $f[$k] = trim($_POST[$k] ?? '');
if (in_array('', $f, true)) {
  header('Location: checkout.php?err=' . urlencode('Saari details bharo'));
  exit;
}
$items = [];
$total = 0;
foreach ($_SESSION['cart'] as $id => $n) {
  $p = one("SELECT * FROM products WHERE id=? AND in_stock=1", [$id]);
  if ($p) {
    $p['qty'] = $n;
    $total += $p['price'] * $n;
    $items[] = $p;
  }
}
if (!$items) {
  header('Location: cart.php');
  exit;
}
$no = 'LPT' . date('ymd') . rand(1000, 9999);
q(
  "INSERT INTO orders(order_no,user_id,name,phone,email,address,city,state,pincode,total,payment,status) VALUES(?,?,?,?,?,?,?,?,?,?,'COD','Pending')",
  [$no, $_SESSION['user']['id'], $f['name'], $f['phone'], $f['email'], $f['address'], $f['city'], $f['state'], $f['pincode'], $total]
);
$oid = $db->insert_id;
foreach ($items as $p) {
  q("INSERT INTO order_items(order_id,product_id,name,price,qty,image) VALUES(?,?,?,?,?,?)", [$oid, $p['id'], $p['name'], $p['price'], $p['qty'], $p['image']]);
  $db->query("UPDATE products SET in_stock=IF(stock_qty>0 AND stock_qty-" . (int)$p['qty'] . "<=0,0,in_stock),stock_qty=GREATEST(stock_qty-" . (int)$p['qty'] . ",0),sold=sold+" . (int)$p['qty'] . " WHERE id=" . (int)$p['id']);
}
$_SESSION['cart'] = [];
header('Location: order-success.php?no=' . $no);
