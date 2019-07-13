#!./php
<?php
include 'Database.php';

//DATABASE

try {
        // Connect to Mysql server
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $sql = "CREATE DATABASE $DB_NAME";
        $dbh->exec( $sql );
        var_dump( "Database created");
    } catch ( PDOException $e ) {
        var_dump( "Error : " . $e->getMessage() );
        die();
    }

//USERS TABLE
try {
        $dbh = new PDO($DB_DSN . "dbname=" . $DB_NAME, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `users` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `name` VARCHAR(50) NOT NULL,
          `surname` VARCHAR(50) NOT NULL,
          `email` VARCHAR(100) UNIQUE NOT NULL,
          `username` VARCHAR(50) UNIQUE NOT NULL,
          `password` VARCHAR(255) NOT NULL,
          `auth` TINYINT(1) NOT NULL DEFAULT '0'
        )";
        $dbh->exec($sql);
        var_dump( "users created\n");
    } catch (PDOException $e) {
        var_dump( "Error : " . $e->getMessage() );
    }

//IMAGES TABLE
try {
        $dbh = new PDO($DB_DSN . "dbname=" . $DB_NAME, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `images` (
          `img_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `location` VARCHAR(100) NOT NULL,
          `title` VARCHAR(100) NOT NULL,
          `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `user_id` INT(11) NOT NULL,
          FOREIGN KEY (user_id) REFERENCES users(id)
        )";
        $dbh->exec($sql);
        var_dump( "images created\n");
    } catch (PDOException $e) {
        var_dump( "Error : " . $e->getMessage() );
    }

try {
        $dbh = new PDO($DB_DSN . "dbname=" . $DB_NAME, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `likes` (
            `img_id` INT(11) NOT NULL,
            `likes_count` TEXT NOT NULL,
          FOREIGN KEY (img_id) REFERENCES images(img_id)
        )";
        $dbh->exec($sql);
        var_dump( "likes created\n");
    } catch (PDOException $e) {
        var_dump( "Error : " . $e->getMessage() );
    }

try {
        $dbh = new PDO($DB_DSN . "dbname=" . $DB_NAME, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `comments` (
          `img_id` INT(11) NOT NULL,
          `body` TEXT NOT NULL,
          FOREIGN KEY (img_id) REFERENCES images(img_id)
        )";
        $dbh->exec($sql);
        var_dump( "Comments created\n");
    } catch ( PDOException $e ) {
        var_dump( "Error : " . $e->getMessage() );
    }
Header ( 'Location: ../index.php' );
?>