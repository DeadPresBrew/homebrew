<!doctype html>
<html>
<?php include_once 'head.php'; ?>
<body>
<?php
	include_once 'nav.php';
	include_once 'brewsDB_connection.php';
	
	
	$sql = "SELECT *,
	
	(kiel + ryan + josh + frank) AS present,
	
	DATE_FORMAT(DATE(date), '%m/%d')
	AS bpdate
	
	FROM attendance
	ORDER BY date";
	
	$data = $connection->query($sql);
?>
<script type="text/javascript">
	var present=[<?php
	mysqli_data_seek($data, 0);
	while($info=mysqli_fetch_array($data)) {
		echo $info['present'].",";
	}
	?>];
	var bp =[<?php
	mysqli_data_seek($data, 0);
	while($info=mysqli_fetch_array($data)) {
		echo '"';
		if ($info['kiel'] > 0) {
			echo "Kiel ";
		}
		if ($info['ryan'] > 0) {
			echo "Ryan ";	
		}
		if ($info['josh'] > 0) {
			echo "Josh ";
		}
		if ($info['frank'] > 0) {
			echo "Frank";	
		}
		echo '",';
	}
	?>];
	var dates=[<?php
	mysqli_data_seek($data, 0);
	while($info=mysqli_fetch_array($data))
		echo '"'.$info['bpdate'].'",';
	?>];
	<?php
		$sql = "SELECT COUNT(brews.brewdate) AS brewed
		FROM brews
		RIGHT JOIN attendance
		ON brews.brewdate=attendance.date
		GROUP BY attendance.date ORDER BY attendance.date";
		$events = $connection->query($sql);
	?>
	var brewed=[<?php
	while($info=mysqli_fetch_array($events)) {
		echo $info['brewed'].',';
	}
	?>];
	<?php
		$sql = "SELECT attendance.date, GROUP_CONCAT(brews.name) as gr_name
		FROM brews
		RIGHT JOIN attendance
		ON brews.brewdate=attendance.date
		GROUP BY attendance.date
		ORDER BY attendance.date";
		$names = $connection->query($sql);
	?>
	var namebrewed=[<?php
	while($info=mysqli_fetch_array($names)) {
		echo '"' . $info['gr_name'] . '",';	
	}
	?>];
	<?php
		$sql = "SELECT COUNT(brews.secdate) AS seconded
		FROM brews
		RIGHT JOIN attendance
		ON brews.secdate=attendance.date
		GROUP BY attendance.date ORDER BY attendance.date";
		$events = $connection->query($sql);
	?>
	var seconded=[<?php
	while($info=mysqli_fetch_array($events)) {
		echo $info['seconded'].',';
	}
	?>];
	<?php
		$sql = "SELECT attendance.date, GROUP_CONCAT(brews.name) as gr_name
		FROM brews
		RIGHT JOIN attendance
		ON brews.secdate=attendance.date
		GROUP BY attendance.date
		ORDER BY attendance.date";
		$names = $connection->query($sql);
	?>
	var namesecnd=[<?php
	while($info=mysqli_fetch_array($names)) {
		echo '"' . $info['gr_name'] . '",';	
	}
	?>];
	<?php
		$sql = "SELECT COUNT(brews.dryhopdate) AS dryhopped
		FROM brews
		RIGHT JOIN attendance
		ON brews.dryhopdate=attendance.date
		GROUP BY attendance.date ORDER BY attendance.date";
		$events = $connection->query($sql);
	?>
	var dryhopped=[<?php
	while($info=mysqli_fetch_array($events)) {
		echo $info['dryhopped'].',';
	}
	?>];
	<?php
		$sql = "SELECT attendance.date, GROUP_CONCAT(brews.name) as gr_name
		FROM brews
		RIGHT JOIN attendance
		ON brews.dryhopdate=attendance.date
		GROUP BY attendance.date
		ORDER BY attendance.date";
		$names = $connection->query($sql);
	?>
	var namedhped=[<?php
	while($info=mysqli_fetch_array($names)) {
		echo '"' . $info['gr_name'] . '",';	
	}
	?>];
	<?php
		$sql = "SELECT COUNT(brews.bottleddate) AS bottled
		FROM brews
		RIGHT JOIN attendance
		ON brews.bottleddate=attendance.date
		GROUP BY attendance.date ORDER by attendance.date";
		$events = $connection->query($sql);
	?>
	var bottled=[<?php
	while($info=mysqli_fetch_array($events)) {
		echo $info['bottled'].',';
	}
	?>];
	<?php
		$sql = "SELECT attendance.date, GROUP_CONCAT(brews.name) as gr_name
		FROM brews
		RIGHT JOIN attendance
		ON brews.bottleddate=attendance.date
		GROUP BY attendance.date
		ORDER BY attendance.date";
		$names = $connection->query($sql);
	?>
	var namebotld=[<?php
	while($info=mysqli_fetch_array($names)) {
		echo '"' . $info['gr_name'] . '",';	
	}
	?>];
</script>
<?php $connection->close(); ?>
<div class="container">
<div id="attendance" class="col-sm-12"></div>

<script type="text/javascript">
window.onload=function(){
    zingchart.render({
        id:"attendance",
        width:"100%",
        height:400,
        data:{
        "type":"mixed",
		"stacked":true,
		"legend":{
			"layout":"x5",
			"position":"50% 100%"
		},
        "scale-x":{
            "labels":dates
        },
        "series":[
			{	"values":brewed,
				"stack":1,
				"background-color":"#337AB7",
				"type":"bar",
				"text":"Brewed",
				"data-brewed":namebrewed,
				"tooltip":{
					"text":"%data-brewed"
				}
			},
			{	"values":seconded,
				"stack":1,
				"background-color":"#719DC3",
				"type":"bar",
				"text":"Seconded",
				"data-secnd":namesecnd,
				"tooltip":{
					"text":"%data-secnd"
				}
			},
			{	"values":dryhopped,
				"stack":1,
				"background-color":"#61B6FF",
				"type":"bar",
				"text":"Dry Hopped",
				"data-dhped":namedhped,
				"tooltip":{
					"text":"%data-dhped"
				}
			},
			{	"values":bottled,
				"stack":1,
				"background-color":"#13426A",
				"type":"bar",
				"text":"Bottled",
				"data-botld":namebotld,
				"tooltip":{
					"text":"%data-botld"
				}
				
			},
			{	"values":present,
				"type":"line",
				"stack":2,
				"line-color":"#6A4408",
				"text":"Present",
				"data-bp":bp,
				"tooltip":{
					"text":"%data-bp"
				}
			}
    ]
    }
    });
    };
</script>
</div><!--container-->
</body>
</html>