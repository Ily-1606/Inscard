<html>

<head>
    <title>
        Incard Instargram - Coded by Ily1606
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="bar">
        <div></div>
    </div>
    <div class="modal_loading"></div>
    <div class="row m-0 mt-3">
        <div class="col-md-6 text-center">
            <form class="submit" action="Incard.php" method="POST">
                <div class="form-group">
                    <label for="link">Link Instagram</label>
                    <input type="text" class="form-control" name="url" id="link" placeholder="https://www.instagram.com/p/B9y3zb7nSFQ/">
                    <small id="emailHelp" class="form-text text-muted">Nhập đúng định dạng link ảnh</small>
                </div>
                <button type="submit" class="btn btn-primary">Lấy ảnh</button>
            </form>
            <form class="submit" action="Incard_url.php" method="POST">
                <div class="form-group">
                    <label for="link">Link ảnh (URL)</label>
                    <input type="text" class="form-control" name="url" id="link" placeholder="https://www.domainexample.com/abc.jpg">
                    <small id="emailHelp" class="form-text text-muted">Nhập đúng định dạng link ảnh</small>
                </div>
                <button type="submit" class="btn btn-primary">Lấy ảnh</button>
            </form>
            <div id="img_result">
            </div>
            <div class="col-12 text-left mt-3">
                <p>Lịch sử cập nhật: </p>
                <p>Giảm độ vỡ của card [22:44] 31/3/2020</p>
                <p>Thêm độ mờ cho ảnh bìa, cải thiện thuật toán phóng to trung tâm ảnh, lúc [17:00] 31/3/2020</p>

                <p>Lưu ý:</p>
                <p>Không nên sử dụng sử dụng máy chủ chúng tôi làm storage (tạo ra ảnh nào, thì bạn nên tải xuống ảnh đó) vì chúng tôi sẽ xóa toàn bộ ảnh trong 0h ngày kế tiếp.</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="background"></div>
        </div>
    </div>
</body>
<style>
    .background {
        background-image: url('B9RnbiZHLo2.jpg');
        width: 100%;
        height: 100vh;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .bar {
        display: none;
        position: absolute;
        top: 1px;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 6px;
        background: #acece6;
        overflow: hidden;
        z-index: 9999;
    }

    .bar div:before {
        content: "";
        position: absolute;
        top: 0px;
        left: 0px;
        bottom: 0px;
        background: orange;
        animation: box-1 1500ms cubic-bezier(0.65, 0.81, 0.73, 0.4) infinite;
    }

    .bar div:after {
        content: "";
        position: absolute;
        top: 0px;
        left: 0px;
        bottom: 0px;
        background: orange;
        animation: box-2 1500ms cubic-bezier(0.16, 0.84, 0.44, 1) infinite;
        animation-delay: 750ms;
    }

    .modal_loading {
        position: fixed;
        display: none;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        background: rgba(0, 0, 0, 0.7);
        animation: fadeIn_out 1500ms cubic-bezier(0.65, 0.81, 0.73, 0.4) infinite;
        z-index: 9998;
    }

    @keyframes box-1 {
        0% {
            left: -35%;
            right: 100%;
        }

        60%,
        100% {
            left: 100%;
            right: -90%;
        }
    }

    @keyframes box-2 {
        0% {
            left: -200%;
            right: 100%;
        }

        60%,
        100% {
            left: 107%;
            right: -8%;
        }
    }

    @keyframes fadeIn_out {
        0% {
            opacity: 0.7;
        }

        50% {
            opacity: 0.1;
        }

        60%,
        100% {
            opacity: 0.7;
        }
    }
</style>
<script>
    $(function() {
        $("form.submit").submit(function() {
            $("#img_result").html('');
            $(".modal_loading, .bar").fadeIn();
            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: $(this).serialize(),
                success: function(e) {
                    if (e.status == "success") {
                        $("#img_result").html('<img src="' + e.data + '" width="500" height="500">');
                    } else {
                        alert(e.msg);
                    }
                    $(".modal_loading, .bar").fadeOut();
                },
                error: function(e) {
                    $(".modal_loading, .bar").fadeOut();
                    alert("Không thể kết nối với máy chủ!");
                }
            });
            return false;
        });
    });
</script>

</html>