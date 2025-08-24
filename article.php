<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My News Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Header Styles */
        .header {
            background: #CC0000;
            padding: 20px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .logo {
            color: white;
            font-size: 40px;
            font-weight: bold;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        /* Navigation Styles */
        .nav {
            background: #f8f9fa;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

        .nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            padding: 8px 15px;
            border-radius: 4px;
        }

        .nav a:hover {
            color: #CC0000;
            background: #f0f0f0;
        }

        /* Search Bar */
        .search-bar {
            text-align: center;
            margin: 20px auto;
            max-width: 600px;
            padding: 0 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #ddd;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #CC0000;
            box-shadow: 0 0 5px rgba(204,0,0,0.2);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Top Story */
        .top-story {
            margin-bottom: 40px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .main-article {
            position: relative;
            height: 500px;
            overflow: hidden;
        }

        .main-article img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .main-article:hover img {
            transform: scale(1.05);
        }

        .article-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
        }

        .article-title h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        /* News Grid */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        .news-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .news-content {
            padding: 20px;
        }

        .news-content h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }

        .news-content p {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .read-more {
            display: inline-block;
            padding: 8px 20px;
            background: #CC0000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .read-more:hover {
            background: #990000;
        }

        /* Category Label */
        .category-label {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #CC0000;
            color: white;
            padding: 5px 15px;
            border-radius: 3px;
            font-size: 14px;
            text-transform: uppercase;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav ul {
                flex-wrap: wrap;
                gap: 10px;
                padding: 0 20px;
            }

            .main-article {
                height: 300px;
            }

            .article-title h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">MY NEWS</div>
    </header>

    <nav class="nav">
        <ul>
            <li><a href="#" onclick="loadCategory('politics')">Politics</a></li>
            <li><a href="#" onclick="loadCategory('sports')">Sports</a></li>
            <li><a href="#" onclick="loadCategory('tech')">Technology</a></li>
            <li><a href="#" onclick="loadCategory('business')">Business</a></li>
            <li><a href="#" onclick="loadCategory('entertainment')">Entertainment</a></li>
        </ul>
    </nav>

    <div class="search-bar">
        <input type="text" placeholder="Search news..." onkeyup="searchNews(this.value)">
    </div>

    <div class="container">
        <div class="top-story">
            <?php
            include 'db_connect.php';
            $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<div class="main-article">
                        <img src="'.$row['image'].'" alt="'.$row['title'].'" 
                             onerror="this.onerror=null; this.src=\'https://placehold.co/800x400?text=News\';">
                        <div class="article-title">
                            <span class="category-label">'.$row['category'].'</span>
                            <h2>'.$row['title'].'</h2>
                            <p>'.substr($row['content'], 0, 150).'...</p>
                        </div>
                    </div>';
            }
            ?>
        </div>

        <div class="news-grid">
            <?php
            $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 6";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                echo '<div class="news-card">
                        <img src="'.$row['image'].'" alt="'.$row['title'].'" 
                             onerror="this.onerror=null; this.src=\'https://placehold.co/400x300?text=News\';">
                        <div class="news-content">
                            <span class="category-label">'.$row['category'].'</span>
                            <h3>'.$row['title'].'</h3>
                            <p>'.substr($row['content'], 0, 100).'...</p>
                            <a href="#" class="read-more" onclick="showArticle('.$row['id'].')">Read More</a>
                        </div>
                    </div>';
            }
            ?>
        </div>
    </div>

    <script>
        function loadCategory(category) {
            // Add category loading logic
            console.log('Loading category: ' + category);
        }

        function searchNews(query) {
            // Add search logic
            console.log('Searching: ' + query);
        }

        function showArticle(id) {
            window.location.href = 'article.php?id=' + id;
        }
    </script>
</body>
</html> 
