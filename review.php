<!doctype html>
<html>
<?php include_once ('head.php'); ?>
<body>
<div id="wrapper">
<?php include_once ('nav.php'); ?>
<div id="content">
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
        <h1 class="text-center">Review the Brew</h1>
            <form>
                <div class="form-group">
                    <label for="brewname">Brew Name</label>
                    <input type="text" class="form-control" id="brewname" placeholder="Brew Name">
                </div>
                <div class="form-group">
                    <label for="reviewdate">Date</label>
                    <input type="date" class="form-control" id="reviewdate" placeholder="Date">
                </div>
                <div class="form-group">
                    <label for="brewscore">Score</label>
                    <select type="text" class="form-control" id="brewscore" placeholder="Score">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <p class="help-block">1= worst ever; 6= best brew ever</p>
                </div>
                <div class="form-group">
                	<label for="feedback">Feedback</label>
                    <textarea class="form-control" id="feedback" placeholder="Leave any extra feedback here..."></textarea>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Submit</button>
            </form>
		</div><!--col-md-6-->
	</div><!--row-->
</div><!--container-->
</div><!--content-->
</div><!--wrapper-->
</body>
</html>