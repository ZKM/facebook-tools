<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require 'src/facebook.php';
// Facebook App and Secret ID
require '_xxx.php';


// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $secret,
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>Facebook</title>
    <link rel="stylesheet" href="./css/tdfriendselector.css" />
    <style>
      body {
      	width: 810px;
      	margin:0 auto;
      	overflow-x:hidden;
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
    <script>
		// Load the SDK Asynchronously
		(function (d) {
		  var js, id = 'facebook-jssdk';
		  if (d.getElementById(id)) {
		    return;
		  }
		  js = d.createElement('script');
		  js.id = id;
		  js.async = true;
		  js.src = "//connect.facebook.net/en_US/all.js";
		  d.getElementsByTagName('head')[0].appendChild(js);
		}(document));

		// Auto Grow the canvas, say NO to scrollbars
		window.fbAsyncInit = function () {
		  FB.init({
		    appId: '<?php echo $appId; ?>',
		    status: true,
		    cookie: true,
		    xfbml: true
		  });
		  FB.Canvas.setSize({
		    height: 600
		  });
		  setTimeout("FB.Canvas.setAutoGrow()", 500);
		};
    </script>
  </head>
  <body>

    <h1>Facebook</h1>
	<div id="fb-root"></div>
	<ul>
		<li>Status: <span id="login-status">Not logged in</span></li>
		<li><a href="#" id="btnSelect2">Select one friend</a></li>
		<li><a href="#" onclick='postToFeed(); return false;'>Post to Feed</a></li>
	</ul>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script> 
	// Post to my wall 
	function postToFeed() {
	  // calling the API ...
	  var obj = {
	    method: 'feed',
	    link: 'https://developers.facebook.com/docs/reference/dialogs/',
	    picture: 'http://fbrell.com/f8.jpg',
	    name: 'Facebook Dialogs',
	    caption: 'Reference Documentation',
	    description: 'Using Dialogs to interact with users.'
	  };

	  function callback(response) {
	    console.log(response);
	  }

	  FB.ui(obj, callback);
	}

	</script>
	<script src="./js/tdfriendselector.js"></script>
	<script src="./js/example.js"></script>
  </body>
</html>
