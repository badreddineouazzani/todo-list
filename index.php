<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
}
include 'db.php';
include 'send_mailer.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $task_name = $_POST['task_name'];
    if(!empty($task_name)){

        $stmt = $conn->prepare("INSERT INTO tasks (task_name, created_At) VALUES (?, NOW())");
        $stmt->bind_param('s', $task_name);        
        $stmt->execute();
        $stmt->close();

        $to="EMAILTO@gmail.com";
        $subject="New Task Added";
        $message="A new task has been added to your TODO-LIST: $task_name";
        sendMail($to, $subject, $message); 

    }
}
$open_task=$conn->query('select * from tasks where is_completed=0');
$in_progress_task=$conn->query('select * from tasks where is_completed=1');
$close_task=$conn->query('select * from tasks where is_completed=2');
$deleted_task=$conn->query('select * from tasks where is_completed=3');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>TODO-LIST</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo Text -->
            <a class="navbar-brand" href="#">ToDoList</a>
            <!-- Toggle Button for Mobile View -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['user_id'])){?>
                    
                    
                    <li class="nav-item">
                        <a class="nav-link" href="Logout.php">Logout</a>
                    </li>
                    <?php }else{?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">
            code with me
        </h1>
        <form class="mb-4" action="./index.php" method="POST">
            <div class="input-group">
                <input type="text" name="task_name" class="form-control" placeholder="New task ...." required>
                <button class="btn btn-primary" type="submit"> ADD</button>
            </div>
        </form>
        <div class="row">
            <div class="col-md-3">
                <h2 class="text-center">OPEN TASKs</h2>
                <ul class="list-group">
                    <?php if($open_task->num_rows >0) { ?>
                        <?php while($row=$open_task->fetch_assoc()){?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $row['task_name'];?>
                        <div>
                            <a href="inprogress_task.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"> Progress</a>
                            <a href="deleted-task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </li>
                    <?php }}else{?>

                        <li class="list-group-item">No task open</li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-3">
                <h2 class="text-center">In Progress TASKs</h2>
                <ul class="list-group">
                    <?php if($in_progress_task->num_rows >0) { ?>
                        <?php while($row=$in_progress_task->fetch_assoc()){?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo $row['task_name'];?>
                        <div>
                            <a href="closed_tasks.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Close</a>
                            <a href="deleted-task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </li>
                    <?php }}else{?>

                        <li class="list-group-item">No task open</li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-3">
                <h2 class="text-center">Closed Tasks</h2>
                <ul class="list-group">
                <?php if($close_task->num_rows >0) { ?>
                    <?php while($row=$close_task->fetch_assoc()){?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $row['task_name'];?>
                        <div>
                            <a href="deleted-task.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </li>
                    <?php }}else{?>

                    <li class="list-group-item">No task close</li>
                    <?php }?>
                </ul>
            </div>
            <div class="col-md-3">
                <h2 class="text-center">Deleted Tasks</h2>
                <ul class="list-group">
                <?php if($deleted_task->num_rows >0) { ?>
                    <?php while($row=$deleted_task->fetch_assoc()){?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $row['task_name'];?>
                       
                    </li>
                    <?php }}else{?>

                    <li class="list-group-item">No task close</li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</body>
</html>