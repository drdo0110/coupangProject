<html>
    <head>
        <meta charset="utf-8">
        <title>JNH</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <style>
        table {
            width: 100%;
            border: 1px solid #444444;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #444444;
            padding: 1px;
            text-align: center;
        }
        ul, li {
            list-style-type: none;
        }
        .header {
            height: 5%;
        }
        .wrap {
            height: 95%;
        }
        .left-box {
            width: calc(100% - 70%);
            height: 100%;
	    float: left;
            margin-right:1%;
        }
        .middle-box {
            width: calc(70% - 32%);
            height: 95%;
            border: 1px solid #ccc;
            float: left;
        }
        .right-box {
	    width: calc(32% - 2%);
	    height: 100%;
            float: right;
        }
        .questionContent-bottom a {
            float: left;
            width: 85%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .right-box textarea {
            width: 100%;
            height: 100%;
        }
        .questionContent-text {
            padding: 5px;
            height: 15%;
            border: 1px solid #ccc;
            position: absolute;
            width: 29.1%;
            z-index: 100;
            background: #fff;
        }
        .textarea-style {
            position: relative;
            height: 54%;
        }
        .addLink {
            position: relative;
            height: 20%;
            border: 1px solid #ccc;
            margin: 155px 0 5px 0;
        }
        .addLink input[type="text"] {
            margin: 4px;
        }
        .middle-box ul li {
            width: 210px;
            height: 250px;
            border: 1px solid #ccc;
            float: left;
            margin: 6px 20px 6px -10px;
        }
    </style>
    <body>
        <div class="header">
            <input type="hidden" id="remote" value="<?=$_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? 'local' : 'production'?>">
            <div style="float: right;">
                <?php if ( ! empty($this->session->userdata('email')) && $this->session->userdata('name')): ?>
                    <div style="float: left;margin: 5px 10px 0 0;"><?=$this->session->userdata('email') . '(' . $this->session->userdata('name') . ')'?></div>
                    <a style="float: right;" class="naver_logout"><img style="height: 35px;" src="http://static.nid.naver.com/oauth/small_g_out.PNG"/></a>
                <?php else: ?>
                    <a style="float: right;" class="naver_login" href="<?=$apiURL ?>"><img style="height: 35px;" src="http://static.nid.naver.com/oauth/small_g_in.PNG"/></a>
                <?php endif ?>
            </div>
            page :
            <select name="show_page">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?=$i?>"><?=$i?></option>
                <?php endfor; ?>
            </select>
            <input type="text" name="category" placeholder="카테고리"> <button id="search">조회</button>
            <input type="text" name="coupang-category" placeholder="쿠팡 카테고리" style="margin-left:16.1%;"> <button id="coupang-search">
            쿠팡 조회</button>
            <div style="font-size:12px;display: contents;">
                검색 횟수 : <div id="cnt" style="display: contents;"><?=$cnt; ?> | </div>
                초기화 : <?=$end_time; ?>
            </div>
        </div>
        <div class="wrap">
            <div id="time_end" style="height: 15px;"></div>

            <!-- 지식인 -->
            <div class="left-box">
                <table style="display: none;">
                    <thead>
                        <tr>
                            <th style="width: 75%;">제목</th>
                            <th style="width: 8%;">답변 수</th>
                            <th style="width: 10%;">등록 일</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="page" style="float: right;">
                    <ul>
                    </ul>
                </div>
                <div id="loading" style="text-align: center;font-size: 17px;line-height: 140px;"></div>
            </div>

            <!-- 쿠팡 -->
            <div class="middle-box">
                <ul>

                </ul>
            </div>

            <!-- etc -->
            <div class="right-box">
                <div class="questionContent-text">
                    <div class="questionContent-top" style="height: 82%;overflow: hidden;font-size: 15px;">
                        <div style="text-align: center;">제목을 선택해 주세요.</div>
                    </div>
                    <div class="questionContent-bottom">

                    </div>
                </div>
                <div class="addLink">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <div>
                            <input type="text" data-type="default" id="coupang-url-<?=$i?>" style="width: 56%;" placeholder="일반 링크"> <input type="text" id="coupang-url-<?=$i?>-change" style="width: 31%;" placeholder="변환 된 링크" readonly>
                            <button name="short-link-copy">복사</button>
                            <br>
                        </div>
                    <?php endfor; ?>
                    <button id="url-change" style="margin-left: 4px;">링크 변환</button>
                    <button id="url-reset" style="float:right;margin-right: 4px;">링크 리셋</button>
                </div>
                <div class="textarea-style">
                    <button id="default_setting">기본 문구 추가</button>
                    <button id="link_add_setting">체크박스 선택 후 문구 추가</button>
                    <textarea name="" id="content"></textarea>

                    <div style="float: left;">
                        <button id="set" style="margin-top:2px;">지식인 답변 달기</button>
                    </div>
                    <div style="float:right;">
                        <button id="reset">RESET</button>
                        <button id="copy">COPY</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    // $(document).ready(() => {
    //     setInterval(() => {
    //         diffDay();
    //     }, 1000);
    // });

    // function diffDay() {
    //     const masTime = new Date("2023-05-28");
    //     const todayTime = new Date();

    //     const diff = masTime - todayTime;

    //     const diffHour = Math.floor((diff / (1000*60*60)) % 24);
    //     const diffMin = Math.floor((diff / (1000*60)) % 60);
    //     const diffSec = Math.floor(diff / 1000 % 60);

    //     remainTime.innerText = `${diffHour}시간 ${diffMin}분 ${diffSec}초`;
    // }

    //디테일 내용 토글
    $(document).on('click', '#toggle', (e) => {
        let target = $(e.target);

        if (target.data('type') == 'open') {
            target.data('type', 'close');
            target.text('접기');

            $('.questionContent-text').css('height', '55%');
            $('.questionContent-top').css('height', '95%');
        } else {
            target.data('type', 'open');
            target.text('펼치기');

            $('.questionContent-text').css('height', '');
            $('.questionContent-top').css('height', '82%');
        }
    });

    //텍스트 리셋
    $(document).on('click', '#reset', (e) => {
        if (confirm('정말로 RESET 하시겠습니까?')) {
            $('#content').val('');
        }
    })

    //카피
    $(document).on('click', '#copy', (e) => {
        copy($('#content'));
    });

    $(document).on('click', '[name="short-link-copy"]', (e) => {
        copy($(e.target).parent().find($('[id*="change"]')));
        $(e.target).parent().find($('[id*="change"]')).attr('type', 'text');
    })

    let loading = null;
    let start = false;
    let contentResult = [];
    $(document).on('click', '#search', (e) => {
        if (start) {
            alert('이미 검색중 입니다.');
            return;
        }

        start = true;
        let loadingCount = 0;
        let category = $('[name="category"]').val();
        let show_page = $('[name="show_page"]').val();

        if (category == '') {
            alert('카테고리명을 입력하세요.');
            return;
        }

        $('table').hide();
        $('.left-box tbody').empty();
        $('#page ul').empty();
        $('#time_end').empty();

        $.ajax({
            url : 'crawling',
            data : {
                category : category,
                show_page : show_page
            },
            type : 'get',
            datatype : 'json',
            beforeSend: function() {
                $('#loading').append('Loading');
                loading = setInterval(function() {
                    loadingCount += 1;
                    $('#loading').append('.');
                }, 1000);
            },
            complete:function() {
                $('#time_end').prepend(`<span id="succ" style="font-size:12px;">총 <b>${loadingCount}</b>초 걸렸습니다.</span>`);

                clearInterval(loading);
            },
            success: (res) => {
                let data = JSON.parse(res);
                contentResult = data;

                dataView(contentResult);
            }
        });
    });

    //페이징 처리
    $(document).on('click', '.pagenation', (e) => {
        dataView(contentResult, $(e.target).data('page'));
    });

    //상세 보기
    let clickDetail = '';
    $(document).on('click', '.detail', (e) => {
        let target = $(e.target),
            tr = target.parents('tr');

        $('.questionContent-top').empty();
        $('.questionContent-top').text(tr.data('questioncontent').trim());

        $('.questionContent-bottom').empty();
        $('.questionContent-bottom').append('<a href="' + tr.data('link') + '" target="_blank">' + tr.data('link').trim() + '</a>');
        $('.questionContent-bottom').append('<button id="toggle" style="float:right;" data-type="open">펼치기</button>');

        clickDetail = tr.data('link');

        $('tr').css('background', 'none');
        tr.css('background', 'beige');
    });

    //로그아웃
    let myWindow;
    $(document).on('click', '.naver_logout', (e) => {
        let width = window.innerWidth;
        let height = window.innerHeight;
        let remote = $('#remote');

        myWindow = window.open('http://nid.naver.com/nidlogin.logout', '네이버팝업', 'width=' + width + ',' + 'height=' + height);
        setTimeout(() => {
            myWindow.close();
            window.location.href = remote.val() == 'local' ? '/main/naver_logout' : '/coupangProject/main/naver_logout';
        }, 200);
    });

    //체크 박스 추가 후 문구 추가
    $(document).on('click', '#link_add_setting', (e) => {
        if ($('.all-data-insert:checked').length == 0) {
            alert('선택된 상품이 없습니다.');
            return;
        }

        let coupangLinks = [];
        $.each($('.all-data-insert:checked'), (idx, el) => {
            let $el = $(el);

            coupangLinks.push('"' + $el.parent().parent().find('.link-copy').attr('data-long-link') + '"');
        });

        $.ajax({
            url : 'coupangLinkChange',
            data : {
                coupangLinks : coupangLinks
            },
            type : 'post',
            datatype : 'json',
            success: (res) => {
                let data = JSON.parse(res);

                let tag = "안녕하세요! \n\n\n\n";
                $.each(data, (idx, val) => {
                    tag += val.shortenUrl + "\n\n\n";
                });
                tag += '*쿠팡파트너스 활동의 일환으로 수수료를 받을 수 있습니다';

                $('textarea#content').val('');
                $('textarea#content').val(tag);
            }
        });

    });

    //기본 문구 추가
    $(document).on('click', '#default_setting', (e) => {
        $('textarea#content').val('');
        $('textarea#content').val("안녕하세요! \n\n\n\n\n\n\n\n\n\n\n\n\n *쿠팡파트너스 활동의 일환으로 수수료를 받을 수 있습니다");
    });

    //쿠팡 상품 검색
    $(document).on('click', '#coupang-search', (e) => {
        if ($('[name="coupang-category"]').val() == '') {
            alert('쿠팡 상품명을 검색해주세요.');
            return;
        }

        $.ajax({
            url : 'coupangProductList',
            data : {
                keyword : $('[name="coupang-category"]').val()
            },
            type : 'get',
            datatype : 'json',
            success: (res) => {
                let data = JSON.parse(res);

                if (typeof data.status != 'undefined' && data.status == false) {
                    alert(data.msg);
                    return;
                }

                let tag = '';
                $.each(data.productData, (idx, val) => {
                    tag += `
                        <li>
                            <div>
                                <div style="position: absolute;width: 100%;height: 4%;">
                                    <input type="checkbox" style="position: absolute;width: 15px;height: 15px;" class="all-data-insert">
                                </div>
                                <div>
                                    <a href="${val.productUrl}" target="_blank">
                                        <img style="width:100%;height: 75%;" src="${val.productImage}" alt="">
                                    </a>
                                </div>
                                <div style="height:29px; text-align: center;font-size: 11px;display: -webkit-box;word-wrap: break-word; -webkit-line-clamp: 2; -webkit-box-orient: vertical; text-overflow: ellipsis; overflow: hidden;">${val.productName}</div>
                                <button id="link-copy" class="link-copy" data-long-link="${val.productUrl}" style="margin: 3px 0 0 15px;width: 85px;">링크 복사</button>
                                <button id="item-click" class="item-click" style="margin: 0px 0 0 6px;width: 85px;">선택 하기</button>
                                <input type="hidden" id="short-url">
                            </div>
                        </li>
                    `;
                });

                $('.middle-box ul').empty();
                $('.middle-box ul').append(tag);

                $('#cnt').text(data.cnt);
            }
        });
    });

    //쿠팡 변환된 링크 1개 복사
    $(document).on('click', '.link-copy', (e) => {
        let target = $(e.target);

        let coupangLinks = [];
        coupangLinks.push('"' + $('.link-copy').attr('data-long-link') + '"');

        $.ajax({
            url : 'coupangLinkChange',
            data : {
                coupangLinks : coupangLinks
            },
            type : 'post',
            datatype : 'json',
            success: (res) => {
                let data = JSON.parse(res);

                target.parent().find('#short-url').val(data[0].shortenUrl);

                copy(target.parent().find('#short-url'));
            }
        });
    });

    //아이템 선택
    $(document).on('click', '.item-click', (e) => {
        let target = $(e.target);

        if (target.parent().find('input:checkbox').is(':checked')) {
            target.parent().find('input:checkbox').attr('checked', false);
            target.text('선택 하기');
        } else {
            target.parent().find('input:checkbox').attr('checked', true);
            target.text('선택 해제');
        }
    });

    //쿠팡 링크 변경
    $(document).on('click', '#url-change', (e) => {
        let l = $('.addLink > div > input[data-type="default"]');

        let cnt = 0;
        $.each(l, (idx, el) => {
            if ($(el).val() != '') {
                cnt++;
            }
        })

        if (cnt == 0) {
            alert('변경 할 링크가 없습니다.');
            return;
        }

        let coupangLinks = [];
        $.each(l, (idx, el) => {
            let $el = $(el);

            if ($el.val() != '') {
                coupangLinks.push('"' + $el.val() + '"' + '|' + $el.attr('id'));
            }
        });

        $.ajax({
            url : 'coupangLinkChange',
            data : {
                coupangLinks : coupangLinks
            },
            type : 'post',
            datatype : 'json',
            success: (res) => {
                let data = JSON.parse(res);

                $.each(data, (idx, val) => {
                    let coupang_link = $(`#${val.id}-change`);
                    let coupang_detail_link = $(`.${val.id}-detail-open`);

                    coupang_link.val(val.shortenUrl);
                    coupang_detail_link.attr('data-url', val.shortenUrl);
                })
            }
        });
    });

    //쿠팡 링크 리셋
    $(document).on('click', '#url-reset', (e) => {
        if (confirm('입력하신 링크 및 변환된 쿠팡링크를 모두 지우시겠습니까?')) {
            $('.addLink input:text').val('');
        }
    });

    //쿠팡 디테일 페이지
    $(document).on('click', '[name="coupang-detail"]', (e) => {
        let target = $(e.target);
        window.open(target.data('url'));
    });

    //지식인 답변 창 오픈
    $(document).on('click', '#set', (e) => {
        e.preventDefault();

        if (clickDetail == '' || clickDetail == null) {
            alert('선택된 값이 없습니다');
            return;
        }

        const queryString = new URL(clickDetail);
        const urlParams = queryString.searchParams;

        let dirId = urlParams.get('dirId');
        let docId = urlParams.get('docId');

        let url = `https://m.kin.naver.com/mobile/answer/registerForm.naver?dirId=${dirId}&docId=${docId}`;

        window.open(url, '지식인', 'width=1000px,height=700px,top=150px,left=450px');
    });

    function copy(id) {
        // 화면에서 hidden 처리한 input box type을 text로 일시 변환
        id.attr('type', 'text');
        // input에 담긴 데이터를 선택
        id.select();
        //  clipboard에 데이터 복사
        var copy = document.execCommand('copy');
        // input box를 다시 hidden 처리
        id.attr('type', 'hidden');
        // 사용자 알림
        if(copy) {
            alert("복사완료");
        }
    }

    function dataView(contentResult, page = 1) {
        $('.left-box tbody').empty();
        $('#page ul').empty();
        $('#loading').empty();
        $('table').show();

        let limit = 20;
        let tag = '';
        if (contentResult.length > 0) {
            let value = contentResult.slice((page - 1) * limit, limit * page);
            $.each(value, (idx, val) => {
                tag += `
                    <tr data-questionContent="${val.questionContent}" data-link="${val.detailLink}" style="background: none;">
                        <td class="detail" style="cursor:pointer;text-align:left;padding: 8px;">${val.title}</td>
                        <td>${val.commentCnt}</td>
                        <td>${val.setDateTime}</td>
                    </tr>
                `;
            });
        } else {
            tag += '<tr><td colspan="3">데이터가 없습니다.</td></tr>';
        }

        $('.left-box tbody').append(tag);

        let pageTag = '';
        let style = '';
        for (var i = 1; i <= Math.ceil(contentResult.length / limit) ; i++) {
            style = page == i ? 'font-weight:bold;' : '';
            pageTag += `<li style="margin-right:10px;float:left;font-size:20px;${style}"><a href="#" class="pagenation" data-page="${i}" style="text-decoration-line: none;">${i}</a></li>`;
        }
        $('#page ul').append(pageTag);

        start = false;
    }
</script>
