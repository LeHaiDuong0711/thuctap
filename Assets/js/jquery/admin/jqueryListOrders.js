function formatDate(dateFormat) {
  if (dateFormat != null) {
    date = new Date(dateFormat);
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();
    formattedDate = day + "-" + month + "-" + year;

    if (formattedDate == "NaN-NaN-NaN" || formattedDate == "") {
      return "";
    } else {
      return formattedDate;
    }
  }
  return "";
}
function formatCurrency(price) {
  price = parseFloat(price);
  price = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);

  return price;
}
$(document).ready(function () {
  urlParam = new URLSearchParams(window.location.href);
  keyword = urlParam.get("keyword");

  if (keyword == null) {
    keyword = "";
  }
  $.ajax({
    type: "get",
    url: "admin.php?act=listOrders_act",
    data: { keyword: keyword },
    // cache: false,
    // processData: false,
    success: function (response) {
      arr = response.split("##-##");
      result = JSON.parse(arr[1]);
      currentPage = urlParam.get("page");
      if (currentPage == null) {
        currentPage = 1; // trang hiện tại
      }
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
        i = 0;
        currentOrders.forEach((item) => {
         
          html =
            `<tr id="` +
            item.order_id +
            `">
            <td>` +
            ++i +
            `</td>
          <td>` +
            item.order_id +
            `</td>
          <td>` +
            item.user_id +
            `</td>
          <td>` +
            item.fullName +
            `</td>
          <td>` +
            item.phone +
            `</td>
          <td>` +
            formatCurrency(item.total) +
            `</td>
          <td>` +
            item.note +
            `</td>
          <td>` +
            formatDate(item.date_create) +
            `</td>
            <td>` +
            formatDate(item.delivery_date) +
            `</td><td>` +
            formatDate(item.received_date) +
            `</td><td>` +
            formatDate(item.cancellation_date) +
            `</td><td>` +
            formatDate(item.reset_date) +
            `</td>
            <td class="status"></td>
            <td class="operation"></td>
            <td class="containerBtn"></td>
           </tr> `;

          htmls.push(html);
        });

        $("#listOrders").html(htmls);

        if (currentPage > 1) {
          if (keyword != "") {
            $(
              '<a class="page-item page-link prev" href="admin.php?act=listOrders' +
                "&keyword=" +
                "&page=" +
                (currentPage - 1) +
                '">Trước đó</a>'
            ).appendTo("#paginationOrders");
          } else {
            $(
              '<a class="page-item page-link prev" href="admin.php?act=listOrders' +
                "&page=" +
                (currentPage - 1) +
                '">Trước đó</a>'
            ).appendTo("#paginationOrders");
          }
        }

        for (let i = 1; i <= totalPages; i++) {
          if (keyword != "") {
            $("#paginationOrders").append(
              '<li class="page-item page"><a class="page-link" href="admin.php?act=listOrders' +
                "&keyword=" +
                keyword +
                "&page=" +
                i +
                '">' +
                i +
                "</a></li>"
            );
          } else {
            $("#paginationOrders").append(
              '<li class="page-item page"><a class="page-link" href="admin.php?act=listOrders' +
                "&page=" +
                i +
                '">' +
                i +
                "</a></li>"
            );
          }

          $("#paginationOrders li a").each(function (index) {
            if (index + 1 == currentPage) {
              $(this).attr("style", "background-color:orange");
            }
          });
        }
        if (currentPage < totalPages) {
          page = parseInt(currentPage) + 1;

          if (keyword != "") {
            $(
              '<a class="page-item page-link next" href="admin.php?act=listOrders' +
                "&keyword=" +
                keyword +
                "&page=" +
                page +
                '">Tiếp theo</a>'
            ).appendTo("#paginationOrders");
          } else {
            $(
              '<a class="page-item page-link next" href="admin.php?act=listOrders' +
                "&page=" +
                page +
                '">Tiếp theo</a>'
            ).appendTo("#paginationOrders");
          }
        }

        currentOrders.forEach((item) => {
          if (item.status == 0) {
            $("#" + item.order_id + " .status").text("Chờ Duyệt");
            $("#" + item.order_id + " .operation").html(
              `<button class="btn-delivering delivering" type="button" data-id="` +
                item.order_id +
                `" data-value=1><i class="fas fa-shipping-fast"></i></button>
             <button class="btn-received received" type="button"  data-id="` +
                item.order_id +
                `" data-value=2><i class="far fa-check-circle"></i></button>
                <button class="btn-cancel cancel" type="button"  data-id="` +
                item.order_id +
                `" data-value=3><i class="fas fa-window-close"></i></button>`
            );
          } else if (item.status == 1) {
            $("#" + item.order_id + " .status").text("Đang Giao");
            $("#" + item.order_id + " .operation").html(
              `<button class="btn-received received" type="button"  data-id="` +
                item.order_id +
                `" data-value=2><i class="far fa-check-circle"></i></button>
                <button class="btn-cancel cancel" type="button"  data-id="` +
                item.order_id +
                `" data-value=3><i class="fas fa-window-close"></i></button>`
            );
          } else if (item.status == 2) {
            $("#" + item.order_id + " .status").text("Đã Nhận");
            $("#" + item.order_id + " .operation").html(
              `
                <button class="btn-cancel cancel" type="button"  data-id="` +
                item.order_id +
                `" data-value=3><i class="fas fa-window-close"></i></button>`
            );
          } else if (item.status == 3) {
            $("#" + item.order_id + " .status").text("Đã Hủy");
            $("#" + item.order_id + " .operation").html(
              `
                <button class="btn-reset reset" type="button"  data-id="` +
                item.order_id +
                `" data-value=0><i class="fas fa-sync"></i></button>`
            );
          }

          if (item.hide == 0) {
            i =
              '<button class="btn-hide hide" data-id="' +
              item.order_id +
              '"><i class="fas fa-eye"></i></button>';
            $("#" + item.order_id).addClass("opacity-100");
          } else {
            i =
              '<button class="btn-hide hide" data-id="' +
              item.order_id +
              '"><i class="fas fa-eye-slash"></i></button>';
            $("#" + item.order_id).addClass("opacity-25");
          }
          $("#" + item.order_id + " .containerBtn").append(i);
          $("#" + item.order_id + " .containerBtn").append(
            '<a href="admin.php?act=orderDetail&id=' +
              item.order_id +
              '"><button class="btn-detail" ><i class="fas fa-info-circle"></i></button></a>'
          );

          $("#" + item.order_id + " .operation button").on(
            "click",
            function () {
              id = $(this).data("id");
              status = $(this).data("value");
              $.ajax({
                type: "post",
                url: "admin.php?act=updateStatus",
                data: { id: id, status: status },

                success: function (response) {
                  arr = response.split("##-##");
                  result = arr[1];

                  if (result == "success") {
                    window.location.reload();
                  }
                },
              });
            }
          );
          $("#" + item.order_id + " .hide").click(function () {
            dataId = $(this).data("id");
            $.ajax({
              type: "post",
              url: "admin.php?act=updateHide",
              data: {
                id: dataId,
              },

              success: function (response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);

                if (result == 1) {
                  $("#" + item.order_id + " .hide").html(
                    '<i class="fas fa-eye-slash"></i>'
                  );
                  $("#" + item.order_id).attr("class", "opacity-25");
                } else {
                  $("#" + item.order_id + " .hide").html(
                    '<i class="fas fa-eye"></i>'
                  );
                  $("#" + item.order_id).attr("class", "opacity-100");
                }
              },
            });
          });
        });

        //
      }
    },
  });

  $(document).on("input", ".keyword", function () {
    keyword = $(this).val();
    $.ajax({
      type: "get",
      url: "admin.php?act=listOrders_act",
      data: { keyword: keyword },
      // cache: false,
      // processData: false,
      success: function (response) {
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
              `<tr id="` +
              item.order_id +
              `">
            <td>` +
              item.order_id +
              `</td>
            <td>` +
              item.user_id +
              `</td>
            <td>` +
              item.fullName +
              `</td>
            <td>` +
              item.phone +
              `</td>
            <td>` +
              item.total +
              `</td>
            <td>` +
              item.note +
              `</td>
            <td>` +
              item.date_create +
              `</td><td class="status"></td>
              <td class="operation"></td>
              <td class="containerBtn"></td>
             </tr> `;

            htmls.push(html);
          });

          $("#listOrders").html(htmls);
          $("#paginationOrders").html("");

          if (currentPage > 1) {
            if (keyword != "") {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=listOrders' +
                  "&keyword=" +
                  "&page=" +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#paginationOrders");
            } else {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=listOrders' +
                  "&page=" +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#paginationOrders");
            }
          }

          for (let i = 1; i <= totalPages; i++) {
            if (keyword != "") {
              $("#paginationOrders").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=listOrders' +
                  "&keyword=" +
                  keyword +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            } else {
              $("#paginationOrders").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=listOrders' +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            }

            $("#paginationOrders li a").each(function (index) {
              if (index + 1 == currentPage) {
                $(this).attr("style", "background-color:orange");
              }
            });
          }
          if (currentPage < totalPages) {
            page = parseInt(currentPage) + 1;

            if (keyword != "") {
              $(
                '<a class="page-item page-link next" href="admin.php?act=listOrders' +
                  "&keyword=" +
                  keyword +
                  "&page=" +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#paginationOrders");
            } else {
              $(
                '<a class="page-item page-link next" href="admin.php?act=listOrders' +
                  "&page=" +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#paginationOrders");
            }
          }

          currentOrders.forEach((item) => {
            if (item.status == 0) {
              $("#" + item.order_id + " .status").text("Chờ Duyệt");
              $("#" + item.order_id + " .operation").html(
                `<button class="btn-delivering delivering" type="button" data-id="` +
                  item.order_id +
                  `" data-value=1><i class="fas fa-shipping-fast"></i></button>
               <button class="btn-received received" type="button"  data-id="` +
                  item.order_id +
                  `" data-value=2><i class="far fa-check-circle"></i></button>
                  <button class="btn-cancel cancel" type="button"  data-id="` +
                  item.order_id +
                  `" data-value=3><i class="fas fa-window-close"></i></button>`
              );
            } else if (item.status == 1) {
              $("#" + item.order_id + " .status").text("Đang Giao");
              $("#" + item.order_id + " .operation").html(
                `<button class="btn-received received" type="button"  data-id="` +
                  item.order_id +
                  `" data-value=2><i class="far fa-check-circle"></i></button>
                  <button class="btn-cancel cancel" type="button"  data-id="` +
                  item.order_id +
                  `" data-value=3><i class="fas fa-window-close"></i></button>`
              );
            } else if (item.status == 2) {
              $("#" + item.order_id + " .status").text("Đã Nhận");
              $("#" + item.order_id + " .operation").html(
                `
                  <button class="btn-cancel cancel" type="button"  data-id="` +
                  item.order_id +
                  `" data-value=3><i class="fas fa-window-close"></i></button>`
              );
            } else if (item.status == 3) {
              $("#" + item.order_id + " .status").text("Đã Hủy");
              $("#" + item.order_id + " .operation").html(
                `
                  <button class="btn-reset reset" type="button"  data-id="` +
                  item.order_id +
                  `" data-value=0><i class="fas fa-sync"></i></button>`
              );
            }

            if (item.hide == 0) {
              i =
                '<button class="btn-hide hide" data-id="' +
                item.order_id +
                '"><i class="fas fa-eye"></i></button>';
              $("#" + item.order_id).addClass("opacity-100");
            } else {
              i =
                '<button class="btn-hide hide" data-id="' +
                item.order_id +
                '"><i class="fas fa-eye-slash"></i></button>';
              $("#" + item.order_id).addClass("opacity-25");
            }
            $("#" + item.order_id + " .containerBtn").append(i);

            $("#" + item.order_id + " .operation button").on(
              "click",
              function () {
                id = $(this).data("id");
                status = $(this).data("value");
                $.ajax({
                  type: "post",
                  url: "admin.php?act=updateStatus",
                  data: { id: id, status: status },

                  success: function (response) {
                    arr = response.split("##-##");
                    result = arr[1];

                    if (result == "success") {
                      window.location.reload();
                    }
                  },
                });
              }
            );
            $("#" + item.order_id + " .hide").click(function () {
              dataId = $(this).data("id");
              $.ajax({
                type: "post",
                url: "admin.php?act=updateHide",
                data: {
                  id: dataId,
                },

                success: function (response) {
                  arr = response.split("##-##");
                  result = arr[1];

                  if (result == 1) {
                    $("#" + item.order_id + " .hide").html(
                      '<i class="fas fa-eye-slash"></i>'
                    );
                    $("#" + item.order_id).attr("class", "opacity-25");
                  } else {
                    $("#" + item.order_id + " .hide").html(
                      '<i class="fas fa-eye"></i>'
                    );
                    $("#" + item.order_id).attr("class", "opacity-100");
                  }
                },
              });
            });
          });
        } else {
          $("#listOrders").html(
            `<div><h3 class="text-bg-warning text-light">Không có đơn hàng</h3></div>`
          );
        }
      },
    });
  });
});
