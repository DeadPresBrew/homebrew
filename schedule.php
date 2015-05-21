<!doctype html>
<html>
<?php include_once 'head.php'; ?>
<body>
<?php
include_once 'nav.php';

//include Brews Database
include_once 'brewsDB_connection.php';
?>
<div class="container">

<?php
//update sec date form
if (isset($_POST['updateSecDate'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];
$nextstep = $_POST['nextstep'];
$secdate = $_POST['secdate'];

$sql = "UPDATE brews SET status = 'seconded' , nextstep = '$nextstep' , secdate = '$secdate' WHERE brewID = '$brewID'";

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
			<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<b>Uh-Oh!</b> There was a problem while updating the secondary date.' . $connection->error . '</div>
		</div>
	</div>';
}
}

$secinfo = "SELECT *,
CASE
WHEN status = 'brewed'
THEN DATEDIFF(DATE_ADD(brewdate, INTERVAL tilsec DAY), curdate())
END AS daystosec

FROM brews WHERE nextstep = 'secondary'";

$result = $connection->query($secinfo);

if ($result->num_rows > 0) {
	echo "<div class='row'>
		<div class='col-sm-6 hidden-xs'>
		<img class='img-responsive center-block' src='media/brewstage-secondary.png'>
		</div>
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Ready to Secondary</div>
				<table class='table table-bordered'>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td><a href='details.php?brew=" . $row['brewID'] . "'>" . $row['name'] . "</a></td>";
					echo "<td class='text-center'>" . $row['daystosec'] . "</td>";
					echo "<td><button class='btn btn-primary btn-block' data-toggle='modal' data-target='#secUpdateModal" . $row['brewID']. "'>Seconded Today</button></td></tr>";
					include 'SecUpdateModal.php';
                }
                echo "</table></div></div></div>";
} else {}
?>
<?php
//update dryhop date form
if (isset($_POST['updateDHDate'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];

$sql = "UPDATE brews SET status = 'dryhopped' , nextstep = 'bottle' , dryhopdate = curdate() WHERE brewID = '$brewID'";

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

$dhinfo = "SELECT *,
CASE
WHEN status = 'seconded'
THEN DATEDIFF(DATE_ADD(secdate, INTERVAL tildryhop DAY), curdate())

WHEN status = 'brewed'
THEN DATEDIFF(DATE_ADD(brewdate, INTERVAL tildryhop DAY), curdate())
END AS daystodh

FROM brews WHERE nextstep = 'dryhop'";

$result = $connection->query($dhinfo);

if ($result->num_rows > 0) {
	echo "<hr>
	<div class='row'>
		<div class='col-sm-6 hidden-xs'>
		<img class='img-responsive center-block' src='media/brewstage-dryhop.png'>
		</div>
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Ready to Dry Hop</div>
				<table class='table table-bordered'>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td><a href='details.php?brew=" . $row['brewID'] . "'>" . $row['name'] . "</a></td>";
					echo "<td class='text-center'>" . $row['daystodh'] . "</td>";
					echo "<td><button class='btn btn-primary btn-block' data-toggle='modal' data-target='#dhUpdateModal" . $row['brewID']. "'>Dryhopped Today</button></td></tr>";
					include 'DhUpdateModal.php';
                }
                echo "</table></div></div></div>";
} else {}
?>


<?php
//update bottle date form
if (isset($_POST['updateBotInfo'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];
$bottleddate = $_POST['bottleddate'];
$cap = $_POST['cap'];
$fg = $_POST['fg'];

$sql = "UPDATE brews SET status = 'bottled' , nextstep = 'drink' , bottleddate = '$bottleddate', cap = '$cap', fg = '$fg', actualABV = ((actualOG-fg)*131.25), targetABV = ((idealOG-fg)*131.25) WHERE brewID = '$brewID'";

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

$botinfo = "SELECT *,
CASE
WHEN status='brewed'
THEN DATEDIFF(DATE_ADD(brewdate, INTERVAL tilbottle DAY), curdate())

WHEN status='seconded'
THEN DATEDIFF(DATE_ADD(secdate, INTERVAL tilbottle DAY), curdate())

WHEN status='dryhopped'
THEN DATEDIFF(DATE_ADD(dryhopdate, INTERVAL tilbottle DAY), curdate())
END AS daystobottle

FROM brews WHERE nextstep = 'bottle'";

$result = $connection->query($botinfo);

if ($result->num_rows > 0) {
	echo "<hr>
	<div class='row'>
		<div class='col-sm-6 hidden-xs'>
		<img class='img-responsive center-block' src='media/brewstage-bottle.png'>
		</div>
		<div class='col-sm-6'>
        	<div class='panel panel-default'>
            	<div class='panel-heading'>Ready to Bottle</div>
					<table class='table table-bordered'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<tr><td><a href='details.php?brew=" . $row['brewID'] . "'>" . $row['name'] . "</a></td>";
						echo "<td class='text-center'>" . $row['daystobottle'] . "</td>";
						echo "<td><button class='btn btn-primary btn-block' data-toggle='modal' data-target='#botUpdateModal" . $row['brewID']. "'>Add Bottle Info</button></td></tr>";
						include "BotUpdateModal.php";
					}
					echo "</table></div></div></div>";
} else {}
?>

<?php
//update brew gone date form
if (isset($_POST['brewGoneDate'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];

$sql = "UPDATE brews SET status = 'gone' , nextstep = 'mourn' , brewgone = curdate() WHERE brewID = '$brewID'";

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

$goneinfo = "SELECT *,
CASE
WHEN nextstep = 'drink' AND cap = 'keg'
THEN DATEDIFF(DATE_ADD(bottleddate, INTERVAL 2 DAY), curdate())

WHEN nextstep = 'drink' AND cap != 'keg'
THEN DATEDIFF(DATE_ADD(bottleddate, INTERVAL 14 DAY), curdate())
END AS dttest

FROM brews WHERE nextstep = 'drink'";

$result = $connection->query($goneinfo);

if ($result->num_rows > 0) {
	echo "<hr>
	<div class='row'>
		<div class='col-sm-6 hidden-xs'>
		<img class='img-responsive center-block' src='media/brewstage-drink.png'>
		</div>
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Ready to Drink</div>
				<table class='table table-bordered'>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td><a href='details.php?brew=" . $row['brewID'] . "'>" . $row['name'] . "</a></td>";
					echo "<td class='text-center'>";
					if ( $row['dttest'] == 0 ) {
						echo "test";
					} else if ( $row['dttest'] < 0 ) {
						echo "drink";
					} else {
						echo $row['dttest'];
					}
					echo "</td>";
					echo "<td><button class='btn btn-primary btn-block' data-toggle='modal' data-target='#brewDoneModal" . $row['brewID']. "'>Gone Today</button></td></tr>";
					include 'brewDoneModal.php';
                }
                echo "</table></div></div></div>";
} else {}
?>
</div>
</div>
</body>
</html>