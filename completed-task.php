<?php 
include 'db.php';

if ( isset($_GET['id'])) {
    $id=$_GET['id'];
    $stmt = $conn->prepare("update tasks set is_completed=1 where id=?");
    $stmt->bind_param('i', $id);        
    $stmt->execute();
    $stmt->close();

}
header('Location: index.php');
?>