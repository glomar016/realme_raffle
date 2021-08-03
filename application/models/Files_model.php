<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Files_model extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

   public function store($data, $tableName)
   {
        return $this->db->insert($tableName, $data);
   }

}
?>