<?php
include 'db.php';    

try {

    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);

    $users = $stmt->fetchAll();

    header('Content-Type: application/json');
    // { value: 1, name: 'Emma Smith', avatar: 'avatars/300-6.jpg', email: 'e.smith@kpmg.com.au' },
    $users_array = [];
    foreach ($users as $user) {
        $users_array[] = [
            'value' => $user['id'],
            'name' => $user['name'],
            'avatar' => $user['avatar'],
            'email' => $user['email']
        ];
    }
    echo json_encode($users_array);
} catch (PDOException $e) {
    // This will catch any PDO exceptions (database errors)
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "A database error occurred. Please try again later."]);
} catch (Exception $e) {
    // This will catch any other exceptions
    error_log("General error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "An error occurred. Please try again later."]);
}