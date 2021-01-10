<div class="page-header">
    <h2>Manage Posts <a href="<?= admin_url('posts/add-post'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Post</a> </h2>
</div>
<?php echo form_open('post/bulksave'); ?>
<div class="row">
    
    <div class="col-sm-12">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#ID</th>
                <th>Post Title</th>
                <th>Category</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sl = 1;
            
if(is_array($post_list) && count($post_list)){
            foreach($post_list as $row) {
               
                $p = New AI_Post($row->id);
                
                ?>
                <tr>
                    <td><?= $p->ID(); ?></td>
                    <td><a href="<?= $p->permalink(); ?>" target="_blank"><?= $p->title(); ?></a></td>
                    <td><?php $cat = $this->Blogcat_model->categoryName($p->data('category_id')); if($cat) echo $cat->name; ?> </td>
                    <td><?php
                        if ($p->status == 1) {
                            ?>
                            <a href="<?= admin_url('posts/deactivate/' . $p->ID()); ?>"
                               class="label label-success">Published</a>
                        <?php
                        } else {
                            ?>
                            <a href="<?= admin_url('posts/activate/' . $p->ID()); ?>"
                               class="label label-danger">Draft</a>
                        <?php
                        }
                        ?>
                    </td>
                    <td>
                        <div class="btn-group pull-right">

                            <a class="btn btn-xs btn-default"
                               href="<?= admin_url('posts/add-post/' . $p->ID()); ?>"><i
                                    class="fa fa-pencil"></i></a>

                            <a class="btn btn-xs btn-danger delete"
                               href="<?= admin_url('posts/delete/' . $p->ID()); ?>"><i class="fa fa-trash"></i></a>
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
