<?php
session_start();
include("config.php");

// Handle all form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'])) {
        // Delete task
        $id = $_POST['id'];
        $query = "DELETE FROM `tasks` WHERE `id` = '$id'";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $update_query = "SET @count = 0; UPDATE `tasks` SET `id` = @count:= @count + 1; ALTER TABLE `tasks` AUTO_INCREMENT = 1;";
            $update_query_run = mysqli_multi_query($con, $update_query);

            if ($update_query_run) {
                $_SESSION['status'] = "Task deleted successfully.";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Error updating task IDs.";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['status'] = "Task deletion failed.";
            $_SESSION['status_code'] = "error";
        }
    } elseif (isset($_POST["insertTask"])) {
        // Insert new task
        $title = $_POST['title'];
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $due_date = $_POST['due_date'];

        if (empty($title) || empty($description)) {
            $_SESSION['status'] = "Please make sure all required fields are filled in before submitting.";
            $_SESSION['status_code'] = "error";
        } else {
            // Insert task into database
            $query = "INSERT INTO `tasks`(`title`, `description`, `priority`, `due_date`) VALUES ('$title', '$description', '$priority', '$due_date')";
            $query_result = mysqli_query($con, $query);

            if ($query_result) {
                $_SESSION['status'] = "Task added!";
                $_SESSION['status_code'] = "success";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['status'] = "Failed to add task.";
                $_SESSION['status_code'] = "error";
            }
        }
    } elseif (isset($_POST["update_task"])) {
        // Update task
        $task_id = $_POST['task_id'];
        $updated_title = $_POST['updated_title'];
        $updated_description = $_POST['updated_description'];
        $updated_due_date = $_POST['updated_due_date'];
        $updated_priority = $_POST['updated_priority'];

        // Update task details in the database
        $query = "UPDATE `tasks` SET `title` = '$updated_title', `description` = '$updated_description', `due_date` = '$updated_due_date', `priority` = '$updated_priority' WHERE `id` = '$task_id'";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $_SESSION['status'] = "Task updated successfully!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Task update failed.";
            $_SESSION['status_code'] = "error";
        }
    } else {
        // If no valid action is detected, redirect to index.php with an error message
        $_SESSION['status'] = "Invalid request.";
        $_SESSION['status_code'] = "error";
    }
}

// Redirect back to create_task.php or index.php after processing form submission
if ($_SESSION['status_code'] == 'error') {
    header("Location: create_task.php");
} else {
    header("Location: index.php");
}
exit();
?>
