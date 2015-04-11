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

$sql = "UPDATE brews SET status = 'seconded' , nextstep = '$nextstep' , secdate = curdate() WHERE brewID = '$brewID'";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo "Date Updated";
} else {
	echo "no update" . $connection->error;
}
}

$secinfo = "SELECT *, ((brewdate+tilsec)-curdate()) as daystosec FROM brews WHERE nextstep = 'secondary'";
$result = $connection->query($secinfo);

if ($result->num_rows > 0) {
	echo "<div class='row'>
		<div class='col-sm-6'>
		</div>
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Ready to Secondary</div>
				<table class='table table-bordered'>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td><a href='details?brew=" . $row['brewID'] . "'>" . $row['name'] . "</a></td>";
					echo "<td>" . $row['daystosec'] . "</td>";
					echo "<td><button class='btn btn-primary pull-right' data-toggle='modal' data-target='#secUpdateModal" . $row['brewID']. "'>Seconded Today</button></td></tr>";
					include 'SecUpdateModal.php';
                }
                echo "</table></div></div></div>";
} else {}
?>
<?php
//update sec date form
if (isset($_POST['updateDHDate'])) {

$connection->select_db('brews');

//input variables
$brewID = $_POST['brewID'];

$sql = "UPDATE brews SET status = 'dryhopped' , nextstep = 'bottle' , dryhopdate = curdate() WHERE brewID = '$brewID'";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo "Date Updated";
} else {
	echo "no update" . $connection->error;
}
}

$dhinfo = "SELECT *,
CASE
WHEN status = 'seconded'
THEN ((secdate+tildryhop)-curdate())

WHEN status = 'brewed'
THEN ((brewdate+tildryhop)-curdate())
END AS daystodh

FROM brews WHERE nextstep = 'dryhop'";

$result = $connection->query($dhinfo);

if ($result->num_rows > 0) {
	echo "<div class='row'>
		<div class='col-sm-6'>
		</div>
		<div class='col-sm-6'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Ready to Dry Hop</div>
				<table class='table table-bordered'>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td><a href='details?brew=" . $row['brewID'] . "'>" . $row['name'] . "</a></td>";
					echo "<td>" . $row['daystodh'] . "</td>";
					echo "<td><button class='btn btn-primary pull-right' data-toggle='modal' data-target='#dhUpdateModal" . $row['brewID']. "'>Dryhopped Today</button></td></tr>";
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

$sql = "UPDATE brews SET status = 'bottled' , nextstep = 'drink' , bottleddate = '$bottleddate', cap = '$cap', fg = '$fg' WHERE brewID = '$brewID'";

$result = mysqli_query($connection, $sql);

if ($result === TRUE) {
	echo "Date Updated";
} else {
	echo "no update" . $connection->error;
}
}

$botinfo = "SELECT *,
CASE
WHEN status='brewed'
THEN ((brewdate+tilbottle)-curdate())

WHEN status='seconded'
THEN ((secdate+tilbottle)-curdate())

WHEN status='dryhopped'
THEN ((dryhopdate+tilbottle)-curdate())
END AS daystobottle

FROM brews WHERE nextstep = 'bottle'";

$result = $connection->query($botinfo);

if ($result->num_rows > 0) {
	echo "<div class='row'>
		<div class='col-sm-6'>
		</div>
		<div class='col-sm-6'>
        	<div class='panel panel-default'>
            	<div class='panel-heading'>Ready to Bottle</div>
					<table class='table table-bordered'>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo "<tr><td><a href='details?brew=" . $row['brewID'] . "'>" . $row['name'] . "</a></td>";
						echo "<td>" . $row['daystobottle'] . "</td>";
						echo "<td><button class='btn btn-primary pull-right' data-toggle='modal' data-target='#botUpdateModal" . $row['brewID']. "'>Add Bottle Info</button></td></tr>";
						include "BotUpdateModal.php";
					}
					echo "</table></div></div></div></div>";
} else {}    
?>
</div>
</body>
</html>