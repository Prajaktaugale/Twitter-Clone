<?php
include_once('../core/init.php');
$user_id = @$_SESSION['user_id'];
$user = $getFromU->userData($user_id);

if (isset($_GET['step']) === true && empty($_GET['step']) === false) {
    if (isset($_POST['next'])) {
        $username = $getFromU->CheckInput($_POST['username']);
        if (!empty($username)) {
            if (strlen($username) > 20) {
                $error = "username must be between 6 to 20 character";
            } elseif ($getFromU->checkUsername($username) === true) {
                $error = "Username is taken";
            } else {
                $query = "UPDATE users SET username =:username WHERE user_id=:user_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                header('Location: username.php?step=2');
                exit();
            }
        } else {
            $error = "Please enter your useername to choose";
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
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Twitter - Username</title>
</head>
<body>
  <?php if (($_GET['step']) == '1') { ?>
    <div class="username">
      <form method="post">
      <div class="header__signup--logo center__content">
        <image
          class="signup__page--logo default__color"
          xlink:href="../images/svg/twitter.svg"
          src="../images/svg/twitter.svg"
        />
      </div>
        <h1 class="heading">Choose an Username</h1>
        <p class="sub__heading">Don't worry, you can always change it later.</p>
         <input type="text" name="username" placeholder="Username" /><br>
         <?php if (isset($error)) { echo '<p id="error">'.$error.'</p>';} ?>
         <button class="next__btn margin__top--small btn__basic maring signup__btn--color" type="submit" name="next" value="next">Next</button>
      <form>
    </div>
  <?php } ?>

    <?php if (($_GET['step']) == '2') { ?>
    <div class='username__got'>
        <div class='lets__go'>
        <div class="header__signup--logo center__content">
        <image
          class="signup__page--logo default__color"
          xlink:href="../images/svg/twitter.svg"
          src="../images/svg/twitter.svg"
        />
      </div>
          <h2 class="heading">We're glad you're here,<?php echo $user->screenName; ?></h2>
            <p class="sub__heading"><strong>Twitter is a constantly updating stream of the coolest, most important news, media, sports, TV, conversations and more--all tailored just for you.</strong></p>
              <br />
                <p class="sub__heading">
                  Tell us about all the stuff you love and we'll help you get set up.
                </p>
                <span>
                  <a href='../home.php' class='signup__btn--color margin__top--small'>Let's go!</a>
                </span>
          </div>
      </div>
      <?php } ?>
</body>
</html>
<?php
}
?>