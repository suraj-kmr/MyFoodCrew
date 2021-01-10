<div class="page-header">
	<h2>User Setting</h2>
</div>
<style>
    #set{pointer-events: none;}
    #set input[type = 'text']{background: #ddd;}
    #pri{   border-bottom: 1px solid black;
    margin: 2px;}
    #pri_lbl{margin-left: 0; padding-left: 0;}
</style>
<div class="row" >
	<div class="col-sm-12">
    	<?php echo form_open('', array('class' => 'form-horizontal', 'id' => 'set')); ?>
        <!--<div class="form-group">
        	<label class="col-sm-2">Username</label>
            <div class="col-sm-6">
            	<input type="text" name="frm[username]" value="<?php /*echo $m -> username; */?>" class="form-control input-sm" />
            </div>

        </div>-->
        <div class="form-group">
        	<label class="col-sm-2">Email ID</label>
            <div class="col-sm-3">
            	<input type="text" name="frm[email_id]" value="<?php echo $m -> email_id; ?>" class="form-control input-sm" />
            </div>
            <?php
            if($m->id == '')
            {
                ?>
                <label class="col-sm-1">Password</label>
                <div class="col-sm-2">
                    <input type="text" name="frm[password]" value="" class="form-control input-sm" />
                </div>
            <?php
            }
            ?>

        </div>
        <div class="form-group">

	        <label class="col-sm-2">Role</label>
	        <div class="col-sm-3">
		        <label class="radio radio-inline"><input type="radio" name="frm[role]" value="1" <?php if($m -> role == 1) echo 'checked'; ?> /> Admin</label>
		        <label class="radio radio-inline"><input type="radio" name="frm[role]" value="2" <?php if($m -> role == 2) echo 'checked'; ?> /> User</label>
	        </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2">Account Status</label>
            <div class="col-sm-3">
            	<label class="radio radio-inline">
                    <input type="radio" name="frm[status]" value="1" <?php if($m -> status == 1) echo 'checked'; ?> /> Active</label>
                <label class="radio radio-inline">
                    <input type="radio" name="frm[status]" value="0" <?php if($m -> status == 0) echo 'checked'; ?> /> Deactive</label>
            </div>
        </div>

        <?php echo form_close(); ?>


        <?php echo form_open(admin_url('privilege/setting/'.$m -> id), array('class' => 'form-horizontal')); ?>
        <div class="form-group" id="pri">
            <label class="col-sm-2" id="pri_lbl">Users Privileges</label>
        </div>
        <style>
            .ch{margin-left: 20px;}
            .hig{min-height: 262px;}
        </style>
        <div class="form-group">

            <?php
            $arr = $cha = array();
            $id = false;
            $da = $this->db->get_where('privilege', array('user_id' => $m->id));
            if($da->num_rows() > 0)
            {
                $row = $da->row();
                $arr = get_array($row->privilege);
                $cha = get_array($row->submenu);
                $id = $row->id;
            }
            foreach($tabs as $t)
            {
                ?>
                <div class="col-sm-3 hig">
                    <label class="checkbox-inline">
                        <input type="checkbox" class="checkb" value="<?= $t['pa'];?>" <?php if(in_array($t['pa'], $arr)){echo "checked";} ?> > <b><?= $t['pa']?></b></label><br>
                        <?php
                        if(isset($t['ch']) )
                        {
                            $chaild = get_array($t['ch']);
                            foreach($chaild as $c)
                            {
                                ?>
                                <div class="ch">
                                    <label><input type="checkbox" class="child" value="<?= $c;?>" <?php if(in_array($c, $cha)){echo "checked";} ?> > <?= $c;?></label><br>
                                </div>
                                <?php
                            }

                        }
                        ?>

                </div>
            <?php
            }
            ?>
            <input type="hidden" id="priv" name="frm[privilege]">
            <input type="hidden" id="child" name="frm[submenu]">
            <input type="hidden" name="id" value="<?= $id;?>">
            <script>
                function calculate(){
                    var arr = $.map($('.checkb:checked'), function(e){
                        return e.value;
                    });
                    $('#priv').val(arr.join(','));

                    var arr1 = $.map($('.child:checked'), function(j){
                        return j.value;
                    });
                    $('#child').val(arr1.join(','));
                }

                $('.child').click(function(){
                    $(this).parents('.hig').find('.checkb').attr('checked', true);
                });


                calculate();
                $('div').delegate('.checkb,.child', 'click', calculate);

            </script>
        </div>
<br>
<br>
<br>
        <div class="form-group">
            <label class="col-sm-2">&nbsp;</label>
            <div class="col-sm-10">
                <input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary" />
                <a href="<?= admin_url('members'); ?>" class="btn btn-sm btn-warning">Cancel</a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
