<?php
//add our database connection script
include_once 'resources/database.php';
include_once 'resources/utilities.php';

//process the form if the reset password button is clicked
if(isset($_POST['passwordResetBtn'])){
    //initialize an array to store any error message from the form
    $form_errors = array();

    //Form validation
    $required_fields = array('email', 'new_password', 'confirm_password');

    //call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    //Fields that requires checking for minimum length
    $fields_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

    //call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    //email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));

    //check if error array is empty, if yes process form data and insert record
    if(empty($form_errors)){
        //collect form data and store in variables
        $email = $_POST['email'];
        $password1 = $_POST['new_password'];
        $password2 = $_POST['confirm_password'];

        //check if new password and confirm password is same
        if($password1 != $password2){
            $result = "<p style='padding:20px; border: 1px solid gray; color: red;'> New password and confirm password does not match</p>";
        }else{
            try{
                //create SQL select statement to verify if email address input exist in the database
                $sqlQuery = "SELECT email FROM users WHERE email =:email";

                //use PDO prepared to sanitize data
                $statement = $db->prepare($sqlQuery);

                //execute the query
                $statement->execute(array(':email' => $email));

                //check if record exist
                if($statement->rowCount() == 1){
                    //hash the password
                    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

                    //SQL statement to update password
                    $sqlUpdate = "UPDATE users SET password =:password WHERE email=:email";

                    //use PDO prepared to sanitize SQL statement
                    $statement = $db->prepare($sqlUpdate);

                    //execute the statement
                    $statement->execute(array(':password' => $hashed_password, ':email' => $email));

                    $result = "<p style='padding:20px; border: 1px solid gray; color: green;'> Password Reset Successful</p>";
                    echo "<br>";
                    header("location:login.php");
                }
                else{
                    $result = "<p style='padding:20px; border: 1px solid gray; color: red;'> The email address provided
                                does not exist in our database, please try again</p>";
                }
            }catch (PDOException $ex){
                $result = "<p style='padding:20px; border: 1px solid gray; color: red;'> An error occurred: ".$ex->getMessage()."</p>";
            }
        }
    }
    else{
        if(count($form_errors) == 1){
            $result = "<p style='color: red;'> There was 1 error in the form<br>";
        }else{
            $result = "<p style='color: red;'> There were " .count($form_errors). " errors in the form <br>";
        }
    }
}
?>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Bankist | FORGOT PASSWORD</title>
    <link rel="stylesheet" type="text/css" href="forgot.css" />
  </head>

  <body>
    <div class="login-root">
      <div
        class="box-root flex-flex flex-direction--column"
        style="min-height: 100vh; flex-grow: 1"
      >
        <div class="loginbackground box-background--white padding-top--64">
          <div class="loginbackground-gridContainer">
            <div
              class="box-root flex-flex"
              style="grid-area: top / start / 8 / end"
            >
              <div
                class="box-root"
                style="
                  background-image: linear-gradient(
                    white 0%,
                    rgb(247, 250, 252) 33%
                  );
                  flex-grow: 1;
                "
              ></div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 4 / 2 / auto / 5">
              <div
                class="box-root box-divider--light-all-2 animationLeftRight tans3s"
                style="flex-grow: 1"
              ></div>
            </div>
            <div
              class="box-root flex-flex"
              style="grid-area: 6 / start / auto / 2"
            >
              <div
                class="box-root box-background--blue800"
                style="flex-grow: 1"
              ></div>
            </div>
            <div
              class="box-root flex-flex"
              style="grid-area: 7 / start / auto / 4"
            >
              <div
                class="box-root box-background--blue animationLeftRight"
                style="flex-grow: 1"
              ></div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 8 / 4 / auto / 6">
              <div
                class="box-root box-background--gray100 animationLeftRight tans3s"
                style="flex-grow: 1"
              ></div>
            </div>
            <div
              class="box-root flex-flex"
              style="grid-area: 2 / 15 / auto / end"
            >
              <div
                class="box-root box-background--cyan200 animationRightLeft tans4s"
                style="flex-grow: 1"
              ></div>
            </div>
            <div
              class="box-root flex-flex"
              style="grid-area: 3 / 14 / auto / end"
            >
              <div
                class="box-root box-background--blue animationRightLeft"
                style="flex-grow: 1"
              ></div>
            </div>
            <div
              class="box-root flex-flex"
              style="grid-area: 4 / 17 / auto / 20"
            >
              <div
                class="box-root box-background--gray100 animationRightLeft tans4s"
                style="flex-grow: 1"
              ></div>
            </div>
            <div
              class="box-root flex-flex"
              style="grid-area: 5 / 14 / auto / 17"
            >
              <div
                class="box-root box-divider--light-all-2 animationRightLeft tans3s"
                style="flex-grow: 1"
              ></div>
            </div>
          </div>
        </div>
        <div
          class="box-root padding-top--24 flex-flex flex-direction--column"
          style="flex-grow: 1; z-index: 9"
        >
          <div
            class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center"
          >
            <h1>
              <a href="http://blog.stackfindover.com/" rel="dofollow"
                >Bankist</a
              >
            </h1>
          </div>
          <div class="formbg-outer">
            <div class="formbg">
              <div class="formbg-inner padding-horizontal--48">
                <span class="padding-bottom--15">Change Your Password</span>
                <form id="stripe-login" method="post">
                  <div class="field padding-bottom--24">
                    <label for="email">Email</label>
                    <input type="email" name="email" />
                  </div>
                  <div class="field padding-bottom--24">
                    <label for="password"></label>
                    <input type="password" name="new_password" />
                  </div>
                  <div class="field padding-bottom--24">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" />
                  </div>

                  <div class="field padding-bottom--24">
                    <input
                      type="submit"
                      name="passwordResetBtn"
                      value="Change Password"
                    />
                  </div>
                </form>
              </div>
            </div>
            <div class="footer-link padding-top--24">
              <div
                class="listing padding-top--24 padding-bottom--24 flex-flex center-center"
              >
                <span><a href="#">© Bankist</a></span>
                <span><a href="#">Contact</a></span>
                <span><a href="#">Privacy & terms</a></span>
                <?php if(isset($result)) echo $result; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
