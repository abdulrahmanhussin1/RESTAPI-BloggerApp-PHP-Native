<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ((isset($_GET['user_id'])  && isset($_GET['id'])) && ($_GET['user_id'] != " "  &&  $_GET['id'] != " ")) {
        $user_id = $_GET['user_id'];
        $id = $_GET['id'];
        $query = "SELECT * FROM `blogApi`.`posts` WHERE `id` = '$id' AND `user_id` = $user_id";
        $result = mysqli_query($conn, $query);
        $post = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) < 1) {
                header("Content-Type: application/json");
                return response("Post Not Found", 404);
            } else {
                header("Content-Type: application/json");
                return response($post, 200);
            }
    } else {
        header("Content-Type: application/json");
        return response("user or id not valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
