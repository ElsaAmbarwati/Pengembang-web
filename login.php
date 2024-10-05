<?php
session_start();

// Fungsi untuk memeriksa apakah pengguna sudah login
function is_logged_in() {
    return isset($_SESSION['username']);
}

// Fungsi untuk logout
function logout() {
    session_destroy();
    header("Location: ?page=login");
    exit();
}

// Proses login
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Menggunakan hash untuk password yang lebih aman
    if($username == 'Elsa Ambarwati' && password_verify($password, password_hash('5230411238', PASSWORD_DEFAULT))){
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';
        header("Location: ?page=dashboard");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

// Proses logout
if(isset($_GET['action']) && $_GET['action'] == 'logout'){
    logout();
}

// Routing sederhana
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Login Sederhana</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #d1b22c;
        }
        .container {
            width: 40%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
            margin-top: 50px;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        form {
            margin-top: 10px;
            max-width: 300px;
            margin: 0 auto;
        }
        label {
            display: inline-block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center; 
        }
        a {
            color: #333;
            text-decoration: none;
        }
        a:hover {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if($page == 'login'): ?>
            <h2>Login</h2>
            <?php if(isset($error)) echo "<p class='error' style='text-align: center;'>$error</p>"; ?>
            <form method="post" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" name="login" value="Login">
            </form>
        <?php elseif($page == 'dashboard'): ?>
            <?php if(!is_logged_in()): ?>
                <?php header("Location: ?page=login"); exit(); ?>
            <?php else: ?>
                <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>
                <a href="?action=logout">Logout</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
