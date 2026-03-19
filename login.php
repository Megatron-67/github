<?php
session_start();
$db = new PDO('sqlite:users.db');
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: dashboard.php");
    } else { $error = "Incorrect username or password."; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { background-color: #0d1117; color: #c9d1d9; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; display: flex; flex-direction: column; align-items: center; padding-top: 40px; margin: 0; }
        .auth-form-header h1 { font-size: 24px; font-weight: 300; letter-spacing: -0.5px; margin-bottom: 15px; }
        .auth-form-body { width: 300px; background-color: #161b22; border: 1px solid #30363d; border-radius: 6px; padding: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 400; font-size: 14px; text-align: left; }
        input { width: 100%; padding: 5px 12px; margin-bottom: 15px; background-color: #0d1117; border: 1px solid #30363d; border-radius: 6px; color: #c9d1d9; font-size: 14px; box-sizing: border-box; outline: none; }
        .btn-primary { width: 100%; background-color: #238636; color: #ffffff; padding: 5px 16px; border: 1px solid rgba(240, 246, 252, 0.1); border-radius: 6px; font-weight: 500; cursor: pointer; }
        .create-account-callout { width: 300px; border: 1px solid #30363d; border-radius: 6px; padding: 15px 20px; margin-top: 15px; text-align: center; font-size: 14px; }
        .create-account-callout a { color: #58a6ff; text-decoration: none; }
        .error { background: #f8514922; color: #f85149; border: 1px solid #f8514944; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 15px; width: 100%; box-sizing: border-box; }
        .success { background: #2ea04322; color: #3fb950; border: 1px solid #3fb95044; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 15px; width: 100%; box-sizing: border-box; text-align: center;}
    </style>
</head>
<body>
    <div class="auth-form-header">
        <h1>Sign in to Github</h1>
    </div>

    <div class="auth-form-body">
        <?php if($error) echo "<div class='error'>$error</div>"; ?>
        <?php if(isset($_GET['msg'])) echo "<div class='success'>Signup successful!</div>"; ?>
        <form method="POST">
            <label>Username or email address</label>
            <input type="text" name="username" required>
            
            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" class="btn-primary">Sign in</button>
        </form>
    </div>

    <div class="create-account-callout">
        New to Github? <a href="signup.php">Create an account</a>.
    </div>
</body>
</html>