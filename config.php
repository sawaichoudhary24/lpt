<?php
// ====== DATABASE SETTINGS ======
$DB_HOST='localhost'; $DB_USER='root'; $DB_PASS=''; $DB_NAME='lpt_store';
// ===============================
mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
if(session_status()===PHP_SESSION_NONE) session_start();
$db=new mysqli($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME); $db->set_charset('utf8mb4');

$docroot=rtrim(str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']),'/');
define('BASE', rtrim(substr(str_replace('\\','/',__DIR__),strlen($docroot)),'/').'/');

// default admin (admin@gmail.com / admin123) - pehli baar auto ban jata hai
if(!$db->query("SELECT id FROM admins LIMIT 1")->num_rows){
  $h=password_hash('admin123',PASSWORD_DEFAULT); $em='admin@gmail.com';
  $st=$db->prepare("INSERT INTO admins(email,password) VALUES(?,?)"); $st->bind_param('ss',$em,$h); $st->execute();
}
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function q($sql,$p=[]){global $db;$st=$db->prepare($sql);if($p){$st->bind_param(str_repeat('s',count($p)),...$p);}$st->execute();$r=$st->get_result();return $r?$r->fetch_all(MYSQLI_ASSOC):[];}
function one($sql,$p=[]){$r=q($sql,$p);return $r?$r[0]:null;}
function money($n){return '₹'.number_format((float)$n);}
function slugify($t){$s=strtolower(trim(preg_replace('/[^A-Za-z0-9]+/','-',$t),'-'));return $s?:'item';}
function uniq_slug($table,$t,$id=0){$b=slugify($t);$s=$b;$i=1;while(one("SELECT id FROM $table WHERE slug=? AND id<>?",[$s,$id])){$s=$b.'-'.(++$i);}return $s;}
function img($f){return ($f && file_exists(__DIR__.'/uploads/'.$f))?BASE.'uploads/'.$f:BASE.'assets/images/placeholder.svg';}
function save_upload($f){if(empty($f['name'])||$f['error']!==0)return '';$x=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));if(!in_array($x,['jpg','jpeg','png','webp','gif']))return '';$n=uniqid('img_').'.'.$x;move_uploaded_file($f['tmp_name'],__DIR__.'/uploads/'.$n);return $n;}
function discount($p){return $p['mrp']>$p['price']?round(($p['mrp']-$p['price'])*100/$p['mrp']):0;}
function safe_next($n){return preg_match('/^[A-Za-z0-9_\-\.\?=&]+$/',(string)$n)?$n:'index.php';}
function card($p){
  $off=discount($p); $out=!$p['in_stock'];
  echo '<div class="card"><a class="ci" href="product.php?slug='.e($p['slug']).'"><img src="'.e(img($p['image'])).'" alt="'.e($p['name']).'" loading="lazy"><span class="rate"><i>★</i>'.e($p['rating']).($p['rating_text']?' <u></u> '.e($p['rating_text']):'').'</span></a>';
  echo '<div class="cb"><a class="ct" href="product.php?slug='.e($p['slug']).'">'.e($p['name']).'</a>';
  echo '<div class="tagrow">'.($off?'<span class="off">'.$off.'% OFF</span>':'&nbsp;').'</div><div class="cf"><div class="pr"><b>'.money($p['price']).'/-</b>'.($p['mrp']>$p['price']?'<s>'.money($p['mrp']).'/-</s>':'').'</div>';
  echo $out?'<span class="oos">Out of stock</span>':'<button class="cartb" title="Add to cart" onclick="addCart('.$p['id'].')"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#222" stroke-width="1.8"><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.6 12h11l2-8H6.5M14 5v4M12 7h4"/></svg></button>';
  echo '</div></div></div>';
}
