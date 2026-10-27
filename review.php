<?php
require_once "config.php";
require_login();
$order_id=(int)($_GET['order'] ?? $_POST['order_id'] ?? 0);
$stmt=$pdo->prepare("SELECT * FROM orders WHERE id=? AND buyer_id=? AND status='completed'");
$stmt->execute([$order_id,$_SESSION['user']['id']]); $order=$stmt->fetch();
if(!$order) die("Invalid review request.");
if($_SERVER['REQUEST_METHOD']==='POST'){
    $rating=max(1,min(5,(int)$_POST['rating']));
    $comment=trim($_POST['comment']);
    $stmt=$pdo->prepare("INSERT INTO reviews(order_id,gig_id,reviewer_id,rating,comment) VALUES(?,?,?,?,?)");
    $stmt->execute([$order_id,$order['gig_id'],$_SESSION['user']['id'],$rating,$comment]);
    flash("success","Review submitted.");
    header("Location: gig.php?id=".$order['gig_id']); exit;
}
include "header.php";
?>
<div class="form-card">
<h2>Rate Completed Work</h2>
<form method="post">
<input type="hidden" name="order_id" value="<?= $order_id ?>">
<label>Rating
<select name="rating"><option>5</option><option>4</option><option>3</option><option>2</option><option>1</option></select></label>
<label>Comment<textarea name="comment" rows="5" required></textarea></label>
<button class="btn">Submit Review</button>
</form>
</div>
<?php include "footer.php"; ?>
