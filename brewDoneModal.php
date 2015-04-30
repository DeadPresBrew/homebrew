<div class="modal fade" id="brewDoneModal<?php echo $row['brewID']; ?>" tabindex="-1" role="dialog" aria-labelledby="brewDone" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
        <?php
        	echo 'Add brew gone date to ' . $row['name'];
		?></h4>
      </div>
      <div class="modal-body">
      	<?php echo "<h4>Set the brew gone date to <b>" .  date("m/d/Y") . "</b>?</h4>" ?>
      </div>
      <div class="modal-footer">
      	<form action="schedule.php" method="post" id="brewGoneDate">
            <input type="hidden" name="brewID" value="<?php echo $row['brewID']; ?>">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" name="brewGoneDate" class="btn btn-success">Save</button>
        </form>
      </div>
    </div>
  </div>
</div