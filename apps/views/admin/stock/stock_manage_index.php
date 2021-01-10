<div class="row page-header">
    <div class="col-sm-6">
        <h2>Manage Stock </h2>
    </div>

    <div class="col-sm-6">
        <a href="javascript:void(0);" onclick="submit('delete')" style="margin-right: 10px" class="btn btn-sm btn-danger action pull-right tooltips" title="Delete"> <i class="fa fa-trash"></i> Delete Selected</a>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('.box-status input').on('click', function(){
            var v = $(this).val();
            if(v == 1){
                window.location.href="<?= admin_url('stock/index?status=active'); ?>"
            }else if(v == 0){
                window.location.href="<?= admin_url('stock/index?status=inactive'); ?>"
            }else{
                window.location.href="<?= admin_url('stock/index'); ?>"
            }
        });
        $('.btn-save-all').on('click', function(){
            $('#frmsave').submit();
        });
    });
</script>

	<div class="row form-search">
		<div class="col-sm-6">
            <form method="get" action="<?= admin_url ('stock_manage'); ?>">
			<div class="input-group">
				<input type="search" name="q" value="<?= $q; ?>" placeholder="e.g Product Design, ID, SKU"
				       class="form-control input-sm"/>

				<div class="input-group-btn">
					<button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i
							class="fa fa-search"></i> Search
					</button>
				</div>
			</div>
            </form>
		</div>
        <div class="col-sm-6">
            <a href="#" style="margin-left: 5px" class="btn btn-sm btn-warning pull-right btn-save-all"><i class="fa fa-save"></i> Save All</a>
            <a href="<?= admin_url('stock_manage/import_files'); ?>" style="margin-left:5px;" class="btn btn-sm btn-warning pull-right"> <i class="fa fa-upload"></i> Import File</a>
            <a href="<?= admin_url('stock_manage/export'); ?>" style="margin-left:5px;" class="btn btn-sm btn-warning pull-right"> <i class="fa fa-upload"></i> Export File</a>

            <a href="<?= admin_url('stock_manage/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Stock Item</a>

        </div>
	</div>
<form id="frmsave" method="post" action="<?= admin_url('stock_manage/bulksave'); ?>">
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
                    <th>ID</th>
                    <th>Rake Code</th>
                    <th>Name</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(is_array($stock) && count($stock) > 0){
                    foreach($stock as $p){
                        //$ob = new AI_Product($p -> id);
                        ?>
                        <tr>
                            <td class="center">
                                <input type="checkbox" class="checkb" value="<?php echo $p->id; ?>" name="ids[]" />
                            </td>
                            <td><?= $p -> id; ?></td>
                            <td><?php echo $p->rake_code; ?></td>
                            <td><?php echo $p->name; ?></td>
                            <td><input type="number" name="quantity[<?= $p->id; ?>]"  value="<?= $p -> quantity; ?>" class="form-control input-sm" style="width: 70px;" /> </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <!-- <a href="#" title="Save" class="btn btn-xs btn-warning"><i class="fa fa-save"></i> </a> -->
                                    <a href="<?= admin_url('stock_manage/add/'. $p -> id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
                                    <a href="<?= admin_url('stock_manage/delete/'. $p -> id); ?>" title="Delete" class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
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
            var url = '<?php echo admin_url('stock_manage'). '/'; ?>' + type;
            $('#frmsave').attr('action', url).submit();
        } else {
            return false;
            //alert("You are safe!");
        }

    }
</script>