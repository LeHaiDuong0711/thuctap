function formatCurrency(price) {
  price = parseFloat(price);
  price = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);

  return price;
}
function formatDate(dateFormat) {
  date = new Date(dateFormat);
  day = date.getDate();
  month = date.getMonth() + 1;
  year = date.getFullYear();
  formattedDate = day + "-" + month + "-" + year;
  return formattedDate;
}
function timeBetweenTwoDays(date) {
  now = moment();

  dateFormat = "YYYY/MM/DD HH:mm:ss";
  today = now.format(dateFormat);

  // Tạo đối tượng Moment cho ngày thứ nhất
  date1 = moment(date, dateFormat);

  // Tạo đối tượng Moment cho ngày thứ hai
  date2 = moment(today, dateFormat);

  // Tính khoảng cách giữa hai ngày
  duration = moment.duration(date2.diff(date1));

  // Chuyển đổi khoảng cách thành giờ và phút
  hours = Math.floor(duration.asHours());
  return hours;
}
function render() {
  $("#nav-all-order").html("");
  $("#nav-processing").html("");
  $("#nav-delivering").html("");
  $("#nav-received").html("");
  $("#nav-cancel-order").html("");
  $.ajax({
    type: "get",
    url: "index.php?act=myOrders",
    success: function (response) {
      arr = response.split("##-##");

      if (arr[1] != "error") {
        result = JSON.parse(arr[1]);
        if (result.length <= 0) {
          $("#nav-all-order").append(
            `<div class="text-bg-warning">Không có đơn hàng!</div>`
          );
        } else {
          result.forEach((item) => {
            $("#nav-all-order").append(
              `
                            <div class="card mt-5" id="` +
                item.order_id +
                `">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item myOrderTitle"></li>
                                        <li class="list-group-item myOrderDetail"></li>
                                        <li class="list-group-item operation">Thành tiền: ` +
                formatCurrency(item.total) +
                `</li>
                                    </ul>
                                </div>
                        `
            );

            if (item.status <= 1) {
              if (timeBetweenTwoDays(item.delivery_date) >= 3) {
                $("#" + item.order_id + " .operation").append(
                  '<button class="btn btn-danger float-end cancel-order" data-id=' +
                    item.order_id +
                    ">Hủy</button>"
                );
              }
            }
            if (item.status == 3) {
              $("#" + item.order_id + " .myOrderTitle").append(
                formatDate(item.cancellation_date)
              );
              $("#" + item.order_id + " .myOrderTitle").append(
                '<p class="float-end"><i class="far fa-window-close"></i> Đã hủy</p>'
              );
              $("#" + item.order_id + " .operation").append(
                '<button class="btn btn-success float-end replace-order" data-id=' +
                  item.order_id +
                  ">Mua lại</button>"
              );
            }
            if (item.status == 0) {
              $("#" + item.order_id + " .myOrderTitle").append(
                formatDate(item.date_create)
              );
              $("#" + item.order_id + " .myOrderTitle").append(
                '<p class="float-end"><i class="fas fa-history"></i> Đang xử lý</p>'
              );
            } else if (item.status == 1) {
              $("#" + item.order_id + " .myOrderTitle").append(
                formatDate(item.delivery_date)
              );
              $("#" + item.order_id + " .myOrderTitle").append(
                '<p class="float-end"><i class="fas fa-shipping-fast"></i> Đang vận chuyển</p>'
              );
              $("#" + item.order_id + " .operation").append(
                '<button class="me-2 btn btn-success float-end received-order" data-id=' +
                  item.order_id +
                  ">Đã nhận</button>"
              );
            } else if (item.status == 2) {
              $("#" + item.order_id + " .myOrderTitle").append(
                formatDate(item.received_date)
              );
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
                    `<div class="row mt-3" id=` +
                      value.id +
                      `>
                                          <div class="col-lg-2">
                                              <img class="proImage w-50"/>
                                          </div>
                                          <div class="col-lg-7 product-content">
                                          <h6 class="name"></h6>
                                          </div>
                                      </div>
                      `
                  );
                  if (item.status == 2) {
                    if (value.propertyId != 0) {
                      $.ajax({
                        type: "get",
                        url: "index.php?act=getProductByPropertyId",
                        data: { id: value.propertyId },

                        success: function (res) {
                          arr1 = res.split("##-##");
                          result1 = JSON.parse(arr1[1]);
                          $("#" + value.id).append(
                            ' <div class="text-end col-lg-2"><a href="index.php?act=productDetail&id=' +
                              result1.id +
                              '">Đánh giá</a></div>'
                          );
                        },
                      });
                    } else {
                      $("#" + value.id).append(
                        ' <div class="text-end col-lg-2"><a href="index.php?act=productDetail&id=' +
                          value.pro_id +
                          '">Đánh giá</a></div>'
                      );
                    }
                  }
                  if (value.propertyId != 0) {
                    setTimeout(() => {
                      $.ajax({
                        type: "get",
                        url: "index.php?act=productPropertyInOrder",
                        data: {
                          id: value.propertyId,
                        },
                        success: function (response) {
                          arr = response.split("##-##");
                          result = JSON.parse(arr[1]);
                          version = "";

                          keys = Object.keys(result);

                          halfKey = keys.slice(keys.length / 2);

                          halfKey = halfKey.slice(4);
                          halfKey = halfKey.slice(0, -5);

                          halfKey.forEach((item1) => {
                            if (result[item1] != null && result[item1] != "") {
                              version += result[item1] + " / ";
                            }

                            version = version.slice(0, -2);
                          });
                          img = result.image;
                          name = value.pro_name + "( " + version + " )";
                          $(
                            "#nav-all-order #" +
                              value.order_id +
                              " #" +
                              value.id +
                              " img"
                          ).attr("src", "./Assets/img/" + img);
                          $(
                            "#nav-all-order #" +
                              value.order_id +
                              " #" +
                              value.id +
                              " .name"
                          ).html(name);
                          $(
                            "#nav-all-order #" +
                              value.order_id +
                              " #" +
                              value.id +
                              " .product-content"
                          ).append(
                            "<small>Số lượng:" + value.quantity + "</small>"
                          );
                        },
                      });
                    }, 50);
                  } else {
                    $.ajax({
                      type: "get",
                      url: "index.php?act=productInOrder",
                      data: {
                        id: value.pro_id,
                      },
                      success: function (response) {
                        arr = response.split("##-##");
                        result = JSON.parse(arr[1]);

                        img = result.pro_image;
                        name = value.pro_name;
                        $(
                          "#nav-all-order #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " img"
                        ).attr("src", "./Assets/img/" + img);
                        $(
                          "#nav-all-order #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .name"
                        ).html(name);
                        $(
                          "#nav-all-order #" +
                            value.order_id +
                            " #" +
                            value.id +
                            " .product-content"
                        ).append(
                          "<small>Số lượng:" + value.quantity + "</small>"
                        );
                      },
                    });
                  }
                });
              },
            });
          });
        }
      }
    },
  });

  $("#nav-tab-order button").each((index, value) => {
    if ($(value).attr("id") == "nav-processing-tab") {
      $.ajax({
        type: "get",
        url: "index.php?act=myOrders",
        data: { status: 0 },
        success: function (response) {
          arr = response.split("##-##");

          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);
            if (result.length <= 0) {
              $("#nav-processing").append(
                `<div class="text-bg-warning">Không có đơn hàng đang xử lý!</div>`
              );
            } else {
              result.forEach((item) => {
                $("#nav-processing").append(
                  `
                                    <div class="card mt-5" id="` +
                    item.order_id +
                    `">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item myOrderTitle">` +
                    formatDate(item.date_create) +
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
                  '<button class="btn btn-danger float-end cancel-order" data-id=' +
                    item.order_id +
                    ">Hủy</button>"
                );

                $(
                  "#nav-processing #" + item.order_id + " .myOrderTitle"
                ).append(
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
                        `<div class="row mt-3" id=` +
                          value.id +
                          `>
                                                  <div class="col-lg-2">
                                                      <img class="proImage w-50"/>
                                                  </div>
                                                  <div class="col-lg-9 product-content">
                                                  <h6 class="name"></h6>
                                                  </div>
                                              </div>
                              `
                      );
                      if (value.propertyId != 0) {
                        setTimeout(() => {
                          $.ajax({
                            type: "get",
                            url: "index.php?act=productPropertyInOrder",
                            data: {
                              id: value.propertyId,
                            },
                            success: function (response) {
                              arr = response.split("##-##");
                              result = JSON.parse(arr[1]);
                              version = "";

                              keys = Object.keys(result);

                              halfKey = keys.slice(keys.length / 2);

                              halfKey = halfKey.slice(4);
                              halfKey = halfKey.slice(0, -5);

                              halfKey.forEach((item1) => {
                                if (
                                  result[item1] != null &&
                                  result[item1] != ""
                                ) {
                                  version += result[item1] + " / ";
                                }

                                version = version.slice(0, -2);
                              });
                              img = result.image;
                              name = value.pro_name + "( " + version + " )";
                              $(
                                "#nav-processing #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " img"
                              ).attr("src", "./Assets/img/" + img);
                              $(
                                "#nav-processing #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " .name"
                              ).html(name);
                              $(
                                "#nav-processing #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " .product-content"
                              ).append(
                                "<small>Số lượng:" + value.quantity + "</small>"
                              );
                            },
                          });
                        }, 50);
                      } else {
                        $.ajax({
                          type: "get",
                          url: "index.php?act=productInOrder",
                          data: {
                            id: value.pro_id,
                          },
                          success: function (response) {
                            arr = response.split("##-##");
                            result = JSON.parse(arr[1]);

                            img = result.pro_image;
                            name = value.pro_name;
                            $(
                              "#nav-processing #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " img"
                            ).attr("src", "./Assets/img/" + img);
                            $(
                              "#nav-processing #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " .name"
                            ).html(name);
                            $(
                              "#nav-processing #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " .product-content"
                            ).append(
                              "<small>Số lượng:" + value.quantity + "</small>"
                            );
                          },
                        });
                      }
                    });
                  },
                });
              });
            }
          }
        },
      });
    }
    if ($(value).attr("id") == "nav-delivering-tab") {
      $.ajax({
        type: "get",
        url: "index.php?act=myOrders",
        data: { status: 1 },
        success: function (response) {
          arr = response.split("##-##");

          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);
            if (result.length <= 0) {
              $("#nav-delivering").append(
                `<div class="text-bg-warning">Không có đơn hàng đang vận chuyển!</div>`
              );
            } else {
              result.forEach((item) => {
                $("#nav-delivering").append(
                  `
                                    <div class="card mt-5" id="` +
                    item.order_id +
                    `">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item myOrderTitle">` +
                    formatDate(item.delivery_date) +
                    `</li>
                                                <li class="list-group-item myOrderDetail"></li>
                                                <li class="list-group-item operation">Thành tiền: ` +
                    formatCurrency(item.total) +
                    `</li>
                                            </ul>
                                        </div>
                                `
                );
                 
                if (timeBetweenTwoDays(item.delivery_date) >= 3) {
                  $("#nav-delivering #" + item.order_id + " .operation").append(
                    '<button class="ms-2 btn btn-danger float-end cancel-order" data-id=' +
                      item.order_id +
                      ">Hủy</button>"
                  );
                }

                $(
                  "#nav-delivering #" + item.order_id + " .myOrderTitle"
                ).append(
                  '<p class="float-end"><i class="fas fa-shipping-fast"></i> Đang vận chuyển</p>'
                );
                $("#nav-delivering #" + item.order_id + " .operation").append(
                  '<button class="me-2 btn btn-success float-end received-order" data-id=' +
                    item.order_id +
                    ">Đã nhận</button>"
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
                        `<div class="row mt-3" id=` +
                          value.id +
                          `>
                                                  <div class="col-lg-2">
                                                      <img class="proImage w-50"/>
                                                  </div>
                                                  <div class="col-lg-9 product-content">
                                                  <h6 class="name"></h6>
                                                  </div>
                                              </div>
                              `
                      );
                      if (value.propertyId != 0) {
                        setTimeout(() => {
                          $.ajax({
                            type: "get",
                            url: "index.php?act=productPropertyInOrder",
                            data: {
                              id: value.propertyId,
                            },
                            success: function (response) {
                              arr = response.split("##-##");
                              result = JSON.parse(arr[1]);
                              version = "";

                              keys = Object.keys(result);

                              halfKey = keys.slice(keys.length / 2);

                              halfKey = halfKey.slice(4);
                              halfKey = halfKey.slice(0, -5);

                              halfKey.forEach((item1) => {
                                if (
                                  result[item1] != null &&
                                  result[item1] != ""
                                ) {
                                  version += result[item1] + " / ";
                                }

                                version = version.slice(0, -2);
                              });
                              img = result.image;
                              name = value.pro_name + "( " + version + " )";
                              $(
                                "#nav-delivering #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " img"
                              ).attr("src", "./Assets/img/" + img);
                              $(
                                "#nav-delivering #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " .name"
                              ).html(name);
                              $(
                                "#nav-delivering #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " .product-content"
                              ).append(
                                "<small>Số lượng:" + value.quantity + "</small>"
                              );
                            },
                          });
                        }, 50);
                      } else {
                        $.ajax({
                          type: "get",
                          url: "index.php?act=productInOrder",
                          data: {
                            id: value.pro_id,
                          },
                          success: function (response) {
                            arr = response.split("##-##");
                            result = JSON.parse(arr[1]);

                            img = result.pro_image;
                            name = value.pro_name;
                            $(
                              "#nav-delivering #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " img"
                            ).attr("src", "./Assets/img/" + img);
                            $(
                              "#nav-delivering #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " .name"
                            ).html(name);
                            $(
                              "#nav-delivering #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " .product-content"
                            ).append(
                              "<small>Số lượng:" + value.quantity + "</small>"
                            );
                          },
                        });
                      }
                    });
                  },
                });
              });
            }
          }
        },
      });
    }
    if ($(value).attr("id") == "nav-received-tab") {
      $.ajax({
        type: "get",
        url: "index.php?act=myOrders",
        data: { status: 2 },
        success: function (response) {
          arr = response.split("##-##");

          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);
            if (result.length <= 0) {
              $("#nav-received").append(
                `<div class="text-bg-warning">Không có đơn hàng đã nhận!</div>`
              );
            } else {
              result.forEach((item) => {
                $("#nav-received").append(
                  `
                                    <div class="card mt-5" id="` +
                    item.order_id +
                    `">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item myOrderTitle">` +
                    formatDate(item.received_date) +
                    `</li>
                                                <li class="list-group-item myOrderDetail"></li>
                                                <li class="list-group-item operation">Thành tiền: ` +
                    formatCurrency(item.total) +
                    `</li>
                                            </ul>
                                        </div>
                                `
                );

                $("#nav-received #" + item.order_id + " .operation").append(
                  '<button class="btn btn-success float-end replace-order" data-id=' +
                    item.order_id +
                    ">Mua lại</button>"
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
                        `<div class="row mt-3" id=` +
                          value.id +
                          `>
                                                  <div class="col-lg-2">
                                                      <img class="proImage w-50"/>
                                                  </div>
                                                  <div class="col-lg-7 product-content">
                                                  <h6 class="name"></h6>
                                                  </div>
                                              </div>
                              `
                      );

                      if (value.propertyId != 0) {
                        $.ajax({
                          type: "get",
                          url: "index.php?act=getProductByPropertyId",
                          data: { id: value.propertyId },

                          success: function (res) {
                            arr1 = res.split("##-##");

                            result1 = JSON.parse(arr1[1]);
                            $("#nav-received #" + value.id).append(
                              ' <div class="text-end col-lg-2"><a href="index.php?act=productDetail&id=' +
                                result1.id +
                                '">Đánh giá</a></div>'
                            );
                          },
                        });
                      } else {
                        $("#nav-received #" + value.id).append(
                          ' <div class="text-end col-lg-2"><a href="index.php?act=productDetail&id=' +
                            value.pro_id +
                            '">Đánh giá</a></div>'
                        );
                      }

                      if (value.propertyId != 0) {
                        setTimeout(() => {
                          $.ajax({
                            type: "get",
                            url: "index.php?act=productPropertyInOrder",
                            data: {
                              id: value.propertyId,
                            },
                            success: function (response) {
                              arr = response.split("##-##");
                              result = JSON.parse(arr[1]);
                              version = "";

                              keys = Object.keys(result);

                              halfKey = keys.slice(keys.length / 2);

                              halfKey = halfKey.slice(4);
                              halfKey = halfKey.slice(0, -5);

                              halfKey.forEach((item1) => {
                                if (
                                  result[item1] != null &&
                                  result[item1] != ""
                                ) {
                                  version += result[item1] + " / ";
                                }

                                version = version.slice(0, -2);
                              });
                              img = result.image;
                              name = value.pro_name + "( " + version + " )";
                              $(
                                "#nav-received #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " img"
                              ).attr("src", "./Assets/img/" + img);
                              $(
                                "#nav-received #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " .name"
                              ).html(name);
                              $(
                                "#nav-received #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " .product-content"
                              ).append(
                                "<small>Số lượng:" + value.quantity + "</small>"
                              );
                            },
                          });
                        }, 50);
                      } else {
                        $.ajax({
                          type: "get",
                          url: "index.php?act=productInOrder",
                          data: {
                            id: value.pro_id,
                          },
                          success: function (response) {
                            arr = response.split("##-##");
                            result = JSON.parse(arr[1]);

                            img = result.pro_image;
                            name = value.pro_name;
                            $(
                              "#nav-received #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " img"
                            ).attr("src", "./Assets/img/" + img);
                            $(
                              "#nav-received #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " .name"
                            ).html(name);
                            $(
                              "#nav-received #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " .product-content"
                            ).append(
                              "<small>Số lượng:" + value.quantity + "</small>"
                            );
                          },
                        });
                      }
                    });
                  },
                });
              });
            }
          }
        },
      });
    }
    if ($(value).attr("id") == "nav-cancel-order-tab") {
      $.ajax({
        type: "get",
        url: "index.php?act=myOrders",
        data: { status: 3 },
        success: function (response) {
          arr = response.split("##-##");

          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);
            if (result.length <= 0) {
              $("#nav-cancel-order").append(
                `<div class="text-bg-warning">Không có đơn hàng bị hủy!</div>`
              );
            } else {
              result.forEach((item) => {
               
                $("#nav-cancel-order").append(
                  `
                                    <div class="card mt-5" id="` +
                    item.order_id +
                    `">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item myOrderTitle">` +
                    formatDate(item.cancellation_date) +
                    `</li>
                                                <li class="list-group-item myOrderDetail"></li>
                                                <li class="list-group-item operation">Thành tiền: ` +
                    formatCurrency(item.total) +
                    `</li>
                                            </ul>
                                        </div>
                                `
                );

                $(
                  "#nav-cancel-order #" + item.order_id + " .myOrderTitle"
                ).append(
                  '<p class="float-end"><i class="far fa-window-close"></i> Đã hủy</p>'
                );

                $("#nav-cancel-order #" + item.order_id + " .operation").append(
                  '<button class="btn btn-success float-end replace-order" data-id=' +
                    item.order_id +
                    ">Mua lại</button>"
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
                        "#nav-cancel-order #" +
                          value.order_id +
                          " .myOrderDetail"
                      ).append(
                        `<div class="row mt-3" id=` +
                          value.id +
                          `>
                                                  <div class="col-lg-2">
                                                      <img class="proImage w-50"/>
                                                  </div>
                                                  <div class="col-lg-9 product-content">
                                                  <h6 class="name"></h6>
                                                  </div>
                                              </div>
                              `
                      );
                      if (value.propertyId != 0) {
                        setTimeout(() => {
                          $.ajax({
                            type: "get",
                            url: "index.php?act=productPropertyInOrder",
                            data: {
                              id: value.propertyId,
                            },
                            success: function (response) {
                              arr = response.split("##-##");
                              result = JSON.parse(arr[1]);
                              version = "";

                              keys = Object.keys(result);

                              halfKey = keys.slice(keys.length / 2);

                              halfKey = halfKey.slice(4);
                              halfKey = halfKey.slice(0, -5);

                              halfKey.forEach((item1) => {
                                if (
                                  result[item1] != null &&
                                  result[item1] != ""
                                ) {
                                  version += result[item1] + " / ";
                                }

                                version = version.slice(0, -2);
                              });
                              img = result.image;
                              name = value.pro_name + "( " + version + " )";
                              $(
                                "#nav-cancel-order #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " img"
                              ).attr("src", "./Assets/img/" + img);
                              $(
                                "#nav-cancel-order #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " .name"
                              ).html(name);
                              $(
                                "#nav-cancel-order #" +
                                  value.order_id +
                                  " #" +
                                  value.id +
                                  " .product-content"
                              ).append(
                                "<small>Số lượng:" + value.quantity + "</small>"
                              );
                            },
                          });
                        }, 50);
                      } else {
                        $.ajax({
                          type: "get",
                          url: "index.php?act=productInOrder",
                          data: {
                            id: value.pro_id,
                          },
                          success: function (response) {
                            arr = response.split("##-##");
                            result = JSON.parse(arr[1]);

                            img = result.pro_image;
                            name = value.pro_name;
                            $(
                              "#nav-cancel-order #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " img"
                            ).attr("src", "./Assets/img/" + img);
                            $(
                              "#nav-cancel-order #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " .name"
                            ).html(name);
                            $(
                              "#nav-cancel-order #" +
                                value.order_id +
                                " #" +
                                value.id +
                                " .product-content"
                            ).append(
                              "<small>Số lượng:" + value.quantity + "</small>"
                            );
                          },
                        });
                      }
                    });
                  },
                });
              });
            }
          }
        },
      });
    }
  });
}

$(document).ready(function () {
  render();
  $(document).on("click", ".cancel-order", function () {
    if (confirm("Bạn vẫn muốn tiếp tục hủy đơn hàng!") == true) {
      $.ajax({
        type: "post",
        url: "index.php?act=cancelOrder",
        data: { orderId: $(this).data("id") },
        success: function (response) {
          arr = response.split("##-##");
          if (arr[1] == "success") {
            render();
          }
        },
      });
    }
  });

  $(document).on("click", ".received-order", function () {
    $.ajax({
      type: "post",
      url: "index.php?act=receivedOrder",
      data: { orderId: $(this).data("id") },
      success: function (response) {
        arr = response.split("##-##");
        if (arr[1] == "success") {
          render();
        }
      },
    });
  });
  $(document).on("click", ".replace-order", function () {
    if (confirm("Bạn vẫn tiếp tục mua hàng") == true) {
      $.ajax({
        type: "post",
        url: "index.php?act=replacedOrder",
        data: { orderId: $(this).data("id") },
        success: function (response) {
          arr = response.split("##-##");
          if (arr[1] == "success") {
            render();
            alert("Đặt hàng thành công!");
          }
        },
      });
    }
  });
});
