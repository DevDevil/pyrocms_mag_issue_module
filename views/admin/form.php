<div class="box">

	<?php if($method == 'create'): ?>
		<h3>Add New Issue<?php //echo lang('cat_create_title');?></h3>
		
	<?php else: ?>
		<h3>Edit Issue : <?php echo $issue->total_issue_no;?></h3>
		
	<?php endif; ?>

	<div class="box-container">	
	<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
	
		<fieldset>
			<ol>
				<li class="even">
                                    <label for="total_issue_no">Issue No</label>
                                    <?php
                                    if ($issue->total_issue_no == 0){
                                        $issue->total_issue_no = $next_issue;
                                    }
                                    ?>
                                    <?php echo  form_input('total_issue_no', $issue->total_issue_no); ?>
                                    <span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
                                <li>
                                    <label for="nepali_year">Year (Nepali)</label>
                                    <?php echo  form_input('nepali_year', $issue->nepali_year); ?>
                                    <span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
                                <li class="even">
                                    <label for="nepali_month">Month (Nepali)</label>
                                    <?php
                                    if (empty($issue->nepali_month)) $default_nepali_month = "Baishakh";
                                    else $default_nepali_month = $issue->nepali_month;                                    
                                    ?>
                                    
                                    <?php echo form_dropdown('nepali_month', $months, $default_nepali_month); ?>
                                </li>
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</fieldset>
		
	<?php echo form_close(); ?>
	
	</div>
</div>