<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'security'));
        $this->load->library('form_validation');
        $this->load->model('Registration_model', 'r');
        $config = array(
            'protocol' => "smtp",
            'smtp_host' => "ssl://mail.realmephpromos.com",
            'smtp_port' => "465",
            'smtp_user' => "realgalo2020@realmephpromos.com",
            'smtp_pass' => 'realgalo2020',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
    }

    public function is_valid_email($value) {
    	if (!$value) {
            $this->form_validation->set_message('is_valid_email', '{field} is required.');
            return FALSE;
        } elseif ($this->r->is_registered_email($value) === TRUE) {
        	$this->form_validation->set_message('is_valid_email', '{field} is already used.');
            return FALSE;
        }
        else {
        	return TRUE;
        }
    }

    public function is_valid_contact($value) {
    	if (!$value) {
            $this->form_validation->set_message('is_valid_contact', '{field} is required.');
            return FALSE;
        } elseif ($this->r->is_registered_contact($value) === TRUE) {
        	$this->form_validation->set_message('is_valid_contact', '{field} is already used.');
            return FALSE;
        }
        else {
        	return TRUE;
        }
    }
    
    public function is_valid_date($value) {
    	if (!$value) {
            $this->form_validation->set_message('is_valid_date', '{field} is required.');
            return FALSE;
        } else {
        	$date = date_create($value);
        	$mindate = date_create('2020-11-17');
	        if ($date < $mindate) {
	        	$this->form_validation->set_message('is_valid_date', '{field} must be November 17, 2020 or later.');
	            return FALSE;
	        } else {
	        	return TRUE;
	        }
	    }
    }

    public function is_valid_imei($value) {
    	if (!$value) {
            $this->form_validation->set_message('is_valid_imei', '{field} is required.');
            return FALSE;
        } elseif ($this->r->valid_imei($value) === FALSE) {
        	$this->form_validation->set_message('is_valid_imei', 'Your {field} is not registered on realme Device.');
			
            return FALSE;
        } elseif ($this->r->is_registered_imei($value) === FALSE) {
        	$this->form_validation->set_message('is_valid_imei', '{field} is already registered.');
			
            return FALSE;
        }
        else {
        	return TRUE;
        }
    }

    public function is_valid_image($value) {
    	if ($_FILES['storeReceipt']) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["storeReceipt"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png");
            if( in_array($imageFileType,$extensions_arr) ){
                return TRUE;
            }
            else {
                $this->form_validation->set_message('is_valid_image', '{field} must be a valid image.');
                return FALSE;
            }
        }
        else {
            $this->form_validation->set_message('is_valid_image', 'Please upload {field}.');
            return FALSE;
        }
    }

	public function index()
	{
		$header['style'] = array('registration');
		$body['devices'] = $this->r->get_devices();
		$footer['script'] = array('registration');
        $body['current_time'] = $this->r->PH_Date();
        
		if ($this->input->post()) {
			$this->form_validation->set_rules('firstName', 'First Name', 'trim|required|xss_clean',
				array(
					'required' => '{field} is required.'
				));
            $this->form_validation->set_rules('middleName', 'Middle Name', 'trim|xss_clean');
            $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|xss_clean',
        		array(
					'required' => '{field} is required.'
				));
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('address', 'Home Address', 'trim|required|xss_clean',
        		array(
					'required' => '{field} is required.'
				));
            $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|xss_clean',
        		array(
					'required' => '{field} is required.'
				));
            $this->form_validation->set_rules('contactNumber', 'Contact Number', 'trim|required|is_numeric|xss_clean',
        		array(
					'required' => '{field} is required.',
					'is_numeric' => '{field} must be numeric.',
					'is_unique' => '{field} is already used.'
				));
            $this->form_validation->set_rules('phoneModel', 'Phone Model', 'trim|required|xss_clean',
        		array(
					'required' => 'Please select {field}.'
				));
            $this->form_validation->set_rules('imei', 'IMEI Number', 'trim|callback_is_valid_imei|xss_clean');
            $this->form_validation->set_rules('purchaseDate', 'Date of Purchase', 'trim|required|callback_is_valid_date|xss_clean',
        		array(
					'required' => '{field} is required.'
				));
            $this->form_validation->set_rules('storeName', 'Store Name', 'trim|required|xss_clean',
        		array(
					'required' => '{field} is required.'
				));
            $this->form_validation->set_rules('storeReceipt', 'Store Receipt', 'trim|callback_is_valid_image|xss_clean',
        		array(
					'required' => '{field} is required.'
				));
            $this->form_validation->set_rules('terms', 'Terms and Conditions', 'trim|required|xss_clean',
        		array(
					'required' => 'Please check the {field}.'
				));
            $this->form_validation->set_rules('dataPrivacy', 'Data Privacy', 'trim|required|xss_clean',
        		array(
					'required' => 'Please check the {field}.'
				));
			$this->form_validation->set_rules('dataAgreement', 'Agreement', 'trim|required|xss_clean',
        		array(
					'required' => 'Please accept the {field}.'
				));
            if ($this->form_validation->run()) {
            	$id = $this->r->insert();
            	redirect('registration/send_code/'.$id);
            }
            else {
            	$this->load->view('_shared/onheader', $header);
				$this->load->view('_page/registration/index', $body);
				$this->load->view('_shared/onfooter', $footer);
            }
		}
		else {
			$this->load->view('_shared/onheader', $header);
			$this->load->view('_page/registration/index', $body);
			$this->load->view('_shared/onfooter', $footer);
		}
	}

	public function is_valid_verification($value, $id) {
		if(!$value) {
			$this->form_validation->set_message('is_valid_verification', 'Please enter {field}.');
            return FALSE;
		} else {
			$result = $this->r->get_code($id);
			if ($result === FALSE) {
				$this->form_validation->set_message('is_valid_verification', 'Invalid verification. Please register first.');
            	return FALSE;
			} elseif ($result['attempts'] == 0) {
				$this->form_validation->set_message('is_valid_verification', 'Maximum number of attempts used. Please resend {field} to your email.');
            	return FALSE;
			} elseif ($result['verification_code'] !== $value) {
				$this->form_validation->set_message('is_valid_verification', 'Incorrect {field}.');
				$this->r->attempt($result['id']);
            	return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	public function send_code($id = NULL) {
		if ($id == NULL) {
			$header['style'] = array('registration');
			$footer['script'] = FALSE;
			$this->load->view('_shared/onheader', $header);
			$this->load->view('_page/registration/denied');
			$this->load->view('_shared/onfooter', $footer);
		} else {
			$this->r->update_code($id);
			$result = $this->r->get_registration($id);
			if ($result === FALSE) {
				$header['style'] = array('registration');
				$footer['script'] = FALSE;
				$this->load->view('_shared/onheader', $header);
				$this->load->view('_page/registration/404');
				$this->load->view('_shared/onfooter', $footer);
			}
			else {
				$config = array(
                    'protocol' => "smtp",
                    'smtp_host' => "ssl://mail.realmephpromos.com",
                    'smtp_port' => "465",
                    'smtp_user' => "realgalo2020@realmephpromos.com",
                    'smtp_pass' => 'realgalo2020',
                    'mailtype'  => 'html', 
                    'charset'   => 'iso-8859-1'
                );
				$this->load->library('email', $config);
		        $this->email->set_mailtype("html");
		        $this->email->set_newline("\r\n");
		        $this->email->from("realgalo2020@realmephpromos.com", 'realme Registration');
		        $this->email->to($result['email']);
		        $this->email->subject('realme Registration 2020');
		        $this->email->message('
    		        Hi '.$result['first_name'].',<br><br>
    		        Thank you for joining our promo! Your verification code is: '.$result['verification_code'].'. Please enter this back in the promo registration website to validate your raffle entry.<br><br>
    		        realme Philippines');

		        $this->email->send();
		        redirect('registration/verify/'.$id);
			}
		}
	}

	public function verify($id = NULL) {
		$data = array('id' => $id);
		if ($id == NULL) {
			$header['style'] = array('registration');
			$footer['script'] = FALSE;
			$this->load->view('_shared/onheader', $header);
			$this->load->view('_page/registration/denied');
			$this->load->view('_shared/onfooter', $footer);
		}
		else {
			$result = $this->r->get_registration($id);
			if ($result === FALSE) {
				$header['style'] = array('registration');
				$footer['script'] = FALSE;
				$this->load->view('_shared/onheader', $header);
				$this->load->view('_page/registration/404');
				$this->load->view('_shared/onfooter', $footer);
			}
			elseif ($this->input->post()) {
				$this->form_validation->set_rules('verification', 'Verification Code', 'trim|callback_is_valid_verification['.$id.']|xss_clean');
				if($this->form_validation->run()) {
					$this->r->verify_user($id);

					//Send mail to applicant
					$config = array(
                        'protocol' => "smtp",
                        'smtp_host' => "ssl://mail.realmephpromos.com",
                        'smtp_port' => "465",
                        'smtp_user' => "realgalo2020@realmephpromos.com",
                        'smtp_pass' => 'realgalo2020',
                        'mailtype'  => 'html', 
                        'charset'   => 'iso-8859-1'
                    );
					$this->load->library('email', $config);
			        $this->email->set_mailtype("html");
			        $this->email->set_newline("\r\n");
			        $this->email->from("realgalo2020@realmephpromos.com", 'realme Registration');
			        $this->email->to($result['email']);
			        $this->email->subject('realme Registration 2020');
			        $this->email->message('
        		        Hi '.$result['first_name'].',<br><br>
        	            Congratulations! You earned one raffle entry to realme realGalo 2020 with a reference number of '.str_pad($id, 6, '0', STR_PAD_LEFT).'.<br><br>
        	            Please stay tuned in our Facebook page <a href="https://facebook.com/realmePhilippines">realme Philippines</a> as we will draw the lucky winners on January 8, 2021! We will be sending a text message to the winners so please keep your registered phone number active.<br><br>
        	            realme Philippines');
			        $this->email->send();

			        $client = $this->r->get_info($id);
			        //Send mail to admin
			        $config = array(
                        'protocol' => "smtp",
                        'smtp_host' => "ssl://mail.realmephpromos.com",
                        'smtp_port' => "465",
                        'smtp_user' => "realgalo2020@realmephpromos.com",
                        'smtp_pass' => 'realgalo2020',
                        'mailtype'  => 'html', 
                        'charset'   => 'iso-8859-1'
                    );
					$this->load->library('email', $config);
			        $this->email->set_mailtype("html");
			        $this->email->set_newline("\r\n");
			        $this->email->from("realgalo2020@realmephpromos.com", 'realme Registration');
			        $this->email->to("realmephpromos@realme.com.ph");
			        $this->email->subject('realme Registration 2020');
			        // Name, Address, Contact Info, IMEI, Date of Purchase, Store, Receipt link
			        $this->email->message('This is to inform you that there is an entry for realme realGALO:<br>
			        		<p>
			        			<b>Name: </b><u>'.$client['last_name'].', '.$client['first_name'].' '.$client['middle_name'].'</u><br>
			        			<b>Address: </b><u>'.$client['address'].'</u><br>
			        			<b>Contact: </b><u>'.$client['contact_number'].'</u><br>
			        			<b>IMEI Number: </b><u>'.$client['imei_number'].'</u><br>
			        			<b>Purchase Date: </b><u>'.$client['purchase_date'].'</u><br>
			        			<b>Store: </b><u>'.$client['store_name'].'</u><br>
			        			<b>Receipt: </b><a href="'.base_url('assets/uploads/'.$client['store_receipt']).'" target="_blank">Click here to View</a><br>
			        		</p>
			        	');
			        $this->email->send();
					redirect('registration/success');
				}
				else {
					$header['style'] = array('registration');
					$footer['script'] = array('registration');
					$this->load->view('_shared/onheader', $header);
					$this->load->view('_page/registration/verify', $data);
					$this->load->view('_shared/onfooter', $footer);
				}
			}
			else {
				$header['style'] = array('registration');
				$footer['script'] = array('registration');
				$this->load->view('_shared/onheader', $header);
				$this->load->view('_page/registration/verify', $data);
				$this->load->view('_shared/onfooter', $footer);
			}
		}
	}

	public function success() {
		$header['style'] = array('registration');
		$footer['script'] = FALSE;
		$this->load->view('_shared/onheader', $header);
		$this->load->view('_page/registration/success');
		$this->load->view('_shared/onfooter', $footer);
	}
}
?>