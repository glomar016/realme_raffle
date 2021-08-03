<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

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
    }

	public function index()
	{
        $data['password'] = "r3@lm3";

        $this->load->view('_shared/onheader');
		$this->load->view('_page/registration/export_registration', $data);
		$this->load->view('_shared/onfooter');
	}

    public function registration()
    {
        $this->load->model("files_model");
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array("id", "first_name", "middle_name", "last_name", "email", "address"
        , "contact_number", "phone_model", "imei_id", "purchase_date", "store_name", "store_receipt", "agent"
        , "platform", "ip_address", "is_deleted", "created_at", "is_verified"
        );

        $column = 0;

        foreach($table_columns as $field)
        {
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
        }

        $registration_data = $this->files_model->get_registration();

        $excel_row = 2;

        foreach($registration_data as $row)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->id);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->first_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->middle_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->last_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->email);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->address);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->contact_number);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->phone_model);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->imei_id);
            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->purchase_date);
            $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->store_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->store_receipt);
            $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->agent);
            $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->platform);
            $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->ip_address);
            $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->is_deleted);
            $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $row->created_at);
            $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $row->is_verified);
        $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="List of Registration.xls"');
        $object_writer->save('php://output');


    }
}
?>