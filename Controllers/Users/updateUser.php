<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['id']) && $_GET['id'] !== " ") {
        $id = $_GET['id'];
        //sanitizing
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);
        $confirm_password = sanitizeInput($_POST['confirm_password']);
        $role = sanitizeInput($_POST['role']);

        //validation

        //Name
        if (requiredInput($name)) {
            return response("name required", 500);
        } elseif (minLength($name, 4)) {
            return response("name length must be more then 4 letters", 500);
        } elseif (maxLength($name, 100)) {
            return response("name length must be less then 100 letters", 500);
        } elseif (numericInput($name)) {
            return response("Name must be contain at least one letter", 500);
        }

        //Email
        if (requiredInput($email)) {
            return response("email required", 500);
        } elseif (emailInput($email)) {
            return response("Please Enter Valid Email", 500);
        }

        //Password
        if (requiredInput($password)) {
            return response("password required", 500);
        } elseif (minLength($password, 4)) {
            return response("password length must be more then 4 letters", 500);
        } elseif (maxLength($password, 100)) {
            return response("password length must be less then 100 letters", 500);
        } elseif (numericInput($password)) {
            return response("password must be contain at least one letter", 500);
        }

        //confirm password
        if ($password !== $confirm_password) {
            return response("Password does not match confirm password", 500);
        } elseif (requiredInput($confirm_password)) {
            return response("please confirm your password", 500);
        }
        //role
        $array = array("admin", "user");
        if (requiredInput($role)) {
            $role = 'user';
        } elseif (inArrayInput($role, $array)) {
            return response("invalid user's role", 500);
        }

        //update Data
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "SELECT * FROM `blogApi`.`users` WHERE `id` = '$id'";
        $result = mysqli_query($conn, $query);

        // if user found
        if (mysqli_num_rows($result) > 0) {

            // find if email is already registered
            $query = "SELECT `email` FROM `blogApi`.`users` WHERE `email` = '$email'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $query = "SELECT `email` FROM `blogApi`.`users` WHERE `id` = '$id' AND `email` = '$email'";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    $query = "UPDATE `users` SET `name` = ' $name', `password` = '$hashed_password', `role` = '$role' WHERE `users`.`id` = $id";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        header("Content-Type: application/json");
                        return response("user updated successfully", 200);
                    } else {
                        header("Content-Type: application/json");
                        return response("error in updating user", 405);
                    }
                } else {
                    header("Content-Type: application/json");
                    return response("this email is already existing", 405);
                }

                // if email is not registered before
            } else {
                $query = "UPDATE `users` SET `name` = ' $name', `email` = '$email', `password` = '$hashed_password', `role` = '$role' WHERE `users`.`id` = $id";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    header("Content-Type: application/json");
                    return response("user updated successfully", 200);
                } else {
                    header("Content-Type: application/json");
                    return response("error in updating user", 405);
                }
            }

            //if user not found
        } else {
            header("Content-Type: application/json");
            return response("user Not Found", 404);
        }
    } else {
        header("Content-Type: application/json");
        return response("id not valid", 500);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
