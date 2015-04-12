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

//update database with table form
if (isset($_POST['overallupdate'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];
$status = $_POST['status'];
$nextstep = $_POST['nextstep'];
$secdate = $_POST['secdate'];
$dryhopdate = $_POST['dryhopdate'];
$bottleddate = $_POST['bottleddate'];
$cap = $_POST['cap'];
$fg = $_POST['fg'];
$brewgone = $_POST['brewgone'];

$sql = "UPDATE brews SET status = '$status', nextstep = '$nextstep', secdate = '$secdate', dryhopdate = '$dryhopdate', bottleddate = '$bottleddate', cap = '$cap', fg = '$fg', brewgone = '$brewgone' WHERE brewID = '$brewID'";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo "Brew Updated";
} else {
	echo "no update" . $connection->error;
}
}

$pagename = $_GET['brew'];

$sql = "SELECT *,
CASE
WHEN nextstep = 'secondary'
THEN ((brewdate+tilsec)-curdate())
END AS dtsec,

CASE
WHEN nextstep = 'dryhop' AND status = 'seconded'
THEN ((secdate+tildryhop)-curdate())

WHEN nextstep = 'dryhop' AND status = 'brewed'
THEN ((brewdate+tildryhop)-curdate())
END AS dtdh,

CASE
WHEN nextstep= 'bottle' AND status='brewed'
THEN ((brewdate+tilbottle)-curdate())

WHEN nextstep= 'bottle' AND status='seconded'
THEN ((secdate+tilbottle)-curdate())

WHEN nextstep= 'bottle' AND status='dryhopped'
THEN ((dryhopdate+tilbottle)-curdate())
END AS dtbottle,

CASE
WHEN nextstep = 'drink' AND cap = 'keg'
THEN ((bottleddate+2)-curdate())

WHEN nextstep = 'drink' AND cap != 'keg'
THEN ((bottleddate+14)-curdate())
END AS dttest

FROM brews WHERE brewID = '%s' LIMIT 1";

$sql = sprintf($sql, mysqli_real_escape_string($connection, $pagename));

$result = $connection->query($sql);

if ($result->num_rows > 0) {	
	
    while($data = $result->fetch_assoc()) {
		
        echo '<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<h1 class="text-center">' . $data['name'] . '</h1>
					<h4 class="text-center">' . $data['type'] . ' | ' . $data['style'] . '</h4>
				</div>
			</div>
			<div class="row">';
		if ( $data['status'] != "Bottled" || $data['dttest'] >= 0) {
			echo '
				<div class="col-sm-2 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title text-center"> Days Until</br><b>';
							if ($data["nextstep"] == "secondary") {
								echo "Secondary";
							}
							if ($data["nextstep"] == "dryhop") {
								echo "Dry Hop";
							}
							if ($data["nextstep"] == "bottle") {
								echo "Bottle";
							}
							if ($data["status"] == "Bottled") {
								echo "Test";
							}
						echo'</b></h3>
						</div>
						<div class="panel-body">
							<h2 class="text-center">';
							if ($data["nextstep"] == "secondary") {
								echo $data['dtsec'];
							}
							if ($data["nextstep"] == "dryhop") {
								echo $data['dtdh'];
							}
							if ($data["nextstep"] == "bottle") {
								echo $data['dtbottle'];
							}
							if ($data["status"] == "Bottled") {
								echo $data['dttest'];
							}
							echo'</h2>
						</div>
					</div>
				</div><div class="col-sm-6">';
		} else {
			echo '<div class="col-sm-6 col-sm-offset-3">'; 
		}
	echo '<div class="panel panel-default">
		<table class="table table-bordered">
			<form id="overallUpdate" method="post" action="details.php">
				<input type="hidden" name="brewID" value="' . $data['brewID'] . '">
				<input type="hidden" name="status" value="">
				<input type="hidden" name="nextstep" value="">';
			// output data of each row
			echo '<tr>
				<td>Status</td>
				<td class="text-center">' . $data["status"] . '</td>
			</tr>
			<tr>
				<td>Brew Date</td>
				<td class="text-center">' . date("m/d/Y", strtotime($data["brewdate"])) . '</td>
			</tr>
			<tr>
				<td>Wait To Secondary</td>
				<td class="text-center">' . $data['tilsec'] . '</td>
			</tr>
			<tr>
				<td>Wait To Dry Hop</td>
				<td class="text-center">' . $data['tildryhop'] . '</td>
			</tr>
			<tr>
				<td>Wait to Bottle</td>
				<td class="text-center">' . $data['tilbottle'] . '</td>
			</tr>
			<tr>
				<td>Original Gravity</td>
				<td class="text-center">' . $data['og'] . '</td>
			</tr>';
			if ($data['nextstep'] == "secondary" && $data['dtsec'] < 5) {
				echo '<tr class="danger">';
			} else {
				echo '<tr>';
			}
			echo '<td>Secondary Date</td>
				<td class="text-center">';
				if ($data['nextstep'] != "secondary") {
					echo date("m/d/Y", strtotime($data["secdate"]));
				} else {
					echo '<input type="date" class="form-control" name="secdate" id="secdate">';
				}
				echo '</td>
			</tr>';
			if (($data["nextstep"] == "dryhop") && $data["dtdh"] < 5) {
				echo '<tr class="danger">';
			} else {
				echo '<tr>';
			}
			echo '<tr>
				<td>Dry Hop Date</td>
				<td class="text-center">';
				if ($data["tildryhop"] > 0 && $data["nextstep"] == "dryhop") {
					echo '<input type="date" class="form-control" name="dryhopdate" id="dryhopdate">';
				} else if ($data["status"] == "Dryhopped") {
						echo date("m/d/Y", strtotime($data["dryhopdate"]));
				} else {
					echo "N/A";
				}
				echo '</td>
			</tr>';
			if ( ($data["nextstep"] == "bottle") && $data["tilbottle"] < 5 ) {
				echo '<tr class="danger">';
			} else {
				echo '<tr>';
			}
			echo '<td>Bottled Date</td>
				<td class="text-center">';
				if ( $data["status"] != "Bottled") {
					echo '<input type="date" class="form-control" name="bottleddate" id="bottleddate">';
				} else {
					echo date("m/d/Y", strtotime($data["bottleddate"]));
				}
				echo '</td>
			</tr>
			<tr>
				<td>Cap Marking</td>
				<td class="text-center">';
				if ( $data["status"] != "Bottled") {
					echo '<input type="text" class="form-control" name="cap" id="cap">';
				} else {
					echo $data["cap"];
				}
				echo '</td>
			</tr>
			<tr>
				<td>Final Gravity</td>
				<td class="text-center">';
				if ( $data["status"] != "Bottled") {
					echo '<input type="number" class="form-control" name="fg" id="fg">';
				} else {
					echo $data['fg'];
				}
				echo '</td>
			</tr>
			<tr>
				<td>Last Bottle Gone</td>
				<td class="text-center">
					<input type="date" class="form-control" name="brewgone" id="brewgone" value="' . $data['brewgone'] . '">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-block btn-primary" name="overallupdate">Update</button>
				</td>
			</tr>';
    echo '</form></table></div></div></div>';
    }
} else {
	echo "NO SUCH BREW EXISTS 404 ERROR HERE";
}
$connection->close();
?>
</div>
</body>
</html>