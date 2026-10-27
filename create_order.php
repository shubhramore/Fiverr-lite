<?php
require_once "config.php";
require_login();
$gig_id=(int)$_POST['gig_id'];
$stmt=$pdo->prepare("SELECT * FROM gigs WHERE id=?");
$stmt->execute([$gig_id]); $gig=$stmt->fetch();
if(!$gig || $gig['seller_id']==$_SESSION['user']['id']) { die("Invalid order."); }

$pdo->beginTransaction();
try {
    $stmt=$pdo->prepare("INSERT INTO orders(gig_id,buyer_id,seller_id,amount,status) VALUES(?,?,?,?, 'escrow')");
    $stmt->execute([$gig_id,$_SESSION['user']['id'],$gig['seller_id'],$gig['price']]);
    $order_id=$pdo->lastInsertId();
    $stmt=$pdo->prepare("INSERT INTO payments(order_id,payer_id,receiver_id,amount,status) VALUES(?,?,?,?, 'held')");
    $stmt->execute([$order_id,$_SESSION['user']['id'],$gig['seller_id'],$gig['price']]);
    $pdo->commit();
    flash("success","Order created. Payment is now held in simulated escrow.");
    header("Location: orders.php"); exit;
} catch(Exception $e) {
    $pdo->rollBack(); die("Could not create order.");
}
