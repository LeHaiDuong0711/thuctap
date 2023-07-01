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
    url: "index.php?act=checkout",

    success: function (response) {
      arr = response.split("##-##");
      result = JSON.parse(arr[1]);
      subTotal = 0;
      $('#orderForm input[name="fullName"]').val(result.user.fullName);

      $('#orderForm input[name="phone"]').val(result.user.phone);

      result.cart.forEach((cart, index) => {
        if (cart.version == "") {
          name = cart.name;
        } else {
          name = cart.name + "( " + cart.version + " )";
        }

        $("#myProducts").append(
          `<div class="d-flex" id=` +
            index +
            `>
            <div>
              <small class="text-muted">
                ` +
            name +
            ` x ` +
            cart.quantity +
            `
  
              </small>
            </div>
  
              <div >
                <span class="total"> ` +
            cart.total +
            `</span>
  
              </div>
  
          </div>`
        );
        cartTotal = formatCurrency($("#" + index + " .total").text());
        $("#" + index + " .total").text(cartTotal);

        subTotal += cart.total;
      });

      $("#containerProvisional").append(
        `
           <strong id="provisional">` +
          subTotal +
          `</strong>`
      );

      $("#containerSubTotal").append(
        `
        <strong id="subtotal">` +
          subTotal +
          `</strong>`
      );
      provisional = formatCurrency($("#provisional").text());
      $("#provisional").text(provisional);
      total = formatCurrency($("#subtotal").text());
      $("#subtotal").text(total);
    },
  });

  $("#submitForm").click(function () {
    var code = $('input[name="code"]').val();
    if (code != "" && code != null) {
      $("#codePromotionForm .errCode").remove();
      $.ajax({
        url: "index.php?act=promotion",
        cache: false,
        data: {
          code: code,
        },
        method: "POST",
        success: function (response) {
          // console.log(response.data);
          arr = response.split("##-##");
          kq = JSON.parse(arr["1"]);
          if(kq!=false){
            $("#codePromotionForm .errCode").remove();
            $("#description").html(kq.description);
          var provisional = $("#provisional").text();
          provisional = provisional.replaceAll(".", "").replace("đ", "");
          value = parseFloat(provisional) * parseFloat(kq.value);
          value1 = value;
          value = formatCurrency(value);
          $("#value").html("<strong>-" + value + "</strong>");
          sub_total = parseFloat(provisional);
          sub_total -= parseFloat(value1);
          sub_total = formatCurrency(sub_total);

          $("#subtotal").html("<strong>" + sub_total + "</strong>");
          $("#codePromotionForm")[0].reset();
          $("#prov").val(value);
          } else{
            $("#codePromotionForm .errCode").remove();
            $("#codePromotionForm").append('<span class="text-danger errCode">Mã giảm giá không tồn tại</span>')
          }

          
        },
      });
    }else{
      $("#codePromotionForm .errCode").remove();
      $("#codePromotionForm").append('<span class="text-danger errCode">Vui lòng nhập mã giảm giá</span>')
    }
  });

  $("#orderForm").submit(function (e) {
    formData = $(this).serialize();
    // e.preventDefault()
    $.ajax({
      url: "index.php?act=order_data",
      method: "POST",
      data: formData,

      success: function (response) {},
    });
  });
});
