<?php
    $circlename = $_GET['circlename'];
    echo "Circle Name: " . htmlspecialchars($circlename);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>兴趣圈详情</title>
    <link rel="stylesheet" href="./post.css">
    <style>
        .comment-form {
            display: none;
        }
        .home-button {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .post, .comment {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .post .username {
            font-weight: bold;
        }
        .post img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .comment {
            margin-left: 20px;
            background-color: #f1f1f1;
        }
        .comment p {
            margin: 5px 0;
        }
        .comment-form textarea {
            width: 100%;
            height: 60px;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .comment-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .comment-form button:hover {
            background-color: #45a049;
        }
        .toggle-comment-button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .toggle-comment-button:hover {
            background-color: #007B9A;
        }
    </style>
    <script>
        function toggleCommentForm(postId) {
            var form = document.getElementById('comment-form-' + postId);
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <h1>欢迎来到兴趣圈：<?php echo htmlspecialchars($circlename); ?></h1>
    <a href="兴趣圈.html" class="home-button">回到主页</a>
    <?php
        $mysqli = new mysqli("localhost", "root", "root", "lo_db");
        if ($mysqli->connect_errno) {
            die("数据库连接错误:" . $mysqli->connect_error);
        }

        $sql = "SELECT name, total_score FROM tuser ORDER BY total_score DESC";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>用户排名</h2><ol>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['name']) . " - 总分: " . $row['total_score'] . "</li>";
            }
            echo "</ol>";
        }

        $mysqli->close();
    ?>
    <?php
        $mysqli1 = new mysqli("localhost", "root", "root", "lo_db");
        if ($mysqli1->connect_errno) {
            die("数据库连接错误:" . $mysqli1->connect_error);
        }

        $sql = "SELECT name, total_score FROM tuser ORDER BY total_score DESC";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>用户排名</h2><ol>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['name']) . " - 总分: " . $row['total_score'] . "</li>";
            }
            echo "</ol>";
        }

        $mysqli1->close();
    ?>
    <!-- 显示兴趣圈的详细内容 -->
    <form method="post" action="post_to_circle.php" enctype="multipart/form-data">
        <div class="panel px-15 py-15 mb-12">
            <div class="ctrl-wrap drop-zone">
                <textarea rows="4" id="content" name="content" placeholder="和大家分享点什么吧..." class="db input bgc-body bdc-transparent no-transition" style="resize: vertical;"></textarea>
            </div>
            <div class="flex jsb aic mt-7">
                <div class="flex" style="margin-left: -0.8rem;">
                    <div class="px-15 por">
                        <label class="file dark-9 hover-primary transition" title="可上传 30 张图片">
                            <div class="icon fz-x-lg" style="background-image: url(&quot;https://rpc.red-ring.cn/assets/img/icon-picture.9bc0e04e.svg&quot;);"></div>
                            <span class="fz-sm ml-5 va-2">图片</span>
                            <input type="file" name="image" accept="image/*">
                        </label>
                    </div>
                </div>
                <input type="hidden" name="circlename" value="<?php echo htmlspecialchars($circlename); ?>">
                <input type="submit" value="发布" name="fabu" class="btn btn-primary fz-sm brs-4 px-20">
            </div>
        </div>
    </form>
    <!-- 显示帖子 -->
    <div class="posts-container">
        <?php
        $mysqli = new mysqli("localhost", "root", "root", "lo_db");
        if ($mysqli->connect_errno) {
            die("数据库连接错误:" . $mysqli->connect_error);
        }

        $sql = "SELECT post_id, username, content, image_path FROM tcircle WHERE circlename = ?";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            die("准备语句失败: " . $mysqli->error);
        }
        $stmt->bind_param("s", $circlename);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<p class='username'>用户名: " . htmlspecialchars($row["username"]) . "</p>";
                echo "<p>内容: " . htmlspecialchars($row["content"]) . "</p>";
                if ($row["image_path"]) {
                    echo "<img src='" . htmlspecialchars($row["image_path"]) . "' alt='Post Image'>";
                }
                echo "<button class='toggle-comment-button' onclick='toggleCommentForm(" . htmlspecialchars($row['post_id']) . ")'>评论</button>";
                echo "<form id='comment-form-" . htmlspecialchars($row['post_id']) . "' method='post' action='submit_comment.php' class='comment-form'>";
                echo "<textarea name='content' required></textarea>";
                echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($row['post_id']) . "'>";
                echo "<input type='hidden' name='circlename' value='" . htmlspecialchars($circlename) . "'>";
                echo "<button type='submit'>提交评论</button>";
                echo "</form>";
                echo "<div class='comments'>";
                // 显示评论
                $comment_sql = "SELECT username, content FROM comments WHERE post_id = ?";
                $comment_stmt = $mysqli->prepare($comment_sql);
                if (!$comment_stmt) {
                    die("准备语句失败: " . $mysqli->error);
                }
                $comment_stmt->bind_param("i", $row['post_id']);
                $comment_stmt->execute();
                $comment_result = $comment_stmt->get_result();
                while ($comment_row = $comment_result->fetch_assoc()) {
                    echo "<div class='comment'>";
                    echo "<p><strong>" . htmlspecialchars($comment_row['username']) . ":</strong> " . htmlspecialchars($comment_row['content']) . "</p>";
                    echo "</div>";
                }
                $comment_stmt->close();
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>没有找到帖子。</p>";
        }

        $stmt->close();
        $mysqli->close();
        ?>
    </div>
</body>
</html>