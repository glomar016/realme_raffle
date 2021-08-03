<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

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
        $this->load->helper(array('url'));
		$this->load->model('files_model');
    }

	public function index()
	{

		$data['password'] = "r3@lm3";
		
		$this->load->view('_shared/onheader');
		// $this->load->view('_page/registration/verify_admin');
		$this->load->view('_page/registration/import_store', $data);
		$this->load->view('_shared/onfooter');
	}

	public function store()
	{
		$this->load->model('files_model');
		if(isset($_FILES["excelFile"]["name"]))
		{
			$config['upload_path'] = './assets/files';
			$config['allowed_types'] = 'xlsx';
			
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload('excelFile'))
			{
				echo $this->upload->display_errors();
			}
			else
			{
				$fileInfo = $this->upload->data();
				$file = 'assets/files/'.$fileInfo['file_name'];
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

				foreach ($cell_collection as $cell) {
					$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
					$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
					$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getCalculatedValue();
				 
					//The header will/should be in row 1 only. of course, this can be modified to suit your need.
					if ($row == 1) {
						$header[$row][$column] = $data_value;
					} 
					else if($data_value == ""){
						
					}
					else {
						$arr_data[$row][$column] = $data_value;
					}
				}
				 
				//send the data in an array format
				$data['header'] = $header;
				$userDetails['values'] = $arr_data;
			}

			

			foreach($userDetails['values'] as $row){
				$insert_data = array(
					'store_name' => $row['E'],
				);
				
				$insert = $this->files_model->store($insert_data, "store_names");
				echo json_encode($insert);
			}
		
		}
	}

}
?>