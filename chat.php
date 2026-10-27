<?php
require_once "config.php";
require_login();
$uid=$_SESSION['user']['id'];
$users=$pdo->prepare("SELECT id,name FROM users WHERE id<>? ORDER BY name");
$users->execute([$uid]); $users=$users->fetchAll();
$to=(int)($_GET['to'] ?? ($users[0]['id'] ?? 0));

if($_SERVER['REQUEST_METHOD']==='POST'){
    $to=(int)$_POST['receiver_id'];
    $message=trim($_POST['message']);
    if($message){
        $stmt=$pdo->prepare("INSERT INTO messages(sender_id,receiver_id,message) VALUES(?,?,?)");
        $stmt->execute([$uid,$to,$message]);
    }
    header("Location: chat.php?to=".$to); exit;
}
$msg=$pdo->prepare("SELECT m.*,u.name sender_name FROM messages m JOIN users u ON u.id=m.sender_id
WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?) ORDER BY m.created_at");
$msg->execute([$uid,$to,$to,$uid]); $messages=$msg->fetchAll();
include "header.php";
?>
<h1>Buyer-Seller Chat</h1>
<div class="chat-layout">
<aside class="people">
<h3>Users</h3>
<?php foreach($users as $u): ?><a href="chat.php?to=<?= $u['id'] ?>" class="<?= $to==$u['id']?'active':'' ?>"><?= e($u['name']) ?></a><?php endforeach; ?>
</aside>
<section class="chat">
<div class="messages">
<?php foreach($messages as $m): ?><div class="message <?= $m['sender_id']==$uid?'mine':'' ?>"><b><?= e($m['sender_name']) ?></b><br><?= e($m['message']) ?><small><?= e($m['created_at']) ?></small></div><?php endforeach; ?>
</div>
<?php if($to): ?><form method="post" class="chat-form"><input type="hidden" name="receiver_id" value="<?= $to ?>"><input name="message" placeholder="Type a message..." required><button class="btn">Send</button></form><?php endif; ?>
</section>
</div>
<?php include "footer.php"; ?>
