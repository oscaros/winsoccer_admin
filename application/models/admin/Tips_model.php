<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tips_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


 function getBettips(){
      $this->db->select('id,fixture,odds,prediction,date_submitted');
      $this->db->from('tips');
      $query = $this->db->get();
      return $query->result();
      //print_r($query->result()); 
    
     }

function createTip($additional_data){
     
    //$this->db->insert('tips', $additional_data);
     $this->db->insert('tips',$additional_data);
    
     }

}
