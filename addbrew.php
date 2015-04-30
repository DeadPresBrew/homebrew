<!doctype html>
<?php include_once 'head.php'; ?>
<body>
<?php include_once ('nav.php'); ?>

<?php
include_once ('brewsDB_connection.php');

if (isset($_POST['addbrew'])) {

$connection->select_db('brews');

//input variables
$name = $_POST['name'];
$status = $_POST['status'];
$nextstep = $_POST['nextstep'];
$type = $_POST['type'];
$style = $_POST['style'];
$brewdate = $_POST['brewdate'];
$tilsec = $_POST['tilsec'];
$tildryhop = $_POST['tildryhop'];
$tilbottle = $_POST['tilbottle'];
$og = $_POST['og'];

$sql = "INSERT INTO brews (name, status, nextstep, type, style, brewdate, tilsec, tildryhop, tilbottle, og)
VALUES ('$name','$status','$nextstep','$type','$style','$brewdate','$tilsec','$tildryhop','$tilbottle','$og')";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Wohoo!</b> The brew was added.</div>
		</div>
	</div>';
} else {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Uh-Oh!</b> There was a problem adding the brew.' . $connection->error . '</div>
		</div>
	</div>';
}
}
?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h1 class="text-center">Add a Brew</h1>
                <form id="addbrew" class="form-horizontal" method="post" action="addbrew.php" >
                    <div class="form-group">
                        <label for="brewname" class="col-xs-3 control-label">Name</label>
                        <div class="col-xs-8">
                        	<input type="text" name="name" class="form-control  required" id="brewname" placeholder="Brew Name">
                        </div>
                    </div>
                    
                    <input type="hidden" id="status" name='status' value="Brewed">
                    
                    <input type="hidden" id="nextstep" name='nextstep' value="secondary">
                    
                    <div class="form-group">
                        <label for="type" class="col-xs-3 control-label">Type</label>
                        <div class="col-xs-3">
                        	<select type="text" class="form-control required" id="type" name="type">
                            	<option></option>
                                <option>Ale</option>
                                <option>Lager</option>
                                <option>Malt</option>
                                <option>Porter</option>
                                <option>Stout</option>
                        	</select>
                        </div>

                        <label for="style" class="col-xs-2 control-label">Style</label>
                        <div class="col-xs-3">
                        	<select type="text" class="form-control required" id="style" name="style">
                            	<option></option>
                                <option>Amber</option>
                                <option>Bitter</option>
                                <option>Blonde</option>
                                <option>Brown</option>
                                <option>Cream</option>
                                <option>Dark</option>
                                <option>Fruit</option>
                                <option>Golden</option>
                                <option>Honey</option>
                                <option>IPA</option>
                                <option>Pale</option>
                                <option>Pilsner</option>
                                <option>Red</option>
                                <option>Rye</option>
                                <option>Wheat</option>
                        	</select>
                        </div>
                    </div> 
                    <div class="form-group">   
                        <label for="brewdate" class="col-xs-3 control-label">Brew Date</label>
                        <div class="col-xs-8">
                        	<input type="date" class="form-control  required" id="brewdate" name="brewdate">
                        </div>
                    </div>
                    <div class="form-group">
                    	<label for="qsec" class="col-xs-3 control-label">Secondary?</label>
                        <div class="col-xs-2">
                            <input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="primary" data-offstyle="default" id="qsec" class="setns" checked>
                        </div>

                        <label for="tilsec" class="col-xs-3 control-label">Til Secondary</label>
                        <div class="col-xs-3">
                        	<input type="number" class="form-control  required" id="tilsec" name="tilsec">
                        </div>
                    </div>
                    <div class="form-group">
                    	<label for="qdh" class="col-xs-3 control-label">Dry Hop?</label>
                        <div class="col-xs-2">
                            <input type="checkbox" data-toggle="toggle" data-on="yes" data-off="no" data-onstyle="primary" data-offstyle="default" id="qdh" class="setns">
                        </div>
                            
                        <label for="tildryhop" class="col-xs-3 control-label">Til Dryhop</label>
                        <div class="col-xs-3">
                        	<input type="number" class="form-control required" id="tildryhop" name="tildryhop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tilbottle" class="col-xs-3 control-label">Til Bottle</label>
                        <div class="col-xs-3">
                        	<input type="number" class="form-control  required" id="tilbottle" name="tilbottle">
                        </div>

                        <label for="og" class="col-xs-2 control-label">O.G.</label>
                        <div class="col-xs-3">
                        	<input type="number" class="form-control" id="og" name="og" placeholder="1.050">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-1 col-xs-10">
                            <button type="submit" name="addbrew" class="btn btn-block btn-lg btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
	
	//Set value of #nextstep according to checked status of #qsec and #qdh
	$(".setns").change( function () {
		if( $('#qsec').is(":checked") && $('#qdh').not(":checked") ) {
			$('#nextstep').val("secondary");	
		} else if( $('#qsec').not(":checked") && $('#qdh').is(":checked") ) {
			$('#nextstep').val("dryhop");	
		} else if( $('#qsec').not(":checked") && $('#qdh').not(":checked") ) {
			$('#nextstep').val("bottle");	
		}
	});
	
	//Check to see if secondary is selected - if yes remove disabled state from #tilsec
	var secondary = function () {
		if ($('#qsec').is(":checked")) {
			$('#tilsec').prop('readonly', false);
			$('#tilsec').val("");
		} else {
			$('#tilsec').prop('readonly', true);
			$('#tilsec').val(-1);
		}

	};
	$(secondary);
	$("#qsec").change(secondary);

	//Check to see if dryhop is selected - if yes remove disabled state from #tildryhop
	var dryhop = function () {
		if ($('#qdh').is(":checked")) {
			$('#tildryhop').prop('readonly', false);
			$('#tildryhop').val("");
		} else {
			$('#tildryhop').prop('readonly', true);
			$('#tildryhop').val(-1);
		}

	};
	$(dryhop);
	$("#qdh").change(dryhop);
	
	//Vadidate addbrew form
	$("#addbrew").submit(function(){
		var isFormValid = true;
		
		$(".required").each(function(){
			if ($.trim($(this).val()).length == 0){
				$(this).addClass("forgot");
				isFormValid = false;
			}
		});
		return isFormValid;
	});
</script>
</body>
</html>