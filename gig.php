<?php
require_once "config.php";
$id=(int)($_GET['id'] ?? 0);
$stmt=$pdo->prepare("SELECT g.*,u.name seller_name,u.id seller_id FROM gigs g JOIN users u ON g.seller_id=u.id WHERE g.id=?");
$stmt->execute([$id]); $gig=$stmt->fetch();
if(!$gig){ die("Gig not found."); }
$reviews=$pdo->prepare("SELECT r.*,u.name FROM reviews r JOIN users u ON r.reviewer_id=u.id WHERE r.gig_id=? ORDER BY r.created_at DESC");
$reviews->execute([$id]);
include "header.php";
?>
<div class="detail">
<div class="detail-main">
<p class="category"><?= e($gig['category']) ?></p>
<h1><?= e($gig['title']) ?></h1>
<p><?= nl2br(e($gig['description'])) ?></p>
<p class="seller">Freelancer: <b><?= e($gig['seller_name']) ?></b></p>
</div>
<aside class="order-box">
<h2>₹<?= number_format($gig['price'],2) ?></h2>
<?php if(logged_in() && $_SESSION['user']['id'] != $gig['seller_id']): ?>
<form method="post" action="create_order.php">
<input type="hidden" name="gig_id" value="<?= $gig['id'] ?>">
<button class="btn full">Order This Gig</button>
</form>
<?php elseif(!logged_in()): ?>
<a class="btn full" href="login.php">Login to Order</a>
<?php else: ?><p>You cannot order your own gig.</p><?php endif; ?>
</aside>
</div>

<h2>Reviews</h2>
<?php foreach($reviews as $r): ?>
<div class="review"><b><?= e($r['name']) ?></b> — ★ <?= $r['rating'] ?><p><?= e($r['comment']) ?></p></div>
<?php endforeach; ?>
<?php include "footer.php"; ?>
