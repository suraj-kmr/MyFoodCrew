<div class="page-header">
	<h2><i class="fa fa-pencil"></i> Compose Email</h2>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php echo form_open(current_url(), array('class' => 'form-horizontal')); ?>
		<div class="form-group">
			<label class="col-sm-2 control-label">Email To</label>
			<div class="col-sm-4">
				<input type="email" name="data[email]" class="form-control" value="<?= set_value('data[email]', $data['email']); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Subject</label>
			<div class="col-sm-4">
				<input type="text" name="data[subject]" class="form-control" value="<?= set_value('data[subject]', $data['subject']); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Email Body</label>
			<div class="col-sm-8">
				<textarea rows="5" cols="" class="form-control ckeditor" name="data[description]"><?php echo set_value('data[description]', $data['description']); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2">&nbsp;</label>
			<div class="col-sm-3">
				<input type="submit" name="send_mail" value="Send Email" class="btn btn-sm btn-primary" />
				<a href="<?= $data['redirect_to']; ?>" class="btn btn-sm btn-default">Cancel</a>
				<input type="hidden" name="redirect_to" value="<?= $data['redirect_to']; ?>" />
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
