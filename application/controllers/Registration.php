<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'security'));
        $this->load->library('form_validation');
		$this->load->library('upload');
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
            echo json_encode('IMEI is required');
            // return FALSE;
        } elseif ($this->r->valid_imei($value) === FALSE) {
        	// $this->form_validation->set_message('is_valid_imei', 'Your {field} is not registered on realme Device.');
			echo json_encode('Your IMEI is not registered on realme Device');
            // return FALSE;
        } elseif ($this->r->is_registered_imei($value) === FALSE) {
        	// $this->form_validation->set_message('is_valid_imei', '{field} is already registered.');
			echo json_encode('Your IMEI is already registered.');
            // return FALSE;
        }
        else {
			// return TRUE;
        	echo json_encode('Success');
        }
    }

    public function is_valid_image() {
    	if ($_FILES['storeReceipt']) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["storeReceipt"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png");

			
            if(in_array($imageFileType, $extensions_arr) ){
				$filename = $this->input->post('imei') . '-' . date('YmsHis');
				$target_dir = "assets/uploads/";
				$target_file = $target_dir . basename($_FILES["storeReceipt"]["name"]);
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				
				$new_file = $filename . '.' . $imageFileType;

				//Upload image
        		move_uploaded_file($_FILES['storeReceipt']['tmp_name'], $target_dir.$new_file);

				echo json_encode('Success');
                // return TRUE;
            }
            else {
                // $this->form_validation->set_message('is_valid_image', '{field} must be a valid image.');
				echo json_encode('Store Receipt must be a valid image.');
                return FALSE;
            }
        }
        else {
            // $this->form_validation->set_message('is_valid_image', 'Please upload {field}.');
			echo json_encode('Please upload Store Receipt.');
            return FALSE;
        }
    }

	public function index()
	{
		$header['style'] = array('registration');
		$body['devices'] = $this->r->get_devices();
		$body['stores'] = $this->r->get_stores();
		$footer['script'] = array('registration');
        $body['current_time'] = $this->r->PH_Date();

		$this->load->view('_shared/onheader', $header);
		$this->load->view('_page/registration/index', $body);
		$this->load->view('_shared/onfooter', $footer);
	}

	public function submit_registration()
	{
		$postdata = array(
			'first_name' => ucwords(strtolower($this->input->post('firstName'))),
    		'middle_name' => ucwords(strtolower($this->input->post('middleName'))),
    		'last_name' => ucwords(strtolower($this->input->post('lastName'))),
    		'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
    		'contact_number' => $this->input->post('contactNumber'),
            'phone_model' => $this->input->post('phoneModel'),
    		'imei_id' => $this->input->post('imei'),
            'purchase_date' => $this->input->post('purchaseDate'),
            'store_name' => $this->input->post('storeName'),
			'storeReceipt' => $this->input->post('storeReceipt')
		);

		$id = $this->r->insert($postdata);
		
		echo json_encode($id);
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
		        $this->email->subject('realme Registration 2021');

				$realmelogo = base_url().'assets/img/realme-logo.png';
				$rafflepromo = base_url().'assets/img/Raffle-Promo-600x155.jpg';
				$realme02 = base_url().'assets/img/realme-02.png';
				$this->email->attach($realmelogo);
				$this->email->attach($rafflepromo);
				$this->email->attach($realme02);
				$cidrealmelogo = $this->email->attachment_cid($realmelogo);
				$cidrafflepromo = $this->email->attachment_cid($rafflepromo);
				$cidrealme02 = $this->email->attachment_cid($realme02);


				$htmlContent = ' 
                <html> 
					<head> 
						<title>Realme Registration 2021</title> 
					</head> 
					<body style="background-color: #091548; max-width:700px; margin:auto; padding:100px">  
					<div style="margin:50px; background-color:#222a5b; border-radius: 25px; padding: 10px;">
						<div style="text-align: center; margin:0px; padding:25px;">
						<br><br>
						<div style="margin-top: -150px">
							<img src="cid:' .$cidrealmelogo.'"><br>
						</div>
							<h2 style="color:white; font-family:arela Round, Trebuchet MS, Helvetica, sans-serif;">Congratulations!</h3> 
							<h4 style="color:white; font-family:arela Round, Trebuchet MS, Helvetica, sans-serif;" >Hi '.$result['first_name'].',<br><br>
													Thank you for joining our promo! Your verification code is: '.$result['verification_code'].'. Please enter this back in the promo registration website to validate your raffle entry.<br><br>
													realme Philippines</h2> 
							<h1 style="text-align: center; color:yellow; margin:0px;"></h1>
						</div>
						<div style="color:white; text-align:center">
							<br>
								<img style="width:435px" src="cid:' .$cidrafflepromo.'">
						</div> <br><br>
						
					</div>
					<div style="color:white; text-align:center">
							<br>
								<img style="margin-top: -50px; width:145px" src="cid:' .$cidrealme02.'">
						</div> 
					</body> 
				</html>
				';

				$this->email->message($htmlContent);

		        // $this->email->message('
    		    //     Hi '.$result['first_name'].',<br><br>
    		    //     Thank you for joining our promo! Your verification code is: '.$result['verification_code'].'. Please enter this back in the promo registration website to validate your raffle entry.<br><br>
    		    //     realme Philippines');

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