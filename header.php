<?php require_once "config.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fiverr-lite Marketplace</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar">
    <a class="brand" href="index.php">Fiverr<span>-lite</span></a>
    <div class="navlinks">
        <a href="index.php">Gigs</a>
        <?php if (logged_in()): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="post_gig.php">Post Gig</a>
            <a href="orders.php">Orders</a>
            <a href="chat.php">Chat</a>
            <span class="user">Hi, <?= e($_SESSION['user']['name']) ?></span>
            <a class="btn small" href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a class="btn small" href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>
<main class="container">
<?php show_flash(); ?>
