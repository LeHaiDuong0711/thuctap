<div class="container-fluid px-4">
    <form method="post" id="filed">
        <div class="row">
            <div class="col-lg-2 "><select class="form-select " aria-label="Default select example" name="month" id="month">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select></div>
            <div class="col-lg-2">
                <input class="form-control" type="number" name="year" id="" value="<?php $today = getdate();
                                                                                    echo $today['year'] ?>">
            </div>
            <div class="col-lg-1">
                <button class="form-control btn-success" type="submit" id="btnFiled">Lọc</button>
            </div>
        </div>
    </form>
    <div class="container-fluid pt-4">
        <div class="g-4">

            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Doanh Số Sản Phẩm</h6>
                </div>
                <div class="d-flex" id="productSales">

                </div>


            </div>
        </div>
        <div class="g-4 mt-5">

            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Doanh Thu Tháng</h6>
                </div>
                <div class="d-flex" id="monthlyRevenue">

                </div>


            </div>
        </div>
    </div>




</div>
<script src="./../Assets/js/jquery/admin/jqueryChart.js"></script>