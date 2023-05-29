<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupang_account_info_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function getCoupangAccountInfo($data) {
        $selectQuery = $this->db
            ->select('
                *
            ')
            ->from('coupang_account_info')
            ->where('seq', $data->user)
            ->get();

        return $selectQuery->row();
    }

    public function accountUpdate($data) {
        return $this->db->update('coupang_account_info', $data['set'], $data['where']);
    }
}

