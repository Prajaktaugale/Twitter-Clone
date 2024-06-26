<?php
include_once('core/init.php');
$user_id = @$_SESSION['user_id'];
$user = $getFromU->userData($user_id);
$notify = $getFromM->getNotificationCount($user_id);
if (isset($_POST['tweet'])) {
    $status = $getFromU->CheckInput($_POST['status']);
    $tweetImage = '';

    if (!empty($status) || !empty($_FILES['file']['name'][0])) {
        if (!empty($_FILES['file']['name'][0])) {
            $tweetImage = $getFromU->uploadImage($_FILES['file']);
        }
        if (strlen($status) > 140) {
            $error = "The text of your tweet is to long";
        }
        $Tweet_id = $getFromU->create('tweets', array('status' => $status, 'tweetBy' => $user_id, 'tweetImage' => $tweetImage, 'postedOn' => date('Y-m-d H:i:s')));

        preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);
        if (!empty($hashtag)) {
            $getFromT->addTrend($status);
        }
        $getFromT->addMention($status, $user_id, $Tweet_id);
        header("Location: home.php");
        exit();
    } else {
        $error = "Type or choose an image";
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
    <title>Home</title>
  </head>
  <body>
    <div class="layout">
      <div class="layout__left--sidebar-container">
        <div class="layout__left--sidebar">
          <div class="brand__box">
            <img src="images/svg/twitter.svg" alt="twitter" class="brand" />
          </div>
          <div class="left__sidebar--box">
            <ul class="left__sidebar--menu">
              <li class="left__sidebar--menu-items">
                <a href="#" class="left__sidebar--menu-links left__sidebar--menu-links--active"
                  ><div class="left__sidebar--menu-image--box"
                    ><img
                      src="images/svg/home.svg"
                      alt="twitter"
                      class="left__sidebar--menu-image" /></
                  >Home</div></a
                >
              </li>
              <li class="left__sidebar--menu-items">
                <a href="#" class="left__sidebar--menu-links"
                  ><div class="left__sidebar--menu-image--box"
                    ><img
                      src="images/svg/explore.svg"
                      alt="twitter"
                      class="left__sidebar--menu-image" /></
                  >Explore</div></a
                >
              </li>
              <li class="left__sidebar--menu-items">
                <a href="#" class="left__sidebar--menu-links"
                  ><div class="left__sidebar--menu-image--box"
                    ><img
                      src="images/svg/notifications.svg"
                      alt="twitter"
                      class="left__sidebar--menu-image" /></
                  >Notification</div></a
                >
              </li>
              <li class="left__sidebar--menu-items">
                <a href="#" class="left__sidebar--menu-links"
                  ><div class="left__sidebar--menu-image--box"><img
                    src="images/svg/messages.svg"
                    alt="twitter"
                    class="left__sidebar--menu-image" />Messages</div></a
                >
              </li>
              <li class="left__sidebar--menu-items">
                <a href="#" class="left__sidebar--menu-links"
                  ><div class="left__sidebar--menu-image--box"><img
                    src="images/svg/bookmark.svg"
                    alt="twitter"
                    class="left__sidebar--menu-image" />Bookmarks</div></a
                >
              </li>
              <li class="left__sidebar--menu-items">
                <a href="#" class="left__sidebar--menu-links"
                  ><div class="left__sidebar--menu-image--box"><img
                    src="images/svg/list.svg"
                    alt="twitter"
                    class="left__sidebar--menu-image" />Lists</div></a
                >
              </li>
              <li class="left__sidebar--menu-items">
                <a href="profile.html" class="left__sidebar--menu-links"
                  ><div class="left__sidebar--menu-image--box"><img
                    src="images/svg/profile.svg"
                    alt="twitter"
                    class="left__sidebar--menu-image" />Profile</div></a
                >
              </li>
              <li class="left__sidebar--menu-items">
                <a href="#" class="left__sidebar--menu-links"
                  ><div class="left__sidebar--menu-image--box"><img
                    src="images/svg/more.svg"
                    alt="twitter"
                    class="left__sidebar--menu-image" />More</div></a
                >
              </li>
            </ul>
          </div>
          <!-- ! User Logout Menu -->
        </div>
        <div class="left__sidebar--logout">
            <img src="images/default__peofile.png" alt="profile__image" class="tweet__user-logo">
            <div class="left__sidebar--userText">
              <h4>Gaurav Sharma</h4>
              <h5>@gsharma010</h5>
            </div>
            <div class="logout__menu"><img src="images/svg/menu.svg" alt="more"></div>
          </div>
      </div>
      <!-- ! Center -->
      <div class="layout__main--sidebar">
        <div>
          <div class="explorar">
            <h2>Home</h3>
            <div class="Exploara"><img src="images/svg/more.svg" alt="explore"></div>
          </div>
        </div>
      <!-- ! Devider  -->
        <div class="tweet__container">
          <img src="images/default__peofile.png" alt="profile__image" class="tweet__user-logo">
          <div class="tweet__creater">
            <div>
              <textarea name="tweet" placeholder="What's Happning ?" id="tweetArea" cols="55" rows="3"></textarea>
            </div>
            <!-- ? Tweet Actions -->
            <div class="tweet__options">
              <div class="tweet__options--items"><img src="images/svg/media.svg" alt="media"></div>
              <div class="tweet__options--items"><img src="images/svg/gif.svg" alt="media"></div>
              <div class="tweet__options--items"><img src="images/svg/graph.svg" alt="media"></div>
              <div class="tweet__options--items"><img src="images/svg/smile.svg" alt="media"></div>
              <div class="tweet__options--items"><img src="images/svg/date.svg" alt="media"></div>
              <div class="tweet__options--items"><button class="btn btn__basic">Tweet</button></div>
            </div>
          </div>
        </div>
        <!-- ? Tweets -->
        <div class="tweet">
          <img src="images/default__peofile.png" alt="profile__image" class="tweet__user-logo">
          <div class="tweet__main">
            <div class="tweet__header">
              <div class="tweet__person--name">Gaurav Sharma</div>
              <div class="tweet__username"><a href="#">(@gsharma010)</a></div>
              <div class="tweet__publish--time">10h</div>
              <div class="tweet__menu"><img src="images/svg/menu.svg" alt="menu"></div>
            </div>
            <div class="tweet__content">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum perspiciatis eos itaque quidem dolor quam tempora. Voluptatem aliquam consequatur quibusdam, rem, laboriosam quia eum veritatis ullam harum commodi illum! Non!
            </div>
            <div class="tweet__actions">
              <div class="comment">
                <a href="#"><img class="action__icon" src="images/svg/comment.svg" alt="comment"></a>
              </div>
              <div class="retweet">
                <a href="#"><img class="action__icon" src="images/svg/retweet.svg" alt="retweet"></a> 
              </div>
              <div class="like">
                <a href="#"><img class="action__icon" src="images/svg/like.svg" alt="like"></a> 
              </div>
              <div class="share">
                <a href="#"><img class="action__icon" src="images/svg/share.svg" alt="share"></a> 
              </div>
            </div>
          </div>
        </div>       
      </div>
      <!-- ! RIGHT -->
      <div class="layout__right--sidebar-container">
        <div class="layout__right--sidebar">
          <div class="search__box">
            <input
              type="search"
              name="search"
              id="search"
              placeholder="Search on Twitter"
            />
          </div>

          <!-- ? Who to follow -->
          <div class="follow__suggestion">
            <h3 class="follow__suggestion--heading">Who to follow</h3>
            <div class="follow__suggestion--data">
              <img src="images/default__peofile.png" alt="profile__image" class="tweet__user-logo">
              <div class="follow__you--data">
                <h4>Gaurav Sharma</h4>
                <h6>@gsharma010</h6>
              </div>
              <button>Follow</button>
            </div>

            <div class="follow__suggestion--data">
              <img src="images/default__peofile.png" alt="profile__image" class="tweet__user-logo">
              <div class="follow__you--data">
                <h4>Gaurav Sharma</h4>
                <h6>@gsharma010</h6>
              </div>
              <button>Follow</button>
            </div>

            <div class="follow__suggestion--data">
              <img src="images/default__peofile.png" alt="profile__image" class="tweet__user-logo">
              <div class="follow__you--data">
                <h4>Gaurav Sharma</h4>
                <h6>@gsharma010</h6>
              </div>
              <button>Follow</button>
            </div>
            <a href="#" class="follow__suggestion--more">Show More</a>
          </div>

        </div>
      </div>
    </div>
  </body>
</html>
