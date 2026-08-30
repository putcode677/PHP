<?php

require_once "config.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check fields
    if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {

        $message = "Please fill in all fields.";
        $messageType = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $messageType = "error";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";
        $messageType = "error";

    } elseif ($password !== $confirm_password) {

        $message = "Passwords do not match.";
        $messageType = "error";

    } else {

        // Check if email already exists
        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->execute([$email]);

        if ($check->fetch()) {

            $message = "This email is already registered.";
            $messageType = "error";

        } else {

            // Hash password
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert user
            $stmt = $conn->prepare(
                "INSERT INTO users (fullname, email, password)
                 VALUES (?, ?, ?)"
            );

            if ($stmt->execute([
                $fullname,
                $email,
                $hashedPassword
            ])) {

                $message = "Registration successful! You can now login.";
                $messageType = "success";

            } else {

                $message = "Registration failed.";
                $messageType = "error";
            }
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

```
<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Register - Auth System</title>

<style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f1f5f9;

        display: flex;
        justify-content: center;
        align-items: center;

        min-height: 100vh;
    }

    .container {
        width: 400px;
        background: white;

        padding: 35px;

        border-radius: 12px;

        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #222;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 7px;
        font-weight: bold;
        color: #333;
    }

    input {
        width: 100%;
        padding: 12px;

        border: 1px solid #ccc;
        border-radius: 6px;

        font-size: 15px;
    }

    input:focus {
        outline: none;
        border-color: #007bff;
    }

    button {
        width: 100%;
        padding: 13px;

        border: none;
        border-radius: 6px;

        background: #007bff;
        color: white;

        font-size: 16px;
        font-weight: bold;

        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }

    .message {
        padding: 12px;
        margin-bottom: 20px;

        border-radius: 6px;
        text-align: center;
    }

    .success {
        background: #d1fae5;
        color: #065f46;
    }

    .error {
        background: #fee2e2;
        color: #991b1b;
    }

    .login {
        text-align: center;
        margin-top: 20px;
    }

    .login a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

</style>
```

</head>

<body>

<div class="container">

```
<h2>Create Account</h2>

<?php if (!empty($message)): ?>

    <div class="message <?= $messageType ?>">
        <?= htmlspecialchars($message) ?>
    </div>

<?php endif; ?>


<form method="POST">

    <div class="form-group">

        <label for="fullname">
            Full Name
        </label>

        <input
            type="text"
            id="fullname"
            name="fullname"
            placeholder="Enter your full name"
            required
        >

    </div>


    <div class="form-group">

        <label for="email">
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            placeholder="Enter your email"
            required
        >

    </div>


    <div class="form-group">

        <label for="password">
            Password
        </label>

        <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter password"
            required
        >

    </div>


    <div class="form-group">

        <label for="confirm_password">
            Confirm Password
        </label>

        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            placeholder="Confirm password"
            required
        >

    </div>


    <button type="submit">
        Register
    </button>

</form>


<div class="login">

    Already have an account?

    <a href="login.php">
        Login
    </a>

</div>
```

</div>

</body>

</html>
