
<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
?>
<?php

include_once 'resources/Database.php';
include_once 'resources/utilities.php';

if(isset($_POST['loginBtn'])){
    //array to hold errors
    $form_errors = array();

//validate
    $required_fields = array('username', 'password');
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    if(empty($form_errors)){

        //collect form data
        $user = $_POST['username'];
        $password = $_POST['password'];

        //check if user exist in the database
        $sqlQuery = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($sqlQuery);
        $statement->execute(array(':username' => $user));

       while($row = $statement->fetch()){
           $id = $row['id'];
           $hashed_password = $row['password'];
           $username = $row['username'];

           if(password_verify($password, $hashed_password)){
            $_SESSION["loggedin"] = true;
               $_SESSION['id'] = $id;
               $_SESSION['username'] = $username;
               header("location: index.php");
           }else{
               $result = "<p style='padding: 20px; color: red; border: 1px solid gray;'> Invalid username or password</p>";
           }
       }

    }else{
        if(count($form_errors) == 1){
            $result = "<p style='color: red;'>There was one error in the form </p>";
        }else{
            $result = "<p style='color: red;'>There were " .count($form_errors). " error in the form </p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/png" href="img/icon.png" />
    <title>Bankist | When Banking meets Minimalist</title>
    <link rel="stylesheet" href="signup1.css" />
<style>
  body {
  background-color: #36a395;
  }
  .li {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  padding-bottom: 1rem;
  margin-top: 1rem;
}

.signup:link,
.signup:visited {
  font-size: 1.1rem;
  font-weight: 100;
  color: #222;
  text-decoration: none;
  display: block;
  transition: all 0.3s;
}

.forgot:link,
.forgot:visited {
  font-size: 1.1rem;
  font-weight: 100;
  color: #222;
  text-decoration: none;
  display: block;
  transition: all 0.3s;
}
#btn {
    text-align: center;
    padding: 20px 70px;
    position: relative;
    left: 60px;
    color: #fff;
    background-color: #1fab89;
    border: none;
    outline: none;
    border-radius: 5px;
    font-size: 23px;
    font-family: 'Comfortaa', cursive;
  }

</style>
  </head>
  <body>
    <div class="container" id="content01">
      <div class="img-slider">
        <h2>Welcome to Bankist</h2>
        <p>
          we are a community together helping thousands of people out there who
          are struggling to open a Bank account
        </p>
        <img src="img\Img1-removebg-preview.png" alt="img" />
      </div>
      <div class="content">
        <h2>SignIn</h2>
        <form id="form" method="post">
          <label for="name" id="nlabel">Name</label> <br />
          <input
            type="text"
            id="fname"
            placeholder="Lucifer Henry "
            autocomplete="off"
            name="username"
          />
          <br />
          <br />
          <label for="password" id="plabel">Password</label> <br />
          <input type="password" name="password" id="lpassword" /> <br />
          <div class="li">
            <a class="forgot" href="forgotpassword.php">Forgot password</a
            ><br />
            <a class="signup" href="signup.php">New user Register?</a><br />
          </div>

          <button
            type="submit"
            onclick="UserRegister()"
            id="btn"
            name="loginBtn"
          >
            Sign in
          </button>
          <?php if(isset($result)) echo $result; ?>
          <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </form>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  </body>
</html>
