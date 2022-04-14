<?php
//add our database connection script
include_once 'resources/Database.php';
include_once 'resources/utilities.php';

//process the form
if(isset($_POST['signupBtn'])){
    //initialize an array to store any error message from the form
    $form_errors = array();

    //Form validation
    $required_fields = array('email', 'username', 'password');

    //call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    //Fields that requires checking for minimum length
    $fields_to_check_length = array('username' => 4, 'password' => 6);

    //call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    //email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));

    //check if error array is empty, if yes process form data and insert record
    if(empty($form_errors)){
        //collect form data and store in variables
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //hashing the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sqlInsert = "INSERT INTO users (username, email, password, join_date)
        VALUES (:username, :email, :password, now())";
        $statement = $db->prepare($sqlInsert);
        $statement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));
        $result="REGISTRATION SUCCESFUL";
         header("location:login.php");
          /* $rows=array(1,2,3,4,5,6);
          
            //create SQL insert statement
           /* $sqlInsert = "INSERT INTO users (username, email, password, join_date)
              VALUES (:username, :email, :password, now())";
              
*/         /*$sql="INSERT INTO users (username, email, password, join_date)
              VALUES (:username, :email, :password, now())";
            //use PDO prepared to sanitize data
            $statement = $db->prepare($sql);
           foreach($rows as $row){
            //add the data into the database
            $statement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));
            
            //check if one new row was created
            if($statement->rowCount() == $row){
               
                $result="REGISTRATION SUCCESFUL";
                header("location: login.php");
                
            }
          }
        }*/
      }
    else{
        if(count($form_errors) == 1){
            $result = "<p style='color: red;'> There was 1 error in the form<br>";
        }else{
            $result = "<p style='color: red;'> There were " .count($form_errors). " errors in the form <br>";
        }
    }

  }?>

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
    margin-top:20px;
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
        <h2>Get Started</h2>
     <!--- <p>Already have account ? <a href="login.php" id="login">Sign In </a></p>--->

        <form id="form" method="post">
          <label for="name" id="nlabel" >Name</label> <br />
          <input
            type="text"
            id="fname"
            placeholder="Lucifer Henry "
            autocomplete="off"
            name="username"
          />
          <br />
          <label for="email" id="elabel" >Email</label> <br />
          <input
            type="email"
            id="eemail"
            placeholder="Lucifer@gmail.com"
            autocomplete="off"
            name="email"
          />
          <br />
          <label for="password" id="plabel" >Password</label> <br />
          <input type="password" name="password" id="lpassword" /> <br />
          <button type="submit" onclick="UserRegister()" id="btn" name="signupBtn">
            Sign Up
            
          </button>
          <?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

        </form>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  </body>
</html>
