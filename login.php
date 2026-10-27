<?php
require_once "config.php";
if (logged_in()) { header("Location: dashboard.php"); exit; }
$error="";
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([trim($_POST['email'])]);
    $user=$stmt->fetch();
    if ($user && password_verify($_POST['password'],$user['password'])) {
        unset($user['password']);
        $_SESSION['user']=$user;
        header("Location: dashboard.php"); exit;
    }
    $error="Invalid email or password.";
}
include "header.php";
?>
<div class="form-card">
<h2>Login</h2>
<?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<label>Email<input type="email" name="email" required></label>
<label>Password<input type="password" name="password" required></label>
<button class="btn">Login</button>
</form>
<p>Demo: register two accounts (one buyer and one seller).</p>
</div>
<?php include "footer.php"; ?>
