<?php
require_once "config.php";
require_login();
$id=(int)$_POST['id'];
$pdo->beginTransaction();
try {
    $stmt=$pdo->prepare("SELECT * FROM orders WHERE id=? AND buyer_id=? AND status='delivered' FOR UPDATE");
    $stmt->execute([$id,$_SESSION['user']['id']]); $o=$stmt->fetch();
    if(!$o) throw new Exception();
    $pdo->prepare("UPDATE orders SET status='completed' WHERE id=?")->execute([$id]);
    $pdo->prepare("UPDATE payments SET status='released',released_at=NOW() WHERE order_id=?")->execute([$id]);
    $pdo->commit();
    flash("success","Escrow released to the freelancer.");
} catch(Exception $e) {
    $pdo->rollBack(); flash("error","Payment could not be released.");
}
header("Location: orders.php"); exit;
