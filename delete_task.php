<?php
session_start();
include("config.php");

if(isset($_POST['delete'])){
    $id = $_POST['id'];
    
    // Fetch task details for confirmation dialog
    $query = "SELECT * FROM `tasks` WHERE `id` = '$id'";
    $result = mysqli_query($con, $query);
    $task = mysqli_fetch_assoc($result);

    if (!$task) {
        $_SESSION['status'] = "Task not found.";
        $_SESSION['status_code'] = "error";
        header("Location: index.php");
        exit();
    }

    // Display confirmation dialog
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Task</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <style>
                body {
                    background-color: #f8f9fa;
                    color: #343a40;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background-color: #fff;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    color: red;
                    text-align: center;
                    margin-bottom: 30px;
                }
                .form-label {
                    font-weight: bold;
                }
                .btn-back {
                    margin-top: 20px;
                }
                .confirmation {
                    color: red;
                    font-weight: bold;
                }
            </style>
    </head>
    <body>
    <div class="container">
                <h1>Delete Task</h1>
                <div class="mb-3">
                    <p class="form-label"><strong>ID:</strong> <?= $task['id']; ?></p>
                </div>
                <div class="mb-3">
                    <p class="form-label"><strong>Title:</strong> <?= $task['title']; ?></p>
                </div>
                <div class="mb-3">
                    <p class="form-label"><strong>Description:</strong> <?= $task['description']; ?></p>
                </div>
                <div class="mb-3">
                    <p class="form-label"><strong>Priority:</strong> <?= $task['priority']; ?></p>
                </div>
                <div class="mb-3">
                    <p class="form-label"><strong>Due Date:</strong> <?= $task['due_date']; ?></p>
                </div>
                <p class="mb-3 confirmation">Are you sure you want to delete this task?</p>
                <form action="process.php" method="POST">
                    <input type="hidden" name="id" value="<?= $task['id']; ?>">
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
    </body>
    </html>
    <?php
    exit();
}

// Redirect to index.php if delete request is not valid
$_SESSION['status'] = "Invalid delete request.";
$_SESSION['status_code'] = "error";
header("Location: index.php");
exit();
?>