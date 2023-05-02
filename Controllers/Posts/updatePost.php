<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((isset($_GET['user_id'])  && isset($_GET['id'])) && ($_GET['user_id'] != " "  &&  $_GET['id'] != " ")) {
        $id = $_GET['id'];
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
        
        // Update Post


        $query = "SELECT `id` FROM `blogApi`.`posts` WHERE `id` = '$id' AND `user_id` = '$user_id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) < 1) {
            header("Content-Type: application/json");
            return response("post not found", 405);
        } else {
            $query = "UPDATE `blogApi`.`posts` SET `title` = '$title', `body` = '$body', `image` = '$image', `updated_at` = NOW() WHERE `posts`.`id` = $id AND `user_id` = '$user_id'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                header("Content-Type: application/json");
                return response("post updated successfully", 200);
            } else {
                header("Content-Type: application/json");
                return response("error in updating user", 405);
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
