<!doctype html>
<html>
<?php include_once 'head.php'; ?>
<body>
<?php
	include_once 'nav.php';
	include_once 'brewsDB_connection.php';
	
	
	$sql = "SELECT *,
	
	(@row:=@row+1) AS row,
	
	(kiel + ryan + josh + frank) AS present,
	
	DATE_FORMAT(DATE(date), '%m/%d')
	AS bpdate
	
	FROM attendance, (SELECT @row :=0) r
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
		$sql = "SELECT brews.name
		FROM brews
		RIGHT JOIN attendance
		ON brews.brewdate=attendance.date
		ORDER BY attendance.date";
		$names = $connection->query($sql);
	?>
	var namebrewed=[<?php
	while($info=mysqli_fetch_array($names))  {
		echo '"'.$info['name'].'",';
		//echo '"'.$info['name'].'",';
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
</script>
<?php $connection->close(); ?>
<div id="myChart"></div>

<script type="text/javascript">
window.onload=function(){
    zingchart.render({
        id:"myChart",
        width:"100%",
        height:400,
        data:{
        "type":"mixed",
		"stacked":true,
        "title":{
            "text":"Brew-tendance"
        },
		"legend":{
		},
        "scale-x":{
            "labels":dates
        },
        "series":[
			{	"values":brewed,
				"stack":1,
				"type":"bar",
				"text":"Brewed",
				"data-brewed":namebrewed,
				"tooltip":{
					"text":"%data-brewed"
				}
			},
			{	"values":seconded,
				"stack":1,
				"type":"bar",
				"text":"Seconded"
			},
			{	"values":dryhopped,
				"stack":1,
				"type":"bar",
				"text":"Dry Hopped"
			},
			{	"values":bottled,
				"stack":1,
				"type":"bar",
				"text":"Bottled"
			},
			{	"values":present,
				"type":"line",
				"stack":2,
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
</body>
</html>