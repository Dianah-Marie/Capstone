<?php
session_start(); // Start session to manage user data

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'attendease';

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$error = ''; // Variable to store error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Validate input
  if (empty($email) || empty($password)) {
    $error = "All fields are required!";
  } else {
    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT user_ID, username, email, password, accountType FROM user WHERE email = ?");
    if ($stmt === false) {
      die("SQL Error: " . $conn->error); // Output SQL error
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      // Compare the input password with the stored password hash
      if (password_verify($password, $row['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $row['user_ID'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = $row['accountType'];
        $_SESSION['username'] = $row['username'];

        // Redirect based on role
        if ($row['accountType'] === 'Admin') {
          header("Location: index.php");
        } else {
          header("Location: index.php");
        }
        exit();
      } else {
        $error = "Incorrect password!";
      }
    } else {
      $error = "No account found with that email!";
    }
  }
}



?>


<html>

<head>
  <link rel="icon" href="images/icon.png" type="image/x-icon">
  <link rel="stylesheet" href="login/styles.css">
  <link rel="icon" href="img/icon.png" type="image/x-icon">
  <script src="login/js/script.js" defer></script>
</head>

<body>
  <div class="card">
    <!-- Logo -->
    <div class="logo-wrapper" id="logoWrapper">
      <img src="images/icon.png" alt="AttendEase Logo" class="logoimg">
    </div>

    <!-- Login Form -->
    <div class="form-wrapper loginform show" id="loginForm">
      <h1>Login</h1>
      <form method="POST" action="">
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <input type="password" name="password" placeholder="Enter your password" required><br>
        <button type="submit" class="loginbtn">Login</button>
      </form>
      <a href="#" id="toForget">Forget Password</a>
    </div>

    <!-- Forget Form -->
    <div class="form-wrapper forgetform" id="forgetForm">
      <h1>Forget Password</h1>
      <form>
        <input type="email" placeholder="Enter your email" required><br>
        <button type="submit" class="resetbtn">Reset Password</button>
      </form>
      <a href="#" id="showLogin">Back to Login</a>
    </div>

    <?php if (!empty($error)): ?>
      <div style="color: red; right: 135px; position: absolute; bottom: 172px;">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>
  </div>


</body>

</html>