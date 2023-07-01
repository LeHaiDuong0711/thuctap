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
    url: "index.php?act=order_data",
    success: function (response) {
      arr = response.split("##-##");
      result = JSON.parse(arr[1]);
      infoClient = result.infoClient;
      carts = result.carts;
      $("#infoClient").append(
        `
        <tr>
                                            <th>Mã Hóa Đơn</th>
                                            <td>` +
          infoClient.id +
          `</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Họ Và Tên</th>
                                            <td>` +
          infoClient.fullName +
          `</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Địa Chỉ</th>
                                            <td>` +
          infoClient.address +
          `</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Số Điện Thoại</th>
                                            <td>` +
          infoClient.phoneNumber +
          `</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Ngày Đặt</th>
                                            <td>` +
          infoClient.dateCreate +
          `</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
`
      );
      subTotal = 0;


      carts.forEach((cart,index) => {
  
        subTotal += cart.total;
        $("#listProductsClient").append(
          `<tr id="` +
            index +
            `"> <td>` +
            cart.id +
            `
</td>
<td class=cartName>` +
            cart.name +
            ` (` +
            cart.version +
            `
            )
            </td>
<td class="price">` +
            cart.unit_price +
            `</td>
<td>` +
            cart.quantity +
            `</td>
   </tr> `
        );
        cartTotal = formatCurrency($("#" + index+ " .price").text());
        $("#" + index + " .price").text(cartTotal);
        if(cart.version==""){
          $('#'+index+' .cartName').html(
            `<p>` +
          cart.name +
          `</p>`);
        }
      });
      if (infoClient.provisional != "") {
        temp1 = infoClient.provisional.replace(".", "").replace("đ", "");
      } else {
        temp1 = 0;
      }
      money = parseInt(subTotal) - parseInt(temp1);
      // console.log(temp1);

      $("#containerIntoMoney").append(
        `
      <h6>Tổng Tiền: <span id="subTotal" class="float-end">` +
          subTotal +
          `</span></h6>
      <h6 >Giảm Giá: <span id="provisional" class="float-end">` +
          temp1 +
          `</span></h6>
      <h6 >Thành Tiền: <span id="intoMoney" class="float-end">` +
          money +
          `</span></h6>
      `
      );
      intoMoney = $("#intoMoney").text();
      $("#intoMoney").text(formatCurrency(intoMoney));
      provisional = $("#provisional").text();
      $("#provisional").text(formatCurrency(provisional));
      subTotal = $("#subTotal").text();
      $("#subTotal").text(formatCurrency(subTotal));

      $("#submitFormOrder").click(function (e) {
        e.preventDefault();
        $.ajax({
          type: "post",
          url: "index.php?act=order_action",
          data: {
            intoMoney: intoMoney,
          },

          success: function (response) {
            result = response.split("##-##");
            if (result[1] == "success") {
              alert("Đặt hàng thành công");
              window.location.href = "index.php?act=listMyOrder";
            }
          },
        });
      });
    },
  });

  let total = $("#subTotal").text();
  total = total.replaceAll(",", "").replace("đ", "");
  let provisional = $("#provisional").text();
  provisional = provisional.replace(",", "").replace("đ", "");
  let intoMoney = total - provisional;
  intoMoney = intoMoney.toLocaleString("en-US");
  $("#intoMoney").append(intoMoney + "");
});
