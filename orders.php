<?php
require_once "config.php";
require_login();
$user_id=$_SESSION['user']['id'];
$stmt=$pdo->prepare("SELECT o.*,g.title,b.name buyer_name,s.name seller_name
FROM orders o JOIN gigs g ON o.gig_id=g.id
JOIN users b ON o.buyer_id=b.id JOIN users s ON o.seller_id=s.id
WHERE o.buyer_id=? OR o.seller_id=? ORDER BY o.created_at DESC");
$stmt->execute([$user_id,$user_id]); $orders=$stmt->fetchAll();
include "header.php";
?>
<h1>Orders</h1>
<div class="table-wrap"><table>
<tr><th>Gig</th><th>Buyer</th><th>Seller</th><th>Amount</th><th>Status</th><th>Action</th></tr>
<?php foreach($orders as $o): ?>
<tr>
<td><?= e($o['title']) ?></td><td><?= e($o['buyer_name']) ?></td><td><?= e($o['seller_name']) ?></td>
<td>₹<?= number_format($o['amount'],2) ?></td><td><span class="badge"><?= e($o['status']) ?></span></td>
<td>
<?php if($o['seller_id']==$user_id && $o['status']==='escrow'): ?>
<form method="post" action="deliver.php" class="inline"><input type="hidden" name="id" value="<?= $o['id'] ?>"><button class="btn small">Mark Delivered</button></form>
<?php elseif($o['buyer_id']==$user_id && $o['status']==='delivered'): ?>
<form method="post" action="release.php" class="inline"><input type="hidden" name="id" value="<?= $o['id'] ?>"><button class="btn small">Release Payment</button></form>
<?php elseif($o['status']==='completed'): ?>
<a class="btn small outline" href="review.php?order=<?= $o['id'] ?>">Review</a>
<?php endif; ?>
</td></tr>
<?php endforeach; ?>
</table></div>
<?php include "footer.php"; ?>
