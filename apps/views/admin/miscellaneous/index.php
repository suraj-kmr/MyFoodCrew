<div class="row page-header">
    <div class="col-sm-6">
	    <h2>Miscellaneous </h2>
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
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
            <a href="<?= admin_url('miscellaneous/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Item</a>

        </div>
	</div>
<form id="frmsave" method="post" action="<?= admin_url('stock/bulksave'); ?>">
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
                    <th>Name</th>
                    <th>Type</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(is_array($miscellaneous) && count($miscellaneous) > 0){
                    foreach($miscellaneous as $p){
                        //$ob = new AI_Product($p -> id);
                        ?>
                        <tr>
                            <td class="center">
                                <input type="checkbox" class="checkb" value="<?php echo $p->id; ?>" name="ids[]" />
                            </td>
                            <td><?= $p -> id; ?></td>
                            <td><?php echo $p->name; ?></td>
                            <td><?php echo $p->type; ?></td>
                            <td>
                                <div class="btn-group pull-right">
                                    <a href="<?= admin_url('miscellaneous/add/'.$p->id); ?>" title="Edit" class="btn btn-xs"><i class="fa fa-edit"></i> </a>
                                    <a href="<?= admin_url('miscellaneous/delete/'. $p -> id); ?>" title="Delete" class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
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