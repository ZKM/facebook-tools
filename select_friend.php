<link rel="stylesheet" href="./css/tdfriendselector.css?v=2" />

<ul>
	<li>Status: <span id="login-status">Not logged in</span> <a href="#" id="btnLogin">Login</a></li>
	<li><a href="#" id="friendSelect">Select a friend</a> (You'll need to log in first)</li>
</ul>

<div id="results">
	<h2><pre>ACTIVITY LOG</pre></h2>
</div>

<!-- Markup for These Days Friend Selector -->
<div id="TDFriendSelector">
	<div class="TDFriendSelector_dialog">
		<a href="#" id="TDFriendSelector_buttonClose">x</a>
		<div class="TDFriendSelector_form">
			<div class="TDFriendSelector_header">
				<p>Select your friend</p>
			</div>
			<div class="TDFriendSelector_content">
				<p>Then you can invite them to join you in the app.</p>
				<div class="TDFriendSelector_searchContainer TDFriendSelector_clearfix">
					<div class="TDFriendSelector_selectedCountContainer"><span class="TDFriendSelector_selectedCount">0</span> / <span class="TDFriendSelector_selectedCountMax">0</span> friends selected</div>
					<input type="text" placeholder="Search friends" id="TDFriendSelector_searchField" />
				</div>
				<div class="TDFriendSelector_friendsContainer"></div>
			</div>
			<div class="TDFriendSelector_footer TDFriendSelector_clearfix">
				<a href="#" id="TDFriendSelector_pagePrev" class="TDFriendSelector_disabled">Previous</a>
				<a href="#" id="TDFriendSelector_pageNext">Next</a>
				<div class="TDFriendSelector_pageNumberContainer">
					Page <span id="TDFriendSelector_pageNumber">1</span> / <span id="TDFriendSelector_pageNumberTotal">1</span>
				</div>
				<a href="#" id="TDFriendSelector_buttonOK">OK</a>
			</div>
		</div>
	</div>
</div>

<script src="./js/tdfriendselector.js"></script>
<script>
/*globals $, jQuery, FB, TDFriendSelector */
window.fbAsyncInit = function () {
	FB.init({appId: '<?php echo $appId; ?>', status: true, cookie: false, xfbml: false, oauth: true});
  $(document).ready(function () {
    var selector, logActivity, callbackFriendSelected, callbackFriendUnselected, callbackMaxSelection, callbackSubmit;

    // When a friend is selected, log their name and ID
    callbackFriendSelected = function (friendId) {
      var friend, name;
      friend = TDFriendSelector.getFriendById(friendId);
      name = friend.name;
      logActivity('Selected ' + name + ' (ID: ' + friendId + ')');
    };

    // When a friend is deselected, log their name and ID
    callbackFriendUnselected = function (friendId) {
      var friend, name;
      friend = TDFriendSelector.getFriendById(friendId);
      name = friend.name;
      logActivity('Unselected ' + name + ' (ID: ' + friendId + ')');
    };

    // When the maximum selection is reached, log a message
    callbackMaxSelection = function () {
      logActivity('Selected the maximum number of friends');
    };

    // When the user clicks OK, log a message
    callbackSubmit = function (selectedFriendIds) {
      logActivity('Clicked OK with the following friends selected: ' + selectedFriendIds.join(", "));
    };

    // Initialise the Friend Selector with options that will apply to all instances
    TDFriendSelector.init({
      debug: true
    });

    // Create some Friend Selector instances
    selector = TDFriendSelector.newInstance({
      callbackFriendSelected: callbackFriendSelected,
      callbackFriendUnselected: callbackFriendUnselected,
      callbackMaxSelection: callbackMaxSelection,
      callbackSubmit: callbackSubmit,
      maxSelection: 1,
      friendsPerPage: 5,
      autoDeselection: true
    });

    FB.getLoginStatus(function (response) {
      if (response.authResponse) {
        $("#login-status").html("Logged in");
        $("#btnLogin").hide();
      } else {
        $("#login-status").html("Not logged in");
        $("#btnLogin").show();
      }
    });

    $("#btnLogin").click(function (e) {
      e.preventDefault();
      FB.login(function (response) {
        if (response.authResponse) {
          console.log("Logged in");
          $("#login-status").html("Logged in");
          $("#btnLogin").hide();

        } else {
          console.log("Not logged in");
          $("#login-status").html("Not logged in");
          $("#btnLogin").show();
        }
      }, {});
    });

    $("#friendSelect").click(function (e) {
      e.preventDefault();
      selector.showFriendSelector();
    });

    logActivity = function (message) {
      $("#results").append('<div>' + new Date() + ' - ' + message + '</div>');
    };
  });
};
(function () {
	var e = document.createElement('script');
	e.async = true;
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
});
</script>
