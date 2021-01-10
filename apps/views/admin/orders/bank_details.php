<div class="page-header">
	<h2>bank details</h2>
</div>
<div class="widget">
    <div class="widget-head">
        Return Orders Bank details
	</div>
	<div class="widget-content">
		<table class="table table-bordered table-striped table-text-centerd">
			<thead>
			<tr>
				<th>#ID</th>
				<th>Username</th>
				<th>Orderid</th>
				<th>Account no</th>
				<th>Account name</th>
                <th>IFSC code</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			     <?php
                 if(is_array($banks) && count($banks)){
                    $i=1;
                    foreach ($banks as $b) {
                        ?>
                        <tr>
                            <td><?=$i;?></td>
                            <td>
                                <?php
                                $username = $this->db->get_where('users',array('id'=>$b->user_id))->row();
                                echo $username->username;
                                ?>
                            </td>
                            <td><?=$b->order_id;?></td>
                            <td><?=$b->account_no;?></td>
                            <td><?=$b->account_name;?></td>
                            <td><?=$b->ifsc_code;?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                 }
                 ?>
			</tbody>
		</table>
	</div>
</div>
<div class="pagination pagination-small">
	<?= $paginate; ?>
</div>
