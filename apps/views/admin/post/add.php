<div class="page-header">
    <h2>Post Form</h2>
</div>
<?php
//print_r($p);
//print_r($parents);
?>
<?php echo form_open_multipart(admin_url('posts/add_post/' . $p -> id), array('class' => 'form-horizontal')); ?>
<div class="form-group">
    <label class="col-sm-2 control-label">Categories</label>
    <div class="col-sm-3">
        <select class="form-control" name="frm[category_id]">
        <?php
        //print_r($parents);
        if(is_array($parents) && count($parents) > 0) {
            foreach ($parents as $pp) {
                //echo $pp->name;
                        ?>
                        <option <?php if($pp->id==$p->category_id) echo "selected='selected'"; ?> value="<?php echo $pp->id; ?>"><?php echo $pp->name; ?></option>
                    <?php
            }
        }
        ?>
        </select>

    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Post Title</label>

    <div class="col-sm-8">
        <input type="text" name="frm[post_title]" value="<?php echo set_value('frm[post_title]', $p -> post_title); ?>"
               class="form-control input-sm malyalam" placeholder="Post Title">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Slug</label>

    <div class="col-sm-8">
        <input type="text" name="frm[slug]" class="form-control input-sm" placeholder="User Friendly Slug"
               value="<?php echo set_value('frm[slug]', $p -> slug); ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Excerpt</label>

    <div class="col-sm-8">
        <textarea rows="3" name="frm[excerpt]" cols="" class="form-control input-sm malyalam"
                  placeholder="Small Description about post"><?php echo set_value('frm[excerpt]', $p->excerpt); ?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Description</label>

    <div class="col-sm-10">
        <textarea class="form-control redactor ckeditor" name="frm[description]"><?php echo set_value('frm[description]', $p->description); ?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Featured Image</label>
    <div class="col-sm-8">
        <input type="file" name="image">
        <?php if($p->image != ''){ ?>
            <div style="text-align:center; padding:5px; border:1px solid #ddd;"><img src="<?php echo base_url('uploads/'.$p->image);?>" alt="current" class="img-responsive"/><br/>Current File<br />
            </div>
            <label class="checkbox">
                <input type="hidden" name="hid_image" value="<?php echo $p->image; ?>" />
                <input type="checkbox" name="del_image" value="1" />Delete this image
            </label>
        <?php }?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">SEO Title</label>

    <div class="col-sm-8">
        <input type="text" name="frm[seo_title]" class="form-control input-sm"
               value="<?php echo set_value('frm[seo_title]', $p->seo_title); ?>"/>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Meta Description</label>

    <div class="col-sm-8">
        <textarea name="frm[seo_description]" rows="3" cols=""
                  class="form-control input-sm"><?php echo set_value('frm[seo_description]', $p->seo_description); ?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Meta Keywords</label>

    <div class="col-sm-8">
        <textarea name="frm[seo_keywords]" rows="3" cols=""
                  class="form-control input-sm"><?php echo set_value('frm[seo_keywords]', $p->seo_keywords); ?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Status</label>

    <div class="col-sm-2">
        <?php
        echo form_dropdown('status', array(1 => 'Active', 0 => 'Deactive'), $p->status, 'class="form-control input-sm"');
        ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input type="hidden" name="submit" value="Submit"/>
        <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Save
        </button>
        <a href="<?php echo admin_url('posts'); ?>" class="btn btn-default btn-sm"><i
                class="glyphicon glyphicon-remove"></i> Cancel</a>
    </div>
</div>
</form>
<script type="text/javascript" src="<?= site_url('js/ckeditor/ckeditor.js'); ?>"></script>
<script>
    CKEDITOR.replace( '.ckeditor' );
</script>