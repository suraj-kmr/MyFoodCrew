<div class="page-header">
    <h2>Store Page Text</h2>
</div>
<?php echo form_open_multipart(admin_url('city/addstore_text/'.$id), array('class' => 'form-horizontal')); ?>
<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#description_tab" data-toggle="tab">Text</a></li>
    </ul>
    <div>&nbsp;</div>
    <div class="tab-content">
        <div class="tab-pane active" id="description_tab">
            <div class="form-group">
                <label class="col-sm-1">Text</label>
                <div class="col-sm-11">

                    <textarea class="form-control ckeditor" rows="25" name="form[description]"><?php  echo set_value('description', $store_text->description); ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2">&nbsp;</label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    $('form').submit(function() {
        $('.btn').attr('disabled', true).addClass('disabled');
    });
</script>
<script type="text/javascript" src="<?= site_url('js/ckeditor/ckeditor.js'); ?>"></script>
<script>
    CKEDITOR.replace( '.ckeditor' );
</script>