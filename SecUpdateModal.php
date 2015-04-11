<div class="modal fade" id="secUpdateModal<?php echo $row['brewID']; ?>" tabindex="-1" role="dialog" aria-labelledby="secDate" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
        <?php
        	echo 'Add secondary date to ' . $row['name'];
		?></h4>
      </div>
      <div class="modal-body">
      	<?php echo "<h4>Set the secondary date to <b>" .  date("m/d/Y") . "</b>?</h4>" ?>
      </div>
      <div class="modal-footer">
      	<form action="schedule.php" method="post" id="updateSecDate">
            <input type="hidden" name="brewID" value="<?php echo $row['brewID']; ?>">
            <input type="hidden" name="nextstep" value="<?php if( $row['tildryhop'] > 0) { echo "dryhop"; } else { echo "bottle";} ?>">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="updateSecDate" class="btn btn-success">Save</button>
      	</form>
      </div>
    </div>
  </div>
</div>