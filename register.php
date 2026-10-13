<?php
require_once 'config.php';
$next=safe_next($_GET['next']??$_POST['next']??'index.php'); $err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $n=trim($_POST['name']);$em=trim($_POST['email']);$ph=trim($_POST['phone']);$pw=$_POST['password'];
  if(strlen($pw)<6)$err='Password kam se kam 6 character ka ho';
  elseif($pw!==$_POST['cpassword'])$err='Password match nahi hua';
  elseif(one("SELECT id FROM users WHERE email=?",[$em]))$err='Ye email pehle se registered hai';
  else{q("INSERT INTO users(name,email,phone,password) VALUES(?,?,?,?)",[$n,$em,$ph,password_hash($pw,PASSWORD_DEFAULT)]);$_SESSION['user']=['id'=>$db->insert_id,'name'=>$n];header('Location: '.$next);exit;}
}
$title='Register';
$pageCss='.ab{width:min(430px,92%);margin:50px auto;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,.12);padding:34px}.ab h1{font-size:26px;margin-bottom:6px}.ab p.s{color:#777;margin-bottom:18px;font-size:14px}.ab label{display:block;font-size:13px;font-weight:500;margin:14px 0 5px}.ab input{width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;font-family:inherit;font-size:14px}.ab input:focus{outline:0;border-color:#e5252a}.ab button{width:100%;background:#e5252a;color:#fff;border:0;padding:13px;border-radius:8px;font-size:16px;font-weight:500;margin-top:22px;cursor:pointer;font-family:inherit}.ab .err{background:#ffe9ea;color:#c0171c;padding:10px 14px;border-radius:8px;margin-top:10px;font-size:14px}.ab .alt{text-align:center;margin-top:18px;font-size:14px}.ab .alt a{color:#e5252a;font-weight:500}';
include 'includes/header.php'; ?>
<main><form class="ab" method="post"><h1>Register</h1><p class="s">Naya account banao</p>
<?php if($err):?><div class="err"><?=e($err)?></div><?php endif;?>
<input type="hidden" name="next" value="<?=e($next)?>">
<label>Full Name</label><input name="name" required value="<?=e($_POST['name']??'')?>"><label>Email</label><input type="email" name="email" required value="<?=e($_POST['email']??'')?>">
<label>Phone</label><input name="phone" required pattern="[0-9]{10}" maxlength="10" value="<?=e($_POST['phone']??'')?>">
<label>Password</label><input type="password" name="password" required><label>Confirm Password</label><input type="password" name="cpassword" required>
<button>Register</button><div class="alt">Pehle se account hai? <a href="login.php?next=<?=e($next)?>">Login</a></div></form></main>
<?php include 'includes/footer.php';
