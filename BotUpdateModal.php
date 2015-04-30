<div class="modal fade" id="botUpdateModal<?php echo $row['brewID']; ?>" tabindex="-1" role="dialog" aria-labelledby="botDate" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo "Add bottling info to " . $row['name'] ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="schedule.php" method="post" id="updateBotInfo">
            <input type="hidden" name="brewID" value="<?php echo $row['brewID'] ?>">
            <div class="form-group">                
                <label class="control-label col-sm-3" for="bottleddate">Date</label>
                <div class="col-sm-9">
                    <input type="date" name="bottleddate" class="form-control required" id="bottleddate">
                </div>
            </div>
            <div class="form-group">                
                <label class="control-label col-sm-3" for="cap">Cap Marking</label>
                <div class="col-sm-9">
                    <input type="text" name="cap" class="form-control required" id="cap">
                </div>
            </div>
            <div class="form-group">                
                <label class="control-label col-sm-3" for="fg">Final Gravity</label>
                <div class="col-sm-9">
                    <input type="number" step="0.001" name="fg" class="form-control" id="fg">
                </div>
            </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" name="updateBotInfo" class="btn btn-success">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>