<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
    {
        parent::__construct();
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2020 05:00:00 GMT");
        date_default_timezone_set("Africa/Nairobi");
        
        if(!isset($_SESSION['user_id'])){
            header("Location: ".base_url()."login");
        }
    }

	public function index(){
		$data['page_name'] = 'dashboard';
		$this->load->view('admin/index', $data);
	}

	public function members(){
		$data['member'] = $this->db->get('members')->result_array();
		$data['page_name'] = 'members';
		$this->load->view('admin/index', $data);
	}

	public function contributions(){
		$data['contribution'] = $this->db->get('contributions')->result_array();
		$data['page_name'] = 'contributions';
		$this->load->view('admin/index', $data);
	}

	public function loans(){
		$data['loans'] = $this->db->get('loans')->result_array();
		$data['page_name'] = 'loans';
		$this->load->view('admin/index', $data);
	}
	
	public function loan($id){
		$data['loan'] = $this->db->select('*, loan_category.amount as camount, loans.amount as lamount')->join('loan_category', 'loan_category.category_id = loans.type')->join('members', 'members.member_id = loans.member')->where('loan_id', $id)->get('loans')->row();
		$data['loanpaid'] = $this->db->select('sum(amount) as paid')->where('loan_id', $id)->get('loan_payments')->row()->paid;
		$data['loanpayment'] = number_format((float)($data['loanpaid']*100)/$data['loan']->lamount, 1, '.', '');
		$data['paymentdetails'] = $this->db->where('loan_id', $id)->get('loan_payments')->result_array();

		$data['page_name'] = 'loan';
		$this->load->view('admin/index', $data);
	}

	public function loancategory(){
		$data['member'] = $this->db->get('loans')->result_array();
		$data['page_name'] = 'loancategory';
		$this->load->view('admin/index', $data);
	}

	public function reciepts($type, $month = ''){
		if($month != ''){
			$data['month'] = $month;
			$data['date'] = '01-'.substr($month, 0, 2).'-'.substr($month, 2, 4);
		}else{
			$data['month'] = date('mY');
			$data['date'] = '01-'.date('m').'-'.date('Y');
		}

		if($type == 'monthly'){
			$data['page_name'] = 'reciepts_monthly';
		}
		if($type == 'total'){
			$data['page_name'] = 'reciepts_total';
		}

		$data['member'] = $this->db->get('members')->result_array();
		$this->load->view('admin/index', $data);
	}

	public function merit_list(){
		
	}

	public function loanform($id = ''){
		$data['mno'] = $this->db->where('loan_id', $id)->get('loans')->row()->member;
		$data['member'] = $this->db->where('member_id', $data['mno'])->get('members')->row()->name;
		$data['category'] = $this->db->where('category_id', $this->db->where('loan_id', $id)->get('loans')->row()->type)->get('loan_category')->row()->category_name;
		$data['date_to_pay'] = $this->db->where('loan_id', $id)->get('loans')->row()->date_to_pay;
		$data['amount'] = number_format($this->db->where('loan_id', $id)->get('loans')->row()->amount);
		$g1 = $this->db->where('loan_id', $id)->get('loans')->row()->g1;
		$g2 = $this->db->where('loan_id', $id)->get('loans')->row()->g2;
		$g3 = $this->db->where('loan_id', $id)->get('loans')->row()->g3;
		$g4 = $this->db->where('loan_id', $id)->get('loans')->row()->g4;
		$data['guarantor'] = $this->db->
									where('member_id', $g1)->
									or_where('member_id', $g2)->
									or_where('member_id', $g3)->
									or_where('member_id', $g4)->
									order_by('RAND()')->
									get('members')->result_array();
									
		$num = str_replace(array(',', ' '), '' , trim($data['amount']));

		if(! $num) {
			return false;
		}
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
			'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
		);
		$list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
		$list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
			'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
			'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
		);
		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ( $tens < 20 ) {
				$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
			} else {
				$tens = (int)($tens / 10);
				$tens = ' ' . $list2[$tens] . ' ';
				$singles = (int) ($num_levels[$i] % 10);
				$singles = ' ' . $list1[$singles] . ' ';
			}
			$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		} //end for loop
		$commas = count($words);
		if ($commas > 1) {
			$commas = $commas - 1;
		}
		$data['wmount'] = ucwords(implode(' ', $words)). ' only';
		
		$data['page_name'] = "loanform";
		$this->load->view('admin/loanform', $data);
	}

	public function generalsettings(){
		$data['member'] = $this->db->get('loans')->result_array();
		$data['page_name'] = 'generalsettings';
		$this->load->view('admin/index', $data);
	}

	public function systemsettings(){
		$data['member'] = $this->db->get('loans')->result_array();
		$data['page_name'] = 'systemsettings';
		$this->load->view('admin/index', $data);
	}

	public function payments(){
		$data['payment'] = $this->db->get('payments')->result_array();
		$data['page_name'] = 'payments';
		$this->load->view('admin/index', $data);
	}

	public function managepayments(){
		$data['category'] = $this->db->get('payment_categories')->result_array();
		$data['page_name'] = 'managepayments';
		$this->load->view('admin/index', $data);
	}

	public function paycat(){
		$data['type'] = $this->input->post('cat_type');
		$data['category_name'] = $this->input->post('cat_name');

		$data = $this->security->xss_clean($data);

		$this->db->insert('payment_categories', $data);

		echo '
			<script>
				toastr.success("New payment category succesfully added", "Success");
				setTimeout(function(){ window.location.href = "'.base_url().'managepayments"; }, 800);
			</script>
		';
	}

	public function member($mno){
		$data['details'] = $this->db->where('member_id', $mno)->get('members')->row();
		$data['savings'] = $this->db->where('member', $mno)->where('type', '1')->get('contributions')->result_array();
		$data['shares'] = $this->db->where('member', $mno)->where('type', '2')->get('contributions')->result_array();
		$data['guarantorship'] = $this->db->where('g1', $mno)->or_where('g2', $mno)->or_where('g3', $mno)->or_where('g4', $mno)->get('loans')->result_array();
		$data['loans'] = $this->db->where('member', $mno)->get('loans')->result_array();
		$data['payments'] = $this->db->where('member', $mno)->get('payments')->row();

		$data['page_name'] = 'member';
		$this->load->view('admin/index', $data);
	}

	public function newmember(){
		if($_SERVER['REQUEST_METHOD'] = 'POST'){
			$data['name'] 			= $this->input->post('membername');
			$data['phone'] 			= $this->input->post('phonenumber');
			$data['id_no'] 			= $this->input->post('idnumber');
			$data['date_joined'] 	= strtotime($this->input->post('date'));
			$total_members 			= $this->db->get('members')->num_rows();
			$newmembers 			= $total_members + 1;

			$data = $this->security->xss_clean($data);

			$this->db->insert('members', $data);

			echo '
				<tr>
					<td>'. $newmembers .'</td>
					<td>'. $data['name'] .'</td>
					<td>'. $data['phone']. '</td>
					<td>'. $data['id_no']. '</td>
					<td class="center">'. date('d M, Y', $data['date_joined']) .'</td>
					<td>
						<span onclick="approve('. $newmembers .');" class="btn btn-primary">Approve</span>
						<span onclick="deregister('. $newmembers .');" class="btn btn-danger">Deregister</span>
					</td>
				</tr>
				<script>toastr.success("'. $data['name'] .' has been succesfully added tu Ufami Sacco", "Success");</script>';	
		}
	} 

	public function edit_member(){
		if($_SERVER['REQUERST_METHOD'] = 'POST'){
			
			$member_id = $this->input->post('membid');
			if($this->input->post('edname') != ''){
				$data['name'] = $this->input->post('edname');
			}
			if($this->input->post('edid') != ''){
				$data['id_no'] = $this->input->post('edid');
			}
			if($this->input->post('edphone') != ''){
				$data['phone'] = $this->input->post('edphone');
			}

			$data = $this->security->xss_clean($data);

			$this->db->where('member_id', $member_id)->set($data)->update('members');

			echo '
				<script>
					toastr.success("Succesfully edited member #'.$member_id.'", "Success");
				</script>
			';
		}
	}

	public function newcontribution(){
		if($_SERVER['REQUEST_METHOD'] = 'POST'){
			$data['member'] = $this->input->post('member');
			$data['amount'] = $this->input->post('amount');
			$data['method'] = $this->input->post('method');
			$data['type'] 	= $this->input->post('type');
			$data['date'] 	= strtotime($this->input->post('date'));
			$data['invoice'] = substr(sha1(md5(time())), 4, 10);

			$data = $this->security->xss_clean($data);

			$this->db->insert('contributions', $data);

			if($data['type'] == '1'){
				$typetext = 'Deposit';
			}else{
				$typetext = 'Share Capital';
			}

			echo '
			<tr id="contribution'.$this->db->get_where('contributions', $data)->row()->contribution_id.'">
                <td>'.$data['member'] .'</td>
                <td>'. $this->db->where('member_id', $data['member'])->get('members')->row()->name .'</td>
                <td>'. $data['amount'] .'</td>
                <td>'. $typetext .'</td>
				<td>'. date('d M, Y', $data['date']) .'</td>
				<td>
					<span onclick="showAjaxModal(\''. base_url().'getcontribution/'. $this->db->get_where('contributions', $data)->row()->contribution_id .'\', \'Payment #'. $this->db->get_where('contributions', $data)->row()->contribution_id .'\');" class="btn btn-primary btn-sm btn-icon icon-left"> <i class="entypo-eye"></i>View</span>
					<span onclick="delete_contribution('. $this->db->get_where('contributions', $data)->row()->contribution_id .');" class="btn btn-danger btn-sm btn-icon icon-left"> <i class="entypo-trash"></i>Delete</span>
				</td>
            </tr>
			<script>toastr.success("'. $this->db->where('member_id', $data['member'])->get('members')->row()->name .' has succesfully made the contribution. Transaction #'.$this->db->get_where('contributions', $data)->row()->contribution_id.'", "Success");</script>';
		}
	}

	public function newloancategory(){
		$data['category_name'] = $this->input->post('name');
		$data['period'] = $this->input->post('duration');
		$data['amount'] = $this->input->post('amount');
		$data['interest'] = $this->input->post('interest');
		$data['guarantorship'] = $this->input->post('guarantorship');
		$data['requirements'] = $this->input->post('requirements');
		
		$data = $this->security->xss_clean($data);

		$this->db->insert('loan_category', $data);
	}

	public function getcategory($type){
		foreach($this->db->get_where('payment_categories', array('type' => $type))->result_array() as $fetch){
			echo '<option value="'.$fetch['category_id'].'">'.$fetch['category_name'].'</option>';
		}
	}

	public function makepayment(){
		if($this->input->post('member') != ''){
			$data['member'] = $this->input->post('member');
			$data['name'] = $this->db->where('member_id', $this->input->post('member'))->get('members')->row()->name;
		}
		if($this->input->post('name') != ''){
			$data['member'] = '0';
			$data['name'] = $this->input->post('name');
		}
		$data['amount'] = $this->input->post('amount');
		$data['category'] = $this->input->post('category');
		$data['type'] = $this->input->post('type');
		$data['description'] = $this->input->post('description');
		$data['date'] = strtotime($this->input->post('date'));
		$data['invoice'] = substr(sha1(md5(time())), 4, 10);

		$data = $this->security->xss_clean($data);

		$this->db->insert('payments', $data);

		print_r($data);
		echo '
		<tr id="payment'. $this->db->get_where('payments', $data)->row()->payment_id .'">
			<td>'. $data['member'] .'</td>
			<td>'. $data['name'] .'</td>
			<td>'. $data['amount'] .'</td>
			<td>'. ucwords($this->db->where('category_id', $data['category'])->get('payment_categories')->row()->category_name) .'</td>
			<td>'. $data['type'] .'</td>
			<td>'. $data['description'] .'</td>
			<td>'. date('d M, Y', $data['date']) .'</td>
			<td>
			<span onclick="showAjaxModal(\''. base_url().'getpayment/'. $this->db->get_where('payments', $data)->row()->payment_id .'\', \'Payment #'. $this->db->get_where('payments', $data)->row()->payment_id .'\');" class="btn btn-primary btn-sm btn-icon icon-left"> <i class="entypo-eye"></i>View</span>
			<span onclick="delete_payment('. $this->db->get_where('payments', $data)->row()->payment_id .');" class="btn btn-danger btn-sm btn-icon icon-left"> <i class="entypo-trash"></i>Delete</span>
			</td>
		</tr>
		';
	}

	public function newloanrequest(){
		$data['type'] = $this->input->post('type');
		$data['member'] = $this->input->post('member');
		$data['g1'] = $this->input->post('g1');
		$data['g2'] = $this->input->post('g2');
		$data['g3'] = $this->input->post('g3');
		$data['g4'] = $this->input->post('g4');
		$data['amount'] = $this->input->post('amount');
		$maxborrowable = $this->db->select('sum(amount) as max')->where('member', $data['member'])->where('type', '1')->get('contributions')->row()->max * 3;

		if($data['type'] == '1'){
			if($data['amount'] > $maxborrowable){
				echo '<script>toastr.warning("Your loan limit is '.$maxborrowable.'. You cannot borrow more than Kshs '.$maxborrowable.' at this time", "Warning");</script>';
			}else{
				$data['requirements'] = '';
				$thisamountdue = $data['amount']+((1/100)*$data['amount']);
			}			
		}
		if($data['type'] == '2'){
			$requirement = $_FILES['requirement']['name'];
			$tmp_requirement = $_FILES['requirement']['tmp_name'];	
			$data['requirements'] = 'Loan_Requirement_'.time().'.'.pathinfo($requirement, PATHINFO_EXTENSION);				
			move_uploaded_file($tmp_requirement, 'uploads/requirements/'.$requirement);

			$thisamountdue = $data['amount']+((12/100)*$data['amount']);
			
			
		}
		if($data['type'] == '3'){
			$requirement = $_FILES['requirement']['name'];
			$tmp_requirement = $_FILES['requirement']['tmp_name'];	
			$data['requirements'] = 'Loan_Requirement_'.time().'.'.pathinfo($requirement, PATHINFO_EXTENSION);				
			move_uploaded_file($tmp_requirement, 'uploads/requirements/'.$requirement);

			$thisamountdue = $data['amount']+((10/100)*$data['amount']);
			
			
		}
		if($data['type'] == '4'){
			if($data['amount'] > '100000'){
				echo '
					<script>toastr.warning("You cannot borrow more than Kshs 100,000 for BodaBoda loan", "Warning");</script>
				';
			}else{
				$requirement = $_FILES['requirement']['name'];
				$tmp_requirement = $_FILES['requirement']['tmp_name'];	
				$data['requirements'] = 'Loan_Requirement_'.time().'.'.pathinfo($requirement, PATHINFO_EXTENSION);				
				move_uploaded_file($tmp_requirement, 'uploads/requirements/'.$requirement);

				$thisamountdue = $data['amount']+((1/100)*$data['amount']);
				
			}
		}
		if($data['type'] == '5'){
			if($data['amount'] > $maxborrowable){
				echo '<script>toastr.warning("Your loan limit is '.$maxborrowable.'. You cannot borrow more than Kshs '.$maxborrowable.' at this time", "Warning");</script>';
			}else{
				$requirement = $_FILES['requirement']['name'];
				$tmp_requirement = $_FILES['requirement']['tmp_name'];	
				$data['requirements'] = 'Loan_Requirement_'.time().'.'.pathinfo($requirement, PATHINFO_EXTENSION);				
				move_uploaded_file($tmp_requirement, 'uploads/requirements/'.$requirement);

				$thisamountdue = $data['amount']+((1/100)*$data['amount']);
				
			}
		}
		if($data['type'] == '6'){
			$requirement = $_FILES['requirement']['name'];
			$tmp_requirement = $_FILES['requirement']['tmp_name'];	
			$data['requirements'] = 'Loan_Requirement_'.time().'.'.pathinfo($requirement, PATHINFO_EXTENSION);				
			move_uploaded_file($tmp_requirement, 'uploads/requirements/'.$requirement);

			$thisamountdue = $data['amount']+((15/100)*$data['amount']);
			
		}
		if($data['type'] == '7'){
			
			$requirement = $_FILES['requirement']['name'];
			$tmp_requirement = $_FILES['requirement']['tmp_name'];	
			$data['requirements'] = 'Loan_Requirement_'.time().'.'.pathinfo($requirement, PATHINFO_EXTENSION);				
			move_uploaded_file($tmp_requirement, 'uploads/requirements/'.$requirement);

			$thisamountdue = $data['amount']+((10/100)*$data['amount']);
			
			/*if($data['amount'] > '50000'){
				echo '
					<script>toastr.warning("You cannot borrow more than Kshs 50,000 for Short Term loan", "Warning");</script>
				';
			}else{
				$requirement = $_FILES['requirement']['name'];
				$tmp_requirement = $_FILES['requirement']['tmp_name'];	
				$data['requirements'] = 'Loan_Requirement_'.time().'.'.pathinfo($requirement, PATHINFO_EXTENSION);				
				move_uploaded_file($tmp_requirement, 'uploads/requirements/'.$requirement);

				$thisamountdue = $data['amount']+((10/100)*$data['amount']);
				
			}*/
		}
		
		if($thisamountdue != ''){
			$data['amountdue'] = $thisamountdue;
			$data['date_taken'] = strtotime($this->input->post('date'));
			$data['date_to_pay'] = strtotime($this->input->post('repay'));
			$loanapp = $this->input->post('loanapplication');
	
			$data = $this->security->xss_clean($data);
	
			$this->db->insert('loans', $data);
			$this->db->insert('payments', array(
				'member' => $this->input->post('member'),
				'amount' => $loanapp,
				'name' => $this->db->where('member_id', $this->input->post('member'))->get('members')->row()->name,
				'category' => '11',
				'type' => 'income',
				'description' => '',
				'invoice' =>substr(sha1(md5(time())), 4, 10),
				'date' => time()
			));
			
			echo '
			<tr id="loan'.$this->db->get_where('loans', $data)->row()->loan_id.'">
				<td>'. $data['member'] .'</td>
				<td>'. $this->db->where('member_id', $data['member'])->get('members')->row()->name .'</td>
				<td>'. $data['amount'] .'</td>
				<td>
					'. $this->db->where('member_id', $data['g1'])->get('members')->row()->name .'<br />
					'. $this->db->where('member_id', $data['g2'])->get('members')->row()->name .'<br />
					'. $this->db->where('member_id', $data['g3'])->get('members')->row()->name .'<br />
					'. $this->db->where('member_id', $data['g4'])->get('members')->row()->name .'<br />
				</td>
				<td>'. date('d M, Y', $data['date_taken']) .'</td>
				<td><span class="btn btn-danger">Pending</span></td>
				<td>'. $this->db->where('category_id', $data['type'])->get('loan_category')->row()->category_name .'</td>
				<td>
					<span class="entypo-trash btn btn-danger" style="cursor: pointer;" onclick="delete_loan('.$this->db->get_where('loans', $data)->row()->loan_id.');"></span>
					<span class="entypo-trash btn btn-danger" style="cursor: pointer;" onclick="approve_loan('.$this->db->get_where('loans', $data)->row()->loan_id.');"></span>
				</td>
			</tr>
			<script>
				toastr.success("Succesfully applied for a loan request. Kindly wait for aproval", "Success");
				setTimeout(function(){
					window.location.href="'.base_url().'loanform/'.$this->db->get_where('loans', $data)->row()->loan_id.'";
				}, 3000);
			</script>';			
		}
		else{
			echo '
			<script>
				toastr.warning("Could not complete loan application process", "Warning");
			</script>';
		}
	}

	public function loanpayment($id, $payamount, $payday){
		$data['loan_id'] = $id;

		$loantype = $this->db->where('loan_id', $id)->get('loans')->row()->type;

		$amountdue = $this->db->where('loan_id', $id)->get('loans')->row()->amountdue;

		$amount = $this->db->where('loan_id', $id)->get('loans')->row()->amount;

		$member = $this->db->where('loan_id', $id)->get('loans')->row()->member;

		$data['amount'] = $payamount;
		
		$data['date'] = strtotime($payday); #strtotime(date('d M, Y'));

		$data = $this->security->xss_clean($data);

		if($loantype == '1'){
			$amountdue = ($amountdue - $data['amount']) + ((1/100)*($amountdue - $data['amount']));
		}
		if($loantype == '2'){
			$amountdue = ($amountdue - $data['amount']);
		}
		if($loantype == '3'){
			$amountdue = ($amountdue - $data['amount']);
		}
		if($loantype == '4'){
			$amountdue = ($amountdue - $data['amount']) + ((1/100)*($amountdue - $data['amount']));
		}
		if($loantype == '5'){
			$amountdue = ($amountdue - $data['amount']) + ((1/100)*($amountdue - $data['amount']));
		}
		if($loantype == '6'){
			$amountdue = ($amountdue - $data['amount']);
		}
		if($loantype == '7'){
			$amountdue = ($amountdue - $data['amount']);
		}
		
		$this->db->where('loan_id', $id)->set('amountdue', $amountdue)->update('loans');
		$this->db->insert('loan_payments', $data);

		if($amountdue == '0'){
			$this->db->where('loan_id', $id)->set('status', '4')->update('loans');
			$this->db->where('loan_id', $id)->set('date_paid', time())->update('loans');
			$loanrepayment = $this->db->select('sum(amount) as tots')->where('loan_id', $id)->get('loan_payments')->row()->tots - $this->db->where('loan_id', $id)->get('loans')->row()->amount;
			$this->db->insert('payments', array(
				'member' => $this->db->where('loan_id', $id)->get('loans')->row()->member,
				'amount' => $loanrepayment,
				'name' => $this->db->where('member_id', $this->db->where('loan_id', $id)->get('loans')->row()->member)->get('members')->row()->name,
				'category' => '12',
				'type' => 'income',
				'description' => '',
				'invoice' =>substr(sha1(md5(time())), 4, 10),
				'date' => time()
			));
			
			echo number_format($data['amount']).' has been paid. Total paid now is '.number_format($amountpaid).'. Your loan has been fully paid';
		}
		else{			
			echo number_format($data['amount']).' has been paid. Total paid now is '.number_format($amountpaid).'. You need to pay '. number_format($amountdue);
		}
		
	}
	
	public function getpayment($id){
		$data['payment'] = $this->db->where('payment_id', $id)->get('payments')->row();
		$this->load->view('admin/payment_reciept', $data);
	}

	public function getcontribution($id){
		$data['contribution'] = $this->db->where('contribution_id', $id)->get('contributions')->row();
		$this->load->view('admin/contribution_reciept', $data);
	}

	public function delete_contribution($id){
		$this->db->where('contribution_id', $id)->delete('contributions');
	}

	public function delete_payment($id){
		$this->db->where('payment_id', $id)->delete('payments');
	}

	public function delete_loan($id){
		$this->db->where('loan_id', $id)->delete('loans');
	}

	public function approve_loan($id){
		$this->db->where('loan_id', $id)->set('status', '1')->update('loans');
	}

	public function approve_member($id){
		$this->db->where('member_id', $id)->set('status', '1')->update('members');
		echo '<script>toastr.success("Succesfully approved '. $this->db->where('member_id', $id)->get('members')->row()->name .'\'s membership to Ufami sacco", "Success");</script>';
	}
	
	public function deregister_member($id){
		$this->db->where('member_id', $id)->set('status', '3')->update('members');
		echo '<script>toastr.warning("Succesfully revoked '. $this->db->where('member_id', $id)->get('members')->row()->name .'\'s membership to Ufami sacco", "Danger");</script>';
	}

	public function member_report($type, $id){

		if($type == 'loans'){
			$data['page_name'] = 'report_loans';
		}
		if($type == 'payments'){
			$data['page_name'] = 'report_payments';
		}

		$data['loans_report'] = $this->db->get_where('loans', array('loan_id' => $id))->row();
		$data['payments_report'] = $this->db->get_where('payments', array('member' => $id))->result_array();
		$data['deposits_report'] = $this->db->get_where('contributions', array('member' => $id, 'type' => '1'))->result_array();
		$data['shares_report'] = $this->db->get_where('contributions', array('member' => $id, 'type' => '2'))->result_array();
		$data['member_details'] = $this->db->where('member_id', $id)->get('members')->row();

		/* echo '<br /><br /><br />Loans<hr />';
		print_r($data['loans_report']);
		echo '<br /><br /><br />Payments<hr />';
		print_r($data['payments_report']);
		echo '<br /><br /><br />Deposits<hr />';
		print_r($data['deposits_report']);
		echo '<br /><br /><br />Shares<hr />';
		print_r($data['shares_report']);
		echo '<br /><br /><br />Member Details<hr />';
		print_r($data['member_details']); */

		$this->load->view('admin/index', $data);
	}

	public function loan_report(){
		$data['loan'] = $this->db->get('loans')->result_array();

		$data['page_name'] = 'report_all_loans';

		$this->load->view('admin/index', $data);
	}
// PAYROLL
	function payroll()
	{
		if ($this->session->userdata('user_id') != 1) {
			redirect(site_url(), 'refresh');
		}

		$data['page_name']  = 'payroll_add';
		$data['page_title'] = ('create_payroll');
		$this->load->view('admin/index', $data);
	}

	function payroll_selector()
	{
		$user        = explode('-', $this->input->post('employee_id'));
		$user_type   = $user[0];
		$employee_id = $user[1];
		$month       = $this->input->post('month');
		$year        = $this->input->post('year');

		redirect(site_url('payroll_view/' . $user_type . '/' . $employee_id . '/' . $month . '/' . $year), 'refresh');
	}

	function payroll_view($user_type = '', $employee_id = '', $month = '', $year = '')
	{
		$data['user_type']   = $user_type;
		$data['employee_id'] = $employee_id;
		$data['month']       = $month;
		$data['year']        = $year;
		$data['page_name']   = 'payroll_add_view';
		$data['page_title']  = 'create_payroll';
		$this->load->view('admin/index', $data);
	}

	function create_payroll()
	{
		$data['payroll_code']   = substr(md5(rand(100000000, 20000000000)), 0, 7);
		$data['user_id']        = $this->input->post('user_id');
		$data['user_type']      = $this->input->post('user_type');
		$data['joining_salary'] = $this->input->post('joining_salary');

		$allowances        = array();
		$allowance_types   = $this->input->post('allowance_type');
		$allowance_amounts = $this->input->post('allowance_amount');
		$number_of_entries = sizeof($allowance_types);

		for ($i = 0; $i < $number_of_entries; $i++) {
			if ($allowance_types[$i] != "" && $allowance_amounts[$i] != "") {
				$new_entry = array(
					'type' => $allowance_types[$i],
					'amount' => $allowance_amounts[$i]
				);
				array_push($allowances, $new_entry);
			}
		}
		$data['allowances'] = json_encode($allowances);

		$deductions        = array();
		$deduction_types   = $this->input->post('deduction_type');
		$deduction_amounts = $this->input->post('deduction_amount');
		$number_of_entries = sizeof($deduction_types);

		for ($i = 0; $i < $number_of_entries; $i++) {
			if ($deduction_types[$i] != "" && $deduction_amounts[$i] != "") {
				$new_entry = array(
					'type' => $deduction_types[$i],
					'amount' => $deduction_amounts[$i]
				);
				array_push($deductions, $new_entry);
			}
		}
		$data['deductions'] = json_encode($deductions);
		$data['date']       = $this->input->post('month') . ',' . $this->input->post('year');
		$data['status']     = $this->input->post('status');

		$this->db->insert('payroll', $data);

		$this->session->set_flashdata('message', ('data_created_successfully'));
		redirect(site_url('payroll_list'), 'refresh');
	}

	function payroll_list($param1 = '', $param2 = '')
	{
		if ($this->session->userdata('user_id') != 1) {
			redirect(site_url(), 'refresh');
		}

		if ($param1 == 'mark_paid') {
			$data['status'] = 1;

			$this->db->update('payroll', $data, array(
				'payroll_id' => $param2
			));

			$this->session->set_flashdata('message', ('data_updated_successfully'));
			redirect(site_url('payroll_list'), 'refresh');
		}

		$data['page_name']  = 'payroll_list';
		$data['page_title'] = ('payroll_list');
		$this->load->view('admin/index', $data);
	}


	function popup($page_name = '', $param2 = '', $param3 = '')
	{
		$page_data['param2']		=	$param2;
		$page_data['param3']		=	$param3;
		$this->load->view('admin/' . $page_name . '.php', $page_data);

		echo '<script src="' . base_url() . 'assets/js/neon-custom-ajax.js"></script>';
		echo '<script>$(".html5editor").wysihtml5();</script>';
	}
	
    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url().'login', 'refresh');
    }
}
