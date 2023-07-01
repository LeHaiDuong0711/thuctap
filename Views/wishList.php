<div class="sessionWishlist m-5">


    <h1 class="text-success">Danh Sách Sản Phẩm Yêu Thích</h1>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <th>Giá</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="listWishlist">




        </tbody>

    </table>


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

    function appendWishlist() {
        $.ajax({
            type: "get",
            url: "index.php?act=getListWishlist",

            success: function(response) {
                arr = response.split("##-##");
                if (arr[1].length > 0) {
                    result = JSON.parse(arr[1]);
                    htmls = [];

                    result.forEach((value, index, array) => {




                        html =
                            `

                                        <tr id="` + value.pro_id + `">
                                <td>` + (index + 1) + `</td>
                                <td class="prodImage"><img width="50px" height="50px"></td>
                                <td class="prodName">
                                    
                                </td>

                                <td class="prodPrice"></td>

                                </td>
                                <td><button type="button" class="btn btn-danger remove-wishlist" data-id=` + value.pro_id + `>Xóa</button>
                                    <a href="index.php?act=productDetail&id=` + value.pro_id + `"><button type="button" class="btn btn-success">Mua</button></a>

                                </td>

                                </tr>


                         `;
                        htmls.push(html)









                    })
                    $('#listWishlist').html(htmls);

                    result.forEach((value, index, array) => {
                        $.ajax({
                            type: "get",
                            url: "index.php?act=getProductById",
                            data: {
                                prod_id: value.pro_id
                            },

                            success: function(res) {
                                arr1 = res.split("##-##");
                                result1 = JSON.parse(arr1[1]);

                                $('tr#' + result1.id + ' .prodImage img').attr('src', './Assets/img/' + result1.pro_image);
                                $('tr#' + result1.id + ' .prodName').html(result1.name);
                                if (result1.promotion > 0) {
                                    $('tr#' + result1.id + ' .prodPrice').html(formatCurrency(result1.promotion));
                                } else {
                                    $('tr#' + result1.id + ' .prodPrice').html(formatCurrency(result1.price));

                                }
                            }
                        });
                    })
                }





            }
        });


    }



    $(document).ready(function() {
        appendWishlist();

        $(document).on('click', '.remove-wishlist', function() {
            id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "index.php?act=remove_wishlist",
                data: {
                    id: id
                },
                success: function(response) {
                    arr = response.split("##-##");
                    check = arr[1];
                    if (check == "success") {
                      appendWishlist();
                    }
                },
            });
        });
    });
</script>