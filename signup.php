<?php
include_once "core/init.php";
if (isset($_POST['signup'])) {
	$screenName = $_POST['screen_Name'];
	$email = $_POST['email'];
	$password_1 = $_POST['password_1'];
  $password_2 = $_POST['password_2'];
	$error = '';

	if (empty($screenName) or empty($email) or empty($password_1) or empty($password_2) ) {
		$error = "All fields are required";
	} else {
		$screenName = $getFromU->CheckInput($screenName);
		$email = $getFromU->CheckInput($email);
		$password_1 = $getFromU->CheckInput($password_1);
    $password_2 = $getFromU->CheckInput($password_2);
		if (!filter_var($email)) {
			$error = "Invalid email entered";
		} elseif (strlen($screenName) > 20) {
			$error = "Name must be between 6-20 character";
		} elseif (strlen($password_1) < 5) {
			$error = "password is to short";
		} elseif (strcmp($password_1, $password_2) !== 0){
      $error = "password is incorrect";
    }else {
			if ($getFromU->checkEmail($email) === true) {
				$error = "Email is already in use";
			} else {
				$hashPassword = password_hash($password_1, PASSWORD_DEFAULT);
				$getFromU->register($email, $screenName, $hashPassword);
				header('Location: includes/username.php?step=1');
				exit();
			}
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
    <link
      href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900"
      rel="stylesheet"
    />
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Twitter - Sign up</title>
  </head>
  <body>
    <div class="header__signup">
      <div class="header__signup--logo center__content">
        <image
          class="signup__page--logo"
          xlink:href="images/svg/twitter.svg"
          src="images/svg/twitter.svg"
        />
      </div>
      <h4 class="heading-h5 margin__top--small margin__bottom--small">Create your account</h4>
      <form method="post" class="header__signup--form">
        <input type="text" name="screen_Name" id="screen_Name" placeholder="Full Name" />
        <input type="email" name="email" id="email" placeholder="Email" />
        <input
          type="password"
          name="password_1"
          id="password_1"
          placeholder="Password"
        />
        <input
          type="password"
          name="password_2"
          id="password_2"
          placeholder="Confirm Password"
        />
        <?php
		  if (isset($error)) {
			  echo '<div id="error">'.$error.'</div>';
		  }
      ?>
        <button class="btn signup__page--btn signup__btn--color" type="submit" name="signup">Sign Up</button>
      </form>
      <a id="have__ac" href="login.php">Have an account. Log in</a>
    </div>
  </body>
</html>
