<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package  	PyroCMS
 * @subpackage  Issues
 * @category  	Module
 * @author  	Bhupal Sapkota, http://bit.ly/bhu1st
 */
class Admin extends Admin_Controller
{
	/**
	 * Array that contains the validation rules
	 * @access protected
	 * @var array
	 */
	protected $validation_rules;
	
	/** 
	 * The constructor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('issues_m');
		$this->lang->load('issues');
		
		$this->template->set_partial('sidebar', 'admin/sidebar');
	
		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'total_issue_no',
				'label' => 'Issue Number',
				'rules' => 'trim|required'
				//'rules' => 'trim|required|callback__check_issue'
			),
                        array(
				'field' => 'nepali_year',
				'label' => 'Nepali year',
				'rules' => 'trim|required'
			),
                        array(
				'field' => 'nepali_month',
				'label' => 'Nepali month',
				'rules' => 'trim|required'
			)
		);

               $this->data->months = array(
                    'Baishakh'=>'Baishakh',
                    'Jesth'=>'Jesth',
                    'Ashad'=>'Ashad',
                    'Shrawan'=>'Shrawan',
                    'Bhadra'=>"Bhadra",
                    'Ashoj'=>"Ashoj",
                    'Kartik'=>'Katrik',
                    'Mangsir'=>'Mangsir',
                    'Poush'=>'Poush',
                    'Magh'=>'Magh',
                    'Falgun'=>'Falgun',
                    'Chaitra'=>'Chaitra'
                );

                
                $this->data->next_issue = $this->issues_m->get_next_issue();
                

		// Load the validation library along with the rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);
	}
	
	/**
	 * Index method, lists all categories
	 * @access public
	 * @return void
	 */
	public function index()
	{
		// Create pagination links
		$total_rows = $this->issues_m->count_all();
		$this->data->pagination = create_pagination('admin/issues/index', $total_rows);
			
		// Using this data, get the relevant results
		$this->data->issues = $this->issues_m->limit( $this->data->pagination['limit'] )->get_all();
		$this->template->build('admin/index', $this->data);
	}
	
	/**
	 * Create method, creates a new category
	 * @access public
	 * @return void
	 */
	public function create()
	{
		// Validate the data
		if ($this->form_validation->run())
		{
			if ($this->issues_m->insert($_POST))
			{
				$this->session->set_flashdata('success', sprintf( "Issue %s, has been created", $this->input->post('total_issue_no')) );
			}
			else
			{
				$this->session->set_flashdata(array('error'=> "An error occurred."));
			}
			redirect('admin/issues');
		}
		
		// Loop through each validation rule
		foreach($this->validation_rules as $rule)
		{
			$issue->{$rule['field']} = set_value($rule['field']);
		}
                
		// Render the view
		$this->data->issue =& $issue;
		$this->template->build('admin/form', $this->data);
	}
	
	/**
	 * Edit method, edits an existing category
	 * @access public
	 * @param int id The ID of the category to edit 
	 * @return void
	 */
	public function edit($id = 0)
	{	
		// Get the category
		$issue = $this->issues_m->get($id);
		
		// ID specified?
		if (empty($id) or !$issue)
		{
			redirect('admin/issues/index');
		}
		
		// Validate the results
		if ($this->form_validation->run())
		{		
			if ($this->issues_m->update($id, $_POST))
			{
				$this->session->set_flashdata('success', sprintf( lang('issue_edit_success'), $this->input->post('title')) );
			}		
			else
			{
				$this->session->set_flashdata(array('error'=> lang('issue_edit_error')));
			}
			
			redirect('admin/issues/index');
		}
		
		// Loop through each rule
		foreach($this->validation_rules as $rule)
		{
			if($this->input->post($rule['field']) !== FALSE)
			{
				$issue->{$rule['field']} = $this->input->post($rule['field']);
			}
		}


		// Render the view
		$this->data->issue =& $issue;
		$this->template->build('admin/form', $this->data);
	}	

	/**
	 * Delete method, deletes an existing category (obvious isn't it?)
	 * @access public
	 * @param int id The ID of the category to edit 
	 * @return void
	 */
	public function delete($id = 0)
	{	
		$id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');
		
		// Delete multiple
		if(!empty($id_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($id_array as $id) 
			{
				if($this->issues_m->delete($id))
				{
					$deleted++;
				}
				else
				{
					$this->session->set_flashdata('error', sprintf('Error occurred while trying to delete Issue'));
				}
				$to_delete++;
			}
			
			if( $deleted > 0 )
			{
				$this->session->set_flashdata('success', sprintf('%s Issues out of %s successfully deleted.', $deleted, $to_delete));
			}
		}		
		else
		{
			$this->session->set_flashdata('error','You need to select Issue first.');
		}		
		redirect('admin/issues/index');
	}	
	
	/**
	 * Callback method that checks the title of the category
	 * @access public
	 * @param string title The title to check
	 * @return bool
	 */
	public function _check_issue($issue_no = '')
	{
		if ($this->issues_m->check_issue($issue_no) > 0)
		{
			$this->form_validation->set_message('_check_issue', sprintf('Issue number "%s" already exists. Please provide unique issue', $issue_no));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
?>
