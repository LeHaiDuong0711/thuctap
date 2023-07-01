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
  type_id = urlParam.get("type_id");

  if (keyword == null) {
    keyword = "";
  }
  if (type_id == null) {
    type_id = 0;
  }

  $.ajax({
    type: "get",
    url: "admin.php?act=listProducts",
    data: {
      keyword: keyword,
      type_id: type_id,
    },
    success: function (response) {
      currentPage = urlParam.get("page");
      if (currentPage == null) {
        currentPage = 1; // trang hiện tại
      }
      arr = response.split("##-##");
      products = JSON.parse(arr[1]);

      productsPerPage = 10; // số lượng sản phẩm trên mỗi trang
      totalProducts = products.length; // tổng số sản phẩm
      totalPages = Math.ceil(totalProducts / productsPerPage); // tổng số trang
      startIndex = (currentPage - 1) * productsPerPage;
      endIndex = startIndex + productsPerPage;
      if (endIndex > totalProducts) {
        endIndex = totalProducts;
      }

      currentProducts = products.slice(startIndex, endIndex);

      if (products.length > 0) {
        htmls = [];
        currentProducts.forEach((item) => {
          html =
            `<tr id="` +
            item.id +
            `">
              <td class="idProduct" style="width:150px">` +
            item.id +
            `<div class="containerBtnShow"><div></td>
             
              <td class="nameProduct">` +
            item.name +
            `</td>
              <td class="imageProduct"><img src="./../Assets/img/` +
            item.pro_image +
            `" alt="" class="w-10"></td>
              <td class="priceProduct">` +
            formatCurrency(item.price) +
            `</td>
              <td class="promotionProduct">` +
            formatCurrency(item.promotion) +
            `</td>
              <td class="quantityProduct">` +
            item.quantity +
            `</td>
              <td class="containerBtn"><div class="d-flex"><a class="btn-edit edit" href="admin.php?act=editProduct&id=` +
            item.id +
            `"><i class="far fa-edit"></i></a>
             <button type="button" class="btn-remove remove" data-id="` +
            item.id +
            `"><i class="fas fa-trash-alt"></i></button>
              
             </div> </td>

          </tr>`;

          htmls.push(html);
        });
        $("#listProducts").html(htmls);
        products.forEach((item) => {
          $.ajax({
            type: "get",
            url: "admin.php?act=listProductProperty",
            data: { id: item.id },
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              if (result.length > 0) {
                result.forEach((value, index, array) => {
                  if (item.id == value.prod_id) {
                    $("tr#" + item.id + " .containerBtnShow").html(
                      '<button type="button" class="add-btn showProdProp" data-id="' +
                        item.id +
                        '"><i class="fas fa-plus-circle"></i></button>'
                    );
                  }
                });
              }
            },
          });
        });
        $(document).on(
          "click",
          ".containerBtnShow button.showProdProp",
          function () {
            id = $(this).data("id");
            $(this).html('<i class="fas fa-minus-circle"></i>');
            $(this).removeClass("showProdProp");
            $(this).addClass("hideProdProp");
            index = $("#listProducts tr").index($("tr#" + id));

            $.ajax({
              type: "get",
              url: "admin.php?act=listProductProperty",
              data: { id: id },
              success: function (response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);
                htmls = [];
                if (result.length > 0) {
                  result.forEach((value, index, array) => {
                    keys = Object.keys(value);
                
                    halfKey = keys.slice(keys.length / 2);
            
                    halfKey = halfKey.slice(4);
                    halfKey = halfKey.slice(0, -5);
                    version = "";
                  
                    halfKey.forEach((item)=>{
                     if(value[item]!=null&&value[item]!=""){
                      version+=(value[item]+" / ");
                     }
                    })
                    version = version.slice(0,-2);
                            html =
                              `<tr id="prodProp` +
                              value.id +
                              `">

                              <td>#` +
                              value.SKU +
                              `</td>
                              <td>`+version+`</td>
                              <td>
                                <img src="./../Assets/img/` +
                              value.image +
                              `" alt="" class="w-10">
                              </td>
                              <td>` +
                              formatCurrency(value.price) +
                              `</td>
                              <td>` +
                              formatCurrency(value.promotion) +
                              `</td>
                              <td>` +
                              value.quantity +
                              `</td>
                              <td class="containerBtn"><div class="d-flex"><a class="btn-edit edit" href="admin.php?act=editProductProperty&id=` +
                              value.SKU +
                              `"><i class="far fa-edit"></i></a>

                     </div> </td>

                            <tr>`;
                            htmls.push(html);
                  });
                  $("#listProducts tr").eq(index).after(htmls);
                }
              },
            });
          }
        );
        $(document).on(
          "click",
          ".containerBtnShow button.hideProdProp",
          function () {
            id = $(this).data("id");
            $(this).html('<i class="fas fa-plus-circle"></i>');
            $(this).removeClass("hideProdProp");
            $(this).addClass("showProdProp");

            $.ajax({
              type: "get",
              url: "admin.php?act=listProductProperty",
              data: { id: id },
              success: function (response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);

                if (result.length > 0) {
                  result.forEach((value, index, array) => {
                    index = $("#listProducts tr").index(
                      $("#listProducts tr#prodProp" + value.id)
                    );
                    $("#listProducts tr").eq(index).remove();
                  });
                }
              },
            });
          }
        );

        $.ajax({
          type: "get",
          url: "admin.php?act=type",
          success: function (response) {
            arr = response.split("##-##");
            types = JSON.parse(arr[1]);
            types.forEach((type) => {
              $(".type_id").append(
                ` <option value="` +
                  type.type_id +
                  `">` +
                  type.type_name +
                  `</option>`
              );
            });
          },
        });

        if (currentPage > 1) {
          if ((type_id != 0) & (keyword != "")) {
            $(
              '<a class="page-item page-link prev" href="admin.php?act=products&type_id=' +
                type_id +
                "&keyword=" +
                "&page=" +
                (currentPage - 1) +
                '">Trước đó</a>'
            ).appendTo("#pagination");
          } else if (type_id != 0 && keyword == "") {
            $(
              '<a class="page-item page-link prev" href="admin.php?act=products&type_id=' +
                type_id +
                "&page=" +
                (currentPage - 1) +
                '">Trước đó</a>'
            ).appendTo("#pagination");
          } else if (type_id == 0 && keyword != "") {
            $(
              '<a class="page-item page-link prev" href="admin.php?act=products&keyword=' +
                keyword +
                "&page=" +
                (currentPage - 1) +
                '">Trước đó</a>'
            ).appendTo("#pagination");
          } else {
            $(
              '<a class="page-item page-link prev" href="admin.php?act=products&page=' +
                (currentPage - 1) +
                '">Trước đó</a>'
            ).appendTo("#pagination");
          }
        }

        for (let i = 1; i <= totalPages; i++) {
          if ((type_id != 0) & (keyword != "")) {
            $("#pagination").append(
              '<li class="page-item page"><a class="page-link" href="admin.php?act=products&type_id=' +
                type_id +
                "&keyword=" +
                keyword +
                "&page=" +
                i +
                '">' +
                i +
                "</a></li>"
            );
          } else if (type_id != 0 && keyword == "") {
            $("#pagination").append(
              '<li class="page-item page"><a class="page-link" href="admin.php?act=products&type_id=' +
                type_id +
                "&page=" +
                i +
                '">' +
                i +
                "</a></li>"
            );
          } else if (type_id == 0 && keyword != "") {
            $("#pagination").append(
              '<li class="page-item page"><a class="page-link" href="admin.php?act=products&keyword=' +
                keyword +
                "&page=" +
                i +
                '">' +
                i +
                "</a></li>"
            );
          } else {
            $("#pagination").append(
              '<li class="page-item page"><a class="page-link" href="admin.php?act=products' +
                "&page=" +
                i +
                '">' +
                i +
                "</a></li>"
            );
          }

          $("#pagination li a").each(function (index) {
            if (index + 1 == currentPage) {
              $(this).attr("style", "background-color:orange");
            }
          });
        }
        if (currentPage < totalPages) {
          page = parseInt(currentPage) + 1;

          if ((type_id != 0) & (keyword != "")) {
            $(
              '<a class="page-item page-link next" href="admin.php?act=products&type_id=' +
                type_id +
                "&keyword=" +
                keyword +
                "&page=" +
                page +
                '">Tiếp theo</a>'
            ).appendTo("#pagination");
          } else if (type_id != 0 && keyword == "") {
            $(
              '<a class="page-item page-link next" href="admin.php?act=products&type_id=' +
                type_id +
                "&page=" +
                page +
                '">Tiếp theo</a>'
            ).appendTo("#pagination");
          } else if (type_id == 0 && keyword != "") {
            $(
              '<a class="page-item page-link next" href="admin.php?act=products&keyword=' +
                keyword +
                "&page=" +
                page +
                '">Tiếp theo</a>'
            ).appendTo("#pagination");
          } else {
            $(
              '<a class="page-item page-link next" href="admin.php?act=products&page=' +
                page +
                '">Tiếp theo</a>'
            ).appendTo("#pagination");
          }
        }

        // chèn các thẻ HTML để hiển thị phân trang

        currentProducts.forEach((item) => {
          if (item.status == 0) {
            i =
              '<button class="btn-hide hide" data-id="' +
              item.id +
              '"><i class="fas fa-eye"></i></button>';
            $("#listProducts #" + item.id).addClass("opacity-100");
          } else {
            i =
              '<button class="btn-hide hide" data-id="' +
              item.id +
              '"><i class="fas fa-eye-slash"></i></button>';
            $("#listProducts #" + item.id).addClass("opacity-25");
          }
          $("#listProducts #" + item.id + " .containerBtn .d-flex").append(i);

          $("#listProducts #" + item.id + " .hide").click(function () {
          
            dataId = $(this).data("id");
            $.ajax({
              type: "post",
              url: "admin.php?act=statusProducts",
              data: {
                id: dataId,
              },

              success: function (response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);
           

                if (result == 1) {
                  $("#listProducts #" + item.id + " .hide").html(
                    '<i class="fas fa-eye-slash"></i>'
                  );
                  $("#listProducts #" + item.id).attr("class", "opacity-25");
                } else {
                  $("#listProducts #" + item.id + " .hide").html(
                    '<i class="fas fa-eye"></i>'
                  );
                  $("#listProducts #" + item.id).attr("class", "opacity-100");
                }
              },
            });
          });

          $("#listProducts #" + item.id + " .remove").click(function () {
            dataId = $(this).data("id");
            $.ajax({
              type: "post",
              url: "admin.php?act=remove-product",
              data: {
                id: dataId,
              },

              success: function (response) {
                arr = response.split("##-##");
                result = arr[1];

                if (result == "success") {
                  alert("Đã xóa sản phẩm");
                  window.location.reload();
                } else {
                  alert("Xóa sản phẩm thất bại");
                  window.location.reload();
                }
              },
            });
          });
        });
      }
    },

    //
  });

  $(document).on("change", ".type_id", function () {
    type_id = $(this).val();
    keyword = $(".keyword").val();
    $.ajax({
      type: "get",
      url: "admin.php?act=listProducts",
      data: {
        keyword: keyword,
        type_id: type_id,
      },
      success: function (response) {
        currentPage = urlParam.get("page");
        if (currentPage == null) {
          currentPage = 1; // trang hiện tại
        }
        arr = response.split("##-##");
        products = JSON.parse(arr[1]);

        productsPerPage = 10; // số lượng sản phẩm trên mỗi trang
        totalProducts = products.length; // tổng số sản phẩm
        totalPages = Math.ceil(totalProducts / productsPerPage); // tổng số trang
        startIndex = (currentPage - 1) * productsPerPage;
        endIndex = startIndex + productsPerPage;
        if (endIndex > totalProducts) {
          endIndex = totalProducts;
        }

        currentProducts = products.slice(startIndex, endIndex);

        if (products.length > 0) {
          htmls = [];
          currentProducts.forEach((item) => {
            html =
              `<tr id="` +
              item.id +
              `">
                <td class="idProduct">` +
              item.id +
              `</td>
                <td class="nameProduct">` +
              item.name +
              `</td>
                <td class="imageProduct"><img src="./../Assets/img/` +
              item.pro_image +
              `" alt="" class="w-10"></td>
                <td class="priceProduct">` +
              formatCurrency(item.price) +
              `</td>
                <td class="promotionProduct">` +
              formatCurrency(item.promotion) +
              `</td>
                <td class="quantityProduct">` +
              item.quantity +
              `</td>
                <td class="containerBtn"><div class="d-flex"><a class="btn-edit edit" href="admin.php?act=editProduct&id=` +
              item.id +
              `"><i class="far fa-edit"></i></a>
               <button type="button" class="btn-remove remove" data-id="` +
              item.id +
              `"><i class="fas fa-trash-alt"></i></button>
                
               </div> </td>
  
            </tr>`;

            htmls.push(html);
          });
          $("#listProducts").html(htmls);

          $("#pagination").html("");

          if (currentPage > 1) {
            if ((type_id != 0) & (keyword != "")) {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&keyword=" +
                  "&page=" +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#pagination");
            } else if (type_id != 0 && keyword == "") {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&page=" +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#pagination");
            } else if (type_id == 0 && keyword != "") {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=products&keyword=' +
                  keyword +
                  "&page=" +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#pagination");
            } else {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=products&page=' +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#pagination");
            }
          }

          for (let i = 1; i <= totalPages; i++) {
            if ((type_id != 0) & (keyword != "")) {
              $("#pagination").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&keyword=" +
                  keyword +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            } else if (type_id != 0 && keyword == "") {
              $("#pagination").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            } else if (type_id == 0 && keyword != "") {
              $("#pagination").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=products&keyword=' +
                  keyword +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            } else {
              $("#pagination").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=products' +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            }

            $("#pagination li a").each(function (index) {
              if (index + 1 == currentPage) {
                $(this).attr("style", "background-color:orange");
              }
            });
          }
          if (currentPage < totalPages) {
            page = parseInt(currentPage) + 1;

            if ((type_id != 0) & (keyword != "")) {
              $(
                '<a class="page-item page-link next" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&keyword=" +
                  keyword +
                  "&page=" +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#pagination");
            } else if (type_id != 0 && keyword == "") {
              $(
                '<a class="page-item page-link next" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&page=" +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#pagination");
            } else if (type_id == 0 && keyword != "") {
              $(
                '<a class="page-item page-link next" href="admin.php?act=products&keyword=' +
                  keyword +
                  "&page=" +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#pagination");
            } else {
              $(
                '<a class="page-item page-link next" href="admin.php?act=products&page=' +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#pagination");
            }
          }

          // chèn các thẻ HTML để hiển thị phân tran
        }
      },

      //
    });
  });

  $(document).on("input", ".keyword", function () {
    type_id = $("select option:selected").val();
    keyword = $(".keyword").val();

    $.ajax({
      type: "get",
      url: "admin.php?act=listProducts",
      data: {
        keyword: keyword,
        type_id: type_id,
      },
      success: function (response) {
        currentPage = urlParam.get("page");
        if (currentPage == null) {
          currentPage = 1; // trang hiện tại
        }
        arr = response.split("##-##");
        products = JSON.parse(arr[1]);

        productsPerPage = 10; // số lượng sản phẩm trên mỗi trang
        totalProducts = products.length; // tổng số sản phẩm
        totalPages = Math.ceil(totalProducts / productsPerPage); // tổng số trang
        startIndex = (currentPage - 1) * productsPerPage;
        endIndex = startIndex + productsPerPage;
        if (endIndex > totalProducts) {
          endIndex = totalProducts;
        }

        currentProducts = products.slice(startIndex, endIndex);

        if (products.length > 0) {
          htmls = [];
          currentProducts.forEach((item) => {
            html =
              `<tr id="` +
              item.id +
              `">
                <td class="idProduct">` +
              item.id +
              `</td>
          
                <td class="nameProduct">` +
              item.name +
              `</td>
                <td class="imageProduct"><img src="./../Assets/img/` +
              item.pro_image +
              `" alt="" class="w-10"></td>
                <td class="priceProduct">` +
              formatCurrency(item.price) +
              `</td>
                <td class="promotionProduct">` +
              formatCurrency(item.promotion) +
              `</td>
                <td class="quantityProduct">` +
              item.quantity +
              `</td>
                <td class="containerBtn"><div class="d-flex"><a class="btn-edit edit" href="admin.php?act=editProduct&id=` +
              item.id +
              `"><i class="far fa-edit"></i></a>
               <button type="button" class="btn-remove remove" data-id="` +
              item.id +
              `"><i class="fas fa-trash-alt"></i></button>
                
               </div> </td>
  
            </tr>`;

            htmls.push(html);
          });
          $("#listProducts").html(htmls);

          $("#pagination").html("");

          if (currentPage > 1) {
            if ((type_id != 0) & (keyword != "")) {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&keyword=" +
                  "&page=" +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#pagination");
            } else if (type_id != 0 && keyword == "") {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&page=" +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#pagination");
            } else if (type_id == 0 && keyword != "") {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=products&keyword=' +
                  keyword +
                  "&page=" +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#pagination");
            } else {
              $(
                '<a class="page-item page-link prev" href="admin.php?act=products&page=' +
                  (currentPage - 1) +
                  '">Trước đó</a>'
              ).appendTo("#pagination");
            }
          }

          for (let i = 1; i <= totalPages; i++) {
            if ((type_id != 0) & (keyword != "")) {
              $("#pagination").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&keyword=" +
                  keyword +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            } else if (type_id != 0 && keyword == "") {
              $("#pagination").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            } else if (type_id == 0 && keyword != "") {
              $("#pagination").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=products&keyword=' +
                  keyword +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            } else {
              $("#pagination").append(
                '<li class="page-item page"><a class="page-link" href="admin.php?act=products' +
                  "&page=" +
                  i +
                  '">' +
                  i +
                  "</a></li>"
              );
            }

            $("#pagination li a").each(function (index) {
              if (index + 1 == currentPage) {
                $(this).attr("style", "background-color:orange");
              }
            });
          }
          if (currentPage < totalPages) {
            page = parseInt(currentPage) + 1;

            if ((type_id != 0) & (keyword != "")) {
              $(
                '<a class="page-item page-link next" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&keyword=" +
                  keyword +
                  "&page=" +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#pagination");
            } else if (type_id != 0 && keyword == "") {
              $(
                '<a class="page-item page-link next" href="admin.php?act=products&type_id=' +
                  type_id +
                  "&page=" +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#pagination");
            } else if (type_id == 0 && keyword != "") {
              $(
                '<a class="page-item page-link next" href="admin.php?act=products&keyword=' +
                  keyword +
                  "&page=" +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#pagination");
            } else {
              $(
                '<a class="page-item page-link next" href="admin.php?act=products&page=' +
                  page +
                  '">Tiếp theo</a>'
              ).appendTo("#pagination");
            }
          }

          // chèn các thẻ HTML để hiển thị phân tran
        }
      },

      //
    });
  });

  $("#addProductForm").submit(function (e) {
    e.preventDefault();
    formData = new FormData(this);

    $.ajax({
      type: "post",
      url: "admin.php?act=add-action",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        arr = response.split("##-##");
        result = arr[1];

        if (result == "success") {
          alert("Thêm Sản Phẩm Thành Công");
          $("#addProductForm")[0].reset();
        } else if (result == "insert error") {
          alert("Thêm Sản Phẩm Thất Bại");
        } else if (result == "image name already exists") {
          alert("tên hình ảnh đã tồn tại");
        } else if (result == "images exceed 500kb") {
          alert("ảnh vượt quá 500kb");
        } else if (result == "file is not an image format") {
          alert("file không đúng định dạng hình ảnh (jpg, jpeg, png, gif)");
        } else if (result == "file image does not exis") {
          alert("file ảnh không tồn tại");
        } else {
        }
      },
    });
  });

  $("#editForm").submit(function (e) {
    e.preventDefault();
    formData = new FormData(this);

    $.ajax({
      type: "post",
      url: "admin.php?act=edit-action",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        arr = response.split("##-##");
        result = arr[1];

        if (result == "success") {
          alert("Cập Nhật Sản Phẩm Thành Công");
          window.location.reload();
        } else if (result == "update error") {
          alert("Cập Nhật Sản Phẩm Thất Bại");
        } else if (result == "image name already exists") {
          alert("tên hình ảnh đã tồn tại");
        } else if (result == "images exceed 500kb") {
          alert("ảnh vượt quá 500kb");
        } else if (result == "file is not an image format") {
          alert("file không đúng định dạng hình ảnh (jpg, jpeg, png, gif)");
        } else if (result == "file image does not exis") {
          alert("file ảnh không tồn tại");
        } else {
        }
      },
    });
  });
});
