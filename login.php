<?php
session_start();
require 'db.php'; // connect to DB

function require_login() {
    if (!isset($_SESSION['admin']) || !isset($_SESSION['session_token']) || !isset($_COOKIE['session_token']) || $_SESSION['session_token'] !== $_COOKIE['session_token'] || !isset($_SESSION['tab_id']) || !isset($_COOKIE['tab_id']) || $_SESSION['tab_id'] !== $_COOKIE['tab_id']) {
        logout();
    }
}

function logout() {
    session_unset();
    session_destroy();
    // Remove session token cookie
    setcookie('session_token', '', time() - 3600, '/');
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $tab_id = isset($_POST['tab_id']) ? $_POST['tab_id'] : null;
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1 && $tab_id) {
                $admin = $result->fetch_assoc();
                $_SESSION['admin'] = $admin['id'];
                // Generate a random token for this session/tab
                $token = bin2hex(random_bytes(32));
                $_SESSION['session_token'] = $token;
                setcookie('session_token', $token, 0, '/');
                // Store tab_id in session
                $_SESSION['tab_id'] = $tab_id;
                header('Location: dashboard.php');
                exit;
        } else {
                $error = "Invalid login!";
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
        body {
            font-family: Tahoma,Verdana,Segoe,sans-serif;
            background: #f6fffd;
            padding: 20px;
            text-align: center;
        }
        .wrapper {
            width: 320px;
            margin: 80px auto;
            perspective: 600px;
            text-align: left;
        }
        .rec-prism {
            width: 100%;
            height: 100%;
            position: relative;
            background: rgba(250,250,250,0.96);
            border: 3px solid #07ad90;
            border-radius: 3px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        }
        .content h2 {
            font-size: 1.5em;
            color: #07ad90;
            margin-bottom: 20px;
            text-align: center;
        }
        .field-wrapper {
            margin-top: 30px;
            position: relative;
        }
        .field-wrapper label {
            position: absolute;
            pointer-events: none;
            font-size: 0.85em;
            top: 40%;
            left: 0;
            transform: translateY(-50%);
            transition: all ease-in 0.25s;
            color: #42509e;
        }
        .field-wrapper input[type="text"],
        .field-wrapper input[type="password"] {
            width: 100%;
            border: none;
            background: transparent;
            line-height: 2em;
            border-bottom: 1px solid #07ad90;
            color: #666;
            font-size: 1em;
        }
        .field-wrapper input[type="text"]:focus + label,
        .field-wrapper input[type="text"]:not(:placeholder-shown) + label,
        .field-wrapper input[type="password"]:focus + label,
        .field-wrapper input[type="password"]:not(:placeholder-shown) + label {
            top: -35%;
            color: #42509e;
        }
        .field-wrapper input[type="submit"] {
            cursor: pointer;
            width: 100%;
            background: #07ad90;
            line-height: 2em;
            color: #fff;
            border: 1px solid #07ad90;
            border-radius: 3px;
            padding: 5px 0;
            font-weight: bold;
            margin-top: 30px;
            font-size: 1.1em;
            transition: background 0.2s;
        }
        .field-wrapper input[type="submit"]:hover {
            background: #03a9f4;
            border-color: #03a9f4;
        }
        .error {
            color: #ff5751;
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
        </style>
</head>
<body>
<script>
// Ensure window.name is set uniquely per tab
if (!window.name) {
    window.name = 'tab_' + Math.random().toString(36).substr(2, 16);
}
// Set tab_id cookie for PHP
function setTabIdCookie() {
    document.cookie = 'tab_id=' + window.name + '; path=/';
}
setTabIdCookie();
// Add tab_id to login form on submit
window.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form[method="post"]');
    if (form) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'tab_id';
        input.value = window.name;
        form.appendChild(input);
    }
});
</script>
    <div class="wrapper">
        <div class="rec-prism">
            <div class="content">
                <h2>Admin Login</h2>
                <form method="post" autocomplete="off">
                    <div class="field-wrapper">
                        <input type="text" name="username" placeholder=" " required>
                        <label>Username</label>
                    </div>
                    <div class="field-wrapper">
                        <input type="password" name="password" placeholder=" " required autocomplete="new-password">
                        <label>Password</label>
                    </div>
                    <div class="field-wrapper">
                        <input type="submit" value="Login">
                    </div>
                    <?php if (isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>