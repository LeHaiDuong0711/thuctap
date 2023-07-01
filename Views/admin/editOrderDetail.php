<div class="sectionEditProduct">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Chỉnh Sửa Chi Tiết Đơn Hàng</h3>
        </div>

    </div>
    <div class="row">
       
        <form method="post" id="editOrderDetailForm">
            <div class="row">

                <div class="col-lg-2">
                    <label for="orderId" class="form-label">Mã Đơn Hàng</label>
                    <input type="number" name="idUpdate" class="form-control" id="orderId" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="proId" class="form-label">Mã Sản Phẩm</label>
                    <input type="number" name="proId" class="form-control" id="proId" value="" readonly />
                </div>
                <div class="col-lg-4 ">
                    <label for="proName" class="form-label">Tên Sản Phẩm</label>
                    <input type="text" name="proName" class="form-control" id="proName" value=">" readonly />
                </div>
                <div class="col-lg-2">
                    <label for="quantity" class="form-label">Số Lượng</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" value="" min="1"/>
                </div>  
                <div class="col-lg-2">
                    <label for="total" class="form-label">Tổng Tiền</label>
                    <input type="text" name="total" class="form-control" id="total" value="" readonly />
                </div>


            </div>
            <div class="float-end">
                <button class="btn-edit">Lưu</button>
            </div>


        </form>

    </div>

</div>

<script>
    // $(document).ready(function() {
       

    //     urlParam = new URLSearchParams(window.location.href);
    //     id = urlParam.get("id");
    //     $.ajax({
    //         type: "get",
    //         url: "admin.php?act=getEditOrderDetail",
    //         data: {id:id},
      
    //         success: function(response) {
    //             arr = response.split("##-##");
    //             result = JSON.parse(arr[1]);
    //             $('#orderId').val(result.order_id);
    //             $('#proId').val(result.pro_id);
    //             $('#proName').val(result.pro_name);
    //             $('#quantity').val(result.quantity);
    //             $('#total').val(result.total);
    //             $('#quantity').on('change', function () {

    //                 total = $(this).val()*result.total;
    //                 $('#total').val(total);
    //             });

    //            $('#editOrderDetailForm').submit(function (e) { 
    //             e.preventDefault();
    //             data = $(this).serialize();
    //             data += "&id="+id
    //             $.ajax({
    //                 type: "post",
    //                 url: "admin.php?act=editOrderDetail_act",
    //                 data: data,
    //                 success: function (response) {
    //                     arr = response.split('##-##');
    //                     result = arr[1];

    //                     if(result == "success"){
    //                         alert('Cập nhật thành công');
    //                         window.location.href = "admin.php?act=listOrderDetails&id="+id
    //                     }else if(result == "error"){
    //                         alert('Cập nhật không thành công');
    //                     } else if(result == "order not exits"){
    //                         alert('Mã đơn hàng chuyển qua không tồn tại');
    //                     } else if(result == "order detail not exits"){
    //                         alert('Chi tiết đơn hàng không tồn tại');
    //                     }
    //                 }
    //             });
                
    //            });

    //         }
    //     });
    // });
</script>