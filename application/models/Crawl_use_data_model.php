<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crawl_use_data_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function setCrawlUseData($data) {
        $this->db->insert('crawl_use_data', $data);
    }
}
