<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-sm-5">
        <form method="get" action="<?= admin_url ('office/theme'); ?>">
            <div class="input-group">
                <input type="search" name="q" value="" placeholder="e.g Theme"
                       class="form-control input-sm"/>
                <div class="input-group-btn">
                    <button type="submit" name="btnsearch" value="Search" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form><p>&nbsp;</p>
    </div>
    <div class="col-sm-5 pull-right">
        <a class="btn btn-success" href="<?= admin_url('office/theme_add'); ?>">Add New Theme</a>
    </div>
</div>
	<div class="box">

		<div class="table-responsive">
			<table class="table table-bordered table-hover" id="admin-list-page">
				<thead>
				<tr>
					<th class="center">#ID</th>
					<th>Theme</th>
					<th class="center"></th>
				</tr>
				</thead>
				<tbody>
                <?php
                if(is_array($theme) && count($theme) > 0) {
                    foreach ($theme as $theme) {
                        ?>
                        <tr>
                            <td><?= $theme->id; ?></td>
                            <td><?= $theme->title; ?></td>
                            <td><a href="<?= admin_url('office/theme_add/'.$theme->id); ?>"><i class="fa fa-edit"></i> </a> <a class="delete" href="<?= admin_url('office/tdelete/'.$theme->id); ?>"><i class="fa fa-trash"></i> </a> </td>
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