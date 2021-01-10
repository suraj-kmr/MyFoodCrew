<?php
/**
 * Created by PhpStorm.
 * User: Rohit
 * Date: 05/07/2017
 * Time: 3:55 PM
 */
?>
<div class="col-sm-12">
    <div class="page-header">
        <h3>Add / Edit URL</h3>
    </div>
</div>

<div class="col-sm-12">
    <?php echo form_open(admin_url('settings/seo/'.$url->id), array('class' => 'form-horizontal')); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">URL</label>
        <div class="col-sm-10">
            <input type="text" name="frm[url]" value="<?php echo set_value('frm[url]', $url->url); ?>" class="form-control input-sm" required="required" />
        </div>
    </div>
    <!--<div class="form-group">
        <label class="col-sm-2 control-label">H1 Tag</label>
        <div class="col-sm-10">
            <input type="text" name="h1_heading" value="<?php echo set_value('h1_heading', $url -> h1_heading); ?>" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Small Description</label>
        <div class="col-sm-10">
            <textarea name="small_desc" rows="3" cols="" class="form-control input-sm"><?php echo set_value('small_desc', $url->small_desc); ?></textarea>
        </div>
    </div>-->
    <div class="form-group">
        <label class="col-sm-2 control-label">SEO Title</label>
        <div class="col-sm-10">
            <input type="text" name="frm[seo_title]" value="<?php echo set_value('frm[seo_title]', $url->seo_title); ?>" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">SEO Description</label>
        <div class="col-sm-10">
            <textarea name="frm[seo_description]" rows="3" cols="" class="form-control input-sm"><?php echo set_value('frm[seo_description]', $url->seo_description); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">SEO Keywords</label>
        <div class="col-sm-10">
            <textarea name="frm[seo_keywords]" rows="3" cols="" class="form-control input-sm"><?php echo set_value('frm[seo_keywords]', $url->seo_keywords); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <input name="submit" type="submit" class="btn btn-sm btn-primary" value="Update" />
            <a href="<?php echo admin_url('settings/seo'); ?>" class="btn btn-sm btn-default">Cancel</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
