<div class="sectionInfoOrderer">


  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Đơn Hàng Của Bạn</span>
        <span class="badge badge-secondary badge-pill">3</span>
      </h4>
      <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div id="myProducts">
            <h6 class="my-0">Sản Phẩm</h6>



          </div>

        </li>
        <li class="list-group-item d-flex justify-content-between" id="containerProvisional">
          <strong>Tạm Tính</strong>





        </li>


        <li class="list-group-item d-flex justify-content-between bg-light">
          <div class="text-success">
            <h6 class="my-0">Mã Khuyến Mãi</h6>

            <small id="description"></small>

          </div>
          <small id="value"></small>
        </li>
        <li class="list-group-item d-flex justify-content-between" id="containerSubTotal">
          <strong>Tổng Tiền</strong>






        </li>

      </ul>

      <form class="card p-2" method="post" id="codePromotionForm">
        <div class="input-group">
          <input type="text" class="form-control" name="code" placeholder="Mã Khuyến Mãi">
          <div class="input-group-append">
            <button type="button" class="btn btn-secondary" id="submitForm">Áp Dụng</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-8 order-md-1">
      <h4 class="mb-3">Thông Tin Đặt Hàng</h4>
      <form class="needs-validation" id="orderForm" method="post" action="index.php?act=order">
        <input type="hidden" name="prov" id="prov" value="">
        <div class="row">
          <div class="col-lg-6 mb-3">
            <label for="fullName">Họ Và Tên</label>
            <input type="text" class="form-control" name="fullName" placeholder="">
            <span class="errFirstName text-danger"></span>
          </div>
          <div class="col-lg-6 mb-3">
            <label for="phone">Số Điện Thoại</label>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="0357570455 hoặc 357570455" required>
            <span class="errPhone text-danger"></span>
          </div>

        </div>







        <div class="row">
          <div class="mb-3">
            <label for="address">Địa Chỉ</label>
            <input type="text" class="form-control" name="address" placeholder="12 Võ Hoành">
            <span class="errAddress text-danger"></span>
          </div>
          <div class="col-md-4 mb-3">
            <label for="country">Tỉnh/Thành Phố</label>
            <select class="custom-select d-block w-100 country" id="" name="country">
              <option value="">Choose...</option>
              <option value="Hồ Chí Minh">Hồ Chí Minh</option>
              <option value="Hà Nội">Hà Nội</option>
              <option value="Hà Tĩnh">Hà Tĩnh</option>
            </select>
            <span class="errCountry text-danger"></span>
          </div>
          <div class="col-md-4 mb-3">
            <label for="district">Quận/Tĩnh</label>
            <select class="custom-select d-block w-100 district" id="district" name="district">
              <option value="">Choose...</option>
              <option value="Tân Phú">Tân Phú</option>
              <option value="Tân Bình">Tân Bình</option>
              <option value="Phú Nhuận">Phú Nhuận</option>

            </select>
            <span class="errDistrict text-danger"></span>
          </div>
          <div class="col-md-4 mb-3">
            <label for="commune">Phường/xã</label>
            <select class="custom-select d-block w-100 commune" id="commune" name="commune">
              <option value="">Choose...</option>
              <option>Phú Thọ Hòa</option>
              <option>Tân Kỳ, Tân Quý</option>

            </select>
            <span class="errCommune text-danger"></span>

          </div>


        </div>

        <div class="mb-3">
          <label for="note">Ghi Chú</label><br>
          <textarea name="note" id="" cols="75" rows="10"></textarea>
        </div>
        <hr class="mb-4">

        <button class="btn btn-danger float-end btn-lg btn-block m-3" type="submit" id="continue">Tiếp Tục</button>

      </form>
    </div>
  </div>
</div>
<script src="./Assets/js/jquery/jqueryCheckout.js"></script>