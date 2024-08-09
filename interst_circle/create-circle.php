<?php
    if(empty($_POST["circlename"])){
        die("名称不能为空！");
    }
    $circlename = $_POST["circlename"];
    $mysqli = new mysqli("localhost","root","root","lo_db");
    if($mysqli->connect_errno){
        die("数据库连接错误:".$mysqli->connect_error);
    }
    if(isset($_POST["build"])){
        $sql = "INSERT INTO tbuild (circlename) VALUES ('$circlename')";
        $mysqli->query($sql);
        if($mysqli->affected_rows > 0){
            echo "<script>window.alert('恭喜你创建成功，马上跳转到主页面！');window.location.href = '兴趣圈.html';</script>";
        }
    }
?>