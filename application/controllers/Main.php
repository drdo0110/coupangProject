<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    const CLIENT_ID = 'FbIzOc0TtOQtZYtgtk5l';
    const CLIENT_SECRET = 'RJhh1d171p';
    const NAVER_LOGIN_CALLBACK_URL = 'http://34.105.106.219/coupangProject/main/naver_login_callback';

    public function index() {
        $data = [];

        $client_id = self::CLIENT_ID; // 위에서 발급받은 Client ID 입력
        $redirectURI = urlencode(self::NAVER_LOGIN_CALLBACK_URL); //자신의 Callback URL 입력
        $state = "RAMDOM_STATE";
        $data['apiURL'] = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;

        $this->load->view('crawling/contents', $data);
    }

    public function crawling() {
        // $oGet = (object) $this->input->get(null, true);

        // if (strlen($oGet->category) == 0) {
        //     return;
        // }

        $this->load->library('Crawling');
        $result = $this->crawling->crawling();

        echo json_encode($result);
    }

    public function naver_login_callback() {
         $client_id = self::CLIENT_ID;
         $client_secret = self::CLIENT_SECRET;

         $code = $_GET["code"];
         $state = $_GET["state"];
         $redirectURI = urlencode(self::NAVER_LOGIN_CALLBACK_URL); // 현재 Callback Url 입력

         $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;

         $is_post = false;

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, $is_post);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

         $headers = array();
         $response = curl_exec ($ch);
         $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         echo "status_code:".$status_code;

         curl_close ($ch);

         if($status_code == 200) {
            $data['naver_info'] = json_decode($response);
            $this->load->view('crawling/contents', $data);
         } else {
          echo "Error 내용:".$response;
         }
    }
}
