<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-sm-5">
        <form method="get" action="<?= admin_url ('tech_accessories/material'); ?>">
            <div class="input-group">
                <input type="search" name="q" value="" placeholder="e.g Material"
                       class="form-control input-sm"/>
                <div class="input-group-btn">
                    <button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form><p>&nbsp;</p>
    </div>
    <div class="col-sm-5 pull-right">
        <a class="btn btn-success" href="<?= admin_url('tech_accessories/material_add'); ?>">Add New Material</a>
    </div>
</div>
	<div class="box">

		<div class="table-responsive">
			<table class="table table-bordered table-hover" id="admin-list-page">
				<thead>
				<tr>
					<th class="center">#ID</th>
					<th>Material</th>
					<th class="center"></th>
				</tr>
				</thead>
				<tbody>
                <?php
                if(is_array($material) && count($material) > 0) {
                    foreach ($material as $material) {
                        ?>
                        <tr>
                            <td><?= $material->id; ?></td>
                            <td><?= $material->title; ?></td>
                            <td><a href="<?= admin_url('tech_accessories/material_add/'.$material->id); ?>"><i class="fa fa-edit"></i> </a> <a class="delete" href="<?= admin_url('tech_accessories/mdelete/'.$material->id); ?>"><i class="fa fa-trash"></i> </a> </td>
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