<style>
    .footer__container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(23rem, 1fr));
        gap: 1.5rem;
        padding-bottom: 2rem;
        margin: 0 72px;
    }

    .box-link {
        display: block;
        font-size: 14px;
        color: #b7b7b7;
        margin: 10px 0;
    }

    .footer__credit {
        text-align: center;
        margin-top: 20px;
        padding: 20px 10px 10px 10px;
        font-size: 14px;
        color: #b7b7b7;
        border-top: 1px solid #b2b2b2;
    }
</style>
</div>
    <div class="row" style="display: block;margin-bottom: 100px"></div>
    <footer class="footer" id="footer">
        <div class="footer__container">
            <div class="footer__container-box">
                <h3 style="background-color: #fff; padding: 10px;">
                    <a href="./" style="pointer-events: none">
                        <img src="./public/images/logo.png" alt="" class="img-responsive">
                    </a>
                </h3>
                <p style="font-size:14px; color: #b7b7b7;">
                    Khách hàng là trọng tâm trong mô hình kinh doanh độc đáo của chúng tôi, bao gồm cả sự thiết kế.
                </p>
                <div>
                    <img src="./public/images/payment2.png" alt="" style="margin-top: 2rem; width: 100%;">
                </div>
            </div>
            <div class="footer__container-box">
                <h3>NYL Shopping</h3>
                <a href="#" class="box-link">
                    Sản phẩm mới
                </a>
                <a href="#" class="box-link">
                    Sản phẩm bán chạy
                </a>
                <a href="#" class="box-link">
                    Sản phẩm khuyến mại
                </a>
            </div>
            <div class="footer__container-box">
                <h3>NYL SHOP</h3>
                <a href="#home" class="box-link">
                    Liên hệ với chúng tôi
                </a>
                <a href="#features" class="box-link">
                    Phương thức thanh toán
                </a>
                <a href="#products" class="box-link">
                    Giao hàng
                </a>
            </div>
            <div class="footer__container-box">
                <h3>FEEDBACK FORM</h3>
                <p>Hãy phản hồi với chúng tôi 
                    <a style="color: #ee4d2d;" href="">tại đây</a>
                </p>
                <p>Hãy là người đầu tiên biết về hàng mới xuất hiện, xem sách, bán hàng & quảng cáo!</p>
            </div>
        </div>
        <div class="footer__credit">
            created by <span style="color: #ee4d2d;">nhóm PHP 03</span> | all rights reserved
        </div>
    </footer>
    <script src="./public/js/jquery-3.1.1.js" type="text/javascript"></script>
    <script src="./public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./public/js/raty/jquery.raty.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $.fn.raty.defaults.path = "./public/js/raty/img'); ?>";
            $('.raty').raty({
                score: function() {
                    return $(this).attr('data-score');
                },
                readOnly: true,
            });
        });
    </script>
</body>
</html>
