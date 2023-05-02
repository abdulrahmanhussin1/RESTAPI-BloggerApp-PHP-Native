<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((isset($_GET['user_id'])  &&  isset($_GET['post_id']) && isset($_GET['id'])) && ($_GET['user_id'] != " " && $_GET['post_id'] != " "  &&  $_GET['id'] != " ")) {
        $id = $_GET['id'];
        $user_id = $_GET['user_id'];
        $post_id = $_GET['post_id'];
        $query = "SELECT * FROM `blogApi`.`comments` WHERE `comments`.`id` = '$id' AND `comments`.`user_id` = '$user_id' AND `comments`.`post_id` = '$post_id' ";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $query = "DELETE FROM `blogApi`.`comments` WHERE `comments`.`id` = '$id'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                header("Content-Type: application/json");
                return response("comment deleted successfully", 200);
            } else {
                header("Content-Type: application/json");
                return response("error in deleting comment", 405);
            }
        } else {
            header("Content-Type: application/json");
            return response("post Not Found", 404);
        }
    } else {
        header("Content-Type: application/json");
        return response("user or id not valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
