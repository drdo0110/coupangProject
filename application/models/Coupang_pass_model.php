<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupang_pass_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function getCoupangPass() {
        $selectQuery = $this->db
            ->select('
                *
            ')
            ->from('coupang_pass')
            ->get();

        return $selectQuery->row();
    }
}

