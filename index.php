<!doctype html>
<html>
<?php include_once 'head.php'; ?>
<body>
<?php
include_once 'nav.php';
?>
<div class="container">
<div class="col-sm-6 col-sm-offset-3">
<?php
//include Brews Database
include_once 'brewsDB_connection.php';

$sql = "SELECT * FROM brews WHERE status = 'bottled' ORDER BY bottleddate";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='panel panel-default'><table class='table table-hover'><tr class='bg-primary'><th>Name</th><th>Cap Marking</th><th>Beer Type</th><th>Beer Style</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
		echo "<td>" . $row['name'] . "</td>";
		echo "<td class='text-center'>" . $row['cap'] . "</td>";
		echo "<td>" . $row['type'] . "</td>";
		echo "<td>" . $row['style'] . "</td>";
		echo "</tr>";
    }
    echo "</table></div>";
} else {
	echo "NO BEERS TO DRINK";
}
$connection->close();
?>
</div>
</div>
</body>
</html>
