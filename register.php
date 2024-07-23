<?php
session_start();
$servername = "localhost";
$username = "root";  // Change this to your database username
$password = "";      // Change this to your database password
$dbname = "login"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50)); // Generate a random token for email confirmation

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $user, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username or email already exists.";
    } else {
        // Insert new user with token
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, token) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user, $pass, $email, $token);
        if ($stmt->execute()) {
            // Send confirmation email
            $to = $email;
            $subject = "Email Verification";
            $message = "Click the link below to verify your email address:\n\n";
            $message .= "76534528+PateDEV@users.noreply.github.com/confirm.php?token={$token}";
            $headers = "no-reply@infraronkx.eu";

            if (mail($to, $subject, $message, $headers)) {
                $success_message = "Registration successful! A confirmation email has been sent to $email.";
            } else {
                $error_message = "Failed to send confirmation email.";
            }
        } else {
            $error_message = "Registration failed. Please try again.";
        }
    }

    $stmt->close();
}

$conn->close();
?>
<!doctype html>
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <title>Register</title> 
  <link rel="stylesheet" href="login.css"> 
  <style>
    /* Include your CSS here */
  </style>
</head> 
<body> 
  <section> 
    <div class="signin"> 
      <div class="content"> 
        <h2>Register</h2> 
        <?php if (!empty($error_message)) { echo '<p style="color:red;">'.$error_message.'</p>'; } ?>
        <?php if (!empty($success_message)) { echo '<p style="color:green;">'.$success_message.'</p>'; } ?>
        <form method="post" action="register.php">
          <div class="inputBox"> 
            <input type="text" name="username" required> 
            <i>Username</i> 
          </div>
          <div class="inputBox"> 
            <input type="email" name="email" required> 
            <i>Email</i> 
          </div>
          <div class="inputBox"> 
            <input type="password" name="password" required> 
            <i>Password</i> 
          </div> 
          <div class="inputBox"> 
            <input type="submit" value="Register"> 
          </div> 
          <a href="index.html" class="button-link back-button">Home</a>
        </form>
      </div> 
    </div> 
  </section> 
</body>
</html>
<!doctype html>
<html lang="en"> 
<head> 
  <meta charset="UTF-8"> 
  <title>LOGIN</title> 
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
    *
    {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Quicksand', sans-serif;
    }
    body 
    {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #000;
    }
    section 
    {
      position: absolute;
      width: 100vw;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 2px;
      flex-wrap: wrap;
      overflow: hidden;
    }
    section::before 
    {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: linear-gradient(#000,#85B7B6,#000);
      animation: animate 5s linear infinite;
    }
    @keyframes animate 
    {
      0%
      {
        transform: translateY(-100%);
      }
      100%
      {
        transform: translateY(100%);
      }
    }
    section span 
    {
      position: relative;
      display: block;
      width: calc(6.25vw - 2px);
      height: calc(6.25vw - 2px);
      background: #181818;
      z-index: 2;
      transition: 1.5s;
    }
    section span:hover 
    {
      background: #85B7B6; 
      transition: 0s;
    }

    section .signin
    {
      position: absolute;
      width: 400px;
      background: #222;  
      z-index: 1000;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
      border-radius: 4px;
      box-shadow: 0 15px 35px rgba(0,0,0,9);
    }
    section .signin .content 
    {
      position: relative;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      gap: 40px;
    }
    section .signin .content h2 
    {
      font-size: 2em;
      color: #85B7B6; 
      text-transform: uppercase;
    }
    section .signin .content .form 
    {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 25px;
    }
    section .signin .content .form .inputBox
    {
      position: relative;
      width: 100%;
    }
    section .signin .content .form .inputBox input 
    {
      position: relative;
      width: 100%;
      background: #333;
      border: none;
      outline: none;
      padding: 25px 10px 7.5px;
      border-radius: 4px;
      color: #fff;
      font-weight: 500;
      font-size: 1em;
    }
    section .signin .content .form .inputBox i 
    {
      position: absolute;
      left: 0;
      padding: 15px 10px;
      font-style: normal;
      color: #aaa;
      transition: 0.5s;
      pointer-events: none;
    }
    .signin .content .form .inputBox input:focus ~ i,
    .signin .content .form .inputBox input:valid ~ i
    {
      transform: translateY(-7.5px);
      font-size: 0.8em;
      color: #fff;
    }
    .signin .content .form .links 
    {
      position: relative;
      width: 100%;
      display: flex;
      justify-content: space-between;
    }
    .signin .content .form .links a 
    {
      color: #fff;
      text-decoration: none;
    }
    .signin .content .form .links a:nth-child(2)
    {
      color: #85B7B6; 
      font-weight: 600;
    }
    .signin .content .form .inputBox input[type="submit"]
    {
      padding: 10px;
      background: #85B7B6;
      color: #000;
      font-weight: 600;
      font-size: 1.35em;
      letter-spacing: 0.05em;
      cursor: pointer;
    }
    input[type="submit"]:active
    {
      opacity: 0.6;
    }
    @media (max-width: 900px)
    {
      section span 
      {
        width: calc(10vw - 2px);
        height: calc(10vw - 2px);
      }
    }
    @media (max-width: 600px)
    {
      section span 
      {
        width: calc(20vw - 2px);
        height: calc(20vw - 2px);
      }
    }

    .signup-page {}

    .back-button {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .button-link {
      display: inline-block;
      padding: 20px 40px; 
      background-color: #017481;
      color: #ffffff; 
      text-decoration: none;
      border-radius: 5px;
      font-size: 24px; 
      font-weight: bold;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
      transition: background-color 0.3s, transform 0.3s;
    }

    .button-link:hover {
      background-color: #0092A2; 
      transform: translateY(-3px); 
    }

    .button-link:active {
      transform: translateY(0);
    }
  </style>