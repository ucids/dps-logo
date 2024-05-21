<?php
// Database connection

include 'db.php';

// Fetch the meetings
$query = "SELECT meetings.*, salas.* FROM meetings JOIN salas ON meetings.room_id = salas.id";
$stmt = $pdo->query($query);
$meetings = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Convert the meetings to the format expected by FullCalendar
$events = [];
foreach ($meetings as $meeting) {
$stmt = $pdo->prepare("
    SELECT meeting_invitations.*, users.id, users.name, users.email, users.avatar
    FROM meeting_invitations
    JOIN users ON meeting_invitations.user_id = users.id
    WHERE meeting_invitations.meeting_id = ?
");
$stmt->execute([$meeting['id']]);
$users_invited = $stmt->fetchAll();

    $events[] = [
        'id' => $meeting['id'],
        'title' => $meeting['room'] . ' '. '*',
        'nombre_sala' => 'Sala ' . $meeting['room_id'],
        'sala' => $meeting['room_id'],
        'start' => $meeting['date'] . 'T' . $meeting['start_time'],
        'end' => $meeting['date'] . 'T' . $meeting['end_time'],
        'motivo' => $meeting['subject'],
        'color' => $meeting['color'],
        'users_invited' => $users_invited,
    ];
}

// Return the events as JSON
header('Content-Type: application/json');
echo json_encode($events);