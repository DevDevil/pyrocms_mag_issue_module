<div class="box">

	<h3><?php //echo lang('cat_list_title');?>LIST ISSUES</h3>
	
	<div class="box-container">
	
		<?php echo form_open('admin/issues/delete'); ?>
			<table border="0" class="table-list">
				<thead>
				<tr>
					<th class="width-5"><?php echo form_checkbox('action_to_all');?></th>
					<th><?php echo lang('issue_label');?></th>
					<th><?php echo lang('issue_status_label');?></th>
					<th class="width-10"><span><?php echo lang('issue_actions_label');?></span></th>
				</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="3">
							<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>  
				<?php if ($issues): ?>
					<?php foreach ($issues as $issue): ?>
					<tr>
						<td><?php echo form_checkbox('action_to[]', $issue->issue_id); ?></td>
						<td>Issue : <?php echo $issue->total_issue_no.', '.ucfirst($issue->nepali_month).' - ',$issue->nepali_year;?> </td>
						<td>
                                                    <?php
                                                    if ($issue->status == 0 && $issue->is_current == 0){
                                                        echo "Draft - Upcoming Issue";
                                                    }else if ($issue->status == 1 && $issue->is_current == 0){
                                                        echo "Published";
                                                    }else if ($issue->status == 1 && $issue->is_current == 1){
                                                        echo "Published - Current Issue";
                                                    }else {
                                                      echo "Error!";
                                                    }
                                                    
                                                    ?> 
                                                </td>
						<td>
							<?php echo anchor('admin/issues/edit/' . $issue->issue_id, lang('issue_edit_label')) . ' | '; ?>
							<?php echo anchor('admin/issues/delete/' . $issue->issue_id, lang('issue_delete_label'), array('class'=>'confirm'));?>
						</td>
					</tr>
					<?php endforeach; ?>                      
				<?php else: ?>
					<tr>
						<td colspan="3"><?php echo lang('no_issues');?></td>
					</tr>
				<?php endif; ?>    
				</tbody>
			</table>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		<?php echo form_close(); ?>
	
	</div>
</div>