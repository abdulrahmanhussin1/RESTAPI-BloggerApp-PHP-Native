<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((isset($_GET['user_id'])  &&  isset($_GET['post_id'])) || ($_GET['user_id'] == " " || $_GET['post_id'] == " ")) {
        $user_id = $_GET['user_id'];
        $post_id = $_GET['post_id'];

        $query = "SELECT * FROM `blogApi`.`posts` WHERE `id` = '$post_id' AND `user_id` = $user_id";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
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
        //storeData
        $query = "INSERT INTO `comments` (`id`, `content`, `user_id`, `post_id`, `created_at`, `updated_at`) VALUES (NULL, '$content', '$user_id', '$post_id', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $result = mysqli_query($conn, $query);
        if ($result) {
            header("Content-Type: application/json");
            return response("comment stored successfully", 200);
        } else {
            header("Content-Type: application/json");
            return response("error in storing comment", 405);
        }
        } else {
            header("Content-Type: application/json");
            return response("post or user are in valid", 500);
        }

    } else {
        header("Content-Type: application/json");
        return response("post or user are in valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
