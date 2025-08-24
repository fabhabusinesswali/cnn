<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "usqct4ub2firu";
$password = "tikflxfe5xbh";
$dbname = "db1hif2dbiiqjy";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_POST['image'];
        
        // If image URL doesn't start with http:// or https://, add https://
        if (!preg_match("~^(?:f|ht)tps?://~i", $image)) {
            $image = "https://" . $image;
        }
        
        $category = $_POST['category'];

        // Simple insert query
        $sql = "INSERT INTO articles (title, content, image, category) 
                VALUES ('$title', '$content', '$image', '$category')";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?> 
