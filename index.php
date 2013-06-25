<?php
// Facebook PHP SDK
require 'src/facebook.php';

// Facebook App and Secret ID
require '_xxx.php';

// Create our Application instance.
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $secret,
));

// Database Connection
include('con.php');

?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>FB Tools</title>
  <meta property="og:title" content=""/>
  <meta property="og:type" content="contest"/>
  <meta property="og:url" content="//www.zgresources.com/_facebook/zg_test_case/"/>
  <meta property="og:image" content="/img/appLogo.jpg"/>
  <meta property="og:site_name" content="Merci-O-Matic"/>
  <meta property="fb:admins" content="100004990624658"/>
  <meta property="og:description" content="Description."/>
  <meta property="fb:app_id" content="<?php echo $appId; ?>"/>
</head>
<body>
  <style type="text/css">
  div#friend_form .validation, div#friend_form .success {display: none; font-size: 12px; margin-bottom: 20px;}
  </style>
<div id="fb-root"></div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '<?php echo $appId; ?>', // App ID from the App Dashboard
      channelUrl : '//www.zgresources.com/_facebook/zg_test_case/', // Channel File for x-domain communication
      status     : true, // check the login status upon init?
      cookie     : true, // set sessions cookies to allow your server to access the session?
      xfbml      : true  // parse XFBML tags on this page?
    });

    // Additional initialization code such as adding Event Listeners goes here
    FB.Canvas.setSize();
    FB.Canvas.scrollTo(0,0);
  };

  // Load the SDK's source Asynchronously
  // Note that the debug version is being actively developed and might 
  // contain some type checks that are overly strict. 
  // Please report such bugs using the bugs tool.
  (function(d, debug){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
     ref.parentNode.insertBefore(js, ref);
   }(document, /*debug*/ false));
</script>
<pre>Your journey begins now.</pre>
<div id="friend_form">
<div class="validation">
  <p>Oops! Please correct the highlighted fields...</p>
</div>
<div class="success">
  <p>Thanks! I'll get back to you shortly.</p>
</div>
<form action="javascript:;" method="post">
    <?php include 'select_friend.php'; ?>
  </form>
</div>
  <script>
  // AJAX POST
  $("div#friend_form form").submit(function() {
    var this_form = $(this);
    $.ajax({
      type: 'post',
      data: this_form.serialize(),
      url: 'process.php',
      success: function(res) {
        if(res == "true") {
          this_form.fadeOut("fast");
          $(".success").fadeIn("fast");
          $(".validation").fadeOut("fast");
        } else {
          $(".validation").fadeIn("fast");
          this_form.find(".text").removeClass("error");
          $.each(res.split(","), function() {
            this_form.find("#"+this).addClass("error");
          });
        }
      }
    });
  });
</script>
</body>
</html>