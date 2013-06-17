<div>
	<a class="friendSelect" href="#">Select a Friend</a>
</div>



<script>
$(".friendSelect").click(function () {
  FB.ui({
    method: 'apprequests',
    message: 'Choose 1 friends!'
  }, function (response) {
    console.log(response) //The friends
  });
});
</script>