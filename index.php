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

  <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>

<body>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
  FB.init({
    appId  : "<?php echo $appId; ?>", // unique app ID for tab application. This will need to be updated for live app.
    status : true, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml  : true, // parse XFBML
    oauth  : true // enable OAuth 2.0
  });

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
  //print_r($signed_request);
  //print_r($_REQUEST['signed_request']);
  if ($signed_request["page"]["liked"]) { 
?>
  <script type="text/javascript">
    FB.Canvas.setSize(); // Set to the correct height of your page content.
    FB.Canvas.scrollTo(0,0);
  </script>
  <div id="like">
    You liked this.
  </div>
  <?php
  } else {
  ?>
  <script type="text/javascript">
    FB.Canvas.setSize(); // Set to the correct height of your page content.
    FB.Canvas.scrollTo(0,0);
  </script>
  <div id="preLike">
    Like this page.
  </div>
  <?php
  }
} else {
  echo "No signed_request. I am broken.";
}
?>
</body>
</html>