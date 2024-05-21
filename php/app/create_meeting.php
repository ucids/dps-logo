<?php
// Check if the form was submitted
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $sala = $_POST['sala'];
    $user_id = $_POST['user_id'];
    $users = $_POST['users'];
    $motivo = $_POST['motivo'];
    $calendar_event_start_date = date('H:i:s', strtotime($_POST['calendar_event_start_date']));
    $calendar_event_end_date = date('H:i:s', strtotime($_POST['calendar_event_end_date']));
    $date = $_POST['date'];

    // Check for existing meetings in the same room at the same time
    $checkQuery = "SELECT * FROM meetings WHERE room_id = :room_id AND date = :date AND 
    ((start_time <= :start_time AND end_time > :start_time) OR 
    (start_time < :end_time AND end_time >= :end_time) OR 
    (start_time >= :start_time AND end_time <= :end_time))";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':room_id', $sala);
    $checkStmt->bindParam(':date', $date);
    $checkStmt->bindParam(':start_time', $calendar_event_start_date);
    $checkStmt->bindParam(':end_time', $calendar_event_end_date);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // An existing meeting was found, return an error message
        echo json_encode([
            'status' => 'error',
            'message' => 'Una reunión ya está programada en esta sala a la misma hora. Por favor, seleccione una hora diferente.'
        ]);
    } else {
        // No existing meeting was found, insert the new meeting
        $query = "INSERT INTO meetings (room_id, subject, date, start_time, end_time, user_id) VALUES (:room_id, :subject, :date, :start_time, :end_time, :user_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':room_id', $sala);
        $stmt->bindParam(':subject', $motivo);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':start_time', $calendar_event_start_date);
        $stmt->bindParam(':end_time', $calendar_event_end_date);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Send a response back to the client
        echo json_encode([
            'status' => 'success',
            'message' => 'Meeting created successfully',
            'sala' => $sala,
            'users' => $users,
            'motivo' => $motivo,
            'calendar_event_start_date' => $calendar_event_start_date,
            'calendar_event_end_date' => $calendar_event_end_date,
            'date' => $date
        ]);
    }
} else {
    // The request method is not POST
    echo 'Invalid request';
}