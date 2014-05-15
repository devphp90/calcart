<br/>
<h3>Order Confirmation</h3>
<br/>


<div class="alert alert-success">
	An email confirmation has been sent.
</div>

<div class="alert alert-success">
	Will continue in 5 secs, or click <a href="<?php echo $url?>">Here</a> to continue....
</div>
<script>
function redirect(){
	window.location.replace("<?php echo $url?>");
}
setTimeout("redirect();", 5000);
</script>

