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
            width: 60%;
            height: 100%;
            float: left;
        }
        .right-box {
            width: 39%;
            height: 100%;
            float: right;
        }
        .questionContent-text {
            padding: 5px;
            height: 15%;
            border: 1px solid #ccc;
            position: absolute;
            width: 38%;
            z-index: 100;
            background: #fff;
        }
        .questionContent-bottom a {
            float: left;
            width: 90%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .right-box textarea {
            width: 100%;
            height: 100%;
        }
        .textarea-style {
            position: absolute;
            width: 38.5%;
            height: 69%;
            top: 230px;
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
        </div>
        <div class="wrap">
            <div id="time_end" style="height: 15px;"></div>
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
            <div class="right-box">
                <div class="questionContent-text">
                    <div class="questionContent-top" style="height: 82%;overflow: hidden;font-size: 15px;">
                        <div style="text-align: center;">제목을 선택해 주세요.</div>
                    </div>
                    <div class="questionContent-bottom">

                    </div>
                </div>
                <div class="addLink">

                </div>
                <div class="textarea-style">
                    <button id="default_setting">기본 문구 추가</button>
                    <textarea name="" id="content">
안녕하세요!

























*쿠팡파트너스 활동의 일환으로 수수료를 받을 수 있습니다
                    </textarea>

                    <div style="float:right;">
                        <button id="set">등록</button>
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
        $('textarea#content').text("안녕하세요! \n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n*쿠팡파트너스 활동의 일환으로 수수료를 받을 수 있습니다");
    });

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

        $.ajax({
            url : 'main/get_csrf_token',
            data : {
                url : url
            },
            type : 'get',
            datatype : 'json',
            success:(res) => {

            }
        })
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
