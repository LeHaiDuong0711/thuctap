<?php
$sl = new sales();
$p = new page();
//lấy ra toàn bộ sản phẩm

// $count=$result->rowCount();
//giới hạn số lượng hiển thị
$limit = 10;
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
} else {
    $keyword = 0;
}; ?>

<div class="row my-5">
    <div class="d-flex">
        <h3 class="fs-4 mb-3">Danh Sách Loại Sản Phẩm</h3>
        <form class="form-group d-flex" id="search" method="post" action="admin.php?use=listTypeProducts&keyword=<?php echo $keyword; ?>">

            <input type="search" name="keyword" class="form-control" placeholder="Nhập Mã Đơn Hàng">
            <button class=" btn""><i class=" fa fa-search aria-hidden="true"></i></button>
        </form>
    </div>

</div>



<div class="col">
    <table class="table bg-white rounded shadow-sm  table-hover">
        <thead>
            <tr>
                <th>Mã Loại</th>
                <th>Tên Loại</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pr = new products();
            $p = new page();
            //lấy ra toàn bộ sản phẩm

            // $count=$result->rowCount();
            //giới hạn số lượng hiển thị
            $limit = 10;
            $keyword = "";
            if (isset($_GET['keyword'])) {

                $keyword = $_GET['keyword'];
            }
            $count = $pr->countType($keyword);
            $page = $p->findPage($count, $limit);
            $start = $p->findStart($limit);
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $result = $pr->getAllType($start, $limit,  $keyword);


            while ($set = $result->fetch()) :
            ?>
                <tr>
                    <td><?php echo ($set['type_id']) ?></td>
                    <td><?php echo ($set['type_name']) ?></td>
                    <td><a href="admin.php?use=edit-type&id=<?php echo ($set['type_id']) ?>"><button type="button" class="btn-edit">Sửa</button></a> <a href="admin.php?use=remove-type&id=<?php echo ($set['type_id']) ?>"><button type="button" class="btn-remove">Xóa</button></a></td>
                </tr>
            <?php endwhile ?>

        </tbody>
    </table>
</div>
<ul class="pagination justify-content-center mt-5">
    <?php if ($current_page > 1 && $page > 1) : ?>
        <li class="page-item"><a class="page-link" href="admin.php?use=listType<?php if ($keyword != "") {
                                                                                        echo "&" . "keyword=" . "$keyword";
                                                                                    } ?>&page=<?php echo $current_page - 1 ?>">Previous</a></li>
    <?php endif ?>

    <?php for ($i = 1; $i <= $page; $i++) : ?>
        <li class="page-item"><a class="page-link" href="admin.php?use=listType=<?php if ($keyword != "") {
                                                                                        echo "&" . "keyword=" . "$keyword";
                                                                                    } ?>&page=<?php echo $i ?>"><?php echo $i ?></a></li>
    <?php endfor ?>






    <?php if ($current_page < $page &&  $page > 1) : ?>
        <li class="page-item"><a class="page-link" href="admin.php?use=listType<?php if ($keyword != "") {
                                                                                        echo "&keyword=" . "$keyword";
                                                                                    }
                                                                                    ?>&page=<?php echo $current_page + 1 ?>">Next</a></li>
    <?php endif ?>
</ul>
</div>