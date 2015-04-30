<?php
include_once 'brewsDB_connection.php';
include_once 'functions.php';

sec_session_start();
?>
<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
				<span class="sr-only">Toggle Nav</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="">DPB</a>
		</div><!--navbar-header-->
		
			<div class="collapse navbar-collapse" id="navbar-collapse-1">
            <?php
			if (login_check($connection) == true) {
				echo
				'<ul class="nav navbar-nav">
					<li><a href="index.php">Beers<span class="sr-only"></span></a></li>
					<li><a href="schedule.php">Schedule</a></li>
					<li><a href="review.php">Review</a></li>
				</ul>
				<a href="addbrew.php" type="button" class="btn btn-primary navbar-btn">Add Brew</button>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Stats <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/year-to-date.php">To Date</a></li>
							<li><a href="/attendance.php">Attendance</a></li>
							<li><a href="/yir.php">Beerly Review</a></li>
						</ul>
					</li>
                    <li><a href="logout.php">Log Out</a></li>
				</ul>';
			} else {
				echo
				'<ul class="nav navbar-nav">
					<li><a href="index.php">Beers<span class="sr-only"></span></a></li>
					<li><a href="review.php">Review</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Stats <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/year-to-date.php">To Date</a></li>
							<li><a href="/yir.php">Beerly Review</a></li>
						</ul>
					</li>
                    <li><a href="#logInModal" data-toggle="modal" data-target="#logInModal">Log In</a></li>
				</ul>';
			}
			?>
			</div>
            <?php include_once 'logInModal.php'; ?>
	</div><!--container-->
</nav>
