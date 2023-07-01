<div class="row">
    <div class="col-lg-6">
        <h3 class="fs-4 mb-3">Danh Sách Danh Mục</h3>
    </div>
    <div class="col-lg-6">
        <?php
        $keyword = "";
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        }
        ?>
        <form method="get" class="d-flex" id="searchCategoryForm">
            <input type="hidden" name="act" value="category">
            <input name="keyword" class="form-control" value="<?php echo  $keyword ?>" placeholder="tìm kiếm...">
            <button type="submit" class="btn"><i class="fas fa-search"></i></button>
        </form>

        <a href="admin.php?act=add-category"><button type="button" class="btn-add float-end"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </a>
    </div>

</div>




<div class="col">
    <table class="table bg-white rounded shadow-sm  table-hover table-bordered">
        <thead>
            <tr>
                <th>Mã Danh Mục</th>
                <th>Danh Mục Cha</th>
                <th>Tên Danh Mục</th>
                <th>Đường Dẫn</th>
                <!-- <th>Ngày Tạo</th> -->
                <th></th>
            </tr>
        </thead>
        <tbody id="listCategory">




        </tbody>
    </table>
</div>
<div>
    <ul id="paginationCategory" class="pagination">

    </ul>
</div>
</div>