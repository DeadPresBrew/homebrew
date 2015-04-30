<?php
	$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
	
	if(! $error) {
		$error = "oops";
	}
?>
<html>
<?php include_once 'head.php'; ?>
<body>
<p><?php echo $error; ?></p>
</body>
</html>