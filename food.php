<!doctype html>
<html>
<?php include_once 'head.php'; ?>
<body>
<?php
include_once 'nav.php';
?>
<div class="container">
<div class="col-sm-6 col-sm-offset-3">
<h1 class="text-center">Who Ate Food?</h1>
<?php
//include Brews Database
include_once 'brewsDB_connection.php';

$sql = "SELECT * FROM attendance WHERE (kieleat + ryaneat + josheat + frankeat) != 0";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='panel panel-default'><table id='food' class='table table-hover'><thead><tr class='bg-primary'><th class=' text-center'>Date</th><th class=' text-center'>Kiel</th><th class=' text-center'>Ryan</th><th class=' text-center'>Josh</th><th class=' text-center'>Frank</th></tr></thead><tbody class=' text-center'>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
		echo "<td>" . date("m/d/Y", strtotime($row["date"])) . "</td>";
		echo "<td class='ate'>" . $row['kieleat'] . "</td>";
		echo "<td class='ate'>" . $row['ryaneat'] . "</td>";
		echo "<td class='ate'>" . $row['josheat'] . "</td>";
		echo "<td class='ate'>" . $row['frankeat'] . "</td>";
		echo "</tr>";
    }
    echo "</tbody></table></div>";
} else {
	echo "NOBODY ATE!";
}
$connection->close();
?>
</div>
</div>
<script type="text/javascript">
	$(document).ready( function() {
		var FindOne = "1";
		var ReplaceOne = "<span class='glyphicon glyphicon-ok text-success'></span>";
		var FindZero = "0";
		var ReplaceZero = "-";
		$("#food td.ate:contains('" + FindOne + "')").html(ReplaceOne);
		$("#food td.ate:contains('" + FindZero + "')").html(ReplaceZero);
	});
</script>
</body>
</html>