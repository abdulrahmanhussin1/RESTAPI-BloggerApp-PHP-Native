    <?php
    require_once 'connection.php';

    $query = "CREATE TABLE IF NOT EXISTS `blogApi`.`users`(
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(100) NOT NULL UNIQUE,
        `password` VARCHAR(100) NOT NULL,
        `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($conn, $query)) {
        echo "Table `users` created successfully" . "<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }

    $query = "CREATE TABLE IF NOT EXISTS `blogApi`.`posts`(
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `body` TEXT NOT NULL,
        `image` VARCHAR(255) NULL,
        `user_id` INT(11) NOT NULL,
        FOREIGN KEY (`user_id`) REFERENCES `users`(id) ON UPDATE CASCADE ON DELETE CASCADE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($conn, $query)) {
        echo "Table `posts` created successfully" . "<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }
    $query = "CREATE TABLE IF NOT EXISTS `blogApi`.`comments`(
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `content` TEXT NOT NULL,
        `user_id` INT(11) NOT NULL,
        `post_id` INT(11) NOT NULL,
        FOREIGN KEY (`user_id`) REFERENCES `users`(id) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY (`post_id`) REFERENCES `posts`(id) ON UPDATE CASCADE ON DELETE CASCADE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (mysqli_query($conn, $query)) {
        echo "Table `comments` created successfully" . "<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }

    mysqli_close($conn);
