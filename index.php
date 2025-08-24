<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article - My News</title>
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

        .logo a {
            color: white;
            text-decoration: none;
        }

        /* Article Container */
        .article-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Article Header */
        .article-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .article-category {
            display: inline-block;
            background: #CC0000;
            color: white;
            padding: 5px 15px;
            border-radius: 3px;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .article-title {
            font-size: 36px;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .article-meta {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Article Image */
        .article-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Article Content */
        .article-content {
            line-height: 1.8;
            color: #444;
            font-size: 18px;
            margin-bottom: 40px;
        }

        .article-content p {
            margin-bottom: 20px;
        }

        /* Back Button */
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background: #CC0000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s ease;
            margin-bottom: 30px;
        }

        .back-button:hover {
            background: #990000;
        }

        /* Related Articles */
        .related-articles {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #ddd;
        }

        .related-articles h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .related-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .related-card:hover {
            transform: translateY(-5px);
        }

        .related-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .related-content {
            padding: 15px;
        }

        .related-content h4 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .read-more {
            display: inline-block;
            padding: 5px 10px;
            background: #CC0000;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .article-title {
                font-size: 28px;
            }

            .article-image {
                height: 300px;
            }

            .article-content {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <a href="index.php">MY NEWS</a>
        </div>
    </header>

    <div class="article-container">
        <a href="index.php" class="back-button">← Back to Home</a>

        <?php
        include 'db_connect.php';

        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM articles WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $article = $result->fetch_assoc();
                ?>
                <article>
                    <div class="article-header">
                        <span class="article-category"><?php echo $article['category']; ?></span>
                        <h1 class="article-title"><?php echo $article['title']; ?></h1>
                        <div class="article-meta">
                            Published on <?php echo date('F j, Y', strtotime($article['created_at'])); ?>
                        </div>
                    </div>

                    <img src="<?php echo $article['image']; ?>" 
                         alt="<?php echo $article['title']; ?>" 
                         class="article-image"
                         onerror="this.onerror=null; this.src='https://placehold.co/1000x500?text=News';">

                    <div class="article-content">
                        <?php echo nl2br($article['content']); ?>
                    </div>
                </article>

                <!-- Related Articles -->
                <div class="related-articles">
                    <h3>Related Articles</h3>
                    <div class="related-grid">
                        <?php
                        $category = $article['category'];
                        $sql = "SELECT * FROM articles WHERE category = '$category' AND id != $id LIMIT 3";
                        $related = $conn->query($sql);
                        
                        while($row = $related->fetch_assoc()) {
                            echo '<div class="related-card">
                                    <img src="'.$row['image'].'" 
                                         alt="'.$row['title'].'"
                                         onerror="this.onerror=null; this.src=\'https://placehold.co/400x200?text=Related\';">
                                    <div class="related-content">
                                        <h4>'.$row['title'].'</h4>
                                        <a href="article.php?id='.$row['id'].'" class="read-more">Read More</a>
                                    </div>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else {
                echo '<h2>Article not found</h2>';
            }
        } else {
            echo '<h2>No article specified</h2>';
        }
        ?>
    </div>
</body>
</html> 
