<?php
require_once "config.php";
if (logged_in()) { header("Location: dashboard.php"); exit; }
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'] ?? 'buyer';

    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = "Enter valid details. Password must be at least 6 characters.";
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)");
            $stmt->execute([$name,$email,$hash,$role]);
            flash("success","Registration successful. Please login.");
            header("Location: login.php"); exit;
        } catch (PDOException $e) {
            $error = "Email already registered.";
        }
    }
}
include "header.php";
?>
<div class="form-card">
<h2>Create Account</h2>
<?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<label>Name<input name="name" required></label>
<label>Email<input type="email" name="email" required></label>
<label>Password<input type="password" name="password" required></label>
<label>Account Type
<select name="role">
<option value="buyer">Buyer</option>
<option value="seller">Freelancer / Seller</option>
</select></label>
<button class="btn">Register</button>
</form>
<p>Already registered? <a href="login.php">Login</a></p>
</div>
<?php include "footer.php"; ?>
