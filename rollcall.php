<!doctype html>
<html>
<?php 
include_once 'head.php';

include_once ('brewsDB_connection.php');

if (isset($_POST['rollcall'])) {

$connection->select_db('attendance');

//input variables
$date = $_POST['date'];
$kiel = $_POST['kiel'];
$ryan = $_POST['ryan'];
$josh = $_POST['josh'];
$frank = $_POST['frank'];
$kieleat = $_POST['kieleat'];
$ryaneat = $_POST['ryaneat'];
$josheat = $_POST['josheat'];
$frankeat = $_POST['frankeat'];

$sql = "INSERT INTO attendance (date, kiel, ryan, josh, frank, kieleat, ryaneat, josheat, frankeat)
VALUES ('$date','$kiel','$ryan','$josh','$frank','$kieleat','$ryaneat','$josheat','$frankeat')";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Wohoo!</b> Attendance recorded.</div>
		</div>
	</div>';
} else {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Uh-Oh!</b> There was a problem while taking attendance.' . $connection->error . '</div>
		</div>
	</div>';
}
}
?>
<body>
<?php include_once 'nav.php'; ?>
<div class="containter">
	<div class="col-sm-2 col-sm-offset-5">
    	<h1 class="text-center">Roll Call</h1>   
    	<form id="rollcall" action="rollcall.php" class="form-horizontal" method="post">
        	<div class="form-group">
            	<label for="date" class="col-sm-4 control-label">Date</label>
                <div class="col-sm-8">
                	<input type="date" id="date" class="form-control" name="date">
                </div>
            </div>
        	<div class="form-group">
            	<div class="col-sm-4 text-center">Name</div>
            	<div class="col-sm-4 text-center">Present?</div>
            	<div class="col-sm-4 text-center">Eat?</div>
            </div>
        	<div class="form-group">
            	<label for="kiel" class="col-sm-4 control-label">Kiel</label>
                <div class="col-sm-4">
                	<input type="hidden" name="kiel" value="0">
                	<input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="success" data-offstyle="danger" id="kiel" name="kiel" class="allhere" value="1">
                </div>
                <div class="col-sm-4">
                	<input type="hidden" name="kieleat" value="0">
                	<input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="success" data-offstyle="danger" id="kieleat" name="kieleat" class="allate" value="1">
                </div>
            </div>
            <div class="form-group">
            	<label for="ryan" class="col-sm-4 control-label">Ryan</label>
                <div class="col-sm-4">
                	<input type="hidden" name="ryan" value="0">
                	<input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="success" data-offstyle="danger" id="ryan" name="ryan" class="allhere" value="1">
                </div>
                <div class="col-sm-4">
                	<input type="hidden" name="ryaneat" value="0">
                	<input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="success" data-offstyle="danger" id="ryaneat" name="ryaneat" class="allate" value="1">
                </div>
            </div>
            <div class="form-group">
            	<label for="josh" class="col-sm-4 control-label">Josh</label>
                <div class="col-sm-4">
                	<input type="hidden" name="josh" value="0">
                	<input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="success" data-offstyle="danger" id="josh" name="josh" class="allhere" value="1">
                </div>
                <div class="col-sm-4">
                	<input type="hidden" name="josheat" value="0">
                	<input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="success" data-offstyle="danger" id="josheat" name="josheat" class="allate" value="1">
                </div>
            </div>
            <div class="form-group">
            	<label for="frank" class="col-sm-4 control-label">Frank</label>
                <div class="col-sm-4">
                	<input type="hidden" name="frank" value="0">
                	<input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="success" data-offstyle="danger" id="frank" name="frank" class="allhere" value="1">
                </div>
                <div class="col-sm-4">
                	<input type="hidden" name="frankeat" value="0">
                	<input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="success" data-offstyle="danger" id="frankeat" name="frankeat" class="allate" value="1">
                </div>
            </div>
            <div class="form-group">
            	<div class="col-sm-4 col-sm-offset-4">
	            	<button class="btn btn-success allpresent" onClick="toggleHere(); return false;" id="allhere">All Here!</button>
                    <button class="btn btn-danger hidden allpresent" onClick="toggleGone(); return false;" id="allgone">No One</button>
                </div>
                <div class="col-sm-4">
	            	<button class="btn btn-success allfood" onClick="toggleAte(); return false;" id="allate">All Ate</button>
                    <button class="btn btn-success hidden allfood" onClick="toggleEaten(); return false;" id="alleaten">No Eats</button>
                </div>
            </div>
            <div class="form-group">
            	<button type="submit" class="btn btn-primary btn-block" name="rollcall">Submit</button>
            </div>
        </form>
    </div>
</div><!--container-->
<script type="text/javascript" src="js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
	//Change all Present? column checkboxes to same with click of button
	$(".allpresent").click(function() {
		$("#allhere").toggleClass('hidden');
		$("#allgone").toggleClass('hidden');
		return false;
	});
	
	function toggleHere() {
		$('.allhere').prop('checked', true).change();	
	}
	function toggleGone() {
		$('.allhere').prop('checked', false).change();	
	}
	
	//Change all Eat? column checkboxes to same with click of button
	$(".allfood").click(function() {
		$("#allate").toggleClass('hidden');
		$("#alleaten").toggleClass('hidden');
		return false;
	});
	
	function toggleAte() {
		$('.allate').prop('checked', true).change();	
	}
	function toggleEaten() {
		$('.allate').prop('checked', false).change();	
	}
	
	//Set present input to 1 if toggled is on
	/*
	$('.allhere').change(function() {
		if ($(this).prop('checked')) {
			$(this).val(1);
		} else {
			$(this).val(0);
		}
	});
	//Set eat input to 1 if toggled is on
	$('.allate').change(function() {
		if ($(this).prop('checked')) {
			$(this).val(1);
		} else {
			$(this).val(0);
		}
	});*/
</script>
</body>
</html>