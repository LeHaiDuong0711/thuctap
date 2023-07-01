<div class="row">
    <div class="d-flex row">
        <div class="col-lg-6">
            <h3 class="fs-4 mb-3">Danh Sách Đơn Hàng</h3>
        </div>
        <div class="col-lg-6"> <input type="search" name="keyword" class="form-control keyword" placeholder="Nhập Mã Đơn Hàng">
        
        </div>


    </div>

</div>



<div class="col">
    <table class="table bg-white rounded shadow-sm  table-hover table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã Đơn Hàng</th>
                <th>Mã Người Dùng</th>
                <th>Họ và tên</th>
                <th>Số Điện Thoại</th>
                <th>Tổng Tiền</th>
                <th>Ghi Chú</th>
                <th>Ngày Đặt</th>
                <th>Ngày giao</th>
                <th>Ngày nhận</th>
                <th>Ngày hủy</th>
                <th>Ngày đặt lại</th>
                <th>Trạng Thái</th>
                <th>Cập Nhật Trạng Thái</th>
                <th></th>
            
            </tr>
        </thead>
        <tbody id="listOrders">




        </tbody>
    </table>
</div>
<ul id="paginationOrders" class="pagination justify-content-center mt-5">

</ul>
</div>
<script src="./../Assets/js/jquery/admin/jqueryListOrders.js"></script>