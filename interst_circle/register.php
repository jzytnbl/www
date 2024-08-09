<?php
    if(empty($_POST["name"])){
        die("用户名不能为空！");
    }
    if(strlen($_POST["password"])<6){
        die("密码不能小于6位!");
    }
    if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
        die("请输入有效的邮箱形式");
    }
    $name = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $mysqli = new mysqli("localhost","root","root","lo_db");
    if($mysqli->connect_errno){
        die("数据库连接错误:".$mysqli->connect_error);
    }
    if(isset($_POST["reg"])){
        $sql = "INSERT INTO tuser (name,password,email) VALUES ('$name','$password','$email')";
        $mysqli->query($sql);
        if($mysqli->affected_rows > 0){
            echo "<script>window.alert('恭喜你注册成功，马上跳转到登录页面！');window.location.href = 'index.html';</script>";
        }
    }
?>