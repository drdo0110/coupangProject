<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    const CLIENT_ID = 'FbIzOc0TtOQtZYtgtk5l';
    const CLIENT_SECRET = 'RJhh1d171p';
    const NAVER_LOGIN_CALLBACK_URL = 'http://34.105.106.219/coupangProject/main/naver_login_callback';
    const LOCAL_NAVER_LOGIN_CALLBACK_URL = 'http://127.0.0.1/main/naver_login_callback';
    const COUPANG_ID = 'AF9936219';

    public function jnh() {
	    $url = 'https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=1552741507&itemId=2656122108&vendorItemId=70646860854&traceid=V0-153-de36aaf1889d2a60&requestid=20230524012807070132680&token=31850C%7CMIXED';

    	$url = str_replace('//link', '//www', $url);
    	$url = str_replace('/re/', '/vp/products/', $url);

    	$explodeUrl = explode('AFFSDP?', $url);

    	parse_str($explodeUrl[1], $arrParams);

    	$page_key = $arrParams['pageKey'];
    	unset($arrParams['pageKey']);
    	$params = http_build_query($arrParams, '&');

    	$url = $explodeUrl[0] . $page_key . '?' . $params;
    	echo $url;
    }

    public function test() {
        return '{"rCode":"0","rMessage":"게시글 작성 시, \"파트너스 활동을 통해 일정액의 수수료를 제공받을 수 있음\"을 기재하셔야 합니다","data":{"landingUrl":"https://link.coupang.com/re/AFFSRP?lptag=AF9936219&pageKey=food&traceid=V0-163-e95ba2fac0178264&requestid=20230524012807070132680","productData":[{"productId":1552741507,"productName":"페이황 푸주 건두부면","productPrice":9930,"productImage":"https://ads-partners.coupang.com/image1/Nv4pRaCVUX52BNS4Nkumu9-hOcH5DL5o9ZwQ9qJIC2_cLN91BislU29d6ohBxIGfkl-9dwNc_DTY0SUgcsUVbAcpMALGalkdUpow58F796rvmlLH8a2JPG5sr8XM_xUpSsHl_ngoIrUOW7JcY4E36YblHoiP5DqPFCc4lh3XVjcMhd2bl-s98vTqTBlY8nd0wtGaZmL_poggmzmYuFrQGiPYaUFrsOQPj8_dpLeZQzZO91wcTSyNF-ML5HikCJSTcvSsgKGHn45Ssw==","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=1552741507&itemId=2656122108&vendorItemId=70646860854&traceid=V0-153-de36aaf1889d2a60&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"식품","keyword":"food","rank":1,"isRocket":true,"isFreeShipping":false},{"productId":4898921418,"productName":"S.N. FOOD 냉동 인도빵 파라타/ 난(플레인 파라타)Frozen Ruti Paratha Plain1.6KG/20장","productPrice":11900,"productImage":"https://ads-partners.coupang.com/image1/gbsM4xFytjvEot2ZgcKShLjlb4ZdI7UH1CRGi3y1wetJix_MLdBc-KEr1GegymY5Q7Z6HjzxlY_Y5PhwU3oigGKgWBIr2y5v0w0Wmy78OiHmPSlN7vuUk-v5dGY5JspShar4-RpS-_zJpuiFjqPXBqq4inRv6ULqig2GfXcGHImGoiA3wJsW5eZEkO3OR7e94oQqYQ7nCsSyY8gzs_9aH4sbNizFYtQPqEpPGSh01FVUFmcDnea1g-VLVFGbXKQYGTJDqWCFcSg6gCzVrGPst8kQoPkLprdoOdY=","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=4898921418&itemId=6389777713&vendorItemId=73684768932&traceid=V0-153-f3fbfdacf5856beb&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"식품","keyword":"food","rank":2,"isRocket":false,"isFreeShipping":false},{"productId":5049876771,"productName":"S.N. FOOD FROZEN HILSHA(냉동청어)방글라데시, 미얀마 생선 3마리/팩","productPrice":12900,"productImage":"https://ads-partners.coupang.com/image1/q25BDSEThx2YsvkbqwxTR3jjVHl6f0nurs1HictgU3puP-5mxHGJHzZ0QmAZ2MOQj61CwDSvZFNgMVGGwayutcb-n_HeFA-7v2HvH9oBHKSS_n_T8nv93AD0_J3BjZXc8BLR_ZAWv4SENuEPPHxkrFg9Og218xEQ9iAMVDs08uGrLFpDaHO7Y-gNSJnGaNNk1oFUOpOjy6PSdFv3HLZr1tc9B2VFUCsOOjUx2BpYcO3vOLLtr5VzlztxyVjjxf-dgrFjoeQf1oiA6M0jFy8q5F3c4EMRTWpWHaQ=","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=5049876771&itemId=6808959802&vendorItemId=74101612170&traceid=V0-153-032f06664f7157c0&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"식품","keyword":"food","rank":3,"isRocket":false,"isFreeShipping":false},{"productId":6427508066,"productName":"한우물 참치김치 구운주먹밥 100g 20개입 무료배송, 100g, 20개","productPrice":21900,"productImage":"https://ads-partners.coupang.com/image1/GpXvsrilDuGNgAnEGoZQ6Zi1dTd6AiiBTrW9GLh6GLo6ksNKVwegZts4a0OmP7rByt2f6j4fke-JhbbqLM9dA_0jR0CUMIfNLemCC4ZwIy5yFIMx9ICyPcfrv6Ty1Demfd_fXlCtljssMlJzIho1_sLSeiqmCmhIOmW2Z2bOg_OweFDdBu3qxZBl-wKUng2QmYyjTClFx50Uc3Q3_dvTDKOOgPetwgklu42KZVN_q1sFh21i4tr-MYaP6ECFxO9Hppt2uHKJ0KPqQm2M0gcLr8vYlkmtKTvRKkU=","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=6427508066&itemId=13856162445&vendorItemId=85801639879&traceid=V0-153-50003d5a9f6cba81&clickBeacon=jtM4lbowgF1vHa0QVOgZrpIntkb5aaWuLYEXD9AuDSESHyZw%2BqJnPlzet0JZPkpbePxtWIXgwieQMQEfqhoKxH5t2WUGjdd2fhleyD%2FIgnP%2BZzACFZvBsOulup5VvDq%2BkzpkJeSWjgB%2BNS9wbzKK2NXDPy8mmeVm3f6X7Hbhl4CJk63mEd8lrcrnIu5cJDwnO%2FASjqclrRe5VEfoUC%2B8kTKEqC8luzesFVJc844czHfs4UwyAmK8R65pzDysvkovQgms9WApwZ5rA2z3jbdc6%2B86lFD6Shfe3zGvfLQ5EJZ6JyBvt3Fvhcu9VawRfQ9CFhK0un4qJk0Z0C4%2Bk7NyCKPeyS6OfZtWPAFsrn3%2F0cWbuq03fNfnmNqA9js4NNkLTqfl4%2FDw%2FZHPh%2BwIkMRbbEHaekFRrimelcvcl48IuZ1a%2Bpt0SviM5BrWZyDjsbSUAGrCaX%2FEmMOlLowlvazc8I7vuhiofUTZbKvBXRrnfAFG25yRVUUvrhchXXSzZ0j3BX%2FCbil7UEr9sd6Gqq9cnGKr0cEVKzHI855mJz9LmHpot3odmVCK5wHvrb7CdwtRmxPXwpYOHVmkTs%2Fl1iOE%2F%2BdeH5O%2FnMGcgV20ny89NvsYaVn3WeZvoSObfWe7JdRhDqnn8MvWqYpd6n511nB24XivBKEI5ROdU5MaopxmQnmwj%2FI1Q9oFdNPjZeGxHlwN5mgQYcuoWtjZE%2FeDrWvoBwM0UofpYFsQ8SJbGORAbPWu2GmE20qlcNRdUKGwAf8t4ZQTOoDs%2F4UbIZhi83h8Z7sUnWzMnI%2B4Zc2x%2BUkiC8ubQhlsDZD2UeOBWNpSMy5WKit9btzRs8kgo9%2Fbf8L8c6Y6PecRVuGyS7epV%2BZqgQ0%3D&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"식품","keyword":"food","rank":4,"isRocket":false,"isFreeShipping":true},{"productId":5972448394,"productName":"파라타 (냉동)","productPrice":9330,"productImage":"https://ads-partners.coupang.com/image1/8XLyx9c-qSbJoDHq8VnpsnMyMOz5Dr7s10KJ_bCWJD2_VJLv6LbNU3gF4FsBo5GO-s2oiuLz6PJF2LHka4FwKYcwfH2qAQvKndCnfwqh0o4cGwI49DAV_9orjVsl96xFV-qHrxaIkKq22Tajew8IenlbEpAEot-_4D8j9wwhS5QfjW22BGjhbfazlGDab79RDKEtvGmPcRjdZfth8LvJu_anKjfiXDn2Ase411rxHJPnaz3uul0F1NImj4f7h5u5WZJomp_ksm_Ekds=","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=5972448394&itemId=10731396518&vendorItemId=78012004357&traceid=V0-153-3d5e717302eb1b33&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"로켓프레시","keyword":"food","rank":5,"isRocket":true,"isFreeShipping":false},{"productId":2087075298,"productName":"애슐리 통 모짜렐라 핫도그 (냉동), 450g, 2개","productPrice":13800,"productImage":"https://ads-partners.coupang.com/image1/cNyWr_WZJeUXbCSYcEz5hWQruvQzigLoJJ8jXY56mwC9QFAkuRfTy5aLe4TDzoizknbgXeqbUjXcleD5TDlKW-HwhISaFdTL0xa_IkpmE-y8UJW1TetukL3YO-TubfaqXWSAYjvL6pibuK_rI9ZUcOLNBNNJDGmQbotj_AkIx7rmPDZ1oyWdik4-1vj-kPr1ANhRkLVnbfux137ZbjY0TGrPNjsfKXfuMzfZkQrCpy_lRrFggdHhAhsKXLrrq7cH1Ku22w1J9dy1kfqC","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=2087075298&itemId=3545123430&vendorItemId=71531082034&traceid=V0-153-687b7bfa3b59dee2&clickBeacon=jtM4lbowgF1vHa0QVOgZrpIntkb5aaWuLYEXD9AuDSESHyZw%2BqJnPlzet0JZPkpbePxtWIXgwieQMQEfqhoKxPouPQvrujteRisoY8NJUO59VWiFrNCaLjQgg0B2BRK4B380v2G6do600S73Um6W%2FUtXpb3lRHW7YKMxsQkw4mmJk63mEd8lrcrnIu5cJDwnO%2FASjqclrRe5VEfoUC%2B8kTKEqC8luzesFVJc844czHfs4UwyAmK8R65pzDysvkovb%2FJhW6yMi1KOwHsw0C5IwJowMZMxVZHyjUmnF2WPCzhP7CSz%2Bp5QrAF2NPRH6%2BeBFhK0un4qJk0Z0C4%2Bk7NyCNXDB%2Bo5Ua0Fs0OA5IiwF8LOAXrRN9IjzygQWDjL5TRqTqfl4%2FDw%2FZHPh%2BwIkMRbbPFGaQj7hqHQU5E5vun6bIUZ0dsTw1D4s1DccSv02utQCCgA9KJMmdByxJ8INSetMI4t6OeZC%2FnGKuccF9o4WCOMaCONsMyqcDPGba78RPyzOV1baffdn6gILtUqAXceeQ7LyE5ZvEI42N%2FxLJYXPZxDSsX52Cql1dJaJUZDxplKUba5VWqzzYYCPCEXg6A4Jgov6S28N77z66Vfyen8fKj9GPM%2BhNkMDd0c1J2m3zX2ejSP06q1IT1ScitWK79YiGr6sYpapo03bQqW5wrBHWyRc1uPvtz%2F4Kpw6U76C917PdFErIO%2B7BfNYXGzrsASM3kuQ%2BNd70kNPJftjs97fCjdEAlHrySUyS%2BygTMjTJ8O2NanH82F%2F8gT68v%2B1JzgZiSV%2BDwIphn6yvTrml7t8jL3mte6InwYw%2BoDnyCuw8LgbJuRJ7Dais8rgRIxuUYAOw31Vi%2FxzAphC5e8j86Gpv0%3D&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"식품","keyword":"food","rank":6,"isRocket":true,"isFreeShipping":false},{"productId":6335510621,"productName":"[로켓프레시] 에쓰푸드 쿡페파로니 2 (냉동)","productPrice":14530,"productImage":"https://ads-partners.coupang.com/image1/9gDudkpxhztCfGGP9vbzZXhkEsxkTxPVqeFdngxasU6DuKYIgCVwo2Sq7BBnUuUq9blblfL0eeCzxeUe2TzzNd2mDssDOqZgF-_zwBllsyVHw-PfdyAhGPPCJPnfMeDcrDtCvwzxoFdSD1b6l16IDQt99NQnzQRIJkhv2I2ImCJio9Y6viCLYU5Dfyq6akxYW15bG3MvA_EvEnHAPLzhRqOzmQErsX4R-u4HOIMbcVplL58-3zz_p9ph9DSNWUEMyN4ZI7vFpkMPZY0=","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=6335510621&itemId=13266739841&vendorItemId=80524379005&traceid=V0-153-9ec54b8933e23d96&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"로켓프레시","keyword":"food","rank":7,"isRocket":true,"isFreeShipping":false},{"productId":187349213,"productName":"곰곰 햄야채 볶음밥 (냉동)","productPrice":11730,"productImage":"https://ads-partners.coupang.com/image1/OT2GDwddA5Q-AwYPOTKGvZFwqqdTnkb4Lr7dPQVwa69zQQz7kmO_Y5vnI0tj69l8_zvx_QaPKR71_fSr9pafaDqdjUKO1hiG-JLSZJK4dqnEHHX8Vo1UprGpKam-H135zuc_rFdlYOCUZzw7rDNlAU2b2B1vaByXQo-wG8zeCa1o0QxcCTCjkfKVIvlNTfrCCv53noe_0Stkg1BYRoW8unwn1JEgihXj84I6NCBYbN5nmFWLCQAYjeyNmi2xyBb1-vD0ulArOCFWHw==","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=187349213&itemId=983874258&vendorItemId=5510637222&traceid=V0-153-b32c808dbf871e39&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"로켓프레시","keyword":"food","rank":8,"isRocket":true,"isFreeShipping":false},{"productId":6319865673,"productName":"[로켓프레시] 에쓰푸드 포크엔비프탑핑 (냉동)","productPrice":14620,"productImage":"https://ads-partners.coupang.com/image1/Gp1np0qLPtf2C119GmIfwYWGiOU6WqsNgf94DIYHi8Gpl5XQG7OEH5M0Z7nu9lotKJ8LEemYBr5tOT8WCukl_7UExaj4a7kP0D6JtDH9kZCYmSDmnSXCptQl0NrWhjeUxO-s770uVnvFi64j78ML-QrK3fiUshrllSNFQvp--9YoN8ahaoU7SOo79NJEPyRLipwZ2rRWJprOjSxj0Ugk2przyeR8UxSDMPmiKLeLx1_UL0Coq-iyekuFK-AIsSLvtiWGYSLLUdxu92Wf","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=6319865673&itemId=13165859319&vendorItemId=80424560047&traceid=V0-153-ab47b96d83375422&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"로켓프레시","keyword":"food","rank":9,"isRocket":true,"isFreeShipping":false},{"productId":4649912257,"productName":"[디자인푸드]밀리너스 10종 10팩 냉동도시락 건강식단 아침 점심 저녁 직장인 한끼식사 식단조절 다이어트 간편식 양많은 맛있는 냉동도시락","productPrice":36900,"productImage":"https://ads-partners.coupang.com/image1/IeDfgVA8olZgl3iBIYP_xDPzVS5R2kAUKpfcFrpKvvMTV9U9-IK08bzIXEz_2pq6Ti1hqIWcZ0V42tSbqfP4yWyzkqiZEYOOCS-lPawCnIaR38d1E4ZMZWUlqXovpuRzyzvsqm6harjIqGZ_wrN2KnivNtAUhJ2alhWPi79p-SLb2NCRswxontqwfYORfb563Pu-cJm5CWXM3FlUD6nHA71aGDaKlcy0oxl6k2ulmcNzq39j5qOLPOhGrOxOZoDTk7v7XvD3Gt485QFPf9uFYPA0-uc2CteP-sc=","productUrl":"https://link.coupang.com/re/AFFSDP?lptag=AF9936219&pageKey=4649912257&itemId=5795954959&vendorItemId=73094448056&traceid=V0-153-85b5df34c7bfac3b&requestid=20230524012807070132680&token=31850C%7CMIXED","categoryName":"식품","keyword":"food","rank":10,"isRocket":false,"isFreeShipping":true}]}}';
    }

    public function getSession() {
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
        $this->session->sess_destroy();
        $location_url = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? 'http://127.0.0.1/main' : 'http://34.105.106.219/coupangProject';

        header("Location: {$location_url}");
        exit;
    }

    public function coupangProductList() {

        $result = json_decode($this->test());

        echo json_encode($result->data->productData);

        exit;
        $oGet = (object) $this->input->get(null);
        $keyword = urlencode($oGet->keyword);

        $url = "/v2/providers/affiliate_open_api/apis/openapi/products/search?keyword={$keyword}&limit=9";

        $result = $this->get_coupang_curl('GET', $url);
        $result = json_decode($result);


    }

    public function imgLinkChange($url) {
	   $url = str_replace('//link', '//www', $url);
       $url = str_replace('/re/', '/vp/products/', $url);

       $explodeUrl = explode('AFFSDP?', $url);

       parse_str($explodeUrl[1], $arrParams);

       $page_key = $arrParams['pageKey'];
       unset($arrParams['pageKey']);
       $params = http_build_query($arrParams, '&');

	   $url = $explodeUrl[0] . $page_key . '?' . $params . '"';

	   return $url;
}

    public function coupangLinkChange() {
        $url = '/v2/providers/affiliate_open_api/apis/openapi/v1/deeplink';

        $oPost = (object) $this->input->post(null);

        if (isset($oPost->coupangLinks) && count($oPost->coupangLinks) > 0) {
            $ids = [];
            foreach ($oPost->coupangLinks as &$coupangLinks) {
                $explodeData = explode('|', $coupangLinks);

        		$coupangLinks = $explodeData[0];
        		if (strpos($coupangLinks, 'link.coupang.com') !== false) {
        			$coupangLinks = $this->imgLinkChange($coupangLinks);
        		}

                if (isset($explodeData[1])) {
                    $ids[] = $explodeData[1];
                }
            }
	    
            $str = implode(',', $oPost->coupangLinks);

            $strjson = "
                {
                    \"coupangUrls\": [
                        {$str}
                    ]
                }
            ";

            $result = $this->get_coupang_curl('POST', $url, $strjson);
            $result = json_decode($result);

            if ($result->rCode == 0) {
                foreach ($result->data as $key => &$value) {
                    if (isset($ids[$key])) {
                        $value->id = $ids[$key];
                    }
                }

                echo json_encode($result->data);
            }

        }
    }

    public function get_curl($url, $return = false, $is_post = false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 상대 호스트 ssl 인증서 유효성 무시를 위해
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 상대 호스트 ssl 인증서 유효성 무시를 위해

        if ($is_post) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

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

    public function get_coupang_curl($method, $path, $strjson = null) {
        date_default_timezone_set("GMT+0");

        $datetime = date("ymd").'T'.date("His").'Z';

        $message = $datetime.$method.str_replace("?", "", $path);

        // Replace with your own ACCESS_KEY and SECRET_KEY
        $ACCESS_KEY = "d8cdbc33-630d-4d99-80a4-2a099d2c6597";
        $SECRET_KEY = "0d04f98a14c7defc51809eb3fbc3617b7fbb17f9";

        $algorithm = "HmacSHA256";

        $signature = hash_hmac('sha256', $message, $SECRET_KEY);

        //print($message."\n".$SECRET_KEY."\n".$signature."\n");

        $authorization  = "CEA algorithm=HmacSHA256, access-key=".$ACCESS_KEY.", signed-date=".$datetime.", signature=".$signature;

        $url = 'https://api-gateway.coupang.com'.$path;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:  application/json;charset=UTF-8", "Authorization:".$authorization));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $strjson);
        }

        $result = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $result;
    }
}


