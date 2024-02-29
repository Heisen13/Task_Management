<?php
session_start();
include("config.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM `tasks` WHERE `id` = '$id'";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Task Details</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <link rel="stylesheet" href="style.css">
            <style>
                body {
                    background-color: #f8f9fa;
                    color: #343a40;
                }
                .container {
                    max-width: 600px;
                    margin-top: 50px;
                    background-color: #fff;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    color: #007bff;
                    text-align: center;
                    margin-bottom: 30px;
                }
                .form-label {
                    font-weight: bold;
                }
                .btn-back {
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Task Details</h1>
                <div class="mb-3">
                    <p class="form-label"><strong>ID:</strong> <?= $row['id']; ?></p>
                </div>
                <div class="mb-3">
                    <p class="form-label"><strong>Title:</strong> <?= $row['title']; ?></p>
                </div>
                <div class="mb-3">
                    <p class="form-label"><strong>Description:</strong> <?= $row['description']; ?></p>
                </div>
                <div class="mb-3">
                    <p class="form-label"><strong>Priority:</strong> <?= $row['priority']; ?></p>
                </div>
                <div class="mb-3">
                    <p class="form-label"><strong>Due Date:</strong> <?= $row['due_date']; ?></p>
                </div>
                <a href="index.php" class="btn btn-primary btn-back">Back to Tasks</a>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-6NeDyJQ30JlOJS1eEuOjmJvTjAjLAwkW/pAiNtM9HIp9d8hvpUbdG8rh8qjy6qHJ" crossorigin="anonymous"></script>
        </body>
        </html>
        <?php
    } else {
        $_SESSION['status'] = "Task not found.";
        $_SESSION['status_code'] = "error";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['status'] = "Task ID not provided.";
    $_SESSION['status_code'] = "error";
    header("Location: index.php");
    exit();
}
?>