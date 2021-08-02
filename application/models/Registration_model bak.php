<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registration_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    function client_info() {
    	$this->load->library('user_agent');
		if ($this->agent->is_browser())
		{
		    $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		    $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		    $agent = $this->agent->mobile();
		}
		else
		{
		    $agent = 'Unidentified User Agent';
		}
		return array(
			'agent' => $agent,
			'platform' => $this->agent->platform()
		);
    }
    
    public function PH_Date(){
        date_default_timezone_set('Asia/Manila');
        return date('Y-m-d H:i:s');
    }
    
    function get_devices() {
        $query = $this->db->select("*")->from("devices")->get();
        return ($query-> num_rows() == 0) ? FALSE : $query->result_array();
    }

    function is_registered_email($value) {
        $query = $this->db->select("*")->from("registration")->where("email", $value)->where('is_verified', 1)->get();
        return ($query->num_rows() == 1) ? TRUE : FALSE;
    }

    function is_registered_contact($value) {
        $query = $this->db->select("*")->from("registration")->where("contact_number", $value)->where('is_verified', 1)->get();
        return ($query->num_rows() == 1) ? TRUE : FALSE;
    }

    function get_info($id) {
        $query = $this->db->select("r.*, i.imei_number")->from("registration r")->join("imei_list i", "i.id = r.imei_id")->where("r.id", $id)->where("is_verified", 1)->where("is_deleted", 0)->get();
        return ($query->num_rows() == 1) ? $query->row_array() : FALSE;
    }

    function client_ip_address() {
    	return $this->input->ip_address();
    }

    function get_imei_id($imei) {
    	$query = $this->db->select("*")->from("imei_list")->where("imei_number", $imei)->get();
    	$row = $query->row_array();
    	return $row['id'];
    }

    function valid_imei($value) {
        $query = $this->db->select("*")->from("imei_list")->where("imei_number", $value)->get();
        return ($query->num_rows() == 1) ? TRUE : FALSE;
    }

    function is_registered_imei($value) {
    	$query = $this->db->select("l.*")->from("imei_list l")
    		->join("registration r", "r.imei_id = l.id")
    		->where("l.imei_number", $value)->where('r.is_verified', 1)->get();
    	return ($query->num_rows() == 0) ? TRUE : FALSE;
    }

    public function insert() {
    	$client = $this->client_info();

        $filename = $this->input->post('imei') . '-' . date('YmsHis');
        $target_dir = "assets/uploads/";
        $target_file = $target_dir . basename($_FILES["storeReceipt"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        $new_file = $filename . '.' . $imageFileType;

    	$data = [
    		'first_name' => ucwords(strtolower($this->input->post('firstName'))),
    		'middle_name' => ucwords(strtolower($this->input->post('middleName'))),
    		'last_name' => ucwords(strtolower($this->input->post('lastName'))),
    		'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
    		'contact_number' => $this->input->post('contactNumber'),
            'phone_model' => $this->input->post('phoneModel'),
    		'imei_id' => $this->get_imei_id($this->input->post('imei')),
            'purchase_date' => $this->input->post('purchaseDate'),
            'store_name' => $this->input->post('storeName'),
            'store_receipt' => $new_file,
    		'agent' => $client['agent'],
    		'platform' => $client['platform'],
    		'ip_address' => $this->client_ip_address(),
    		'is_deleted' => 0,
    		'created_at' => $this->PH_Date(),
            'is_verified' => 0
		];
        
		$this->db->insert('registration', $data);
        $registrationid = $this->db->insert_id();

        //Upload image
        move_uploaded_file($_FILES['storeReceipt']['tmp_name'], $target_dir.$new_file);

        $code = [
            'registration_id' => $registrationid,
            'verification_code' => rand(100000, 999999),
            'attempts' => 3
        ];
        $this->db->insert('verification_codes', $code);
        return $registrationid;
    }

    public function update_code($id) {
        $code = array(
            'verification_code' => rand(100000, 999999),
            'attempts' => 3
        );
        $this->db->where('registration_id', $id);
        $this->db->update('verification_codes', $code);
    }

    public function get_registration($id) {
        $query = $this->db->select('*')->from('registration r')->join('verification_codes v', 'v.registration_id = r.id')->where('r.id', $id)->where('r.is_verified', 0)->get();
        return ($query->num_rows() == 1) ? $query->row_array() : FALSE;
    }

    public function get_code($id) {
        $query = $this->db->select("*")->from("verification_codes")->where("registration_id", $id)->get();
        return ($query->num_rows() == 1) ? $query->row_array() : FALSE;
    }

    public function attempt($id) {
        $this->db->set('attempts', 'attempts-1');
        $this->db->where('id', $id);
        $this->db->update('verification_codes');
    }

    public function verify_user($id) {
        $this->db->set('is_verified', 1);
        $this->db->where('id', $id);
        $this->db->update('registration');
    }
}
?>