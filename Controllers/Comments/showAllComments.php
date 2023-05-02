<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ((isset($_GET['user_id'])  &&  isset($_GET['post_id'])) || ($_GET['user_id'] == " " || $_GET['post_id'] == " ")) {
        $user_id = $_GET['user_id'];
        $post_id = $_GET['post_id'];
        $query = "SELECT * FROM `blogApi`.`comments` WHERE `user_id` = '$user_id' AND `post_id` = '$post_id' ";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if ($result) {
                header("Content-Type: application/json");
                return response($comments, 200);
            } else {
                header("Content-Type: application/json");
                return response("error in storing user", 405);
            }
        } else {
            header("Content-Type: application/json");
            return response("comments are not founds", 500);
        }
    } else {
        header("Content-Type: application/json");
        return response("post or user are in valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
