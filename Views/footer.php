
<!-- FOOTER -->
<footer id="footer">
    <!-- top footer -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer">
                        <h3 class="footer-title">Chúng tôi</h3>
                        <p><strong>Đồ án CNTT xây dựng website bán thực phẩm trực tuyến</strong></p>
                        <ul class="footer-links">
                            <li><a href="https://goo.gl/maps/LYfAifHVSHyJGqGPA"><i class="fas fa-map-marker-alt"></i>12 Võ Hoành, Phú Thọ Hòa, Tân Phú, TP.HCM</li></a>
                            <li><a href="tel:19001008"><i class="fa fa-phone"></i> 19001008</a></li>
                            <li><a href="mailto:footshophidden@gmail.com"><i class="fas fa-envelope-open-text"></i>footshophidden@gmail.com</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="footer">
                        <h3 class="footer-title">thể loại</h3>
                        <ul class="footer-links">
                            <li><a href="index.php?act=products&type_id=1"><strong>Trái cây</strong></a></li>
                            <li><a href="index.php?act=products&type_id=2"><strong>Bánh ngọt</strong></a></li>
                            <li><a href="index.php?act=products&type_id=3"><strong>Rau củ</strong></a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-lg-3">
                    <div class="footer">
                        <h3 class="footer-title">thông tin</h3>
                        <ul class="footer-links">
                            <li><a href="index.php?act=about"><strong>Hidden Foot </strong></a></li>
                     </ul>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="footer">
                        <h3 class="footer-title">Dịch vụ</h3>
                        <ul class="footer-links">
                            <li hidden class="profile"><a href="index.php?act=profile">Tài Khoản Của Tôi</a></li>
                            <li><a href="index.php?act=cart">Xem Giỏ Hàng</a></li>
                            <!-- <li><a href="#">Yêu Thích</a></li> -->
                            <li hidden class="listMyOrder"><a href="index.php?act=listMyOrder">Xem Đơn Hàng</a></li>
                            <li><a href="index.php?act=contact">Giúp Đỡ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /top footer -->

    <!-- bottom footer -->
    <div id="bottom-footer" class="section">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <ul class="footer-payments">
                        <li><a href="#"><i class="fab fa-cc-visa"></i></a></li>
                        <li><a href="#"><i class="fas fa-credit-card"></i></a></li>
                        <li><a href="#"><i class="fab fa-cc-paypal"></i></a></li>
                        <li><a href="#"><i class="fab fa-cc-mastercard"></i></a></li>
                        <li><a href="#"><i class="fab fa-cc-discover"></i></a></li>
                        <li><a href="#"><i class="fab fa-cc-amex"></i></a></li>
                    </ul>
                    <span class="copyright">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                        </script> Bản quyền giao diện thuộc <strong> Lê Hải Dương </strong> </a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </span>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bottom footer -->
</footer>

<script>
    $.ajax({
        type: "get",
        url: "index.php?act=getUser",
       
        success: function (response) {
            arr= response.split("##-##")
            user = JSON.parse(arr[1]);
            if(user){
                $(".footer .profile").prop('hidden',false);
                $(".footer .listMyOrder").prop('hidden',false);
            }
        }
    });
</script>
<!-- /FOOTER -->


