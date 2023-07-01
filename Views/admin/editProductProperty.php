<div class="sectionEditProductProperty">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Chỉnh Sửa Sản Phẩm Thuộc Tính</h3>
        </div>

    </div>
    <div class="row">
        <form method="post" enctype="multipart/form-data" id="editProductPropertyForm">
            <div class="row">

                <div class="col-lg-2">
                    <label for="SKU" class="form-label">SKU</label>
                    <input type="number" name="SKU" class="form-control" id="SKU" value="" readonly />
                </div>



                <div class="col-lg-2">
                    <label for="price" class="form-label">Giá Sản Phẩm</label>
                    <input type="number" name="price" class="form-control" id="price" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="promotion" class="form-label">Giá Khuyến Mãi</label>
                    <input type="number" name="promotion" class="form-control" id="promotion" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="quantity" class="form-label">Số Lượng</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" value="" />
                </div>



                <div class="col-lg-4">

                    <label for="image" class="form-label">Hình Ảnh</label>
                    <input type="hidden" name="imageOld" id="imageOld">
                    <div class="wrap">

                        <div class="profile">
                            <div class="image_product" id="avatar">
                                <div id="preview"><img id="avatar-image" class="avatar_img">
                                </div>
                                <div class="avatar_upload">
                                    <label class="upload_label">Upload
                                        <input type="file" id="upload" name="uploadImage">
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>






                </div>

            </div>

            <div class="mt-5">
                <button class="btn-save float-end"><i class="far fa-save"></i></button> <button id="back" type="button" class="btn-cancel float-end"><i class="fas fa-window-close"></i></button>
            </div>
            <div class="mt-5">

            </div>




        </form>

    </div>

</div>

<script>
    $(document).ready(function() {
        urlParam = new URLSearchParams(window.location.href);
        id = urlParam.get('id')

        $.ajax({
            type: "get",
            url: "admin.php?act=getProductPropertyBySKU",
            data: {
                id: id
            },

            success: function(response) {
                arr = response.split("##-##");

                result = JSON.parse(arr[1]);

                $('#SKU').val(result.SKU);
                $('#price').val(result.price);
                $('#promotion').val(result.promotion);
                $('#quantity').val(result.quantity);
                $('#imageOld').val(result.image);
                $('#avatar-image').attr('src', './../Assets/img/' + result.image)
            }
        });
        $("input[name='uploadImage']").change(function() {
            file = $(this)[0].files[0];
            fileReader = new FileReader()
            fileReader.readAsDataURL(file)
            fileReader.onloadend = function(e) {
                $('#avatar-image').attr('src', e.target.result);
            }
        });

        $('#editProductPropertyForm').on('submit', function(e) {
            e.preventDefault();
            data = new FormData(this);

            $.ajax({
                type: "post",
                url: "admin.php?act=updateProductProperty",
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    arr = response.split('##-##');
                    if(arr[1]=='success'){
                        alert('cập nhật thành công');
                        $.ajax({
            type: "get",
            url: "admin.php?act=getProductPropertyBySKU",
            data: {
                id: id
            },

            success: function(response) {
                arr = response.split("##-##");

                result = JSON.parse(arr[1]);

                $('#SKU').val(result.SKU);
                $('#price').val(result.price);
                $('#promotion').val(result.promotion);
                $('#quantity').val(result.quantity);
                $('#imageOld').val(result.image);
                $('#avatar-image').attr('src', './../Assets/img/' + result.image)
            }
        });
                    } else{
                        alert('cập nhật thất bại')
                    }
                }
            });

        });
    });
</script>