<?php
include_once "core/init.php";
if (isset($_POST['login']) && !empty($_POST['login'])) {

	$email = $_POST['email'];
	$password = $_POST['password'];

	if (!empty($email) or !empty($password)) {
		$email = $getFromU->CheckInput($email);
		$password = $getFromU->CheckInput($password);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = "Invalid Email";
		} else {
			if ($getFromU->login($email, $password) === false) {
				$error = "The email or password is incorrect";
			}
		}
	} else {
		$error = "Please enter username and password";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900"
      rel="stylesheet"
    />
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Twitter - Log In</title>
  </head>
  <body>
    <div class="header__login">
      <h4 class="heading-h5 margin__top--small margin__bottom--small">Join Twitter Today</h4>
      <form method="post">
        <input type="text" name="email" id="email" placeholder="Username, Email or phone Number">
        <input type="password" name="password" id="password" placeholder="password">
        <?php
		  if (isset($error)) {
			  echo '<p id="error">'.$error.'</p>';
		  } ?>
        <button class="btn login__page--btn signup__btn--color" type="submit" name="login" value="Log in">Log In</button>
      </form>
      <a class="login__links" href="#">Forgot Password?</a>
      <a class="login__links" href="signup.php">Don't have an account? Signup</a>
    </div>
  </body>
</html>
