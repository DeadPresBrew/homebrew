<!doctype html>
<html>
<?php 
include_once 'head.php';

include_once 'register.inc.php';
include_once 'functions.php';
?>
<body>
<div class="container">
<?php
if (!empty($error_msg)) {
	echo $error_msg;
}
?>
<div class="col-sm-4 col-sm-offset-4">
<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">
	<div class="form-group">
    	<label for="email">Email</label>
        <input id="email" class="form-control" name="email" type="email">
    </div>
    <div class="form-group">
    	<label for="username">Username</label>
        <input id="username" class="form-control" name="username" type="text">
    </div>
    <div class="form-group">
    	<label for="password">Password</label>
        <input id="password" class="form-control" name="password" type="password">
    </div>
    <div class="form-group">
    	<label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" class="form-control" name="password-confirm" type="password">
    </div>
    <button class="btn btn-primary" type="button" onclick"return regformhash(this.form, this.form.email, this.form.username, this.form.password, this.form.password-confirm);">Register</button>
</form>
</div>
</div>
</body>
</html>