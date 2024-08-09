<?php
    header('Content-Type: application/json');
    $conn = new mysqli("localhost", "root", "root", "lo_db");
    $response = [];

    if ($conn->connect_error) {
        $response['error'] = "Connection failed: " . $conn->connect_error;
    } else {
        $sql = "SELECT circlename FROM tbuild";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response['data'][] = $row['circlename'];
            }
        }
        $conn->close();
    }

    echo json_encode($response);
?>