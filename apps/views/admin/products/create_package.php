    <!--  <link rel="stylesheet" href="http://103.50.163.11/~shiksw6z/kartar/assets/css/select2.css" type="text/css">
     <script src="http://select2.github.io/select2/select2-3.5.1/select2.js"> </script> -->

<div class="page-header">
	<h2>Create Package</h2>
</div>
<div class="row">
	<div class="col-sm-12">
    	<?php echo form_open_multipart(admin_url('products/create_package/'.$m -> id), array('class' => 'form-horizontal')); ?>
        <!--<div class="form-group">
        	<label class="col-sm-2">Username</label>
            <div class="col-sm-6">
            	<input type="text" name="frm[username]" value="<?php /*echo $m -> username; */?>" class="form-control input-sm" />
            </div>

        </div>-->

        <div class="form-group">
        	<label class="col-sm-2 control-label">Package Name</label>
            <div class="col-sm-5">
            	<input type="text" name="frm[name]" value="<?php echo $m -> name; ?>" class="form-control input-sm" />
            </div>
               
        </div>
       <div class="form-group">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-5">
                  <input type="text" name="frm[price]" value="<?php echo $m -> price; ?>" class="form-control"> 
                </div>
            </div>
<!-- 
            <div class="form-group">
                <label class="col-sm-2 control-label">Select Items</label>
                <div class="col-sm-5">
               <?php  $item = array();

                if($m ->item!=''){
                 $item = explode(',',$m ->item);

                }
                  
                 ?>
                 <div required class="selectRow">
    <select required id="multipleSelectExample" style="width: 100%;" class="" data-placeholder="Select Items" multiple  name="item[]" >
        <?php  
        if(is_array($product) && count($product)>0){
            $i=0;
            foreach($product as $p){
                $selected='';
             if(is_array($item) and $item>0){
                if(in_array($p->id,$item)){
                    $selected = "selected";
                }
             }   
        ?>
            <option value="<?=  $p->id;?>" <?=$selected;?>><?= $p->ptitle;?></option>
           <?php  }} ?>
        </select>
  </div> 
                </div>
            </div> -->

           


                                <!--    <script>
                                    $(document).ready(function() {
                                        $("#multipleSelectExample").select2();
                                       });
                                   </script> -->


            <div class="form-group">
                <label class="col-sm-2 control-label">Image</label>
                <div class="col-sm-5">
                    <div class="input-append">
                        <?php echo form_upload(array('name'=>'image'));?>
                    </div>

                    <?php if($m -> id && $m -> image != ''):?>

                        <div style="text-align:center; padding:5px; border:1px solid #ddd;"><img class="img-responsive img-thumbnail" src="<?php echo base_url('img/uploads/'.$m -> image);?>" alt="current"/><br/>Current File</div>
                        <label class="checkbox checkbox-inline">
                            <input type="hidden" name="hid_image" value="<?php echo $m -> image; ?>" />
                            <input type="checkbox" name="del_image" value="1" />Delete this image
                        </label>
                    <?php endif;?>
                </div>
            </div>
        
        <div class="form-group">
        	<label class="col-sm-2">&nbsp;</label>
            <div class="col-sm-10">
            	<input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary" />
                <a href="<?= admin_url('products/package'); ?>" class="btn btn-sm btn-warning">Cancel</a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
