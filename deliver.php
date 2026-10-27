<?php
require_once "config.php";
require_login();
$id=(int)$_POST['id'];
$stmt=$pdo->prepare("UPDATE orders SET status='delivered' WHERE id=? AND seller_id=? AND status='escrow'");
$stmt->execute([$id,$_SESSION['user']['id']]);
flash("success","Order marked as delivered. Buyer can now release escrow.");
header("Location: orders.php"); exit;
