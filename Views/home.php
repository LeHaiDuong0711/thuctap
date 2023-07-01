<!-- Carousel -->

<div id="demo" class="carousel slide" data-bs-ride="carousel">

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./Assets/img/slide.jpg" class="w-100">
        </div>
        <div class="carousel-item">
            <img src="./Assets/img/slide1.jpg" class="w-100">
        </div>
        <div class="carousel-item">
            <img src="./Assets/img/slide2.jpg" class="w-100">
        </div>
    </div>

    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>



<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- shop -->
            <div class="col-lg-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img">
                        <img src="./Assets/img/banhngot.jpg" alt="">
                    </div>
                    <div class="shop-body">
                        <h3>Bánh ngọt</h3>
                        <a href="index.php?act=products&type_id=2" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /shop -->

            <!-- shop -->
            <div class="col-lg-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img">
                        <img src="./Assets/img/traicaytuoi.jpg" alt="">
                    </div>
                    <div class="shop-body">
                        <h3>Trái cây tươi</h3>
                        <a href="index.php?act=products&type_id=1" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /shop -->

            <!-- shop -->
            <div class="col-lg-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img">
                        <img src="./Assets/img/raucusach.jpg" alt="">
                    </div>
                    <div class="shop-body">
                        <h3>Rau củ sạch</h3>
                        <a href="index.php?act=products&type_id=3" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /shop -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<div class="container-home">
    <div class="newProductsEveryday mb-5">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <h3 class="title">Sản phẩm tươi mới mỗi ngày</h3>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Trái Cây</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Bánh Ngọt</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Rau Củ</button>
            </li>

        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0"><!-- tab -->

                <div class="products-slick row" data-nav="#slick-nav-1" id="type1">

                    <!-- product -->
                    
                    <!-- /product -->

                </div>


            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"><!-- tab -->

                <div class="products-slick row" id="type2">
                    
                        <!-- product -->
                    
                        <!-- /product -->

                  
                </div>


            </div>
            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0"><!-- tab -->

                <div class="products-slick row" id="type3">
                    
                        <!-- product -->
                        
                        <!-- /product -->

                    
                </div>

            </div>
        </div>




    </div>








    <!-- HOT DEAL SECTION -->
    <div id="hot-deal" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="hot-deal" class="hot-deal">
                        <ul class="hot-deal-countdown">
                            <li>
                                <div>
                                    <h3 id="timer-days"></h3>
                                    <span>Ngày</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3 id="timer-hours"></h3>
                                    <span>Giờ</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3 id="timer-minutes"></h3>
                                    <span>Phút</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3 id="timer-seconds"></h3>
                                    <span>Giây</span>
                                </div>
                            </li>
                        </ul>
                        <h2 class="text-uppercase">Khuyến mãi trong tuần</h2>
                        <p>Sản phẩm mới giảm tới 50%</p>
                        <a class="primary-btn cta-btn" href="index.php?act=products&type_id=2">Mua ngay</a>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /HOT DEAL SECTION -->


    <div class="sellingProducts mb-5" id="sellingProducts">
        <ul class="nav nav-tabs" id="myTab1" role="tablist">
            <h3 class="title">Sản phẩm bán chạy</h3>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab1" data-bs-toggle="tab" data-bs-target="#home-tab-pane1" type="button" role="tab" aria-controls="home-tab-pane1" aria-selected="true">Trái Cây</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab1" data-bs-toggle="tab" data-bs-target="#profile-tab-pane1" type="button" role="tab" aria-controls="profile-tab-pane1" aria-selected="false">Bánh Ngọt</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab1" data-bs-toggle="tab" data-bs-target="#contact-tab-pane1" type="button" role="tab" aria-controls="contact-tab-pane1" aria-selected="false">Rau Củ</button>
            </li>

        </ul>
        <div class="tab-content" id="myTabContent1">
            <div class="tab-pane fade show active" id="home-tab-pane1" role="tabpanel" aria-labelledby="home-tab1" tabindex="0">
                <div class="products-slick row" id="type1">
                  
                        <!-- product -->
                        
                        <!-- /product -->
                </div>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane1" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="products-slick row" id="type2">
                
                        <!-- product -->
                      
                        <!-- /product -->
                </div>
            </div>
            <div class="tab-pane fade" id="contact-tab-pane1" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                <div class="products-slick row" id="type3" >
                  
                        <!-- product -->
                        
                        <!-- /product -->
                </div>
            </div>
        </div>






    </div>

</div>

<script src="./Assets/js/jquery/jqueryHome.js"></script>



<?php ?>