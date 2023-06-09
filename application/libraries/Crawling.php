<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crawling {
    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function crawling($category = '추천', $page) {
        ini_set('memory_limit', -1);

        $this->ci->load->library('Simple_html_dom');

        $category = urlencode(trim($category));

        $result = [];
        for ($i = 1; $i <= $page ; $i++) {
            $url = "https://kin.naver.com/search/noAnswerList.naver?query={$category}&dirId=5&cs=utf8&page={$i}&pageOffset=0&isPrevPage=true";

            $headerHtml = str_get_html($this->get_curl($url));
            $trList = $headerHtml->find('.search_noAnswer_noAnswerList', 0)->find('table', 0)->find('tbody', 0)->find('tr');

            foreach ($trList as $key => $tr) {
                if (count($tr->find('.title')) == 0) {
                    continue;
                }

                $title = $tr->find('.title', 0)->find('a', 0)->plaintext; //제목

                if (strpos($title, '광고') !== false) {
                    continue;
                }

                if (strpos($title, '홍보') !== false) {
                    $title = str_replace('홍보', '<span style="color:red;font-weight: bold;">홍보</span>', $title);
                }

                $commentCnt = $tr->find('.t_num', 0)->plaintext; //답변 카운트
                $setDateTime = $tr->find('.t_num', 1)->plaintext; //등록 일
                $detailLink = $tr->find('.title', 0)->find('a', 0)->href; //상세 링크

                $detailPage = str_get_html($this->get_curl($detailLink)); //상세 페이지

                $questionContent = '';
                if (sizeof($detailPage->find('.question-content')) > 0 && ! empty($detailPage->find('.question-content', 0)->find('.c-heading__content', 0)->plaintext)) {
                    $questionContent = $detailPage->find('.question-content', 0)->find('.c-heading__content', 0)->plaintext; //질문
                }

                if ($questionContent == '') {
                    if (sizeof($detailPage->find('.question-content')) > 0 && ! empty($detailPage->find('.question-content', 0)->find('div.title', 0)->plaintext)) {
                        $questionContent = $detailPage->find('.question-content', 0)->find('div.title', 0)->plaintext; //질문
                    }
                }

                if (strpos($questionContent, '광고') !== false) {
                    continue;
                }

                if (strpos($questionContent, '홍보') !== false) {
                    $questionContent = str_replace('홍보', '<span style="color:red;font-weight: bold;">홍보</span>', $questionContent);
                }

                //채택 관련
                if (sizeof($detailPage->find('.answer-content')) > 0) {
                    $answerContent = $detailPage->find('.answer-content', 0)->find('.answer-content__item._contentWrap._answer');

                    $selection = false;
                    foreach ($answerContent as $answer) {
                        if (isset($answer->find('.adoptCheck', 0)->plaintext)) {
                            $selection = true;
                        }
                    }

                    if ($selection) {
                        continue;
                    }
                }

                $result[] = [
                    'title'             => $title,
                    'commentCnt'        => $commentCnt,
                    'setDateTime'       => $setDateTime,
                    'questionContent'   => $questionContent,
                    'detailLink'        => $detailLink,
                ];
            }
        }

        return $result;
    }

    private function get_curl($url) {
        $options = [
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // do not return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);

        if (isset($content) && ! empty($content)) {
            return $content;
        }

        return FALSE;
    }
}
