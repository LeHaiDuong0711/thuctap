<!-- HEADER -->

<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links">
                <li><a href="tel:19001008"><i class="fa fa-phone"></i>19001008</a></li>
                <li><a href="mailto:footshophidden@gmail.com"><i class="fas fa-envelope-open-text"></i>footshophidden@gmail.com</a></li>
                <li><a href="https://goo.gl/maps/LYfAifHVSHyJGqGPA"><i class="fa fa-map-marker"></i>12 Võ Hoành, Phú Thọ Hòa, Tân Phú, TP.HCM</a></li>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="float-end">
                        <div class="dropdown dropstart">
                            <button type="button" class="text-white userProfile" data-bs-toggle="dropdown"><i class="far fa-user-circle"></i>
                                <?php echo $_SESSION['fullName'] ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?act=profile" class="dropdown-item text-dark"><button type="button" class="btn"><i class="far fa-user-circle"></i> Tài khoản của tôi</button></a></li>
                                <li><a href="index.php?act=listMyOrder" class="dropdown-item text-dark"><Button type="button" class="btn"><i class="fas fa-shopping-bag"></i> Đơn mua</Button> </a></li>
                                <li><a href="index.php?act=wishlist" class="dropdown-item text-dark"><Button type="button" class="btn"><i class="fa fa-heart"></i> Sản phẩm yêu thích</Button> </a></li>
                                <li><a class="dropdown-item text-dark"><Button type="button" class="btn btn-logout logout"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</Button></a></li>
                                                           <!-- <li><a href="index.php?act=logout" class="dropdown-item text-dark"><Button type="button" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</Button></a></li> -->

                            </ul>
                        </div>
                    </li>
                <?php else : ?>


                    <li class="float-end"><a href="index.php?act=login">Đăng nhập</a></li>



                <?php endif ?>
            </ul>

        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-lg-3">
                    <div class="header-logo">
                        <a href="index.php" class="logo">
                            <img src="./Assets/img/logobandoan.jpg" alt="logo">
                        </a>
                    </div>
                </div>
                <?php
                $keyword = "";
                $type_id = 0;
                if (isset($_GET['keyword'])) {
                    $keyword = $_GET['keyword'];
                }

                if (isset($_GET['type_id'])) {
                    $type_id = $_GET['type_id'];
                }
                ?>



                <div class="col-lg-6">
                    <div class="header-search">
                        <form method="get" action="index.php">
                            <input type="text" name="act" value="products" hidden>
                            <select class="input-select" name="type_id">
                                <option value="0" <?php if ($type_id == 0) echo "selected" ?>>Tất cả</option>
                                <option value="1" <?php if ($type_id == 1) echo "selected" ?>>Trái cây</option>
                                <option value="2" <?php if ($type_id == 2) echo "selected" ?>>Bánh ngọt</option>
                                <option value="3" <?php if ($type_id == 3) echo "selected" ?>>Rau củ</option>
                            </select>
                            <input name="keyword" class="input" value="<?php echo  $keyword ?>">
                            <button type="submit" class="search-btn">Tìm</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="header-ctn">
                        <div>
                            <a href="index.php?act=cart">
                                <i class="fa fa-shopping-bag"></i>
                                <span>Giỏ hàng</span>
                                <div class="qty countCart">
                                  
                                </div>
                            </a>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->

<!-- NAVIGATION -->

<!-- NAV -->
<nav class="navbar navbar-expand-lg" id="navigation">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav" id="menu">
              

            </ul>
        </div>
    </div>
</nav>
<!-- /NAV -->
<!-- /NAVIGATION -->