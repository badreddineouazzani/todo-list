<?php 
include 'db.php';

$id=$_GET['id'];

if ($id) {
    $stmt = $conn->prepare("delete from tasks where id=?");
    $stmt->bind_param('i', $id);        
    $stmt->execute();
    $stmt->close();

}
header('Location: index.php');


?>