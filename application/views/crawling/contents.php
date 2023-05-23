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
            width: 30%;
            height: 100%;
            float: left;
        }
        .middle-box {
            width: 38%;
            height: 95%;
            border: 1px solid #ccc;
            float: left;
            margin-left: 1%;
        }
        .right-box {
            width: 30%;
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
            <input type="text" name="coupang-category" placeholder="쿠팡 카테고리" style="margin-left: 14.1%;"> <button id="coupang-search">쿠팡 조회</button>
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
                    <li>
                        <div>
                            <div>
                                <img style="width:100%;height: 75%;" src="https://ads-partners.coupang.com/image1/Nv4pRaCVUX52BNS4Nkumu9-hOcH5DL5o9ZwQ9qJIC2_cLN91BislU29d6ohBxIGfkl-9dwNc_DTY0SUgcsUVbAcpMALGalkdUpow58F796rvmlLH8a2JPG5sr8XM_xUpSsHl_ngoIrUOW7JcY4E36YblHoiP5DqPFCc4lh3XVjcMhd2bl-s98vTqTBlY8nd0wtGaZmL_poggmzmYuFrQGiPYaUFrsOQPj8_dpLeZQzZO91wcTSyNF-ML5HikCJSTcvSsgKGHn45Ssw==" alt="">
                            </div>
                            <div style="text-align: center;font-size: 12px;height: 32px;">페이황 푸주 건두부면</div>
                            <button id="link-detail" style="margin: 3px 0 0 15px;width: 85px;">상세 보기</button>
                            <button id="link-copy" style="margin: 0px 0 0 6px;width: 85px;">링크 복사</button>
                        </div>
                    </li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
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
                        <input type="text" id="coupang-url-<?=$i?>" style="width: 56%;" placeholder="일반 링크"> <input type="text" id="coupang-url-<?=$i?>-change" style="width: 30%;" placeholder="변환 된 링크" readonly>
                        <input type="button" class="coupang-url-<?=$i?>-detail-open" name="coupang-detail" value="상세">
                        <br>
                    <?php endfor; ?>
                    <button id="url-change" style="margin-left: 4px;">링크 변환</button>
                </div>
                <div class="textarea-style">
                    <button id="default_setting">기본 문구 추가</button>
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
        // 화면에서 hidden 처리한 input box type을 text로 일시 변환
        $('#content').attr('type', 'text');
        // input에 담긴 데이터를 선택
        $('#content').select();
        //  clipboard에 데이터 복사
        var copy = document.execCommand('copy');
        // input box를 다시 hidden 처리
        $('#content').attr('type', 'hidden');
        // 사용자 알림
        if(copy) {
            alert("데이터가 복사되었습니다.");
        }
    });

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
            url : 'main/crawling',
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
    $(document).on('click', '.detail', (e) => {
        let target = $(e.target),
            tr = target.parents('tr');

        $('.questionContent-top').empty();
        $('.questionContent-top').text(tr.data('questioncontent').trim());

        $('.questionContent-bottom').empty();
        $('.questionContent-bottom').append('<a href="' + tr.data('link') + '" target="_blank">' + tr.data('link').trim() + '</a>');
        $('.questionContent-bottom').append('<button id="toggle" style="float:right;" data-type="open">펼치기</button>');

        $('#set').attr('data-link', '');
        $('#set').attr('data-link', tr.data('link'));

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

    $(document).on('click', '#default_setting', (e) => {
        $('textarea#content').val('');
        $('textarea#content').val("안녕하세요! \n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n *쿠팡파트너스 활동의 일환으로 수수료를 받을 수 있습니다");
    });

    //쿠팡 상품 검색
    $(document).on('click', '#coupang-search', (e) => {
        if ($('[name="coupang-category"]').val() == '') {
            alert('쿠팡 상품명을 검색해주세요.');
            return;
        }

        $.ajax({
            url : 'main/coupangProductList',
            data : {
                keyword : $('[name="coupang-category"]').val()
            },
            type : 'post',
            datatype : 'json',
            success: (res) => {
                let data = JSON.parse(res);

                let tag = '';
                $.each(data, (idx, val) => {
                    tag += `

                    `;
                })
            }
        });
    });

    //쿠팡 링크 변경
    $(document).on('click', '#url-change', (e) => {
        if ($('.addLink input').length == 0) {
            alert('변경 할 링크가 없습니다.');
            return;
        }

        let coupangLinks = [];
        $.each($('.addLink input'), (idx, el) => {
            let $el = $(el);

            if ($el.val() != '') {
                coupangLinks.push('"' + $el.val() + '"' + '|' + $el.attr('id'));
            }
        });

        $.ajax({
            url : 'main/coupangLinkChange',
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

    //쿠팡 디테일 페이지
    $(document).on('click', '[name="coupang-detail"]', (e) => {
        let target = $(e.target);
        window.open(target.data('url'));
    });

    //지식인 답변 창 오픈
    $(document).on('click', '#set', (e) => {
        let target = $(e.target),
            link = target.data('link');

        if (link == '' || link == null) {
            alert('선택된 값이 없습니다');
            return;
        }

        const queryString = new URL(link);
        const urlParams = queryString.searchParams;

        let dirId = urlParams.get('dirId');
        let docId = urlParams.get('docId');

        let url = `https://m.kin.naver.com/mobile/answer/registerForm.naver?dirId=${dirId}&docId=${docId}`;

        window.open(url, '지식인', 'width=1000px,height=700px,top=150px,left=450px');
    });

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
