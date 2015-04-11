<!doctype html>
<html>
<?php include_once 'head.php'; ?>
<body>
<?php
include_once 'nav.php';
?>
<div class="container">
<div class="col-sm-4 col-sm-offset-8">
<?php
//include Brews Database
include_once 'brewsDB_connection.php';

$sql = "SELECT name, cap FROM brews WHERE status = 'bottled' AND brewgone = '0000-00-00'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='panel panel-default'><table class='table table-bordered'><tr><th>Name</th><th>Cap Marking</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row['name']."</td><td>".$row['cap'] . "</td></tr>";
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
