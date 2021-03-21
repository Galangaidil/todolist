<?php

require_once("config.php");

//untuk sign in
if (isset($_POST['login'])) {

  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
  $stmt = $db->prepare($sql);

  // bind parameter ke query
  $params = array(
    ":username" => $username,
    ":email" => $username
  );

  $stmt->execute($params);

  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // jika user terdaftar
  if ($user) {
    // verifikasi password
    if (password_verify($password, $user["password"])) {
      // buat Session
      session_start();
      $_SESSION["user"] = $user;
      // login sukses, alihkan ke halaman timeline
      header("Location: dashboard.php");
    }
  }
}

//untuk register / sign up
if (isset($_POST['register'])) {

  // filter data yang diinputkan
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  // enkripsi password
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


  // menyiapkan query
  $sql = "INSERT INTO users (username, email, password) 
            VALUES (:username, :email, :password)";
  $stmt = $db->prepare($sql);

  // bind parameter ke query
  $params = array(
    ":username" => $username,
    ":password" => $password,
    ":email" => $email
  );

  // eksekusi query untuk menyimpan ke database
  $saved = $stmt->execute($params);

  // jika query simpan berhasil, maka user sudah terdaftar
  // maka alihkan ke halaman login
  if ($saved) header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/de6a8b7c3d.js" crossorigin="anonymous"></script>
  <title>Sign in & Sign Up Form</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="POST" class="sign-in-form">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username">
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
          <input type="submit" name="login" value="Login" class="btn solid">

          <p class="social-text">Or Sign in with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>

        <form action="" name="RegForm" method="POST" class="sign-up-form" onsubmit="return registrasi()">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username">
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="text" name="email" placeholder="Email">
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
          <input type="submit" name="register" value="Sign up" class="btn solid">

          <p class="social-text">Or Sign up with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta distinctio assumenda illum?</p>
          <button class="btn transparent" id="sign-up-btn">Sign up</button>
        </div>

        <img src="img/log.svg" class="image" alt="">
      </div>

      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta distinctio assumenda illum?</p>
          <button class="btn transparent" id="sign-in-btn">Sign in</button>
        </div>

        <img src="img/register.svg" class="image" alt="">
      </div>
    </div>
  </div>

  <script src="js/app.js"></script>
  <script src="js/validasi.js"></script>
</body>

</html>