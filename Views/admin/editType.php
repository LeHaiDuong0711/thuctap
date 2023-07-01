<div class="sectionEditProduct">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Chỉnh Sửa Loại</h3>
        </div>

    </div>
    <div class="row">
        <?php
        $pr = new products();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $result = $pr->getTypeById($id);
        ?>
        <form action="admin.php?use=edit-type-action&id=<?php echo $id ?>" method="post">
            <div class="row">

                <div class="col-lg-2">
                    <label for="orderId" class="form-label">Mã Loại</label>
                    <input type="number" name="idUpdate" class="form-control" id="orderId" value="<?php echo $result['type_id'] ?>" />
                </div>
                <div class="col-lg-2">
                    <label for="userId" class="form-label">Tên Loại</label>
                    <input type="text" name="userId" class="form-control" id="type_name" value="<?php echo $result['type_name'] ?>" />
                </div>
                
                
            </div>
            <div class=""> 
                <button class="btn-edit">Lưu</button><button id="back" type="button" class="btn-cancel">Lưu</button>
            </div>


        </form>

    </div>

</div>