<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    const CLIENT_ID = 'FbIzOc0TtOQtZYtgtk5l';
    const CLIENT_SECRET = 'RJhh1d171p';
    const NAVER_LOGIN_CALLBACK_URL = 'http://34.105.106.219/coupangProject/main/naver_login_callback';
    const LOCAL_NAVER_LOGIN_CALLBACK_URL = 'http://127.0.0.1/main/naver_login_callback';

    public function test() {
        print_r($this->session->all_userdata());
    }

    public function index() {
        $data = [];

        $client_id = self::CLIENT_ID; // 위에서 발급받은 Client ID 입력
        $redirectURI = urlencode($_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? self::LOCAL_NAVER_LOGIN_CALLBACK_URL : self::NAVER_LOGIN_CALLBACK_URL); //자신의 Callback URL 입력
        $state = md5(microtime() . mt_rand());
        $data['apiURL'] = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;

        $this->load->view('crawling/contents', $data);
    }

    public function crawling() {
        $oGet = (object) $this->input->get(null, true);

        if (strlen($oGet->category) == 0) {
            return;
        }

        $this->load->library('Crawling');
        $result = $this->crawling->crawling($oGet->category, $oGet->show_page);

        echo json_encode($result);
    }

    public function naver_login_callback() {
         $client_id = self::CLIENT_ID;
         $client_secret = self::CLIENT_SECRET;

         $code = $this->input->get('code');
         $state = $this->input->get('state');
         $redirectURI = urlencode($_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? self::LOCAL_NAVER_LOGIN_CALLBACK_URL : self::NAVER_LOGIN_CALLBACK_URL); // 현재 Callback Url 입력

         $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;

         $curlResult = $this->get_curl($url, true);

         if($curlResult->status_code == 200) {
            $response = json_decode($curlResult->response);

            $this->naver_info($response);
         } else {
            echo "Error 내용:".$response;
         }
    }

    public function naver_info($response) {
        $access_token = $response->access_token;

        $token = $access_token;
        $header = "Bearer ".$token; // Bearer 다음에 공백 추가
        $url = "https://openapi.naver.com/v1/nid/me";
        $is_post = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = [];
        $headers[] = "Authorization: ".$header;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "status_code:".$status_code."<br>";
        curl_close ($ch);

        if($status_code == 200) {
            $response = json_decode($response);

            $sessionData = [
                'access_token'  => $access_token,
                'email'         => $response->response->email,
                'name'          => $response->response->name,
            ];

            $this->session->set_userdata($sessionData);

            $location_url = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? 'http://127.0.0.1/main' : 'http://34.105.106.219/coupangProject';

            header("Location: {$location_url}");
            exit;
        } else {
            echo "Error 내용:".$response;
        }
    }

    public function naver_logout() {
        // $client_id = self::CLIENT_ID;
        // $client_secret = self::CLIENT_SECRET;
        // $access_token = $this->session->userdata('access_token');

        // $url = "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id={$client_id}&client_secret={$client_secret}&access_token={$access_token}";

        // $curlResult = $this->get_curl($url, true);

        $this->session->sess_destroy();
        $location_url = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? 'http://127.0.0.1/main' : 'http://34.105.106.219/coupangProject';

        header("Location: {$location_url}");
        exit;
    }

    public function get_curl($url, $return = false, $is_post = false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($return) {
            return (object) [
                'response'      => $response,
                'status_code'   => $status_code,
            ];
        }
    }
}
