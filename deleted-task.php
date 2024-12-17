<?php 
include 'db.php';

$id=$_GET['id'];

if ($id) {
    $stmt = $conn->prepare("update tasks set is_completed=3 where id=?");
    $stmt->bind_param('i', $id);        
    $stmt->execute();
    $stmt->close();

}
header('Location: index.php');


?>