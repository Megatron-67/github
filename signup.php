<?php
$db = new PDO('sqlite:users.db');
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    $conf = $_POST['confirm_password'] ?? '';

    if (strlen($pass) < 15) {
        $error = "Password must be at least 15 characters long.";
    } elseif (!preg_match('/[0-9]/', $pass) || !preg_match('/[^A-Za-z0-9]/', $pass)) {
        $error = "Password needs at least 1 number and 1 punctuation mark.";
    } elseif ($pass !== $conf) {
        $error = "Passwords do not match.";
    } else {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$user, $email, $hashed]);
            header("Location: login.php?msg=success");
        } catch (Exception $e) { $error = "Username or Gmail already taken."; }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GitHub · Theme</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { background-color: #0d1117; color: #c9d1d9; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; display: flex; flex-direction: column; align-items: center; padding-top: 40px; margin: 0; }
        .logo { margin-bottom: 24px; color: #f0f6fc; }
        .auth-form-header { text-align: center; margin-bottom: 15px; }
        .auth-form-header h1 { font-size: 24px; font-weight: 300; letter-spacing: -0.5px; margin: 0; }
        .auth-form-body { width: 300px; background-color: #161b22; border: 1px solid #30363d; border-radius: 6px; padding: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 400; font-size: 14px; text-align: left; }
        input { width: 100%; padding: 5px 12px; margin-bottom: 15px; background-color: #0d1117; border: 1px solid #30363d; border-radius: 6px; color: #c9d1d9; font-size: 14px; box-sizing: border-box; outline: none; }
        input:focus { border-color: #58a6ff; box-shadow: 0 0 0 3px rgba(31, 111, 235, 0.3); }
        .btn-primary { width: 100%; background-color: #238636; color: #ffffff; padding: 5px 16px; border: 1px solid rgba(240, 246, 252, 0.1); border-radius: 6px; font-weight: 500; cursor: pointer; font-size: 14px; }
        .btn-primary:hover { background-color: #2ea043; }
        .create-account-callout { width: 300px; border: 1px solid #30363d; border-radius: 6px; padding: 15px 20px; margin-top: 15px; text-align: center; font-size: 14px; }
        .create-account-callout a { color: #58a6ff; text-decoration: none; }
        .error { background: #f8514922; color: #f85149; border: 1px solid #f8514944; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 15px; width: 100%; box-sizing: border-box; }
        .pass-group { position: relative; }
        .eye-icon { position: absolute; right: 10px; top: 7px; cursor: pointer; color: #8b949e; width: 18px; }
    </style>
</head>
<body>
    <div class="auth-form-header">
        <h1>Create your account</h1>
    </div>

    <div class="auth-form-body">
        <?php if($error) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Gmail address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <div class="pass-group">
                <input type="password" name="password" id="p1" required>
                <i data-lucide="eye" class="eye-icon" onclick="toggle('p1', this)"></i>
            </div>

            <label>Confirm password</label>
            <div class="pass-group">
                <input type="password" name="confirm_password" id="p2" required>
                <i data-lucide="eye" class="eye-icon" onclick="toggle('p2', this)"></i>
            </div>

            <button type="submit" class="btn-primary">Create account</button>
        </form>
    </div>

    <div class="create-account-callout">
        Already have an account? <a href="login.php">Sign in</a>.
    </div>

    <script>
        lucide.createIcons();
        function toggle(id, icon) {
            const el = document.getElementById(id);
            if (el.type === "password") {
                el.type = "text";
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                el.type = "password";
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>