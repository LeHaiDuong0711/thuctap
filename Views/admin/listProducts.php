<div class="row">
    <div class="col-lg-6">
        <h3 class="fs-4 mb-3">Danh Sách Sản Phẩm</h3>
    </div>
    <div class="col-lg-6 row">

        <div class="col-lg-6">
            <select class="form-select type_id" name="type_id" >
                <option value="0">Tất cả</option>
            </select>
        </div>
        <div class="col-lg-6">
            <input name="keyword" class="form-control keyword" value="" placeholder="tìm kiếm...">
        </div>
        <a href="admin.php?act=add-product"><button type="button" class="btn-add float-end"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </a>
    </div>

</div>




<div class="col">
    <table class="table bg-white rounded shadow-sm  table-hover table-bordered">
        <thead>
            <tr>
                <th>Mã Sản Phẩm</th>
          
                <th>Tên</th>
                <th>Hình ảnh</th>
                <th>Giá</th>
                <th>Khuyến mãi</th>
                <th> Số Lượng</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="listProducts">




        </tbody>
    </table>
</div>
<div>
    <ul id="pagination" class="pagination">

    </ul>
</div>
</div>