<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id']) && $_GET['id'] !== " ") {

        $id = $_GET['id'];
        $query = "SELECT * FROM `blogApi`.`users` WHERE `id` = '$id'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        if ($result) {
            if (mysqli_num_rows($result) < 1) {
                header("Content-Type: application/json");
                return response("user Not Found", 404);
            } else {
                header("Content-Type: application/json");
                return response($user, 200);
            }
        } else {
            header("Content-Type: application/json");
            return response("error in storing user", 405);
        }
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
