<div class="sectionEditProduct">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Thêm Sản Phẩm</h3>
        </div>

    </div>
    <div class="row">
        <form method="post" enctype="multipart/form-data" id="addProductForm">
            <div class="row">


                <div class="col-lg-6">
                    <label for="nameAddProduct" class="form-label">Tên Sản Phẩm</label>
                    <input type="text" name="name" class="form-control" id="nameAddProduct" value="" />
                </div>

                <div class="col-lg-6">
                    <label for="supplierAddProduct" class="form-label">Nhà phân phối</label>
                    <select id="supplierAddProduct" class="form-select supplierProduct" name="supplier" value="">
                        <option value=0>Chọn</option>

                    </select>
                </div>
                <div class="col-lg-2">
                    <label for="priceAddProduct" class="form-label">Giá Sản Phẩm</label>
                    <input type="number" name="price" class="form-control" id="priceAddProduct" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="promotionAddProduct" class="form-label">Giá Khuyến Mãi</label>
                    <input type="number" name="promotion" class="form-control" id="promotionAddProduct" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="quantityAddProduct" class="form-label">Số Lượng</label>
                    <input type="number" name="quantity" class="form-control" id="quantityAddProduct" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="typeAddProduct" class="form-label">Phân Loại</label>
                    <select id="typeAddProduct" class="form-select" name="type_id" value="">
                        <option value=0>Chọn</option>

                    </select>
                </div>


                <div class="col-lg-2">
                    <label for="dateAdd" class="form-label">Ngày nhập</label>
                    <input type="date" name="dateAdd" class="form-control" id="dateAdd" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="expiry" class="form-label">Hạn sử dụng</label>
                    <input type="date" name="expiry" class="form-control" id="expiry" value="" />
                </div>
                <div class="col-lg-4">

                    <label for="imageProduct" class="form-label">Hình Ảnh</label>
                    <div class="wrap">

                        <div class="profile">
                            <div class="image_product" id="avatar">
                                <img id="avatar-image" class="avatar_img">

                                <div class="avatar_upload">
                                    <label class="upload_label">Upload
                                        <input type="file" id="upload" name="uploadImageAddProduct">
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>






                </div>

                <div class="col-lg-8">
                    <label for="descriptionProduct" class="form-label">Mô tả ngắn</label>
                    <textarea class="form-control description" name="description" id="descriptionProduct" rows="10">

                    </textarea>
                </div>
                <div class="col-lg-12 mt-5 productProperty">
                    <label for="propertyProduct" class="form-label">Sản phẩm thuộc tính</label>
                    <button type="button" class="add-btn property">Thêm thuộc tính</button>
                    <div class="containerProperty row">

                    </div>
                    <div class="create">

                    </div>


                </div>
            </div>


            <table id="productPropertyTable" class="table bg-white rounded shadow-sm  table-hover table-bordered" hidden>
                <thead id="titleListProduct">
                    <tr>
                        <th>#</th>
                        <th>SKU</th>

                        <th>Giá</th>
                        <th>Khuyến mãi</th>
                        <th> Số Lượng</th>
                        <th>Hình ảnh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="listProductProperty">





                </tbody>
            </table>


            <div class="mt-5">
                <button class="btn-save float-end"><i class="far fa-save"></i></button><button id="back" type="button" class="btn-cancel float-end"><i class="fas fa-window-close"></i></button>
            </div>



        </form>

    </div>

</div>

<script src="./../Assets/js/jquery/admin/jqueryAddProduct.js">

</script>