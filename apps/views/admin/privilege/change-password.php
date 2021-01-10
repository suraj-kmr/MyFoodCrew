
    <!-- Main content -->

     <div class="box box-warning">
            <!-- /.box-header -->
            <div class="box-body">

              <form action="<?php echo admin_url('privilege/change_pass'); ?>" method="POST" style="padding: 10px;">
                <!-- text input -->
                <div class="row">
                 <div class="col-sm-4">
                <div class="form-group">
                  <label>Old Password </label>
                  <input type="password" class="form-control"  name="old_pass" placeholder="Enter ...">
                </div>
                </div>
                 <div class="col-sm-4">
                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" class="form-control" name="new_pass" placeholder="Enter ...">
                </div>
                </div>
                 <div class="col-sm-4">
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input type="password" class="form-control" name="con_pass" placeholder="Enter ...">
                </div>
                </div>
                </div>
                  <div class="box-footer">
                      <button type="submit" class="btn btn-info"> <i class="fa fa-send"> </i> Submit </button>
                  </div>
              </form>
            </div>

            <!-- /.box-body -->

          </div>
    <!-- /.content -->
  <!-- /.content-wrapper -->
