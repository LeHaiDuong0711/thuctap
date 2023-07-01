<div class="row my-5">
    <div class="d-flex">
        <h3 class="fs-4 mb-3">Danh Sách Chi Tiết Đơn Hàng</h3>
    </div>
</div>



<div class="col">
    <table class="table bg-white rounded shadow-sm  table-hover table-bordered">
        <thead>
            <tr>
                <th>Mã Đơn Hàng</th>
                <th>Mã Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>Số Lượng</th>
                <th>Tổng Tiền</th>
              
            </tr>
        </thead>
        <tbody id="listOrderDetails">




        </tbody>
    </table>
</div>
<ul class="pagination justify-content-center mt-5" id="paginationListOrderDetail">

</ul>
</div>
<script>
    function formatCurrency(price) {
        price = parseFloat(price);
        price = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(price);

        return price;
    }
    $(document).ready(function() {
        urlParam = new URLSearchParams(window.location.href);
        id = urlParam.get("id");
        $.ajax({
            type: "get",
            url: "admin.php?act=orderDetail-act",
            data: {
                id: id
            },

            success: function(response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);
                ordersPerPage = 10; // số lượng sản phẩm trên mỗi trang
                totalOrders = result.length; // tổng số sản phẩm
                totalPages = Math.ceil(totalOrders / ordersPerPage); // tổng số trang
                startIndex = (currentPage - 1) * ordersPerPage;
                endIndex = startIndex + ordersPerPage;
                if (endIndex > totalOrders) {
                    endIndex = totalOrders;
                }

                currentOrders = result.slice(startIndex, endIndex);
                if (currentOrders.length > 0) {
                    htmls = [];
                    currentOrders.forEach((item) => {
                        html =
                            `  <tr id=` + item.id + `>
                                    <td>` + item.order_id + `</td>
                                    <td>` + item.pro_id + `</td>
                                    <td>` + item.pro_name + `</td>
                                    <td>` + item.quantity + `</td>
                                    <td>` + formatCurrency(item.total)  + `</td>
                                   
                                </tr>`;

                        htmls.push(html);
                    });

                    $("#listOrderDetails").html(htmls);

                    if (currentPage > 1) {

                        $(
                            '<a class="page-item page-link prev" href="admin.php?act=listOrderDetails&id=' + id +
                            "&page=" +
                            (currentPage - 1) +
                            '">Trước đó</a>'
                        ).appendTo("#paginationListOrderDetail");

                    }

                    for (let i = 1; i <= totalPages; i++) {

                        $("#paginationListOrderDetail").append(
                            '<li class="page-item page"><a class="page-link" href="admin.php?act=listOrderDetails&id=' + id +

                            "&page=" +
                            i +
                            '">' +
                            i +
                            "</a></li>"
                        );


                        $("#paginationListOrderDetail li a").each(function(index) {
                            if (index + 1 == currentPage) {
                                $(this).attr("style", "background-color:orange");
                            }
                        });
                    }
                    if (currentPage < totalPages) {
                        page = parseInt(currentPage) + 1;


                        $(
                            '<a class="page-item page-link next" href="admin.php?act=listOrderDetails&id=' + id +

                            "&page=" +
                            page +
                            '">Tiếp theo</a>'
                        ).appendTo("#paginationListOrderDetail");

                    }



                    //
                }
            }
        });
    });
</script>