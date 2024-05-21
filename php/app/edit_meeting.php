<?php
// Check if the form was submitted
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $meeting_id = $_POST['meeting_id'];
    $sala = $_POST['sala'];
    $user_id = $_POST['user_id'];
    $users = $_POST['users'];
    $motivo = $_POST['motivo'];
    $calendar_event_start_date = date('H:i:s', strtotime($_POST['calendar_event_start_date']));
    $calendar_event_end_date = date('H:i:s', strtotime($_POST['calendar_event_end_date']));
    $date = $_POST['date'];

    // TODO: Validate the form data

    // Update the meeting in the database
    $query = "UPDATE meetings SET room_id = :room_id, subject = :subject, date = :date, start_time = :start_time, end_time = :end_time, user_id = :user_id WHERE id = :meeting_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':meeting_id', $meeting_id);
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
        'message' => 'Meeting updated successfully',
        'sala' => $sala,
        'users' => $users,
        'motivo' => $motivo,
        'calendar_event_start_date' => $calendar_event_start_date,
        'calendar_event_end_date' => $calendar_event_end_date,
        'date' => $date
    ]);
} else {
    // The request method is not POST
    echo 'Invalid request';
}