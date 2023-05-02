<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ((isset($_GET['user_id'])  &&  isset($_GET['post_id']) && isset($_GET['id'])) && ($_GET['user_id'] != " " && $_GET['post_id'] != " "  &&  $_GET['id'] != " ")) {
        $user_id = $_GET['user_id'];
        $post_id = $_GET['post_id'];
        $id = $_GET['id'];
        
        $query = "SELECT * FROM `blogApi`.`comments` WHERE `id` = '$id' AND `user_id` = $user_id AND `post_id` = '$post_id'";
        $result = mysqli_query($conn, $query);
        $comment = mysqli_fetch_assoc($result);

        if ($result) {
            if (mysqli_num_rows($result) < 1) {
                header("Content-Type: application/json");
                return response("comment Not Found", 404);
            } else {
                header("Content-Type: application/json");
                return response($comment, 200);
            }
        } else {
            header("Content-Type: application/json");
            return response("error", 405);
        }
    } else {
        header("Content-Type: application/json");
        return response("comment or user are in valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
