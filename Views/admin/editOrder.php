<div class="sectionEditProduct">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Chỉnh Sửa Đơn Hàng</h3>
        </div>

    </div>
    <div class="row">
        <?php
        $sl = new sales();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $result = $sl->getOrderById($id);
        ?>
        <form method="post" id="editOrderForm">
            <div class="row">

                <div class="col-lg-2">
                    <label for="id" class="form-label">Mã Đơn Hàng</label>
                    <input type="number" name="id" class="form-control" id="id" value="<?php echo $result['order_id'] ?>" readonly />
                </div>
                <div class="col-lg-2">
                    <label for="userId" class="form-label">Mã Người Dùng</label>
                    <input type="number" name="userId" class="form-control" id="userId" value="<?php echo $result['user_id'] ?>" readonly />
                </div>
                
                <div class="col-lg-8">
                    <label for="fullName" class="form-label">Tên</label>
                    <input type="text" name="fullName" class="form-control" id="fullName" value="<?php echo $result['fullName'] ?>" />
                </div>
                <div class="col-lg-4">
                    <label for="phone" class="form-label">Số Điện Thoại</label>
                    <input type="number" name="phone" class="form-control" id="phone" value="<?php echo $result['phone'] ?>" />
                </div>
                <div class="col-lg-4">
                    <label for="total" class="form-label">Tổng Tiền</label>
                    <input type="text" name="total" class="form-control" id="total" value="<?php echo number_format($result['total']) ?>" readonly />
                </div>
                <div class="col-4">
                    <label for="status" class="form-label">Trạng Thái</label>
                    <select id="status" class="form-select" name="status" value="<?php echo $result['status'] ?>">
                        <option value="0" <?php if ($result['status'] == 0) {
                                                echo "selected";
                                            } ?>>Chờ Duyệt</option>
                        <option value="1" <?php if ($result['status'] == 1) {
                                                echo "selected";
                                            } ?>>Đang Giao</option>
                        <option value="2" <?php if ($result['status'] == 2) {
                                                echo "selected";
                                            } ?>>Đã Nhận</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="note" class="form-label">Ghi Chú</label>
                    <textarea class="form-control description" name="note" id="note" rows="10">
                    <?php echo $result['note'] ?>
      </textarea>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn-save float-end"><i class="far fa-save"></i></button><button id="back" type="button" class="btn-cancel float-end"><i class="fas fa-window-close"></i></button>
            </div>


        </form>

    </div>

</div>
<script>
    $('#editOrderForm').submit(function(e) {
        e.preventDefault();
        data = $(this).serialize();
        $.ajax({
            type: "post",
            url: "admin.php?act=editOrder_act",
            data: data,
            cache: false,
            processData: false,
            success: function(response) {
                arr = response.split("##-##");
                result = arr[1];
                if (result == "success") {
                    alert('Cập nhật thành công')
                    window.location.reload();
                } else {
                    alert('Cập nhật không thành công')
                }

            }
        });

    });
    $("#back").on("click", function() {
            window.history.back();
        });
</script>