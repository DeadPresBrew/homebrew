<!doctype html>
<html>
<?php
include_once 'head.php';
include_once 'brewsDB_connection.php';
?>
<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="dpbLogInModal" aria-hidden="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form id="login" name="login_form" method="post">
                	<div class="form-group">
                    	<input type="email" class="form-control" name="email" placeholder="email">
                	</div>
                	<div class="form-group">
                    	<input type="password" class="form-control" name="password" placeholder="password">
                    </div>
                    <div class="form-group">
                    	<button type="submit" class="btn btn-primary btn-block" id="login" name="login">Log In</button>
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
</html>