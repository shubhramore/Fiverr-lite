<?php
require_once "config.php";
require_login();
$user_id=$_SESSION['user']['id'];

$gigCount=$pdo->prepare("SELECT COUNT(*) FROM gigs WHERE seller_id=?");
$gigCount->execute([$user_id]);
$orders=$pdo->prepare("SELECT COUNT(*) FROM orders WHERE buyer_id=? OR seller_id=?");
$orders->execute([$user_id,$user_id]);
$wallet=$pdo->prepare("SELECT COALESCE(SUM(amount),0) FROM payments WHERE receiver_id=? AND status='released'");
$wallet->execute([$user_id]);
include "header.php";
?>
<h1>Dashboard</h1>
<div class="stats">
<div><strong><?= $gigCount->fetchColumn() ?></strong><span>Your Gigs</span></div>
<div><strong><?= $orders->fetchColumn() ?></strong><span>Your Orders</span></div>
<div><strong>₹<?= number_format($wallet->fetchColumn(),2) ?></strong><span>Released Earnings</span></div>
</div>
<div class="card">
<h2>Welcome, <?= e($_SESSION['user']['name']) ?>!</h2>
<p>Your role: <b><?= e(ucfirst($_SESSION['user']['role'])) ?></b></p>
<p>Use the navigation bar to post gigs, place orders, chat and manage escrow payments.</p>
</div>
<?php include "footer.php"; ?>
