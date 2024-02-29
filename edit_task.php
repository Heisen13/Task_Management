<?php
session_start();
include("config.php");

if (isset($_POST['update'])) {
    // Retrieve task details from the database based on ID
    $id = $_POST['id'];
    $query = "SELECT * FROM `tasks` WHERE `id` = '$id'";
    $result = mysqli_query($con, $query);
    $task = mysqli_fetch_assoc($result);

    if (!$task) {
        $_SESSION['status'] = "Task not found.";
        $_SESSION['status_code'] = "error";
        header("Location: index.php");
        exit();
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
  .text-center {
            color: #007bff;
            margin-bottom: 20px;
        }
</style>
<div class="container mt-4">
    <h1 class="text-center">Update Task</h1>
    <form action="process.php" method="POST">
        <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="updated_title" value="<?= $task['title']; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="updated_description" value="<?= $task['description']; ?>">
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="updated_due_date" value="<?= $task['due_date']; ?>">
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-control" id="priority" name="updated_priority">
                <option value="low" <?= ($task['priority'] == 'low') ? 'selected' : ''; ?>>Low</option>
                <option value="medium" <?= ($task['priority'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                <option value="high" <?= ($task['priority'] == 'high') ? 'selected' : ''; ?>>High</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="update_task">Update Task</button>
    </form>
</div>

<!-- Bootstrap and other scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

</body>
</html>

<?php
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    header("Location: index.php");
    exit();
}
?>