<?php
require_once '../../Config/connection.php';
require_once '../../Core/app.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
    //storeData

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES (NULL,' $name', '$email', '$hashed_password','$role')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Content-Type: application/json");
        return response("user stored successfully", 200);
    } else {
        header("Content-Type: application/json");
        return response("error in storing user", 405);
    }
} else {
    header("Content-Type: application/json");
    return response("Method Not allowed", 500);
}
