<?
// session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start(); // Start the session
    header('Content-Type: application/json');
    include 'db.php';
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Consulta para obtener el hash de la contraseña del usuario
    $query = "SELECT * FROM Vista_Usuarios WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Inicio de sesión exitoso
        // Puedes almacenar información del usuario en la sesión si es necesario
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nombre'] = $user['nombre'] . ' ' . $user['lastname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['rol_id'] = $user['rol_id'];
        $_SESSION['rol'] = $user['rol'];
        $_SESSION['departamento_id'] = $user['departamento_id'];
        $_SESSION['departamento'] = $user['departamento'];
        $_SESSION['logged_in'] = true;
        $_SESSION['token'] = bin2hex(random_bytes(32));
        $response = array(
            'status' => 'success',
            'message' => 'Bienvenido' . ' ' . $user['nombre']
        );
        echo json_encode($response);
    } else {
        // Credenciales incorrectas
        echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas. Inténtalo de nuevo.']);
    }
} else {
    // El método de solicitud no es POST
    echo json_encode(['status' => 'error', 'message' => 'Forbidden']);
    $_SESSION['error_title'] = '403 Forbidden';
    $_SESSION['error_message'] = 'Esta pagina no esta disponible para usted';
    header('Location: /public/403.php');
    exit();
}
