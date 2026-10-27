<?php
require_once "config.php";
require_login();
$error="";
if ($_SESSION['user']['role'] !== 'seller') {
    flash("error","Only seller accounts can post gigs.");
    header("Location: dashboard.php"); exit;
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $title=trim($_POST['title']); $category=trim($_POST['category']);
    $description=trim($_POST['description']); $price=(float)$_POST['price'];
    if (!$title || !$description || $price<=0) $error="Fill all fields with a valid price.";
    else {
        $stmt=$pdo->prepare("INSERT INTO gigs(seller_id,title,category,description,price) VALUES(?,?,?,?,?)");
        $stmt->execute([$_SESSION['user']['id'],$title,$category,$description,$price]);
        flash("success","Gig posted successfully.");
        header("Location: index.php"); exit;
    }
}
include "header.php";
?>
<div class="form-card">
<h2>Post a New Gig</h2>
<?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<label>Gig Title<input name="title" placeholder="I will build a responsive website" required></label>
<label>Category<input name="category" placeholder="Web Development" required></label>
<label>Description<textarea name="description" rows="6" required></textarea></label>
<label>Price (₹)<input type="number" name="price" min="1" step="0.01" required></label>
<button class="btn">Publish Gig</button>
</form>
</div>
<?php include "footer.php"; ?>
