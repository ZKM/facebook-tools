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

?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Coupon</title>
  <meta property="og:title" content=""/>
  <meta property="og:type" content="sport"/>
  <meta property="og:url" content="http://site.com"/>
  <meta property="og:image" content="/images/appLogo.jpg"/>
  <meta property="og:site_name" content="Coupon"/>
  <meta property="fb:admins" content="USER_ID"/>
  <meta property="og:description" content="Description."/>
  <meta property="fb:app_id" content="APP ID"/>
</head>
<body>
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
<?php
function parse_signed_request($signed_request) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2);

  // decode the data
  $sig  = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }
  return $data;
}

function base64_url_decode($input) {
  return base64_decode(strtr($input, '-_', '+/'));
}

if ($signed_request = parse_signed_request($_REQUEST['signed_request'])) {
  if ($signed_request["page"]["liked"]) {
    echo  ("<div id=\"like\"><pre>Your journey begins now.</pre></div>");
    include 'select_friend.php';

  } else {
    echo ("<div id=\"preLike\"><pre>To use this app you will need to like the page first</pre></div>");
  }
} else {
  echo "No signed_request. I am broken.";
}
echo ("</body></html>");