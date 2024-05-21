<?php
header('Content-Type: application/json');
include 'db.php';

// Get the JSON data from the request body
$json = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$data = json_decode($json, true);

// Now you can access the username and password from the $data array
$username = $data['username'];
$password = $data['password'];
$email = $data['email'];

// TODO: Use the username and password to create a user in your database

// For now, let's just return the received data as a JSON response
echo json_encode($data);