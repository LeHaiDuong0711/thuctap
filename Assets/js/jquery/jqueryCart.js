function formatCurrency(price) {
  price = parseFloat(price);
  price = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);

  return price;
}
$(document).ready(function () {
  $.ajax({
    type: "get",
    url: "index.php?act=list_cart",
    success: function (response) {
      arr = response.split("##-##");

      result = JSON.parse(arr[1]);

      if (result == null) {
        carts = [];
        subTotal = 0;

        $(".sessionCart").html(
          `<h4 id="err">Chưa Có Sản Phẩm Trong Giỏ Hàng</h4>
                    <a href="index.php?act=products"> 
                        <button class="add-to-cart-btn"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Mua Ngay</button>
                    </a>
                    <div class="cart-does-not-exits"></div>`
        );
      } else {
        carts = result.carts;
        subTotal = result.subTotal;
        $(".sessionCart").html(
          `<h1 class="text-success">Thông Tin Giỏ Hàng</h1>
        <form id="list-cart" method="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hình Ảnh</th>
                        <th>Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Số Lượng</th>
                        <th>Thành Tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="listCarts">

                    


                </tbody>
                <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <th class="provisional">Tạm Tính:</br>` +
            formatCurrency(subTotal) +
            `
                        <td></td></th>
                    </tr>
                </thead>
            </table>
        </form>

        <a class="m-3" href="index.php?act=info"><button type="button" class="float-end btn btn-danger">Đặt Ngay</button></a>
`
        );
        i = 0;

        carts.forEach((cart, index) => {
          i = index + 1;
          $("#listCarts").append(
            `
                <tr id="` +
              cart.id +
              `">
                    <td class="proId"  hidden>` +
              cart.id +
              `</td>
                    <td class="index">` +
              i +
              `</td>
                    <td><img width="50px" height="50px" src="./Assets/img/` +
              cart.img +
              `"></td>
                    <td class="cartName">
                        <p>` +
              cart.name +` (`+cart.version+`)`+
              `</p>
                    </td>

                    <td>Đơn Giá: ` +
              formatCurrency(cart.unit_price) +
              ` </br>

                    </td>
                    <td>Số Lượng: <input id="quantity" type="number" class="qty" data-id="` +
              cart.id +
              `" inputmode="numeric" pattern="\d*" oninput="this.value = Math.max(this.value,1)" name="newqty[]" value="` +
              cart.quantity +
              `"</td>

                    <td class="cartTotal">
                       

                       ` +
              formatCurrency(cart.total) +
              ` </p>
                    </td>
                    <td><button type="button" data-key="` +
              index +
              `" class="btn btn-danger delete">Xóa</button>



                    </td>
                </tr>
           `
          );
          if(cart.version == ""){
            $('#listCarts tr#'+cart.id+' .cartName').html(
              `<p>` +
            cart.name +
            `</p>`);
          }
          
        });
      }
      $('input[class="qty"]').on("change", function () {
        var quantity = $(this).val();
        var id = $(this).parents("tr").children("td.proId").text();
        var data = {
          id: id,
          newqty: quantity,
        };
        // Gửi yêu cầu cập nhật số lượng sản phẩm trong giỏ hàng
        $.ajax({
          url: "index.php?act=update",
          method: "POST",
          cache: false,
          data: data,

          success: function (response) {
            arr = response.split("##-##");
            result = JSON.parse(arr[1]);

            total = 0;
            result.forEach((item) => {
              total += item.total;
              $("#" + item.id + " .cartTotal").text(formatCurrency(item.total));
              $(".provisional").text(formatCurrency(total));
            });
          },
          error: function (xhr, status, error) {
            console.log(error);
          },
        });
      });
      $(document).on("click", ".delete", function () {
        key = $(this).data("key");
        $.ajax({
          type: "post",
          url: "index.php?act=delete",
          data: { key: key },
          success: function (response) {
            arr = response.split("##-##");
            result = arr[1];
            result = JSON.parse(result);
            if (result != null) {
              alert("Đã xóa sản phẩm khỏi giỏ hàng");
              carts = result.carts;
              subTotal = result.subTotal;
              html = "";
              htmls = [];
              i = 0;
              carts.forEach((cart, index) => {
                i = index + 1;
                html =
                  `
               
                              <tr id="` +
                  cart.id +
                  `">
                                  <td class="proId"  hidden>` +
                  cart.id +
                  `</td>
                                  <td class="index">` +
                  i +
                  `</td>
                                  <td><img width="50px" height="50px" src="./Assets/img/` +
                  cart.img +
                  `"></td>
                                  <td>
                                      <p>` +
                  cart.name +
                  `</p>
                                  </td>

                                  <td>Đơn Giá: ` +
                  formatCurrency(cart.unit_price) +
                  ` </br>

                                  </td>
                                  <td>Số Lượng: <input id="quantity" type="number" class="qty" data-id="` +
                  cart.id +
                  `" inputmode="numeric" pattern="\d*" oninput="this.value = Math.max(this.value,1)" name="newqty[]" value="` +
                  cart.quantity +
                  `"</td>

                                  <td class="cartTotal">
                                    

                                    ` +
                  formatCurrency(cart.total) +
                  ` </p>
                                  </td>
                                  <td><button type="button" data-key="` +
                  index +
                  `" class="btn btn-danger delete">Xóa</button>



                                  </td>
                              </tr>
                        `;

                htmls.push(html);
              });

              $("#listCarts").html(htmls);
              $(".provisional").html("Tạm Tính:</br>" +  formatCurrency(subTotal));
              $.ajax({
                type: "get",
                url: "index.php?act=countCart",
                success: function (response) {
                  arr = response.split("##-##");

                  $(".countCart").html(arr[1]);
                },
              });
            }
          },
        });
      });
    },
  });
  //   Bắt sự kiện thay đổi số lượng sản phẩm trong giỏ hàng
});
