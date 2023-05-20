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
            height: 74%;
            top: 210px;
        }
        .naver_login {
            position: absolute;
            top: 5px;
            left: 10px;
        }
    </style>
    <body>
        <div class="header">
            <a class="naver_login" href="<?php echo $apiURL ?>"><img style="height: 35px;" src="http://static.nid.naver.com/oauth/small_g_in.PNG"/></a>
            <input type="text" name="category" placeholder="카테고리" style="margin-left: 100px;"> <button id="search">조회</button>
        </div>
        <div class="wrap">
            <div class="left-box">
                <table>
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
                    <!-- <textarea name="" id="content"></textarea> -->
                    <iframe style="width: 100%;height: 100%;" src="https://kin.naver.com/qna/detail.naver?d1id=5&dirId=5030104&docId=446230988&qb=7LaU7LKc&enc=utf8&section=kin.qna.all&rank=6&search_sort=3&spq=0"></iframe>
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

    $(document).on('click', '#reset', (e) => {
        if (confirm('정말로 RESET 하시겠습니까?')) {
            $('#content').val('');
        }
    })

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

    $(document).on('click', '#search', (e) => {
        let category = $('[name="category"]').val();

        if (category == '') {
            alert('카테고리명을 입력하세요.');
            return;
        }

        $.ajax({
            url : '/main/crawling',
            data : {
                category : category
            },
            type : 'get',
            datatype : 'json',
            success: (res) => {
                let data = JSON.parse(res);

                let tag = '';
                $.each(data, (idx, val) => {
                    tag += `
                        <tr data-questionContent="${val.questionContent}" data-link="${val.detailLink}" style="background: none;">
                            <td class="detail" style="cursor:pointer;text-align:left;padding: 7px;">${val.title}</td>
                            <td>${val.commentCnt}</td>
                            <td>${val.setDateTime}</td>
                            <td id="link" style="display:none;"></td>
                        </tr>
                    `;
                });

                $('.left-box tbody').append(tag);
            }
        });
    });

    $(document).on('click', '.detail', (e) => {
        let target = $(e.target),
            tr = target.parents('tr');

        $('.questionContent-top').empty();
        $('.questionContent-top').text(tr.data('questioncontent').trim());

        $('.questionContent-bottom').empty();
        $('.questionContent-bottom').append('<a href="' + tr.data('link') + '" target="_blank">' + tr.data('link').trim() + '</a>');
        $('.questionContent-bottom').append('<button id="toggle" style="float:right;" data-type="open">펼치기</button>');


        $('tr').css('background', 'none');
        tr.css('background', 'beige');
    });

</script>
