<?php
require_once '../config.php'; $err='';
if(!empty($_SESSION['admin'])){header('Location: index.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $a=one("SELECT * FROM admins WHERE email=?",[trim($_POST['email']??'')]);
  if($a&&password_verify($_POST['password']??'',$a['password'])){$_SESSION['admin']=$a['id'];header('Location: index.php');exit;}
  $err='Email ya password galat hai';
}
?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}body{font-family:'Outfit',sans-serif;background:#131a2e;min-height:100vh;display:flex;align-items:center;justify-content:center}
form{background:#fff;width:min(400px,92%);padding:34px;border-radius:16px}.lg{background:#fff200;color:#e5252a;font-family:Impact,sans-serif;font-size:30px;padding:0 8px;display:inline-block;margin-bottom:12px}
h1{font-size:22px;margin-bottom:16px}label{display:block;font-size:13px;font-weight:500;margin:14px 0 5px}input{width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;font-family:inherit;font-size:14px}
button{width:100%;background:#e5252a;color:#fff;border:0;padding:13px;border-radius:8px;font-size:16px;margin-top:20px;cursor:pointer;font-family:inherit}.err{background:#ffe9ea;color:#c0171c;padding:10px;border-radius:8px;font-size:14px;margin-bottom:6px}
</style></head><body><form method="post"><span class="lg">LPT</span><h1>Admin Login</h1><?php if($err):?><div class="err"><?=e($err)?></div><?php endif;?>
<label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" required><button>Login</button></form></body></html>
