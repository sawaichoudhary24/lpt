<?php
require_once 'config.php';
$next = safe_next($_GET['next'] ?? $_POST['next'] ?? 'index.php');
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = one("SELECT * FROM users WHERE email=?", [trim($_POST['email'] ?? '')]);
  if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
    $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['name']];
    header('Location: ' . $next);
    exit;
  }
  $err = 'Email ya password galat hai';
}
$title = 'Login';
$pageCss = '.ab{width:min(430px,92%);margin:50px auto;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,.12);padding:34px}.ab h1{font-size:26px;margin-bottom:6px}.ab p.s{color:#777;margin-bottom:18px;font-size:14px}.ab label{display:block;font-size:13px;font-weight:500;margin:14px 0 5px}.ab input{width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;font-family:inherit;font-size:14px}.ab input:focus{outline:0;border-color:#e5252a}.ab button{width:100%;background:#e5252a;color:#fff;border:0;padding:13px;border-radius:8px;font-size:16px;font-weight:500;margin-top:22px;cursor:pointer;font-family:inherit}.ab .err{background:#ffe9ea;color:#c0171c;padding:10px 14px;border-radius:8px;margin-top:10px;font-size:14px}.ab .alt{text-align:center;margin-top:18px;font-size:14px}.ab .alt a{color:#e5252a;font-weight:500}';
include 'includes/header.php'; ?>
<main>
  <form class="ab" method="post">
    <h1>Login</h1>
    <p class="s">Apne account me login karo</p>
    <?php if ($err): ?><div class="err"><?= e($err) ?></div><?php endif; ?>
    <input type="hidden" name="next" value="<?= e($next) ?>">
    <label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" required>
    <button>Login</button>
    <div class="alt">Account nahi hai? <a href="register.php?next=<?= e($next) ?>">Register karo</a></div>
  </form>
</main>
<?php include 'includes/footer.php';
