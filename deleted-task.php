<?php 
include 'db.php';
include 'send_mailer.php';


if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $task_name=$_GET['task_name'];
    $stmt = $conn->prepare("update tasks set is_completed=3 where id=?");
    $stmt->bind_param('i', $id);        
    $stmt->execute();
    $stmt->close();
    $to="EMAILTO@gmail.com";
    $subject="New Task DELETED";
    $message="the task : $task_name has been deleted from your TODO-LIST";
    sendMail($to, $subject, $message);

}
header('Location: index.php');


?>