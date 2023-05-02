<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((isset($_GET['user_id'])  &&  isset($_GET['post_id']) && isset($_GET['id'])) && ($_GET['user_id'] != " " && $_GET['post_id'] != " "  &&  $_GET['id'] != " ")) {
        $id = $_GET['id'];
        $user_id = $_GET['user_id'];
        $post_id = $_GET['post_id'];
        //sanitizing
        $content = sanitizeInput($_POST['content']);
        //validation
        //Content
        if (requiredInput($content)) {
            return response("content required", 500);
        } elseif (minLength($content, 1)) {
            return response("content length must be more then 4 letters", 500);
        } elseif (maxLength($content, 10000)) {
            return response("content length must be less then 100 letters", 500);
        }
        //Select the Comment

        $query = "SELECT * FROM `blogApi`.`comments` WHERE `id` = '$id' AND `user_id` = $user_id AND `post_id` = '$post_id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) < 1) {
            header("Content-Type: application/json");
            return response("post not found", 405);
        } else {

            //Update Data
            $query = "UPDATE `comments` SET `content` = '$content', `updated_at` = NOW() WHERE `comments`.`id` = $id";
            $result = mysqli_query($conn, $query);
            if ($result) {
                header("Content-Type: application/json");
                return response("comment updated successfully", 200);
            } else {
                header("Content-Type: application/json");
                return response("error in updating comment", 405);
            }
        }
    } else {
        header("Content-Type: application/json");
        return response("post or user are in valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
