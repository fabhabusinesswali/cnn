<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .admin-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #CC0000;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .btn {
            background: #CC0000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn:hover {
            background: #990000;
        }

        .articles-list {
            margin-top: 30px;
        }

        .article-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include 'db_connect.php';

    // Check if login form was submitted
    if(isset($_GET['login']) && $_GET['login'] == 'success') {
        $_SESSION['admin'] = true;
    }

    $admin_username = "admin";  // This is your admin username
    $admin_password = "admin123";  // This is your admin password

    if (!isset($_SESSION['admin'])) {
        // Show login form
        echo '<div class="login-container">
                <h2>Admin Login</h2>
                <form onsubmit="return login(event)">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="password" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>';
    } else {
        // Show admin panel
        echo '<div class="admin-container">
                <h2>Admin Panel</h2>
                <form onsubmit="return addArticle(event)">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" id="title" required>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea id="content" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Image URL</label>
                        <input type="text" id="image" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" id="category" required>
                    </div>
                    <button type="submit" class="btn">Add Article</button>
                </form>

                <div class="articles-list">';
                
        // Display existing articles
        $sql = "SELECT * FROM articles ORDER BY id DESC";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            echo '<div class="article-item">
                    <span>'.$row['title'].'</span>
                    <div>
                        <button onclick="editArticle('.$row['id'].')" class="btn">Edit</button>
                        <button onclick="deleteArticle('.$row['id'].')" class="btn">Delete</button>
                    </div>
                </div>';
        }

        echo '</div></div>';

        echo '<a href="admin.php?logout=true" class="btn" style="margin-bottom: 20px;">Logout</a>';
    }

    if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: admin.php');
        exit();
    }
    ?>

    <script>
        function login(e) {
            e.preventDefault();
            let username = document.getElementById('username').value;
            let password = document.getElementById('password').value;
            
            if(username === "admin" && password === "admin123") {
                // Set session and redirect
                window.location.href = "admin.php?login=success";
                return true;
            } else {
                alert("Invalid username or password!");
                return false;
            }
        }

        function addArticle(e) {
            e.preventDefault();
            let title = document.getElementById('title').value;
            let content = document.getElementById('content').value;
            let image = document.getElementById('image').value;
            let category = document.getElementById('category').value;

            // Create form data
            let formData = new FormData();
            formData.append('title', title);
            formData.append('content', content);
            formData.append('image', image);
            formData.append('category', category);

            // Send request to server
            fetch('save_article.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if(data === "success") {
                    alert('Article added successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data);
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });

            return false;
        }

        function editArticle(id) {
            // Add edit logic here
        }

        function deleteArticle(id) {
            if (confirm('Are you sure you want to delete this article?')) {
                // Add delete logic here
            }
        }
    </script>
</body>
</html> 
