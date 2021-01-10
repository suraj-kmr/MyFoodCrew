<style>
    #cust1{
        display:none;
    }
</style>

<div class="page-header"><h2>Products Type</h2></div><?php //print_r($p); ?>
<div class="row">    
    <?php echo form_open_multipart(admin_url('products/add/' . $p->id), array('class' => 'form-horizontal')); ?>
    <!-- <select
        style="float: right;padding-right: 32px;margin-right: 14px;padding-left: 16px;width: 22%;font-size: 17px;height: 40px;"
        class="form-controller input-sm" name="frm[product_type]" id="ptype">
        <option value="">Select Product Type</option>
        <option value="1" <?php if ($p->product_type == "1") echo "Selected"; ?>><?php echo typeStr(1); ?></option>
        <option value="2" <?php if ($p->product_type == "2") echo "Selected"; ?>><?php echo typeStr(2); ?></option>
        <option value="3" <?php if ($p->product_type == "3") echo "Selected"; ?>><?php echo typeStr(3); ?></option>
        <option value="4" <?php if ($p->product_type == "4") echo "Selected"; ?>><?php echo typeStr(4); ?></option>
        <option value="5" <?php if ($p->product_type == "5") echo "Selected"; ?>><?php echo typeStr(5); ?></option>
        <option value="6" <?php if ($p->product_type == "6") echo "Selected"; ?>><?php echo typeStr(6); ?></option>
        <option value="7" <?php if ($p->product_type == "7") echo "Selected"; ?>><?php echo typeStr(7); ?></option>
        <option value="8" <?php if ($p->product_type == "8") echo "Selected"; ?>><?php echo typeStr(8); ?></option>
    </select> 
 -->
    <div class="col-sm-9">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Basic Details</a>
            </li>
          <!--<li role="presentation" class="mobiles"><a href="#mobiles" aria-controls="mobiles" role="tab"data-toggle="tab">Mobiles</a></li> -->
            <li role="presentation">
                <a href="#pincodes" aria-controls="pincodes" role="tab" data-toggle="tab">Delivery</a>
            </li>
            
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Product Title</label>
                    <div class="col-sm-6">
                        <input type="text" name="frm[ptitle]" value="<?= set_value('frm[ptitle]', $p->ptitle); ?>" class="form-control input-sm"/>
                    </div>
                    <div class="col-sm-3" style="float: right;">
                        <select class="form-control input-sm" id="pr_type" name="frm[product_type]">
                           <option>----select----</option>

                            <option value="1" <?php if($p->product_type == 1){ echo "selected";}?>>Clothings</option>
                            <option value="2" <?php if($p->product_type == 2){ echo "selected";}?>>Grocery</option>
                            <option value="3" <?php if($p->product_type == 3){ echo "selected";}?>>Marbles & Tiles</option>
                            <option value="4" <?php if($p->product_type == 4){ echo "selected";}?>>Sports & Outdoor</option>
                            <option value="5" <?php if($p->product_type == 5){ echo "selected";}?>>Electronics</option>
                        </select>
                    </div>
                    <script>
                        $(document).ready(function(){
                            $('#pr_type').change(function(){
                               var val = this.value ;
                                if(val == 1){
                                    $('#clothing').show();
                                    $('#grocery').hide();
                                    $('#price').hide();
                                    $.ajax({
                                        url:'<?=admin_url('products/getclothBrands');?>',
                                        method:'post',
                                        type:'html',
                                        success:function(e){
                                            $('#brands').html(e);
                                        }
                                    });
                                }
                                if(val == 2){
                                    $('#grocery').show();
                                    $('#price').hide();
                                    $('#clothing').hide();
                                    $.ajax({
                                        url:'<?=admin_url('products/getgroceryBrands');?>',
                                        method:'post',
                                        type:'html',
                                        success:function(e){
                                            $('#brands').html(e);
                                        }
                                    });
                                }
                                if(val == 3){
                                    $('#grocery').hide();
                                    $('#clothing').hide();
                                    $('#marble').show();
                                    $('#price').show();
                                    $.ajax({
                                        url:'<?=admin_url('products/getmarbleBrands');?>',
                                        method:'post',
                                        type:'html',
                                        success:function(e){
                                            $('#brands').html(e);
                                        }
                                    });
                                }
                                if(val==4){
                                    $('#clothing').hide();
                                    $('#grocery').hide();
                                    $('#marble').hide();
                                    $('#price').show();
                                    $.ajax({
                                        url:'<?=admin_url('products/gethealthBrands');?>',
                                        method:'post',
                                        type:'html',
                                        success:function(e){
                                            $('#brands').html(e);
                                        }
                                    });
                                }
                                if(val==5){
                                    $('#clothing').hide();
                                    $('#grocery').hide();
                                    $('#marble').hide();
                                    $('#electronic').show();
                                    $('#price').show();

                                    $.ajax({
                                        url:'<?=admin_url('products/getelectronicBrands');?>',
                                        method:'post',
                                        type:'html',
                                        success:function(e){
                                            $('#brands').html(e);
                                        }
                                    });
                                }
                                
                            });
                        });
                    </script>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Slug</label>
                    <div class="col-sm-6">
                        <input type="text" name="frm[slug]" value="<?= set_value('frm[slug]', $p->slug); ?>"class="form-control input-sm"/>
                    </div>
                    <label class="col-sm-2 control-label">SKU</label>
                    <div class="col-sm-2">
                        <input type="text" name="frm[sku]" value="<?= set_value('frm[sku]', $p->sku); ?>"class="form-control input-sm"/>
                    </div>
                </div>
                <!-- <div class="form-group" id="ifYes" style="display:none" >
                     <label class="col-sm-2 control-label">Custom Link</label>
                     <div class="col-sm-10">
                        <input type="text" name="frm[customize]" value="<?= set_value('frm[customize_link]','$p->customize'); ?>" class="form-control input-sm"/>
                    </div>
                </div> -->
                
                <!-- ------------------start clothing products------------ -->
                <div id="clothing" style="<?php if($p->product_type == 1){ echo'display: block';}else{ echo 'display: none'; }?>">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fit Details</label>
                            <div class="col-sm-10">
                                <textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[fit_details]"><?= set_value('frm[fit_details]', $p -> fit_details); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fabric Details</label>
                            <div class="col-sm-10">
                                <textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[fabric_details]"><?= set_value('frm[fabric_details]', $p -> fabric_details); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <div class="field_wrapper_size">
                                    <?php 
                                    $attr = json_decode($p->attr);
                                    if(is_array($attr) && count($attr)){
                                        $i=1;
                                        foreach ($attr as $data) {
                                               ?>
                                            <div class="row">
                                               <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label >Sizes</label>
                                                            <?php
                                                            $options = array(
                                                                'S'         => 'Small',
                                                                'M'           => 'Medium',
                                                                'L'         => 'Large',
                                                                'XL'        => 'XL',
                                                                'XXL'        => 'XXL',
                                                                'XXXL'        => 'XXXL',
                                                            );
                                                            echo form_dropdown('attr[sizes][]', $options, $data->sizes,array('class'=>'form-control'));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label >Price</label>
                                                            <input type="text" name="attr[price][]" class="form-control input-sm" value="<?=$data->price?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label >Qty.</label>
                                                            <input type="text" name="attr[qty][]" class="form-control input-sm" value="<?=$data->qty?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if($i==1){
                                                    ?>
                                                    <a href="javascript:void(0);" class="btn btn-success add_button" style="margin-top: 25px;" title="Add field"><i class="fa fa-plus"></i> add </a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <a href="javascript:void(0);" class="btn btn-danger remove_button" style="margin-top: 25px;" title="Remove field"><i class="fa fa-minus"></i> Remove </a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                               <?php
                                               $i++;
                                           }  
                                       }
                                       else
                                       {
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label >Sizes</label>
                                                        <?php
                                                        $options = array(
                                                            'S'         => 'Small',
                                                            'M'           => 'Medium',
                                                            'L'         => 'Large',
                                                            'XL'        => 'XL',
                                                            'XXL'        => 'XXL',
                                                            'XXXL'        => 'XXXL',
                                                        );
                                                       // $sel = $p -> sizes;
                                                        echo form_dropdown('attr[sizes][]', $options, '',array('class'=>'form-control'));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label >Price</label>
                                                        <input type="text" name="attr[price][]" class="form-control input-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label >Qty.</label>
                                                        <input type="text" name="attr[qty][]" class="form-control input-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                        <a href="javascript:void(0);" class="btn btn-success add_button" style="margin-top: 25px;" title="Add field"><i class="fa fa-plus"></i> add </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                 
                <script type="text/javascript">
                    $(document).ready(function(){
                        var maxField = 10; //Input fields increment limitation
                        var addButton = $('.add_button'); //Add button selector
                        var wrapper = $('.field_wrapper_size'); //Input field wrapper
                        //var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>';
                        var fieldHTML ='<div class="row"><div class="col-sm-3"><div class="form-group"><div class="col-sm-12"><label >Sizes</label><select name="attr[sizes][]" class="form-control"><option value="S">Small</option><option value="M">Medium</option><option value="L">Large</option><option value="XL">XL</option><option value="XXL">XXL</option><option value="XXXL">XXXL</option></select></div></div></div><div class="col-sm-4"><div class="form-group"><div class="col-sm-12"><label >Price</label><input type="text" name="attr[price][]" class="form-control input-sm" /></div></div></div><div class="col-sm-3"><div class="form-group"><div class="col-sm-12"><label >Qty.</label><input type="text" name="attr[qty][]" class="form-control input-sm" /></div></div></div><a href="javascript:void(0);" class="btn btn-danger remove_button" style="margin-top: 25px;" title="Remove field"><i class="fa fa-minus"></i> Remove </a></div>';
                        //New input field html 
                        var x = 1; //Initial field counter is 1
                        
                        //Once add button is clicked
                        $(addButton).click(function(){
                            //Check maximum number of input fields
                            if(x < maxField){ 
                                x++; //Increment field counter
                                $(wrapper).append(fieldHTML); //Add field html
                            }
                        });
                        
                        //Once remove button is clicked
                        $(wrapper).on('click', '.remove_button', function(e){
                            e.preventDefault();
                            $(this).parent('div').remove(); //Remove field html
                            x--; //Decrement field counter
                        });
                    });
                </script> 
               <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <div class="field_wrapper_color">
                                    <?php 
                                    $cloth_color = json_decode($p->cloth_color);
                                    if(is_array($cloth_color) && count($cloth_color)){
                                        $i=1;
                                        foreach ($cloth_color as $data) {
                                               ?>
                                            <div class="row">
                                               <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label >Sizes</label>
                                                            <?php
                                                           $options = array(
                                                            'B'    => 'Blue',
                                                            'W'    => 'White',
                                                            'R'    => 'Red',
                                                            'G'    => 'Green',
                                                            'GR'   => 'Grey',
                                                            'P'    => 'Pink',
                                                            'BL'   => 'Black',
                                                            'Y'    => 'Yellow',
                                                        );
                                                            echo form_dropdown('cloth_color[color][]', $options, $data->color,array('class'=>'form-control'));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label >Image</label>
                                                            <input type="text" name="img[]" class="form-control input-sm" value="<?=$data->image?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <?php
                                                if($i==1){
                                                    ?>
                                                    <a href="javascript:void(0);" class="btn btn-success add_button_color" style="margin-top: 25px;" title="Add field"><i class="fa fa-plus"></i> add </a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <a href="javascript:void(0);" class="btn btn-danger remove_button" style="margin-top: 25px;" title="Remove field"><i class="fa fa-minus"></i> Remove </a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                               <?php
                                               $i++;
                                           }  
                                       }
                                       else
                                       {
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label >Color</label>
                                                        <?php
                                                        $options = array(
                                                            'B'    => 'Blue',
                                                            'W'    => 'White',
                                                            'R'    => 'Red',
                                                            'G'    => 'Green',
                                                            'GR'   => 'Grey',
                                                            'P'    => 'Pink',
                                                            'BL'   => 'Black',
                                                            'Y'    => 'Yellow',
                                                        );
                                                       // $sel = $p -> sizes;
                                                        echo form_dropdown('cloth_color[color][]', $options, '',array('class'=>'form-control'));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <label >Image</label>
                                                        <input type="file" name="img[]" class="form-control input-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                        <a href="javascript:void(0);" class="btn btn-success add_button_color" style="margin-top: 25px;" title="Add field"><i class="fa fa-plus"></i> add </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                 
                <script type="text/javascript">
                    $(document).ready(function(){
                        var maxField = 10; //Input fields increment limitation
                        var addButton = $('.add_button_color'); //Add button selector
                        var wrapper = $('.field_wrapper_color'); //Input field wrapper
                        //var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>';
                        var fieldHTML ='<div class="row"><div class="col-sm-3"><div class="form-group"><div class="col-sm-12"><label >Sizes</label><select name="cloth_color[color][]" class="form-control"><option value="B">Blue</option><option value="W">White</option><option value="R">Red</option><option value="G">Green</option><option value="GR">Grey</option><option value="P">Pink</option><option value="BL">Black</option><option value="Y">Yellow</option></select></div></div></div><div class="col-sm-4"><div class="form-group"><div class="col-sm-12"><label >Image</label><input type="file" name="img[]" class="form-control input-sm" /></div></div></div><a href="javascript:void(0);" class="btn btn-danger remove_button" style="margin-top: 25px;" title="Remove field"><i class="fa fa-minus"></i> Remove </a></div>';
                        //New input field html 
                        var x = 1; //Initial field counter is 1
                        
                        //Once add button is clicked
                        $(addButton).click(function(){
                            //Check maximum number of input fields
                            if(x < maxField){ 
                                x++; //Increment field counter
                                $(wrapper).append(fieldHTML); //Add field html
                            }
                        });
                        
                        //Once remove button is clicked
                        $(wrapper).on('click', '.remove_button', function(e){
                            e.preventDefault();
                            $(this).parent('div').remove(); //Remove field html
                            x--; //Decrement field counter
                        });
                    });
                </script> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-4">
                                <label class="radio radio-inline">
                                    <input type="radio" name="params[gender][]" value="Male" <?php if(isset($p -> params -> gender) && in_array('Male', $p -> params -> gender)) echo 'Checked'; ?>/> Male
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" name="params[gender][]" value="Female" <?php if(isset($p -> params -> gender) && in_array('Female', $p -> params -> gender)) echo 'Checked'; ?>/> Female

                                </label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- ------------------end clothing products-------------- -->
                <!-- ------------------start Grocery products------------ -->
                <div id="grocery" style="<?php if($p->product_type == 2){ echo'display: block';}else{ echo 'display: none'; }?>">
                    <div class="field_wrapper">
                        <?php
                            if(isset($units)){
                                $i=1;
                                foreach($units as $u){
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">units</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="units[]" class="form-control input-sm" value="<?=$u->units?>"/>
                                        </div>
                                        <label class="col-sm-2 control-label">unit Price</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="unit_price[]" class="form-control input-sm" value="<?=$u->unit_price;?>"/>
                                        </div>
                                        <?php if($i==1){
                                            ?>
                                                <a href="javascript:void(0);" class="btn btn-success add_button" title="Add field" style="width:91px;"><i class="fa fa-plus"></i> Add </a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                                <a href="javascript:void(0);" class="btn btn-danger remove_button" title="Remove field"><i class="fa fa-minus"></i> Remove </a>
                                            <?php
                                        }
                                        ?>
                                        
                                    </div>
                                <?php
                                $i++;
                                }
                            }
                            else
                            {
                                ?>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label">units</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="units[]" class="form-control input-sm" />
                                        </div>
                                        <label class="col-sm-2 control-label">unit Price</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="unit_price[]" class="form-control input-sm" />
                                        </div>
                                            <a href="javascript:void(0);" class="btn btn-success add_button" title="Add field" style="width:91px;"><i class="fa fa-plus"></i> add </a>
                                    </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        var maxField = 10; //Input fields increment limitation
                        var addButton = $('.add_button'); //Add button selector
                        var wrapper = $('.field_wrapper'); //Input field wrapper
                        //var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="remove-icon.png"/></a></div>';
                        var fieldHTML ='<div class="form-group"><label class="col-sm-2 control-label">units</label><div class="col-sm-3"><input type="text" name="units[]" class="form-control input-sm" /></div><label class="col-sm-2 control-label">unit Price</label><div class="col-sm-3"><input type="text" name="unit_price[]" class="form-control input-sm" /></div><a href="javascript:void(0);" class="btn btn-danger remove_button" title="Remove field"><i class="fa fa-minus"></i> Remove </a></div>';
                         //New input field html 
                        var x = 1; //Initial field counter is 1
                        
                        //Once add button is clicked
                        $(addButton).click(function(){
                            //Check maximum number of input fields
                            if(x < maxField){ 
                                x++; //Increment field counter
                                $(wrapper).append(fieldHTML); //Add field html
                            }
                        });
                        
                        //Once remove button is clicked
                        $(wrapper).on('click', '.remove_button', function(e){
                            e.preventDefault();
                            $(this).parent('div').remove(); //Remove field html
                            x--; //Decrement field counter
                        });
                    });
                </script>          
                <!-- ------------------end Grocery products-------------- -->

                <!-- ------------------start Marbles products------------ -->
                <div id="marble" style="<?php if($p->product_type == 3){ echo'display: block';}else{ echo 'display: none'; }?>">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" >Wall Tiles:</label>
                            <div class="col-sm-10">
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[wall_tiles][]" value="10" <?php if(isset($p -> params -> wall_tiles) && in_array('10', $p -> params -> wall_tiles)) echo 'Checked'; ?> /> 10*15
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[wall_tiles][]" value="12" <?php if(isset($p -> params -> wall_tiles) && in_array('12', $p -> params -> wall_tiles)) echo 'Checked'; ?> /> 12*18
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" >Floor Tiles:</label>
                            <div class="col-sm-10">
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[floor_tiles][]" value="N" <?php if(isset($p -> params -> floor_tiles) && in_array('N', $p -> params -> floor_tiles)) echo 'Checked'; ?> /> Nano
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[floor_tiles][]" value="DC" <?php if(isset($p -> params -> floor_tiles) && in_array('DC', $p -> params -> floor_tiles)) echo 'Checked'; ?> /> DC(Double Charge)
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[floor_tiles][]" value="PGVT" <?php if(isset($p -> params -> floor_tiles) && in_array('PGVT', $p -> params -> floor_tiles)) echo 'Checked'; ?> /> PGVT(Policed Glazes Vitrified Tiles)
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[floor_tiles][]" value="DGVT" <?php if(isset($p -> params -> floor_tiles) && in_array('DGVT', $p -> params -> floor_tiles)) echo 'Checked'; ?> /> DGVT(Dark Glazed Vitrified Tiles)
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" >Granite:</label>
                            <div class="col-sm-10">
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[granite][]" value="JB" <?php if(isset($p -> params -> granite) && in_array('JB', $p -> params -> granite)) echo 'Checked'; ?> /> Jet Black
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[granite][]" value="R" <?php if(isset($p -> params -> granite) && in_array('R', $p -> params -> granite)) echo 'Checked'; ?> /> Red
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[granite][]" value="BR" <?php if(isset($p -> params -> granite) && in_array('BR', $p -> params -> granite)) echo 'Checked'; ?> /> Brown
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[granite][]" value="TB" <?php if(isset($p -> params -> granite) && in_array('TB', $p -> params -> granite)) echo 'Checked'; ?> /> Tiger Brown
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[granite][]" value="G" <?php if(isset($p -> params -> granite) && in_array('G', $p -> params -> granite)) echo 'Checked'; ?> /> Green
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" >Marbles:</label>
                            <div class="col-sm-10">
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[marble][]" value="dharmeta" <?php if(isset($p -> params -> marble) && in_array('dharmeta', $p -> params -> marble)) echo 'Checked'; ?> /> Dharmeta
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[marble][]" value="onex" <?php if(isset($p -> params -> marble) && in_array('onex', $p -> params -> marble)) echo 'Checked'; ?> /> Onex
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[marble][]" value="torrento" <?php if(isset($p -> params -> marble) && in_array('torrento', $p -> params -> marble)) echo 'Checked'; ?> /> Torrento
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[marble][]" value="orange" <?php if(isset($p -> params -> marble) && in_array('orange', $p -> params -> marble)) echo 'Checked'; ?> /> Orange
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[marble][]" value="dumri" <?php if(isset($p -> params -> marble) && in_array('dumri', $p -> params -> marble)) echo 'Checked'; ?> /> Dumri
                                </label>
                                <label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="params[marble][]" value="waspur" <?php if(isset($p -> params -> marble) && in_array('waspur', $p -> params -> marble)) echo 'Checked'; ?> /> Waspur
                                </label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- ------------------end Marble products-------------- -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Excerpt</label>
                    <div class="col-sm-10">
                        <textarea rows="4" cols="" class="form-control input-sm" name="frm[short_description]"><?= set_value('frm[short_description]', $p->short_description); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea rows="8" cols="" class="form-control input-sm redactor ckeditor" name="frm[description]">
                            <?php 
                            if ($p->description) { ?>
                                <?= set_value('frm[description]', $p->description); ?><?php } ?>
                        </textarea>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Feature</label>
                    <div class="col-sm-10">
                        <textarea rows="8" cols="" class="form-control input-sm redactor ckeditor" name="frm[feature]"><?php if ($p->feature) { ?><?= set_value('frm[feature]', $p->feature); ?><?php } ?></textarea></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Delivery &amp; Return</label>
                    <div class="col-sm-10">
                        <textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[delivery_info]"><?= set_value('frm[delivery_info]', $p->delivery_info); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <span id="price">
                    <label class="col-sm-2 control-label"">Price</label>
                    <div class="col-sm-2"><input type="text" name="frm[price]" value="<?= set_value('frm[price]', $p->price); ?>" class="form-control input-sm" "/>
                    </div></span>
                   <label class="col-sm-2 control-label">Featured</label>
                    <div class="col-sm-2">              
                        <?php $ft = array(0 => 'No', 1 => 'Yes');
                        echo form_dropdown('frm[featured]', $ft, $p->featured, 'class="form-control input-sm"'); ?>                    
                    </div>
                    <label class="col-sm-2 control-label">Available</label>
                    <div class="col-sm-2">
                        <label class="checkbox-inline"> 
                            <input type="checkbox" name="frm[available]" value="1" <?php if ($p->available == 1) echo 'checked'; ?> /> Yes </label>
                        </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                            <label>Cover Image</label>
                            <input type="file" onclick="getFilePath();" name="cover_image" id="file_name">
                            <script type="text/javascript">
                                function getFilePath(){
                                    $('input[type=file]').change(function () {
                                        var filePath=$('#file_name').val().split('\\').pop().split('/').pop();
                                        var fname = site_url(upload_dir());
                                        $('#img1').val(fname+filePath);
                                        //alert(fname+filePath);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image1" id="img1" value="<?php if($p->image !='') echo $p->image; ?>"  />
                        </div>
                        <?php
                        if(!$p->id==''){
                            $os = new AI_Product($p->id);
                            if(is_object($os)) {
                                foreach ($os->images() as $img) {
                                    $imga[] = $img;
                                }
                            }
                        }
                        //print_r($imga);
                        ?>
                        <div class="col-sm-3">
                            <label>Image 1</label>
                            <input type="file" onclick="getFilePath1();" name="image1" id="file_name1">
                            <script type="text/javascript">
                                function getFilePath1(){
                                    $('input[type=file]').change(function () {
                                        var filePath1=$('#file_name1').val().split('\\').pop().split('/').pop();
                                        var fname1 = site_url(upload_dir());;
                                        $('#img2').val(fname1+filePath1);
                                        //alert(fname1+filePath1);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image2" id="img2" value="<?php if(!$p->id=='') echo $imga[1]; ?>" />
                        </div>
                        <div class="col-sm-3">
                            <label>Image 2</label>
                            <input type="file" onclick="getFilePath2();" name="image2" id="file_name2">
                            <script type="text/javascript">
                                function getFilePath2(){
                                    $('input[type=file]').change(function () {
                                        var filePath2=$('#file_name2').val().split('\\').pop().split('/').pop();
                                        var fname2 = site_url(upload_dir());
                                        $('#img3').val(fname2+filePath2);
                                        //alert(fname1+filePath1);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image3" id="img3" value="<?php if(!$p->id=='') echo $imga[2]; ?>"  />
                        </div>
                        <div class="col-sm-3">
                            <label>Image 3</label>
                            <input type="file" onclick="getFilePath3();" name="image3" id="file_name3">
                            <script type="text/javascript">
                                function getFilePath3(){
                                    $('input[type=file]').change(function () {
                                        var filePath3=$('#file_name3').val().split('\\').pop().split('/').pop();
                                        var fname3 = site_url(upload_dir());
                                        $('#img4').val(fname3+filePath3);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image4" id="img4" value="<?php if($p->id!='') echo $imga[3]; ?>"  />
                        </div>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                            <label>Image 4</label>
                            <input type="file" onclick="getFilePath4();" name="image4" id="file_name4">
                            <script type="text/javascript">
                                function getFilePath4(){
                                    $('input[type=file]').change(function () {
                                        var filePath4=$('#file_name4').val().split('\\').pop().split('/').pop();
                                        var fname4 = site_url(upload_dir());
                                        $('#img5').val(fname4+filePath4);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image5" id="img5" value="<?php if($p->id!='') echo @$imga[4]; ?>"  />
                        </div>
                        <div class="col-sm-3">
                            <label>Image 5</label>
                            <input type="file" onclick="getFilePath5();" name="image5" id="file_name5">
                            <script type="text/javascript">
                                function getFilePath5(){
                                    $('input[type=file]').change(function () {
                                        var filePath5=$('#file_name5').val().split('\\').pop().split('/').pop();
                                        var fname5 = site_url(upload_dir());
                                        $('#img6').val(fname5+filePath5);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image6" id="img6" value="<?php if(!$p->id=='') echo @$imga[5]; ?>"  />
                        </div>
                        <div class="col-sm-3">
                            <label>Image 6</label>
                            <input type="file" onclick="getFilePath6();" name="image6" id="file_name6">
                            <script type="text/javascript">
                                function getFilePath6(){
                                    $('input[type=file]').change(function () {
                                        var filePath6=$('#file_name6').val().split('\\').pop().split('/').pop();
                                        var fname6 = site_url(upload_dir());
                                        $('#img7').val(fname6+filePath6);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image7" id="img7" value="<?php if( !$p->id=='') echo @$imga[6]; ?>"  />
                        </div>
                        <div class="col-sm-3">
                            <label>Image 7</label>
                            <input type="file" onclick="getFilePath7();" name="image7" id="file_name7">
                            <script type="text/javascript">
                                function getFilePath7(){
                                    $('input[type=file]').change(function () {
                                        var filePath7=$('#file_name7').val().split('\\').pop().split('/').pop();
                                        var fname7 = site_url(upload_dir());
                                        $('#img8').val(fname7+filePath7);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image8" id="img8" value="<?php if(!$p->id=='') echo @$imga[7]; ?>"  />
                        </div>
                        <p>&nbsp;</p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                            <label>Image 8</label>
                            <input type="file" onclick="getFilePath8();" name="image8" id="file_name8">
                            <script type="text/javascript">
                                function getFilePath8(){
                                    $('input[type=file]').change(function () {
                                        var filePath8=$('#file_name8').val().split('\\').pop().split('/').pop();
                                        var fname8 = site_url(upload_dir());
                                        $('#img9').val(fname8+filePath8);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image9" id="img9" value="<?php if( !$p->id=='') echo @$imga[8]; ?>"  />
                        </div>
                        <div class="col-sm-3">
                            <label>Image 9</label>
                            <input type="file" onclick="getFilePath9();" name="image9" id="file_name9">
                            <script type="text/javascript">
                                function getFilePath9(){
                                    $('input[type=file]').change(function () {
                                        var filePath9=$('#file_name9').val().split('\\').pop().split('/').pop();
                                        var fname9 = site_url(upload_dir());
                                        $('#img10').val(fname9+filePath9);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image10" id="img10" value="<?php if(!$p->id=='') echo @$imga[9]; ?>"  />
                        </div>
                        <div class="col-sm-3">
                            <label>Image 10</label>
                            <input type="file" onclick="getFilePath10();" name="image10" id="file_name10">
                            <script type="text/javascript">
                                function getFilePath10(){
                                    $('input[type=file]').change(function () {
                                        var filePath10=$('#file_name10').val().split('\\').pop().split('/').pop();
                                        var fname10 = site_url(upload_dir());
                                        $('#img10').val(fname10+filePath10);
                                    });
                                }
                            </script>
                            <input type="text" name="txt_image11" id="img11" value="<?php if(!$p->id=='') echo @$imga[10]; ?>"  />
                        </div>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <p>&nbsp;</p>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Video URL</label>
                    <div class="col-sm-10">
                        <input type="text" name="frm[video_url]" value="<?= set_value('frm[video_url]', $p->video_url); ?>" class="form-control input-sm"/>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">SEO Title</label>
                    <div class="col-sm-10">
                        <input type="text" name="frm[meta_title]" value="<?= set_value('frm[meta_title]', $p->meta_title); ?>" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">SEO Descriptions</label>
                    <div class="col-sm-10">
                        <textarea rows="2" cols="" name="frm[meta_description]" class="form-control input-sm"><?= set_value('frm[meta_description]', $p->meta_description); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Searching Keywords</label>
                    <div class="col-sm-10">
                        <textarea rows="2" cols="" name="frm[meta_keywords]" class="form-control input-sm"><?= set_value('frm[meta_keywords]', $p->meta_keywords); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Brand</label>
                    <div class="col-sm-4">
                        <?php 
                        $d = array('' => 'Select Brands');
                        if(isset($brands)){
                        if (is_array($brands) && count($brands) > 0) {
                            foreach ($brands as $b) {
                                $d[$b->id] = $b->title;
                            }
                        }
                    }
                         echo form_dropdown('frm[brand_id]', $d, set_value('frm[brand_id]',$p->brand_id), 'id="brands" class="form-control input-sm"'); 
                        ?>
                    </div>
                    <label class="col-sm-2 control-label">Status</label>

                    <div class="col-sm-3">                        
                        <?php $st = array(1 => 'Active', 0 => 'Deactive');
                        echo form_dropdown('frm[status]', $st, $p->status, 'class="form-control input-sm"'); ?>                    
                    </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-2 control-label">Mobile Featured</label>
                    <div class="col-sm-2">              
                        <?php $mft = array(0 => 'No', 1 => 'Yes');
                        echo form_dropdown('frm[m_featured]', $mft, $p->m_featured, 'class="form-control input-sm"'); ?>                    
                    </div> 

                    <label class="col-sm-2 control-label">GST</label>
                    <div class="col-sm-2">              
                        <?php $mft = array(5 => '5', 12 => '12',18 => '18', 28 => '28');
                        echo form_dropdown('frm[gst]', $mft, $p->gst, 'class="form-control input-sm"'); ?>                    
                    </div>  
                </div>
                

                <div class="form-group">
                   <h4><label class="col-sm-2 control-label">Cashback</label></h4>
                </div>

                <div class="form-group">
                   <label class="col-sm-2 control-label">Cashback type</label>
                    <div class="col-sm-2">              
                        <?php $cash = array(1 => 'Flat', 2 => 'Discount');
                        echo form_dropdown('frm[casback_type]', $cash, $p->casback_type , 'class="form-control input-sm"'); ?>                    
                    </div> 

                    <label class="col-sm-2 control-label"> Discount</label>
                    <div class="col-sm-2">              
                       <input type="text" name="frm[discount_amount]" value="<?= set_value('frm[discount_amount]', $p->discount_amount); ?>" class="form-control input-sm"/>                    
                    </div>  
                </div>
                <div class="form-group">
                 

                    <label class="col-sm-2 control-label">Cashback Offer Note</label>
                    <div class="col-sm-10">              
                        <textarea  name="frm[note]" class="form-control input-sm"value="<?= set_value('frm[note]', $p->note); ?>"></textarea>                    
                    </div>  
                </div>
                

            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
                <div class="row">
                    <div class="col-sm-10">
                        <div id="img-preview">                          
                          <?php $img_str = '';
                            if ($p->gallery <> '') {
                                $pr = explode(',', rtrim($p->gallery, ','));
                                if (is_array($pr) && count($pr) > 0) {
                                    $i = 0;
                                    foreach ($pr as $sr) {
                                        $i++;
                                        ?>
                                        <div style="float: left"><i data-src="<?= $sr; ?>" class="fa fa-trash" aria-hidden="true" style="padding: 0px;margin-left: -17px; float: left; position: absolute; margin-top: 6px; cursor: pointer;"></i>
                                            <img src="<?= $sr; ?>" class="img-thumbnail img-preview <?php if ($sr == $p->image) echo 'img.cover-img'; ?> tip" title="Make it Cover Image"/>
                                        </div>                            
                                    <?php 
                                    }
                                }
                            } 
                            ?>                        
                        </div>
                        <input type="hidden" name="frm[image]" value="<?= $p->image; ?>" id="cover_image"/>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary btn-block btn-sm" data-toggle="modal"
                                data-target="#imgmodel"> Select
                        </button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="imgmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <div class="modal-title" id="myModalLabel">
                                    <div class="row">
                                        <div class="col-sm-2"> Select Image</div>
                                        <div class="col-sm-4">
                                            <input type="search" id="img_q" placeholder="Search..." class="form-control input-sm"/>
                                        </div>
                                        <div class="col-sm-5">
                                            <a href="#" class="btn-file-chooser btn btn-sm btn-primary" data-target="#fromserver">From Server</a>
                                             <a href="#" data-target="#fromdisk" class="btn-file-chooser btn btn-sm btn-warning">From Disk</a>
                                         </div>
                                    </div>
                                </div>
                            </div>
                            <div id="fromserver" class="model-panel">
                                <div class="modal-body clearfix" style="max-height: 400px; overflow: auto;">
                                    <ul class="model-img"
                                        id="model-img-list">     
                                             <?php foreach ($images as $imob) { ?>
                                            <li><img src="<?= base_url(upload_dir($imob->file_name)); ?>"
                                                     class="img-thumbnail img-responsive img-popup"/>
                                            </li>                                        
                                            <?php 
                                            } 
                                        ?>
                                    </ul>
                                    <input type="hidden" id="img_selected" name="img_selected"
                                           value="<?= $p->gallery; ?>"/>
                                    <script type="text/javascript"> 
                                        $(document).ready(function () {
                                            $('#img_q').on('keyup', function () {
                                                var v = $(this).val();
                                                var url = '<?php echo admin_url('products/filter_img'); ?>' + '/' + v;
                                                $.ajax({
                                                    url: url, success: function (a) {
                                                        $('#model-img-list').html(a);
                                                        $('.img-popup').on('click', function () {
                                                            $(this).toggleClass('selected');
                                                            var str = '';
                                                            <?php                                                            
                                                            if($p -> gallery <> ''){                                                                
                                                                ?>
                                                            str = '<?php echo $p -> gallery; ?>';
                                                            <?php                                                            
                                                        }                                                            
                                                        ?>
                                                            $('img.selected').each(function (e, v) {
                                                                str += v.src + ',';
                                                            });
                                                            $('#img_selected').val(str);
                                                        });
                                                    }
                                                });
                                            });
                                            $('.img-popup').on('click', function () {
                                                $(this).toggleClass('selected');
                                                var str = '';
                                                $('img.selected').each(function (e, v) {
                                                    str += v.src + ',';
                                                });
                                                <?php                                                
                                                    if($p -> id){
                                                ?>
                                                gal = '<?= $p -> gallery; ?>';
                                                str = gal + str;
                                                <?php                                                
                                            }                                                
                                            ?>
                                            $('#img_selected').val(str);
                                            });
                                            $('#insertimg').on('click', function (e) {
                                                e.preventDefault();
                                                var selfile = $('#img_selected').val();
                                                var filear = selfile.split(',');
                                                var img_str = '';
                                                for (i = 0; i < filear.length - 1; i++) {
                                                    img_str += '<img src="' + filear[i] + '" class="img-thumbnail img-preview" />';
                                                }
                                                $('#img-preview').html(img_str);
                                                $('#imgmodel').modal('hide');
                                            });
                                        });                                    
                                    </script>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="insertimg" class="btn btn-sm btn-info">Add to Product
                                    </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            <div id="fromdisk" class="model-panel" style="display: none;">
                                <iframe src="<?= admin_url('products/ajax-upload'); ?>" width="" height=""
                                        style="width: 100%; height: 400px;" frameborder="no"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="pincodes">
                <div class="form-group">
                    <label class="col-sm-2">Shipping Charge</label>
                    <div class="col-sm-2">
                        <input type="text" name="frm[ship_charge]" class="form-control input-sm" value="<?= set_value('frm[ship_charge]', $p->ship_charge); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Delivery Notes</label>
                    <div class="col-sm-6">
                        <input type="text" name="frm[ship_notes]" class="form-control input-sm" value="<?= set_value('frm[ship_notes]', $p->ship_notes); ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">COD Available:</label>
                    <div class="col-sm-10">
                        <label class="checkbox checkbox-inline"> 
                        <input type="checkbox" name="cod_available" value="1" <?php if($p->cod_available == 1){echo 'checked';}?>/> Yes </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Pincodes</label>
                    <div class="col-sm-10">
                        <p>
                            <button type="button" class="btn btn-xs btn-info" id="btnfile"><i class="fa fa-upload"></i>
                                TXT File
                            </button>
                            <input id="filepincodes" type="file" name="filepincodes" style="display: none;"/></p>
                        <textarea name="frm[pincodes]" class="form-control input-sm"><?= set_value('frm[pincodes]', $p->pincodes); ?></textarea>
                        <span class="help-text">Format: TXT | Use one PIN per line <a
                                href="<?= site_url('assets/pincode.txt'); ?>" target="_blank">Sample File</a> </span>
                    </div>
                    <script type="text/javascript">                        
                        $(document).ready(function () {
                            $('#btnfile').click(function () {
                                $('#filepincodes').trigger('click');
                            });
                        });                    
                    </script>
                </div>
            </div>
           
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
                <input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary"/> 
                <a href="<?php echo admin_url('products'); ?>" class="btn btn-sm btn-danger">Cancel</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="box">
            <div class="pcate">
                <div class="box-header"><h4 class="box-title"><b>Categories</b></h4></div>
                <div class="box-p" style="max-height: 400px; overflow: auto;">
                    <?php
                    echo form_dropdown('frm[category]', $category, $p -> category, 'class="form-control input-sm"');
                    ?>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title"><b>Options</b></h4>
                </div>
                <div class="box-p">
                    <div class="form-group">
                        <label class="col-xs-6">Quantity</label>
                        <div class="col-sm-6">
                            <input type="text" name="frm[qty]" class="form-control input-sm" value="<?= set_value('frm[qty]', $p->qty); ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-6">Discount</label>
                        <div class="col-sm-6">
                            <label class="checkbox checkbox-inline"> 
                                <input type="checkbox" name="frm[discount]" value="1" <?php if ($p->discount == 1) echo ' checked'; ?> />
                                Yes </label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-6">Discount Amount</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" name="frm[discount_rate]" value="<?= set_value('frm[discount_rate]', $p->discount_rate); ?>" class="form-control input-sm"/> <select name="frm[discount_type]" class="form-control input-sm">
                                    <option value="1" <?php if ($p->discount_type == 1) echo ' selected'; ?>>Rs</option>
                                    <option value="2" <?php if ($p->discount_type == 2) echo ' selected'; ?>>%</option>
                                </select></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">    
    $('.img-preview').on('click', function (e) {
        $('.img-preview').removeClass('cover-img');
        $(this).addClass('cover-img');
        $('#cover_image').val($(this).attr('src'));
    });
</script>
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
<!-- <script type="text/javascript">    
    $('#brands').change(function () {
            var brand_id = $('#brands').val();        
    		//alert(brand_id);        
    		$.ajax({            
    		type: "POST",            
    		url: "<?php echo admin_url('products/mobile_models'); ?>",            
    		data: 'brand_id=' + brand_id,            
    		success: function(f){                
    		$('#models').empty().append(f);            
    		}        
    		});    
    		});    
    		
    		$('.btn-file-chooser').click(function(e){        
    		e.preventDefault();        
    		var tr = $(this).attr('data-target');        
    		$('.model-panel').hide();        
    		$(tr).show();    
        });
	</script> -->
        <!-- <script>
            $('#cust').click(function(){
                $("#cust1").show();
            });
            $('#custn').click(function(){
                $("#cust1").hide();
            });
        </script> -->


<script type="text/javascript">
function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'block';
    }
    else document.getElementById('ifYes').style.display = 'none';
}

function radio_show() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'block';
        //$('#ifyes').attr("checked") == true )
    }
    else document.getElementById('ifYes').style.display = 'none';
}

</script>
<script type="text/javascript">    
    $(document).ready(function () {
        $("#ptype").change(function () {
            var v = $(this).val();
            $.ajax({
                url: '<?= admin_url('products/ajaxLoadCategory'); ?>' + '/' + v,
                type: 'html',
                success: function (s) {
                    $('#pcatlist').html(s);
                }
            });
            $(this).find("option:selected").each(function () {
                if ($(this).attr("value") == "5") {
                    $("#pmobiles").show();
                    $(".mobiles").show();
                    $("#message").hide();
                    $(".clothes").hide();        
                }                
                else if($(this).attr("value")=="3"){                    
                        $("#message").show();                    
                        $(".clothes").show();                    
                        $("#pmobiles").hide();                    
                        $(".mobiles").hide();                    
                }                         
            });        
        });    
    });
</script>
<script type="text/javascript">  
      $(document).ready(function (e) {
        $('.fa-trash').click(function () {
            $imgsrc = $(this).data('src');
            var r = confirm("Are you sure want to delete this image!");
            if (r == false) {
                return false;
            }
            var v = $(this);
            $.ajax({
                type: "POST",
                url: '<?php echo admin_url('products/ajaximgdel'); ?>',
                data: {
                    imgsrc: $imgsrc,
                    pid: <?php echo $p -> id; ?>
                },   
                //data: 'imgsrc=' + $imgsrc,'pid=' +<?php echo $p -> id; ?>,               
                success: function(s){                    
                    v.parent().hide();                
                }            
            });        
        });    
    });
</script>
<script type="text/javascript" src="<?= site_url('js/ckeditor/ckeditor.js'); ?>"></script>
<script>
    CKEDITOR.replace( '.ckeditor' );
</script>


                