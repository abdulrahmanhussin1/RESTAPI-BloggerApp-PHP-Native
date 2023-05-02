<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['user_id']) && $_GET['user_id'] != " ") {
        $user_id = $_GET['user_id'];
        //sanitizing 
        $title = sanitizeInput($_POST['title']);
        $body = sanitizeInput($_POST['body']);
        $image = sanitizeInput($_POST['image']);

        //validations
        //Title
        if (requiredInput($title)) {
            return response("title required", 500);
        } elseif (minLength($title, 4)) {
            return response("title length must be more then 4 letters", 500);
        } elseif (maxLength($title, 100)) {
            return response("title length must be less then 100 letters", 500);
        } elseif (numericInput($title)) {
            return response("title must be contain at least one letter", 500);
        }

        //body
        if (requiredInput($body)) {
            return response("body required", 500);
        } elseif (minLength($body, 10)) {
            return response("body length must be more then 10 letters", 500);
        } elseif (maxLength($body, 500)) {
            return response("body length must be less then 500 letters", 500);
        } elseif (numericInput($body)) {
            return response("body must be contain at least one letter", 500);
        }
        //user_id
        //Title
        if (requiredInput($user_id)) {
            return response("user_id required", 500);
        } elseif (!numericInput($user_id)) {
            return response("user_id must be number", 500);
        }

        // Store Post

        $query = "SELECT `id` FROM `blogApi`.`users` where `id` = '$user_id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) < 1) {
            header("Content-Type: application/json");
            return response("invalid  user and user not found", 405);
        } else {
            $query = "INSERT INTO `posts` (`id`, `title`, `body`, `image`, `user_id`, `created_at`, `updated_at`) VALUES (NULL, '$title', '$body', NULL , '$user_id', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
            $result = mysqli_query($conn, $query);
            if ($result) {
                header("Content-Type: application/json");
                return response("post stored successfully", 200);
            } else {
                header("Content-Type: application/json");
                return response("error in storing post", 405);
            }
        }
    } else {
        header("Content-Type: application/json");
        return response("user or id not valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
