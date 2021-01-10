<div class="row">
    <div class="col-sm-3">
        <div class="page-header">
            <h2>Manage Products </h2>
        </div>
    </div>
    <div class="col-sm-2"><a href="<?= admin_url('products/upload_pin'); ?>" class="btn btn-sm btn-warning pull-right btn-save-all"><i class="fa fa-save"></i> Upload Pin</a></div>
    <div class="col-sm-2"><a href="<?= admin_url('products/update_files'); ?>" class="btn btn-sm btn-warning pull-right btn-save-all"><i class="fa fa-save"></i> Update Product File</a></div>

    <div class="col-sm-3">
        <a class="btn btn-success" href="<?= admin_url('tech_accessories/export_all'); ?>">Export All Products</a>
    </div>

    <div class="col-sm-2">
        <a href="javascript:void(0);" onclick="submit1('export_selected');" class="btn btn-sm btn-warning pull-right"> Export Selected Products </a>
    </div>

    <div class="col-sm-2">
    </div>
</div>

<div class="box box-header box-status">
    Filters: Listing status
    <label class="checkbox-inline">
        <input name="status" type="radio" value="-1" <?php if($filter_status == 'all') echo 'checked="checked"'; ?>> All
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="1" <?php if($filter_status == 'active') echo 'checked="checked"'; ?>> Active
    </label>
    <label class="checkbox-inline">
        <input name="status" type="radio" value="0" <?php if($filter_status == 'inactive') echo 'checked="checked"'; ?>> Inactive
    </label>
    <label class="checkbox-inline"><form name="show" method="get" action="<?= admin_url('tech_accessories'); ?>">

            <label class="checkbox-inline">
                <select name="show_page">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
                <?php
                $v = $_GET;
                foreach($v as $k => $v){
                    if($k == 'show_page') continue;
                    echo '<input type="hidden" name="'.$k.'" value="'.$v .'"/>';

                }
                ?>
            </label>
        </form></label>

    <a href="<?= admin_url('tech_accessories/import_files'); ?>" style="margin-left:5px;" class="btn btn-sm btn-warning pull-right"> <i class="fa fa-upload"></i> Import File</a>
    <a href="<?= admin_url('tech_accessories/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Tech Accessories Product</a>

</div>
<script type="text/javascript">
    $(document).ready(function(){
        //document.show.submit();
        $('.box-status input').on('click', function(){
            var v = $(this).val();
            if(v == 1){
                window.location.href="<?= admin_url('tech_accessories/index?status=active'); ?>"
            }else if(v == 0){
                window.location.href="<?= admin_url('tech_accessories/index?status=inactive'); ?>"
            }else{
                window.location.href="<?= admin_url('tech_accessories/index'); ?>"
            }
        });

        $('.box-status select').on('change', function(){
            document.show.submit();
        });
        $('.btn-save-all').on('click', function(){
            $('#frmsave').submit();
        });
    });
</script>

<div class="row form-search">
    <div class="col-sm-6">
        <form method="get" action="<?= admin_url ('tech_accessories'); ?>">
            <div class="input-group">
                <input type="search" name="q" value="<?= $q; ?>" placeholder="e.g Product Title, ID, SKU" class="form-control input-sm"/>

                <div class="input-group-btn">
                    <button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
                            class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-6">
        <div class="col-sm-4">
            <a href="javascript:void(0);" onclick="submit('delete')" style="margin-right: 10px" class="btn btn-sm btn-danger action pull-right tooltips" title="Delete"> <i class="fa fa-trash"></i> Delete Selected</a>
        </div>
        <div class="col-sm-4">
            <a href="#" class="btn btn-sm btn-warning pull-right btn-save-all"><i class="fa fa-save"></i> Save All</a>
        </div>

    </div>
</div>
<form id="frmsave" method="post" action="<?= admin_url('tech_accessories/bulksave'); ?>">
    <input type="hidden" name="frmall" value="Save All" />
    <input type="hidden" name="url" value="<?= current_url(); ?>" />
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="center" width="5%">
                        <input type="checkbox" onclick="dgUI.checkAll(this)" id="select_all">
                    </th>
                    <th>Ad #</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>SKU</th>
                    <th>Ad Title</th>
                    <th>Sequence</th>
                    <th>Sale Price</th>
                    <th>Shipping</th>
                    <th>Available</th>
                    <th>Offer</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(is_array($products) && count($products) > 0){
                    foreach($products as $p){
                        $ob = new AI_Product($p -> id);
                        ?>
                        <tr>
                            <td class="center">
                                <input type="checkbox" class="checkb" value="<?php echo $p->id; ?>" name="ids[]" />
                            </td>
                            <td><?= $p -> id; ?></td>
                            <td>
                                <?php
                                if($p -> status == 1){
                                    ?>
                                    <a href="<?= admin_url('tech_accessories/deactivate/' . $p -> id, true); ?>" class="label label-success">Active</a>
                                <?php
                                }else{
                                    ?>
                                    <a href="<?= admin_url('tech_accessories/activate/' . $p -> id, true); ?>" class="label label-danger">Deactive</a>
                                <?php
                                }
                                ?>
                            </td>
                            <td><?= $ob -> image('sm', array('class' => 'img-responsive img-admin-sm')) ;?></td>
                            <td><?= $p -> sku; ?></td>
                            <td><a href="<?= $ob -> permalink(); ?>" target="_blank"><?= $p -> ptitle; ?></a></td>
                            <td>
                                <input type="number" name="sequence[<?= $ob -> ID(); ?>]"  value="<?= $p -> sequence; ?>" class="form-control input-sm" style="width: 60px;"/>
                            </td>
                            <td><input type="number" name="pid[<?= $ob -> ID(); ?>]"  value="<?= $p -> sale_price; ?>" class="form-control input-sm" style="width: 60px;" /> </td>
                            <td><input type="number" name="ship[<?= $ob -> ID(); ?>]"  value="<?= $p -> ship_charge; ?>" class="form-control input-sm" style="width: 60px;"/> </td>
                            <td><input type="number" name="qty[<?= $ob -> ID(); ?>]"  value="<?= $p -> qty; ?>" class="form-control input-sm" style="width: 60px;"/> </td>
                            <td><input type="number" name="offer[<?= $ob -> ID(); ?>]"  value="<?= $p -> offer; ?>" class="form-control input-sm" style="width: 60px;"/> </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <!-- <a href="#" title="Save" class="btn btn-xs btn-warning"><i class="fa fa-save"></i> </a> -->
                                    <a href="<?= admin_url('tech_accessories/add/'. $p -> id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
                                    <a href="<?= admin_url('tech_accessories/delete/'. $p -> id); ?>" title="Delete" class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>
</form>
<div class="pagination">
    <?php echo $paginate; ?>
</div>
<script>
    var select_all = document.getElementById("select_all"); //select all checkbox
    var checkboxes = document.getElementsByClassName("checkb"); //checkbox items

    //select all checkboxes
    select_all.addEventListener("change", function(e){
        for (i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = select_all.checked;
        }
    });

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(this.checked == false){
                select_all.checked = false;
            }
            //check "select all" if all checkbox items are checked
            if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
                select_all.checked = true;
            }
        });
    }
</script>
<script type="text/javascript">

    function submit(type){
        var ids = '';
        $('.checkb').each(function(){
            if (jQuery(this).is(':checked'))
            {
                if (ids == '') ids = jQuery(this).val();
                else ids = ids + '-' + jQuery(this).val();
            }
        });
        if (ids == ''){
            alert('Select Checkbox');
            return;
        }
        var r = confirm("Are you sure want to delete");
        if (r == true) {
            var url = '<?php echo admin_url('tech_accessories'). '/'; ?>' + type;
            $('#frmsave').attr('action', url).submit();
        } else {
            return false;
            //alert("You are safe!");
        }

    }

    function submit1(type){
        var ids = '';
        $('.checkb').each(function(){
            if (jQuery(this).is(':checked'))
            {
                if (ids == '') ids = jQuery(this).val();
                else ids = ids + '-' + jQuery(this).val();
            }
        });
        if (ids == ''){
            alert('Select Checkbox');
            return;
        }

    }
</script>