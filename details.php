<!doctype html>
<html>
<?php include_once 'head.php'; ?>
<body>
<?php
include_once 'nav.php';
?>
<div class="container">
<?php
//include Brews Database
include_once 'brewsDB_connection.php';

//update sec date
if (isset($_POST['secBrew'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];
$nextstep = $_POST['nextstep'];
$secdate = $_POST['secdate'];

$sql = "UPDATE brews SET status = 'seconded', nextstep = '$nextstep', secdate = '$secdate' WHERE brewID = '$brewID'";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Wohoo!</b> The secondary date has been updated.</div>
		</div>
	</div>';
} else {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Uh-Oh!</b> There was a problem while updating the secondary date.' . $connection->error . '</div>
		</div>
	</div>';
}
}

//update dryhop date
if (isset($_POST['dhBrew'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];
$dryhopdate = $_POST['dryhopdate'];

$sql = "UPDATE brews SET status = 'dryhopped', nextstep = 'bottle', dryhopdate = '$dryhopdate' WHERE brewID = '$brewID'";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Wohoo!</b> The dry hop date has been updated.</div>
		</div>
	</div>';
} else {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Uh-Oh!</b> There was a problem while updating the dry hop date.' . $connection->error . '</div>
		</div>
	</div>';
}
}

//update bottled date
if (isset($_POST['bottleBrew'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];
$bottleddate = $_POST['bottleddate'];
$cap = $_POST['cap'];
$fg = $_POST['fg'];

$sql = "UPDATE brews SET status = 'bottled', nextstep = 'drink', bottleddate = '$bottleddate', cap = '$cap', fg = '$fg', abv = ((og-fg)*131.25) WHERE brewID = '$brewID'";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Wohoo!</b> The bottling information has been updated.</div>
		</div>
	</div>';
} else {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Uh-Oh!</b> There was a problem while updating the bottling information.' . $connection->error . '</div>
		</div>
	</div>';
}
}

//update brewgone date
if (isset($_POST['goneBrew'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];
$brewgone = $_POST['brewgone'];

$sql = "UPDATE brews SET status = 'gone', nextstep = 'mourn', brewgone = '$brewgone' WHERE brewID = '$brewID'";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Wohoo!</b> The brew gone date has been updated.</div>
		</div>
	</div>';
} else {
	echo '<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Uh-Oh!</b> There was a problem while updating the brew gone date.' . $connection->error . '</div>
		</div>
	</div>';
}
}

$pagename = $_GET['brew'];

$sql = "SELECT *,
CASE
WHEN nextstep = 'secondary'
THEN DATEDIFF(DATE_ADD(brewdate, INTERVAL tilsec DAY), curdate())
END AS dtsec,

CASE
WHEN nextstep = 'dryhop' AND status = 'seconded'
THEN DATEDIFF(DATE_ADD(secdate, INTERVAL tildryhop DAY), curdate())

WHEN nextstep = 'dryhop' AND status = 'brewed'
THEN DATEDIFF(DATE_ADD(brewdate, INTERVAL tildryhop DAY), curdate())
END AS dtdh,

CASE
WHEN nextstep= 'bottle' AND status='brewed'
THEN DATEDIFF(DATE_ADD(brewdate, INTERVAL tilbottle DAY), curdate())

WHEN nextstep= 'bottle' AND status='seconded'
THEN DATEDIFF(DATE_ADD(secdate, INTERVAL tilbottle DAY), curdate())

WHEN nextstep= 'bottle' AND status='dryhopped'
THEN DATEDIFF(DATE_ADD(dryhopdate, INTERVAL tilbottle DAY), curdate())
END AS dtbottle,

CASE
WHEN nextstep = 'drink' AND cap = 'keg'
THEN DATEDIFF(DATE_ADD(bottleddate, INTERVAL 2 DAY), curdate())

WHEN nextstep = 'drink' AND cap != 'keg'
THEN DATEDIFF(DATE_ADD(bottleddate, INTERVAL 14 DAY), curdate())
END AS dttest,

CASE
WHEN nextstep = 'mourn' AND cap = 'keg'
THEN DATEDIFF(brewgone, DATE_ADD(bottleddate, INTERVAL 2 DAY))

WHEN nextstep = 'mourn' AND cap != 'keg'
THEN DATEDIFF(brewgone, DATE_ADD(bottleddate, INTERVAL 14 DAY))
END AS shelflife

FROM brews WHERE brewID = '%s' LIMIT 1";

$sql = sprintf($sql, mysqli_real_escape_string($connection, $pagename));

$result = $connection->query($sql);

if ($result->num_rows > 0) {	
	
    while($row = $result->fetch_assoc()) {
		
        echo '<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<h1 class="text-center">' . $row['name'] . '</h1>
					<h4 class="text-center">' . $row['type'] . ' | ' . $row['style'] . '</h4>
				</div>
			</div>
			<div class="row">';
		if ( $row['status'] != "bottled" ) {
			echo '<div class="col-sm-2 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title text-center">';
							if ( $row['nextstep'] != "mourn" ) {
								echo 'Days Until</br><b>';
							} else {
								echo '<b>Shelf Life <small>(days)</small>';
							}
							if ($row["nextstep"] == "secondary") {
								echo "Secondary";
							}
							if ($row["nextstep"] == "dryhop") {
								echo "Dry Hop";
							}
							if ($row["nextstep"] == "bottle") {
								echo "Bottle";
							}
							if ($row["status"] == "Bottled") {
								echo "Test";
							}
						echo'</b></h3>
						</div>
						<div class="panel-body">
							<h2 class="text-center">';
							if ($row["nextstep"] == "secondary") {
								echo $row['dtsec'];
							}
							if ($row["nextstep"] == "dryhop") {
								echo $row['dtdh'];
							}
							if ($row["nextstep"] == "bottle") {
								echo $row['dtbottle'];
							}
							if ($row["status"] == "Bottled") {
								echo $row['dttest'];
							}
							if ($row["status"] == "gone") {
								echo $row['shelflife'];
							}
							echo'</h2>
						</div>
					</div>
				</div><div class="col-sm-6">';
		} else {
			echo '<div class="col-sm-6 col-sm-offset-3">'; 
		}
	echo '<div class="panel panel-default">';
	if ( $row["nextstep"] != "mourn" ) {
	echo '<form action="details.php?brew=' . $row["brewID"] . '" id="updateBrew" method="post">
		<input type="hidden" id="brewID" name="brewID" value="' . $row["brewID"] . '">';
	}
	echo '<table class="table table-bordered">';
			// output data of each row
			echo '<tr>
				<td>Status</td>
				<td class="text-center">' . $row["status"] . '</td>
			</tr>
			<tr>
				<td>Next Step</td>
				<td class="text-center nextstep">' . $row["nextstep"] . '</td>
			</tr>
			<tr>
				<td>Brew Date</td>
				<td class="text-center">' . date("m/d/Y", strtotime($row["brewdate"])) . '</td>
			</tr>
			<tr>
				<td>Wait To Secondary</td>
				<td id="tilsec" class="text-center">' . $row['tilsec'] . '</td>
			</tr>
			<tr>
				<td>Wait To Dry Hop</td>
				<td id="tildryhop" class="text-center">' . $row['tildryhop'] . '</td>
			</tr>
			<tr>
				<td>Wait to Bottle</td>
				<td class="text-center">' . $row['tilbottle'] . '</td>
			</tr>
			<tr>
				<td>Original Gravity</td>
				<td class="text-center">' . $row['og'] . '</td>
			</tr>';
			if ($row['nextstep'] == "secondary" && $row['dtsec'] < 5) {
				echo '<tr class="danger">';
			} else {
				echo '<tr>';
			}
			echo '<td>Secondary Date</td>
				<td class="text-center">';
				if ($row["tilsec"] > 0 && $row["secdate"] == NULL) {
					echo '<input type="hidden" id="status" name="status" value="Seconded">
					<input type="hidden" id="nextstep" name="nextstep"';
					if ($row["tildryhop"] > 0) {echo 'value="dryhop"';} else { echo 'value="bottle"';}
					echo '>';
					echo '<input type="date" id="secdate" name="secdate" class="form-control" disabled>';
				} else if ($row["tilsec"] > 0 && $row["secdate"] != NULL) {
					echo date("m/d/Y", strtotime($row["secdate"]));
				} else {
					echo "N/A";
				}
				echo '</td>
			</tr>';
			if (($row["nextstep"] == "dryhop") && $row["dtdh"] < 5) {
				echo '<tr class="danger">';
			} else {
				echo '<tr>';
			}
			echo '<tr>
				<td>Dry Hop Date</td>
				<td class="text-center">';
				if ($row["tildryhop"] > 0 && $row["dryhopdate"] == NULL) {
					echo '<input type="date" id="dryhopdate" name="dryhopdate" class="form-control" disabled>';
				} else if ($row["tildryhop"] > 0 && $row["dryhopdate"] != NULL) {
						echo date("m/d/Y", strtotime($row["dryhopdate"]));
				} else {
					echo "N/A";
				}
				echo '</td>
			</tr>';
			if ( ($row["nextstep"] == "bottle") && $row["tilbottle"] < 5 ) {
				echo '<tr class="danger">';
			} else {
				echo '<tr>';
			}
			echo '<td>Bottled Date</td>';
			if ( $row["bottleddate"] == NULL) {
				echo '<td class="text-center">
					<input type="date" id="bottleddate" name="bottleddate" class="form-control" disabled>
					</td>
					</tr>
					<tr>
					<td>Cap Marking</td>
					<td><input type="text" id="cap" name="cap" class="form-control" disabled></td>
					</tr>
					<tr>
					<td>Final Gravity</td>
					<td><input type="text" step="0.001" id="fg" name="fg" class="form-control" disabled></td>
					</tr>';
			} else {
				echo '<td class="text-center">' . date("m/d/Y", strtotime($row["bottleddate"])) . '</td></tr>';
				echo '<tr>
					<td>Cap Marking</td>
					<td class="text-center">' . $row['cap'] . '</td>
				</tr>
				<tr>
					<td>Final Gravity</td>
					<td class="text-center">' . $row['fg'] . '</td>
				</tr>
				<tr>
					<td>Alcohol By Volume</td>
					<td class="text-center">' . $row['abv'] . '</td>
				</tr>';
			}
			echo '<tr>
					<td>Last Bottle Gone</td>';
					if ( $row["brewgone"] == NULL ) {
						echo '<td class="text-center">
						<input type="date" id="brewgone" name="brewgone" class="form-control" disabled>';
					} else {
						echo '<td class="text-center">' . date("m/d/Y", strtotime($row["brewgone"]));
					}
					echo '</td></tr>';
		echo '</table>';
		if ( $row["nextstep"] != "mourn" ) {
			echo '<button id="updateBrewbtn" type="submit" class="btn btn-primary btn-block">Update Brew</button></form></div></div></div>';
		}
    }
} else {
	echo "NO SUCH BREW EXISTS 404 ERROR HERE";
}
$connection->close();
?>

<script type="text/javascript">
	$(document).ready( function() {
		//Remove disabled proptery from button if nextstep is true
		if ($(".nextstep").html() == "secondary") {
			$("#secdate").prop("disabled", false);
			$("#updateBrew").attr("id","secBrew");
			$("#updateBrewbtn").attr("name","secBrew");
		}
		if ($(".nextstep").html() == "dryhop") {
			$("#dryhopdate").prop("disabled", false);
			$("#nextstep").val("bottle");
			$("#updateBrew").attr("id","dhBrew");
			$("#updateBrewbtn").attr("name","dhBrew");
		}
		if ($(".nextstep").html() == "bottle") {
			$("#bottleddate").prop("disabled", false);
			$('#cap').prop("disabled", false);
			$('#fg').prop("disabled", false);
			$("#nextstep").val("drink");
			$("#updateBrew").attr("id","bottleBrew");
			$("#updateBrewbtn").attr("name","bottleBrew");
		}
		if ($(".nextstep").html() == "drink") {
			$("#brewgone").prop("disabled", false);
			$("#nextstep").val("mourn");
			$("#updateBrew").attr("id","goneBrew");
			$("#updateBrewbtn").attr("name","goneBrew");
		}
	});
</script>
</div>
</body>
</html>