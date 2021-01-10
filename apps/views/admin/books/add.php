<div class="page-header">

    <h2>Products Type</h2>

</div>

<?php //print_r($p); ?>

<div class="row">

<?php echo form_open_multipart(admin_url('books/add/'.$p -> id), array('class' => 'form-horizontal')); ?>
<input type="hidden" name="frm[product_type]" value="2" />
<div class="col-sm-9">
<div class="tab-content">

    <div class="form-group">

        <label class="col-sm-2 control-label">Product Title</label>

        <div class="col-sm-10">

            <input type="text" name="frm[ptitle]" value="<?= set_value('frm[ptitle]', $p -> ptitle); ?>" class="form-control input-sm" />

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">Slug</label>

        <div class="col-sm-6">

            <input type="text" name="frm[slug]" value="<?= set_value('frm[slug]', $p -> slug); ?>" class="form-control input-sm" />

        </div>

        <label class="col-sm-2 control-label">ISBN</label>

        <div class="col-sm-2">

            <input type="text" name="frm1[isbn]" value="<?= set_value('frm[isbn]', $book -> isbn); ?>" class="form-control input-sm" />

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">Excerpt</label>

        <div class="col-sm-10">

            <textarea rows="4" cols="" class="form-control input-sm" name="frm[short_description]"><?= set_value('frm[short_description]', $p -> short_description); ?></textarea>

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">Description</label>

        <div class="col-sm-10">

            <textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[description]"><?= set_value('frm[description]', $p -> description); ?></textarea>

        </div>

    </div>



    <div class="form-group">

        <label class="col-sm-2 control-label">Feature</label>

        <div class="col-sm-10">

            <textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[feature]"><?php if($p -> feature) { ?><?= set_value('frm[feature]', $p -> feature); ?><?php } else{ echo "<ul><li>Feature 1</li><li>Feature 2</li><li>Feature 3</li><li>Feature 4 </li><li>Feature 5</li></ul>"; } ?></textarea>

        </div>

    </div>



    <div class="form-group">

        <label class="col-sm-2 control-label">Delivery &amp; Return</label>

        <div class="col-sm-10">

            <textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[delivery_info]"><?= set_value('frm[delivery_info]', $p -> delivery_info); ?></textarea>

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">Price</label>

        <div class="col-sm-2">

            <input type="text" name="frm[price]" value="<?= set_value('frm[price]', $p -> price); ?>" class="form-control input-sm" />

        </div>

        <label class="col-sm-2 control-label">Sale Price</label>

        <div class="col-sm-2">

            <input type="text" name="frm[sale_price]" value="<?= set_value('frm[sale_price]', $p -> sale_price); ?>" class="form-control input-sm" />

        </div>

        <label class="col-sm-2 control-label">Available</label>

        <div class="col-sm-2">

            <label class="checkbox-inline">

                <input type="checkbox" name="frm[available]" value="1" <?php if($p -> available == 1) echo 'checked'; ?> /> Yes

            </label>

        </div>

    </div>



    <div class="form-group">

        <label class="col-sm-2 control-label">SEO Title</label>

        <div class="col-sm-10">

            <input type="text" name="frm[meta_title]" value="<?= set_value('frm[meta_title]', $p -> meta_title); ?>" class="form-control input-sm" />

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">SEO Descriptions</label>

        <div class="col-sm-10">

            <textarea rows="2" cols="" name="frm[meta_description]" class="form-control input-sm"><?= set_value('frm[meta_description]', $p -> meta_description); ?></textarea>

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">Searching Keywords</label>

        <div class="col-sm-10">

            <textarea rows="2" cols="" name="frm[meta_keywords]" class="form-control input-sm"><?= set_value('frm[meta_keywords]', $p -> meta_keywords); ?></textarea>

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2 control-label">Status</label>

        <div class="col-sm-3">

            <?php

            $st = array(

                1 => 'Active',

                0 => 'Deactive'

            );

            echo form_dropdown('frm[status]', $st, $p -> status, 'class="form-control input-sm"');

            ?>

        </div>

    </div>

<!---------------->

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-3">
                <label>Cover Image</label>
                <input type="file" onclick="getFilePath();" name="cover_image" id="file_name">
                <script type="text/javascript">
                    function getFilePath(){
                        $('input[type=file]').change(function () {
                            var filePath=$('#file_name').val().split('\\').pop().split('/').pop();
                            var fname = 'https://images-aldivo.com/img/uploads/';
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
                if(is_object($os) && count($os) > 0) {
                    foreach ($os->images() as $img) {
                        $imga[] = $img;
                    }
                }
            }

            ?>
            <div class="col-sm-3">
                <label>Image 1</label>
                <input type="file" onclick="getFilePath1();" name="image1" id="file_name1">
                <script type="text/javascript">
                    function getFilePath1(){
                        $('input[type=file]').change(function () {
                            var filePath1=$('#file_name1').val().split('\\').pop().split('/').pop();
                            var fname1 = 'https://images-aldivo.com/img/uploads/';
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
                            var fname2 = 'https://images-aldivo.com/img/uploads/';
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
                            var fname3 = 'https://images-aldivo.com/img/uploads/';
                            $('#img4').val(fname3+filePath3);
                        });
                    }
                </script>
                <input type="text" name="txt_image4" id="img4" value="<?php if(!$p->id=='') echo $imga[3]; ?>"  />
            </div>
            <p>&nbsp;</p>
        </div>
    </div>

<!--<div class="row">

    <div class="col-sm-12">
        <div class="col-sm-3">
            <label>Cover Image</label>
            <input type="file" onclick="getFilePath();" name="cover_image" id="file_name">
            <script type="text/javascript">
                function getFilePath(){
                    $('input[type=file]').change(function () {
                        var filePath=$('#file_name').val().split('\\').pop().split('/').pop();
                        var fname = '<?/*= site_url(upload_dir()); */?>/';
                        $('#img1').val(fname+filePath);
                        //alert(fname+filePath);
                    });
                }
            </script>
            <input type="text" name="txt_image1" id="img1" value="<?php /*if($p->image !='') echo $p->image; */?>"  />
        </div>
        <?php
/*        if(!$p->id==''){
            $os = new AI_Product($p->id);
            if(is_object($os) && count($os) > 0) {
                foreach ($os->images() as $img) {
                    $imga[] = $img;
                }
            }
        }

        */?>
        <div class="col-sm-3">
            <label>Image 1</label>
            <input type="file" onclick="getFilePath1();" name="image1" id="file_name1">
            <script type="text/javascript">
                function getFilePath1(){
                    $('input[type=file]').change(function () {
                        var filePath1=$('#file_name1').val().split('\\').pop().split('/').pop();
                        var fname1 = '<?/*= site_url(upload_dir()); */?>/';
                        $('#img2').val(fname1+filePath1);
                        //alert(fname1+filePath1);
                    });
                }
            </script>
            <input type="text" name="txt_image2" id="img2" value="<?php /*if(!$p->id=='') echo $imga[1]; */?>" />
        </div>
        <div class="col-sm-3">
            <label>Image 2</label>
            <input type="file" onclick="getFilePath2();" name="image2" id="file_name2">
            <script type="text/javascript">
                function getFilePath2(){
                    $('input[type=file]').change(function () {
                        var filePath2=$('#file_name2').val().split('\\').pop().split('/').pop();
                        var fname2 = '<?/*= site_url(upload_dir()); */?>/';
                        $('#img3').val(fname2+filePath2);
                        //alert(fname1+filePath1);
                    });
                }
            </script>
            <input type="text" name="txt_image3" id="img3" value="<?php /*if(!$p->id=='') echo $imga[2]; */?>"  />
        </div>
        <div class="col-sm-3">
            <label>Image 3</label>
            <input type="file" onclick="getFilePath3();" name="image3" id="file_name3">
            <script type="text/javascript">
                function getFilePath3(){
                    $('input[type=file]').change(function () {
                        var filePath3=$('#file_name3').val().split('\\').pop().split('/').pop();
                        var fname3 = '<?/*= site_url(upload_dir()); */?>/';
                        $('#img4').val(fname3+filePath3);
                    });
                }
            </script>
            <input type="text" name="txt_image4" id="img4" value="<?php /*if(!$p->id=='') echo $imga[3]; */?>"  />
        </div>
        <p>&nbsp;</p>
    </div>

</div>-->



    <div id="pmobiles">
        <div class="form-group">
            <label class="col-sm-2">Author</label>
            <div class="col-sm-4">
                <?php
                $selected = $book->author;
                $d = array(
                    '' => 'Select Author'
                );
                if(is_array($author) && count($author) > 0){
                    foreach($author as $b){
                        $d[$b -> id] = $b -> title;
                    }
                }
                echo form_dropdown('frm1[author]', $d, set_value('frm1[author]', $selected), 'class="form-control input-sm"');
                ?>
            </div>

            <label class="col-sm-2">Publisher</label>

            <div class="col-sm-4">
                <select id="models" name="frm1[publisher]" class="form-control input-sm">
                    <option value="">Select Publisher</option>
                    <?php

                        if(is_array($publisher) && count($publisher) > 0){
                            foreach($publisher as $ab){
                                ?>
                                <option value="<?= $ab -> id; ?>" <?php if($book -> publisher == $ab -> id) echo "Selected"; ?>><?= $ab -> title; ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>

            </div>

        </div>

        <div class="form-group">

            <label class="col-sm-2">Language</label>

            <div class="col-sm-4">
                <?php
                $selected = $book->language;
                $d = array(
                    '' => 'Select Language'
                );
                if(is_array($language) && count($language) > 0){
                    foreach($language as $b){
                        $d[$b -> id] = $b -> title;
                    }
                }
                echo form_dropdown('frm1[language]', $d, set_value('frm1[language]', $selected), 'class="form-control input-sm"');
                ?>
            </div>

            <label class="col-sm-2">Binding</label>

            <div class="col-sm-4">

                <input type="text" name="frm1[binding]" class="form-control input-sm" value="<?= set_value('frm1[bindind]', $book -> binding); ?>" />

            </div>

        </div>

        <div class="form-group">

            <label class="col-sm-2 control-label">Specification</label>

            <div class="col-sm-10">

                <textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[specification]"><?= set_value('frm[specification]', $p -> specification); ?></textarea>

            </div>

        </div>

        <div class="form-group">

            <label class="col-sm-2 control-label">Highlights</label>

            <div class="col-sm-10">

                <textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[highlights]"><?= set_value('frm[highlights]', $p -> highlights); ?></textarea>

            </div>

        </div>

    </div>


    <div class="form-group">

        <label class="col-sm-2">Shipping Charge</label>

        <div class="col-sm-3">

            <input type="text" name="frm[ship_charge]" class="form-control input-sm" value="<?= set_value('frm[ship_charge]', $p -> ship_charge); ?>" />

        </div>
        <label class="col-sm-2">Delivery Notes</label>

        <div class="col-sm-5">

            <input type="text" name="frm[ship_notes]" class="form-control input-sm" value="<?= set_value('frm[ship_notes]', $p -> ship_notes); ?>" />

        </div>

    </div>

    <div class="form-group">



    </div>
    <!--
    <div class="form-group">

        <label class="col-sm-2">COD Available:</label>

        <div class="col-sm-10">

            <label class="checkbox checkbox-inline">

                <input type="checkbox" name="cod_available" value="1" /> Yes

            </label>

        </div>

    </div>

    <div class="form-group">

        <label class="col-sm-2">Pincodes</label>

        <div class="col-sm-10">

            <p><button type="button" class="btn btn-xs btn-info" id="btnfile"><i class="fa fa-upload"></i> TXT File</button>

                <input id="filepincodes" type="file" name="filepincodes" style="display: none;" /></p>

            <textarea name="frm[pincodes]" class="form-control input-sm"><?= set_value('frm[pincodes]', $p -> pincodes); ?></textarea>

            <span class="help-text">Format: TXT | Use one PIN per line <a href="<?= site_url('assets/pincode.txt'); ?>" target="_blank">Sample File</a> </span>

        </div>

        <script type="text/javascript">

            $(document).ready(function(){

                $('#btnfile').click(function(){

                    $('#filepincodes').trigger('click');

                });

            });

        </script>

    </div>
-->


</div>





<div class="form-group">

    <label class="col-sm-2 control-label">&nbsp;</label>

    <div class="col-sm-10">

        <input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary" />

        <a href="<?php echo admin_url('products'); ?>" class="btn btn-sm btn-default">Cancel</a>

    </div>

</div>

</div>

<div class="col-sm-3">

    <div class="box">

        <div class="pcate">
            <div class="box-header">

                <h4 class="box-title"><b>Gift</b> </h4>

            </div>

            <div class="box-p" style="max-height: 400px; overflow: auto;">
                <select name="frm[event]" class="form-control">
                    <option value="">Select Gift</option>
                    <?php
                    $gift = $this -> Master_model -> listAll('ai_event');
                    if(is_array($gift) && count($gift) > 0){
                        foreach($gift as $gf){
                            ?>
                            <option <?php if($gf->id==$p->event) echo "selected"; ?> value="<?= $gf->id; ?>"><?= $gf->event_name; ?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="box-header">

                <h4 class="box-title"><b>Campus Store</b> </h4>

            </div>

            <div class="box-p" style="max-height: 400px; overflow: auto;">
                <select name="frm[campus_id]" class="form-control">
                    <option value="">Select Campus</option>
                    <?php
                    $gift = $this -> Master_model -> listAll('campus');
                    if(is_array($gift) && count($gift) > 0){
                        foreach($gift as $gf){
                            ?>
                            <option <?php if($gf->id==$p->campus_id) echo "selected"; ?> value="<?= $gf->id; ?>"><?= $gf->title; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="box-header">

                <h4 class="box-title"><b>Categories</b> </h4>

            </div>

            <div class="box-p" style="max-height: 400px; overflow: auto;">

                <ul id="pcatlist" class="products-cats">

                    <?php
                    //print_r($p->cats);
                    function list_categories($cats, $sub='', $pcats) {
                        foreach ($cats as $cat):?>
                            <li><label class="checkbox checkbox-inline">
                                    <input type="checkbox" name="cats[]" value="<?php echo  $cat['category'] -> id; ?>" <?php if(in_array($cat['category'] -> id, $pcats)) echo ' checked'; ?> />
                                    <?php echo  $sub.$cat['category'] -> name; ?></label> </li>
                            <?php
                            if (sizeof($cat['children']) > 0)
                            {
                                $sub2 = str_replace('&rarr;&nbsp;', '&nbsp;', $sub);
                                $sub2 .=  '&nbsp;&nbsp;&nbsp;&rarr;&nbsp;';

                                list_categories($cat['children'], $sub2, $pcats);
                            }
                        endforeach;
                    }
//$type = array('product_type'=> 2);
                    list_categories($categories, '', $p->cats);
                    ?>

                </ul>

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

                        <input type="text" name="frm[qty]" class="form-control input-sm" value="<?= set_value('frm[qty]', $p -> qty); ?>" />

                    </div>

                </div>

                <div class="form-group">

                    <label class="col-xs-6">Discount</label>

                    <div class="col-sm-6">

                        <label class="checkbox checkbox-inline">

                            <input type="checkbox" name="frm[discount]" value="1" <?php if($p -> discount == 1) echo ' checked'; ?> /> Yes

                        </label>

                    </div>

                </div>

                <div class="form-group">

                    <label class="col-xs-6">Discount Amount</label>

                    <div class="col-sm-6">

                        <div class="input-group">

                            <input type="text" name="frm[discount_rate]" value="<?= set_value('frm[discount_rate]', $p -> discount_rate); ?>" class="form-control input-sm" />

                            <select name="frm[discount_type]" class="form-control input-sm">

                                <option value="1" <?php if($p -> discount == 1) echo ' selected'; ?>>Rs</option>

                                <option value="2" <?php if($p -> discount == 2) echo ' selected'; ?>>%</option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php echo form_close(); ?>

</div>

</div>



<script type="text/javascript">

    $('.img-preview').on('click', function(e){

        $('.img-preview').removeClass('cover-img');

        $(this).addClass('cover-img');

        $('#cover_image').val($(this).attr('src'));

    });

</script>

<script type="text/javascript">

    $('.btn-file-chooser').click(function(e){

        e.preventDefault();

        var tr = $(this).attr('data-target');

        $('.model-panel').hide();

        $(tr).show();

    });

</script>

<script type="text/javascript">

    $(document).ready(function(e) {

        $('.fa-trash').click(function(){

            $imgsrc = $(this).data('src');

            var r = confirm("Are you sure want to delete this image!");

            if (r == false) {

                return false;

            }

            var v = $(this);

            $.ajax({

                type: "POST",

                url: '<?php echo admin_url('products/ajaximgdel'); ?>',

                data: { imgsrc: $imgsrc, pid: <?php echo $p -> id; ?> },

                //data: 'imgsrc=' + $imgsrc,'pid=' +<?php echo $p -> id; ?>,

                success: function(s){

                    v.parent().hide();

                }

            });

        });

    });

</script>