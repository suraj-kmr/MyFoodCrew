<div class="page-header">
	<h2>Static Page</h2>
</div>
<div class="row">
	<?php echo form_open_multipart (admin_url ('pages/add/' . $p->id), array('class' => 'form-horizontal')); ?>
	<div class="col-sm-12">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Page
					Details</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="home">
				<div class="form-group">
					<label class="col-sm-2 control-label">Page Title</label>

					<div class="col-sm-10">
						<input type="text" name="frm[title]" value="<?= set_value ('frm[title]', $p->title); ?>"
						       class="form-control input-sm"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Slug</label>

					<div class="col-sm-10">
						<input type="text" name="frm[slug]" value="<?= set_value ('frm[slug]', $p->slug); ?>"
						       class="form-control input-sm"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Excerpt</label>

					<div class="col-sm-10">
						<textarea rows="4" cols="" class="form-control input-sm"
						          name="frm[excerpt]"><?= set_value ('frm[excerpt]', $p->excerpt); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Description</label>

					<div class="col-sm-10">
						<textarea rows="12" cols="" class="form-control input-sm  ckeditor" name="frm[content]"><?= set_value ('frm[content]', $p->content); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Image</label>
					<div class="col-sm-6">
						<input type="file" name="image" />
						<?php
						if($p -> image <> ''){
							?>
							<img src="<?= base_url('img/' . $p -> image); ?>" class="img-thumbnail img-responsive" /><br />
							<label class="checkbox checkbox-inline"><input type="checkbox" name="del_img" value="1" /> Delete Image</label>
							<input type="hidden" name="hid_img" value="<?= $p -> image; ?>" />

							<?php
						}
						?>
					</div>
					<label class="col-sm-2 control-label">Sequence</label>

					<div class="col-sm-2">
						<input type="text" name="frm[sequence]" value="<?= set_value('frm[sequence]', $p -> sequence); ?>" class="form-control input-sm" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">SEO Title</label>

					<div class="col-sm-10">
						<input type="text" name="frm[meta_title]"
						       value="<?= set_value ('frm[meta_title]', $p->meta_title); ?>"
						       class="form-control input-sm"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">SEO Descriptions</label>

					<div class="col-sm-10">
						<textarea rows="2" cols="" name="frm[meta_description]"
						          class="form-control input-sm"><?= set_value ('frm[meta_description]', $p->meta_description); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Sarching Keywords</label>

					<div class="col-sm-10">
						<textarea rows="2" cols="" name="frm[meta_keywords]"
						          class="form-control input-sm"><?= set_value ('frm[meta_keywords]', $p->meta_keywords); ?></textarea>
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
						echo form_dropdown ('frm[status]', $st, $p->status, 'class="form-control input-sm"');
						?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-8 col-sm-offset-2">
					<input type="submit" name="submit" value="Save" class="btn btn-sm btn-primary" />
					<a href="<?= admin_url('pages'); ?>" class="btn btn-sm btn-default">Cancel</a>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close (); ?>
</div>

<script type="text/javascript">
	$('.img-preview').on('click', function (e) {
		$('.img-preview').removeClass('cover-img');
		$(this).addClass('cover-img');
		$('#cover_image').val($(this).attr('src'));
	});
</script>
<script type="text/javascript" src="<?= site_url('js/ckeditor/ckeditor.js'); ?>"></script>
    <script>
        CKEDITOR.replace( '.ckeditor' );
    </script>
    