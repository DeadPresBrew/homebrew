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
			<form>';
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
					echo '<input type="date" class="form-control" id="secdate">';
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
					echo '<input type="date" class="form-control" id="dryhopdate">';
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
					echo '<input type="date" class="form-control" id="bottleddate">';
				} else {
					echo date("m/d/Y", strtotime($data["bottleddate"]));
				}
				echo '</td>
			</tr>
			<tr>
				<td>Final Gravity</td>
				<td class="text-center">';
				if ( $data["status"] != "Bottled") {
					echo '<input type="number" class="form-control" id="fg">';
				} else {
					echo $data['fg'];
				}
				echo '</td>
			</tr>
			<tr>
				<td>Last Bottle Gone</td>
				<td class="text-center">
					<input type="date" class="form-control" id="brewgone" value="' . $data['brewgone'] . '">
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