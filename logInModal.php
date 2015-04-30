<?php
include_once 'head.php';
include_once 'brewsDB_connection.php';
include_once 'functions.php';

sec_session_start();

if (login_check($connection) == true) {
	$logged = 'in';	
} else {
	$logged = 'out';	
}
?>
<!doctype html>
<html>
<?php
if (isset($_GET['error'])) {
	echo '<p>Error Logging In</p>';	
}
?>
<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="dpbLogInModal" aria-hidden="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form action="process_login.php" id="login" name="login_form" method="post">
                	<div class="form-group">
                    	<input type="email" class="form-control" name="email" placeholder="email">
                	</div>
                	<div class="form-group">
                    	<input type="password" class="form-control" name="password" placeholder="password">
                    </div>
                    <div class="form-group">
                    	<button type="submit" class="btn btn-primary btn-block" id="login" name="login" onClick="formhash(this.form this.form.password);">Log In</button>
                    	<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                	</div>
                    <div class="form-group">
                    	<span class="help-block text-center"><a href="" >forgot password?</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (login_check($connection) == true) {
	echo '<p>Currently logged ' . $logged . 'as' . htmlentities($_SESSION['username']) . '.</p>';	
}
?>
</html>