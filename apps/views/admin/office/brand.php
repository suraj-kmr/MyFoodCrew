<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-sm-5">
        <form method="get" action="<?= admin_url ('office/brand'); ?>">
            <div class="input-group">
                <input type="search" name="q" value="" placeholder="e.g Brand"
                       class="form-control input-sm"/>
                <div class="input-group-btn">
                    <button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form><p>&nbsp;</p>
    </div>
    <div class="col-sm-5 pull-right">
        <a class="btn btn-success" href="<?= admin_url('office/brand_add'); ?>">Add New Brand</a>
    </div>
</div>
	<div class="box">

		<div class="table-responsive">
			<table class="table table-bordered table-hover" id="admin-list-page">
				<thead>
				<tr>
					<th class="center">#ID</th>
					<th>Author</th>
					<th class="center"></th>
				</tr>
				</thead>
				<tbody>
                <?php
                if(is_array($brand) && count($brand) > 0) {
                    foreach ($brand as $brand) {
                        ?>
                        <tr>
                            <td><?= $brand->id; ?></td>
                            <td><?= $brand->title; ?></td>
                            <td><a href="<?= admin_url('office/brand_add/'.$brand->id); ?>"><i class="fa fa-edit"></i> </a> <a class="delete" href="<?= admin_url('office/bdelete/'.$brand->id); ?>"><i class="fa fa-trash delete"></i> </a> </td>
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
<div class="row">
	<div class="dataTables_paginate paging_bootstrap pull-right">
		<div class="col-md-12">
		<?php echo $links;?>
		</div>
	</div>
</div>