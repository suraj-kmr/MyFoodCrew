<div class="page-header">
	<h2>Email Message</h2>
</div>
<div class="row-fluid">
	<table class="table table-bordered">
    	<tbody>
        	<tr>
            	<th colspan="2">Email Message @ <?php echo date('jS-M-Y', strtotime($email['created'])); ?></th>
            </tr>
            <tr>
            	<th>Email From : </th>
                <td><?php echo $email['msg_from']; ?></td>
            </tr>
             <tr>
            	<th>Subject : </th>
                <td><?php echo $email['msg_subject']; ?></td>
            </tr>
             <tr>
            	<th>Message : </th>
                <td><?php echo $email['msg_details']; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div><a href="<?php echo base_url('emails'); ?>" class="btn btn-primary">Close</a></div>
