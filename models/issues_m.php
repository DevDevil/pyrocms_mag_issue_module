<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Issues model
 *
 * @package     PyroCMS
 * @subpackage	Issues Module
 * @category	Modules
 * @author      Bhupal Sapkota
 */
class Issues_m extends MY_Model
{

        protected $primary_key = 'issue_id';
        
	/**
	 * Insert a new issue into the database
	 * @access public
	 * @param array $input The data to insert
	 * @return issue number
	 */
	public function insert($input = array())
    {

       $this->db->insert('issues', array(
        	'total_issue_no'=>$input['total_issue_no'],
        	'nepali_year'=>$input['nepali_year'],
                'nepali_month'=>$input['nepali_month'],
                'status'=>0, //save as draft by default
                'is_current'=>0 //save as "not current" issue by default

        ));        
        return $input['total_issue_no'];
    }
    
	/**
	 * Update an existing issue
	 * @access public
	 * @param int $id The ID of the issue
	 * @param array $input The data to update
	 * @return bool
	 */
    public function update($id, $input) {
            
		$this->db->update('issues', array(
                        'total_issue_no' => $input['total_issue_no'],
                        'nepali_year'=>$input['nepali_year'],
                        'nepali_month'=>$input['nepali_month']
		), array('issue_id' => $id));
            
		return TRUE;
    }

	/**
	 * Callback method for validating the title
	 * @access public
	 * @param string $title The title to validate
	 * @return integer Number of categories already in the database
	 */
	public function check_issue($issue_no = '')
	{
		return parent::count_by('total_issue_no', $issue_no);
	}

        function get_next_issue(){
            //$this->db->select('total_issue_no');
            //$query = $this->db->get_where('issues', array('is_current' => 1));

            $this->db->select_max('total_issue_no');
            $query = $this->db->get('issues');

            if ($query->num_rows() > 0)
            {             
                $row = $query->row();
                return $row->total_issue_no + 1;
            }else {
                 return 0;
            }
        }

        function get_all_issues_and_articles(){
            $this->db->select('issues.*, news.*, category.title as cat, category.slug as cat_slug' );
            $this->db->from('issues');
            $this->db->join('news', 'news.issue_no = issues.total_issue_no','left');
            $this->db->join('categories as category', 'category.id = news.category_id AND category.slug <> "news"','left');
            $this->db->order_by('total_issue_no','DESC');
            $this->db->limit(10);
            $query = $this->db->get();
                if ($query->num_rows() > 0)
                {
                    return $query->result();

                }else {
                     return 0;
                }
            
        }
}
?>
