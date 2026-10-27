<?php
require_once "config.php";
$stmt = $pdo->query("SELECT g.*, u.name AS seller_name,
    (SELECT AVG(r.rating) FROM reviews r WHERE r.gig_id=g.id) AS avg_rating,
    (SELECT COUNT(*) FROM reviews r WHERE r.gig_id=g.id) AS review_count
    FROM gigs g JOIN users u ON g.seller_id=u.id ORDER BY g.created_at DESC");
$gigs = $stmt->fetchAll();
include "header.php";
?>
<section class="hero">
    <div>
        <p class="eyebrow">FREELANCE MARKETPLACE</p>
        <h1>Find talent. Post work.<br><span>Get it done.</span></h1>
        <p>Hire freelancers, order gigs, chat with sellers and simulate secure escrow payments.</p>
        <a class="btn" href="#gigs">Browse Gigs</a>
    </div>
</section>

<div class="section-head" id="gigs">
    <h2>Available Gigs</h2>
    <p><?= count($gigs) ?> services available</p>
</div>

<div class="grid">
<?php foreach ($gigs as $gig): ?>
<article class="card">
    <div class="gig-icon"><?= strtoupper(substr($gig['title'],0,1)) ?></div>
    <p class="category"><?= e($gig['category']) ?></p>
    <h3><?= e($gig['title']) ?></h3>
    <p><?= e(substr($gig['description'],0,120)) ?>...</p>
    <p class="seller">By <?= e($gig['seller_name']) ?></p>
    <div class="card-bottom">
        <strong>₹<?= number_format($gig['price'],2) ?></strong>
        <span>★ <?= $gig['avg_rating'] ? number_format($gig['avg_rating'],1) : 'New' ?></span>
    </div>
    <a class="btn outline full" href="gig.php?id=<?= $gig['id'] ?>">View Gig</a>
</article>
<?php endforeach; ?>
</div>
<?php include "footer.php"; ?>
