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
    url: "index.php?act=profile_act",

    success: function (response) {
      arr = response.split("##-##");
      if (arr[1] != "error") {
        result = JSON.parse(arr[1]);
        $("#sectionProfile .avatar_img").attr(
          "src",
          "./Assets/img/" + result.image
        );
        $("#sectionProfile .username").text(result.username);
        $("#sectionProfile .fullName").text(
          result.fullName
        );
        $('#myTabContent input[name="fullName"]').val(result.fullName);
       
        $('#myTabContent input[name="email"]').val(result.email);
        $('#myTabContent input[name="phoneNumber"]').val(result.phone);
      }
    },
  });

  $.ajax({
    type: "get",
    url: "index.php?act=myOrders",
    success: function (response) {
      arr = response.split("##-##");

      if (arr[1] != "error") {
        result = JSON.parse(arr[1]);

        result.forEach((item) => {
          $("#nav-all-order").append(
            `
                            <div class="card mt-5" id="` +
              item.order_id +
              `">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item myOrderTitle">` +
              item.date_create +
              `</li>
                                        <li class="list-group-item myOrderDetail"></li>
                                        <li class="list-group-item operation">Thành tiền: ` +
              formatCurrency(item.total) +
              `</li>
                                    </ul>
                                </div>
                        `
          );

          if (item.status <= 1) {
            $("#" + item.order_id + " .operation").append(
              '<button class="btn btn-danger float-end cancel" data-id="3">Hủy</button>'
            );
          }
          if (item.status == 3) {
            $("#" + item.order_id + " .operation").append(
              '<button class="btn btn-success float-end regain" data-id="0">Mua lại</button>'
            );
          }
          if (item.status == 0) {
            $("#" + item.order_id + " .myOrderTitle").append(
              '<p class="float-end"><i class="fas fa-history"></i> Đang xử lý</p>'
            );
          } else if (item.status == 1) {
            $("#" + item.order_id + " .myOrderTitle").append(
              '<p class="float-end"><i class="fas fa-shipping-fast"></i> Đang vận chuyển</p>'
            );
          } else if (item.status == 2) {
            $("#" + item.order_id + " .myOrderTitle").append(
              '<p class="float-end"><i class="far fa-check-circle"></i></i> Hoàn thành</p>'
            );
          }

          $.ajax({
            type: "get",
            url: "index.php?act=myOrderDetails", 
            data: {
              id: item.order_id,
            },

            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              result.forEach((value) => {
                $(
                  "#nav-all-order #" + value.order_id + " .myOrderDetail"
                ).append(
                  `<div class="row" id=` +
                    value.id +
                    `>
                                            <div class="col-lg-2">
                                                <img class="proImage w-50" alt="` +
                    value.pro_name +
                    `"/>
                                            </div>
                                            <div class="col-lg-9 product-content">
                                                <h6 class="name">` +
                    value.pro_name +
                    ` (` +
                    value.versions +
                    `)</h6>
                                            </div>
                                        </div>
                        `
                );
                if (value.versions == "" || value.versions == null) {
                  $(
                    "#nav-all-order #" +
                      value.order_id +
                      " #" +
                      value.id +
                      " .product-content .name"
                  ).html(value.pro_name);
                }
                $.ajax({
                  type: "get",
                  url: "index.php?act=productInOrder",
                  data: {
                    id: value.pro_id,
                  },
                  success: function (response) {
                    arr = response.split("##-##");
                    result = JSON.parse(arr[1]);
                    $(
                      "#nav-all-order #" +
                        value.order_id +
                        " #" +
                        value.id +
                        " img"
                    ).attr("src", "./Assets/img/" + result.pro_image);
                    $(
                      "#nav-all-order #" +
                        value.order_id +
                        " #" +
                        value.id +
                        " .product-content"
                    ).append("<small>Số lượng:" + value.quantity + "</small>");
                  },
                });
              });
            },
          });

          $("#" + item.order_id + " button.cancel").click(function () {
            status = $(this).data("id");
            if (confirm("Bạn vẫn muốn hủy đơn hàng chứ ?") == true) {
              $.ajax({
                type: "post",
                url: "index.php?act=updateStatus",
                data: {
                  id: item.order_id,
                  status: status,
                },

                success: function (response) {
                  arr = response.split("##-##");
                  if (arr[1] == "success") {
                    alert("Đã hủy đơn hàng");
                  } else {
                    alert("Đơn hàng chưa được hủy");
                  }
                },
              });
            }
          });
          $("#" + item.order_id + " .regain").click(function () {
            status = $(this).data("id");
            $.ajax({
              type: "post",
              url: "index.php?act=updateStatus",
              data: {
                id: item.order_id,
                status: status,
              },

              success: function (response) {
                arr = response.split("##-##");
                if (arr[1] == "success") {
                  alert("Mua hàng thành công");
                } else {
                  alert("Mua hàng thất bại");
                }
              },
            });
          });
        });
      }
    },
  });

  $("#nav-tab-order button").each((index, value) => {
    if ($(value).attr("id") == "nav-processing-tab") {
      $.ajax({
        type: "get",
        data: {
          status: 0,
        },
        url: "index.php?act=myOrders",
        success: function (response) {
          arr = response.split("##-##");

          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);

            result.forEach((item) => {
              $("#nav-processing").append(
                `
                            <div class="card mt-5" id="` +
                  item.order_id +
                  `">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item myOrderTitle">` +
                  item.date_create +
                  `</li>
                                        <li class="list-group-item myOrderDetail"></li>
                                        <li class="list-group-item operation">Thành tiền: ` +
                  formatCurrency(item.total) +
                  `</li>
                                    </ul>
                                </div>
                        `
              );

              $("#nav-processing #" + item.order_id + " .operation").append(
                '<button class="btn btn-danger float-end cancel" data-id="3">Hủy</button>'
              );

              $("#nav-processing #" + item.order_id + " .myOrderTitle").append(
                '<p class="float-end"><i class="fas fa-history"></i> Đang xử lý</p>'
              );

              $.ajax({
                type: "get",
                url: "index.php?act=myOrderDetails",
                data: {
                  id: item.order_id,
                },

                success: function (response) {
                  arr = response.split("##-##");
                  result = JSON.parse(arr[1]);
                  result.forEach((value) => {
                    $(
                      "#nav-processing #" + value.order_id + " .myOrderDetail"
                    ).append(
                      `<div class="row" id=` +
                        value.id +
                        `>
                                            <div class="col-lg-2">
                                                <img class="proImage w-50" alt="` +
                        value.pro_name +
                        `"/>
                                            </div>
                                            <div class="col-lg-9 product-content">
                                                 <h6 class="name">` +
                        value.pro_name +
                        ` (` +
                        value.versions +
                        `)</h6>
                                            </div>
                                        </div>
                        `
                    );
                    if (value.versions == "" || value.versions == null) {
                        $(
                          "#nav-processing #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content .name"
                        ).html(value.pro_name);
                      }
                    $.ajax({
                      type: "get",
                      url: "index.php?act=productInOrder",
                      data: {
                        id: value.pro_id,
                      },
                      success: function (response) {
                        arr = response.split("##-##");
                        result = JSON.parse(arr[1]);
                        $(
                          "#nav-processing #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " img"
                        ).attr("src", "./Assets/img/" + result.pro_image);
                        $(
                          "#nav-processing #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content"
                        ).append("<small>Số lượng:" + value.quantity + "</small>");
                      },
                    });
                  });
                },
              });
            });
          }
        },
      });
    }
    if ($(value).attr("id") == "nav-delivering-tab") {
      $.ajax({
        type: "get",
        data: {
          status: 1,
        },
        url: "index.php?act=myOrders",
        success: function (response) {
          arr = response.split("##-##");

          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);

            result.forEach((item) => {
              $("#nav-delivering").append(
                `
                            <div class="card mt-5" id="` +
                  item.order_id +
                  `">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item myOrderTitle">` +
                  item.date_create +
                  `</li>
                                        <li class="list-group-item myOrderDetail"></li>
                                        <li class="list-group-item operation">Thành tiền: ` +
                  formatCurrency(item.total) +
                  `</li>
                                    </ul>
                                </div>
                        `
              );

              $("#nav-delivering #" + item.order_id + " .operation").append(
                '<button class="btn btn-danger float-end cancel" data-id="3">Hủy</button>'
              );

              $("#nav-delivering #" + item.order_id + " .myOrderTitle").append(
                '<p class="float-end"><i class="fas fa-shipping-fast"></i> Đang vận chuyển</p>'
              );

              $.ajax({
                type: "get",
                url: "index.php?act=myOrderDetails",
                data: {
                  id: item.order_id,
                },

                success: function (response) {
                  arr = response.split("##-##");
                  result = JSON.parse(arr[1]);
                  result.forEach((value) => {
                    $(
                      "#nav-delivering #" + value.order_id + " .myOrderDetail"
                    ).append(
                      `<div class="row" id=` +
                        value.id +
                        `>
                                            <div class="col-lg-2">
                                                <img class="proImage w-50" alt="` +
                        value.pro_name +
                        `"/>
                                            </div>
                                            <div class="col-lg-9 product-content">
                                                 <h6 class="name">` +
                        value.pro_name +
                        ` (` +
                        value.versions +
                        `)</h6>
                                            </div>
                                        </div>
                        `
                    );
                    if (value.versions == "" || value.versions == null) {
                        $(
                          "#nav-delivering #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content .name"
                        ).html(value.pro_name);
                      }
                    $.ajax({
                      type: "get",
                      url: "index.php?act=productInOrder",
                      data: {
                        id: value.pro_id,
                      },
                      success: function (response) {
                        arr = response.split("##-##");
                        result = JSON.parse(arr[1]);
                        $(
                          "#nav-delivering #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " img"
                        ).attr("src", "./Assets/img/" + result.pro_image);
                        $(
                          "#nav-delivering #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content"
                        ).append("<small>Số lượng:" + value.quantity + "</small>");
                      },
                    });
                  });
                },
              });
            });
          }
        },
      });
    }
    if ($(value).attr("id") == "nav-received-tab") {
      $.ajax({
        type: "get",
        data: {
          status: 2,
        },
        url: "index.php?act=myOrders",
        success: function (response) {
          arr = response.split("##-##");

          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);

            result.forEach((item) => {
              $("#nav-received").append(
                `
                            <div class="card mt-5" id="` +
                  item.order_id +
                  `">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item myOrderTitle">` +
                  item.date_create +
                  `</li>
                                        <li class="list-group-item myOrderDetail"></li>
                                        <li class="list-group-item operation">Thành tiền: ` +
                  formatCurrency(item.total) +
                  `</li>
                                    </ul>
                                </div>
                        `
              );

              $("#nav-received #" + item.order_id + " .myOrderTitle").append(
                '<p class="float-end"><i class="far fa-check-circle"></i> Hoàn thành</p>'
              );

              $.ajax({
                type: "get",
                url: "index.php?act=myOrderDetails",
                data: {
                  id: item.order_id,
                },

                success: function (response) {
                  arr = response.split("##-##");
                  result = JSON.parse(arr[1]);
                  result.forEach((value) => {
                    $(
                      "#nav-received #" + value.order_id + " .myOrderDetail"
                    ).append(
                      `<div class="row" id=` +
                        value.id +
                        `>
                                            <div class="col-lg-2">
                                                <img class="proImage w-50" alt="` +
                        value.pro_name +
                        `"/>
                                            </div>
                                            <div class="col-lg-9 product-content">
                                                 <h6 class=name>` +
                        value.pro_name +
                        ` (` +
                        value.versions +
                        `)</h6>
                                            </div>
                                        </div>
                        `
                    );
                    if (value.versions == "" || value.versions == null) {
                        $(
                          "#nav-received #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content .name"
                        ).html(value.pro_name);
                      }
                    $.ajax({
                      type: "get",
                      url: "index.php?act=productInOrder",
                      data: {
                        id: value.pro_id,
                      },
                      success: function (response) {
                        arr = response.split("##-##");
                        result = JSON.parse(arr[1]);
                        $(
                          "#nav-received #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " img"
                        ).attr("src", "./Assets/img/" + result.pro_image);
                        $(
                          "#nav-received #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content"
                        ).append("<small>Số lượng:" + value.quantity + "</small>");
                      },
                    });
                  });
                },
              });
            });
          }
        },
      });
    }
    if ($(value).attr("id") == "nav-cancel-order-tab") {
      $.ajax({
        type: "get",
        data: {
          status: 3,
        },
        url: "index.php?act=myOrders",
        success: function (response) {
          arr = response.split("##-##");

          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);

            result.forEach((item) => {
              $("#nav-cancel-order").append(
                `
                            <div class="card mt-5" id="` +
                  item.order_id +
                  `">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item myOrderTitle">` +
                  item.date_create +
                  `</li>
                                        <li class="list-group-item myOrderDetail"></li>
                                        <li class="list-group-item operation">Thành tiền: ` +
                  formatCurrency(item.total) +
                  `</li>
                                    </ul>
                                </div>
                        `
              );

              $("#nav-cancel-order #" + item.order_id + " .operation").append(
                '<button class="btn btn-success float-end regain" data-id="0">Mua lại</button>'
              );

              $(
                "#nav-cancel-order #" + item.order_id + " .myOrderTitle"
              ).append(
                '<p class="float-end"><i class="far fa-window-close"></i>Hoàn thành</i></p>'
              );

              $.ajax({
                type: "get",
                url: "index.php?act=myOrderDetails",
                data: {
                  id: item.order_id,
                },

                success: function (response) {
                  arr = response.split("##-##");
                  result = JSON.parse(arr[1]);
                  result.forEach((value) => {
                    $(
                      "#nav-cancel-order #" + value.order_id + " .myOrderDetail"
                    ).append(
                      `<div class="row" id=` +
                        value.id +
                        `>
                                            <div class="col-lg-2">
                                                <img class="proImage w-50" alt="` +
                        value.pro_name +
                        `"/>
                                            </div>
                                            <div class="col-lg-9 product-content">
                                                 <h6 class=name>` +
                        value.pro_name +
                        ` (` +
                        value.versions +
                        `)</h6>
                                            </div>
                                        </div>
                        `
                    );
                    if (value.versions == "" || value.versions == null) {
                        $(
                          "#nav-cancel-order #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content .name"
                        ).html(value.pro_name);
                      }
                    $.ajax({
                      type: "get",
                      url: "index.php?act=productInOrder",
                      data: {
                        id: value.pro_id,
                      },
                      success: function (response) {
                        arr = response.split("##-##");
                        result = JSON.parse(arr[1]);
                        $(
                          "#nav-cancel-order #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " img"
                        ).attr("src", "./Assets/img/" + result.pro_image);
                        $(
                          "#nav-cancel-order #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content"
                        ).append("<small>Số lượng:" + value.quantity + "</small>");
                      },
                    });
                  });
                },
              });
            });
          }
        },
      });
    }
  });

  $("#submitChangePassword").on("click", function (e) {
    data = $("#changePasswordForm").serialize();
    $.ajax({
      type: "post",
      url: "index.php?act=change_password",
      data: data,

      success: function (response) {
        arr = response.split("##-##");
        if (arr[1] == "success") {
          alert("Thay đổi mật khẩu thành công");
          $("#changePasswordForm")[0].reset();
        } else if (arr[1] == "error") {
          alert("Thay đổi mật khẩu thất bại");
        } else if (arr[1] == "old password wrong") {
          alert("Mật khẩu củ không chính xác!");
        }
      },
    });
  });

  $("#editProfile").click(function (e) {
    $('input[name="fullName"').attr("readonly", false);
    $('input[name="fullName"').trigger("focus");
  
    $(".container-btn").html(
      `<button type="submit" class="btn btn-warning" id="submitEditProfile">Lưu</button>`
    );
  });

  $("#editProfileForm").submit(function (e) {
    e.preventDefault();
    data = $(this).serialize();
    $.ajax({
      type: "post",
      url: "index.php?act=editProfile",
      data: data,

      success: function (response) {
        arr = response.split("##-##");
        if (arr[1] == "success") {
          alert("cập nhật thành công");
          $('input[name="fullName"').attr("readonly", true);
     
          $(".container-btn").html(
            `<button type="button" class="btn btn-warning" id="editProfile">Chỉnh sửa</button>`
          );
        } else {
          alert("cập nhật thất bại");
        }
      },
    });
  });
  $("input[name='uploadAvatar']").change(function () {
    data = new FormData(document.getElementById("editAvatarForm"));

    $.ajax({
      url: "index.php?act=uploadAvatar",
      method: "POST",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        arr = response.split("##-##");

        if (result == "update error") {
          alert("Cập Nhật Thất Bại");
        } else if (result == "image name already exists") {
          alert("tên hình ảnh đã tồn tại");
        } else if (result == "images exceed 500kb") {
          alert("ảnh vượt quá 500kb");
        } else if (result == "file is not an image format") {
          alert("file không đúng định dạng hình ảnh (jpg, jpeg, png, gif)");
        } else if (result == "file image does not exis") {
          alert("file ảnh không tồn tại");
        } else {
          result = JSON.parse(arr[1]);
          $("#avatar-image").attr("src", "./Assets/img/" + result.image);
        }
      },
    });
  });
});
