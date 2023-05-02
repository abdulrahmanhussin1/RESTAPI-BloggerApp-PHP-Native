<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['user_id']) && $_GET['user_id'] !== " ") {
        $user_id = $_GET['user_id'];

        $query = "SELECT * FROM `blogApi`.`posts` WHERE `user_id` = $user_id ";
        $result = mysqli_query($conn, $query);
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (mysqli_num_rows($result) > 0) {
            if ($result) {
                header("Content-Type: application/json");
                return response($posts, 200);
            } else {
                header("Content-Type: application/json");
                return response("error in storing user", 405);
            }
        } else {
            header("Content-Type: application/json");
            return response("user not found", 500);
        }
    } else {
        header("Content-Type: application/json");
        return response("user or id are in valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
