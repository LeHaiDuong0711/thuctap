function formatCurrency(price) {
  price = parseFloat(price);
  price = new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(price);

  return price;
}

function appendListProduct(products, type_id, keyword, page) {
  currentPage = page;
  if (currentPage == null) {
    currentPage = 1; // trang hiện tại
  }
  productsPerPage = 9; // số lượng sản phẩm trên mỗi trang
  totalProducts = products.length; // tổng số sản phẩm
  totalPages = Math.ceil(totalProducts / productsPerPage); // tổng số trang
  startIndex = (currentPage - 1) * productsPerPage;
  endIndex = startIndex + productsPerPage;
  if (endIndex > totalProducts) {
    endIndex = totalProducts;
  }

  currentProducts = products.slice(startIndex, endIndex);

  htmls = [];
  currentProducts.forEach((item) => {
    html =
      `<div class="col-md-4 col-xs-6">
      <a href="index.php?act=productDetail&id=` +
      item.id +
      `">
      <div class="product mb-5" id="P` +
      item.id +
      `">
        <div class="product-img">
          <img src="./Assets/img/` +
      item.pro_image +
      `" alt="">
          <div class="product-label">

          </div>
        </div>
        <div class="product-body">
          
            <p class="product-category"></p>

            <h3 class="product-name">` +
      item.name +
      `</h3>
            <div class="product-price"> </div>

            <div class="product-rating">

            </div>
            </a>
          <div class="product-btns">
          
              <button type="button" class="btn-wishlist add-to-wishlist" data-id="` +
      item.id +
      `"><i class="fa fa-heart"></i><span class="tooltipp">Yêu thích</span></button>
            

          </div>
        </div>
      </div>
      
  </div>`;

    htmls.push(html);
  });
  if (htmls.length > 0) {
    $("#containerProducts").html(htmls);
  } else {
    $("#containerProducts").html(
      "<h3 class='text-bg-warning text-light'>Không có sản phẩm nào</h3>"
    );
  }

  currentProducts.forEach((item) => {
    if (item.quantity <= 0) {
      $("#P" + item.id + " .product-label").html(
        '<span class="out-of-stock">Hết Hàng</span>'
      );
    } else {
      $.ajax({
        type: "get",
        url: "index.php?act=getProductProperty",
        data: { id: item.id },
        success: function (response) {
          arr = response.split("##-##");
          result = JSON.parse(arr[1]);
          if (result.length > 0) {
            $("#P" + item.id).append(
              `<div class="add-to-cart">
      
              <a href="index.php?act=productDetail&id=`+item.id+`"> <button class="add-to-cart-btn"><i class="far fa-eye" aria-hidden="true"></i>Xem chi tiết</button></a>
              </div>`
            );
          } else {
            $("#P" + item.id).append(
              `<div class="add-to-cart">
      
                   <button type="button" name="add_cart" id="` +
                item.id +
                `" class="add-to-cart-btn add-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Thêm vào giỏ hàng</button>
                                                </div>`
            );
          }
        },
      });
    }
    if (item.promotion > 0) {
      $("#P" + item.id + " .product-price").html(
        '<h4><span class="price formatPromotion">' +
          item.promotion +
          '</span> <del class="text-dark price formatPrice ">' +
          item.price +
          " </del></h4>"
      );
    } else {
      $("#P" + item.id + " .product-price").html(
        '<h4 class="price formatPrice">' + item.price + "</h4>"
      );
    }

    price = formatCurrency($("#P" + item.id + " .formatPrice").html());
    $("#P" + item.id + " .formatPrice").html(price);

    promotion = formatCurrency($("#P" + item.id + " .formatPromotion").html());

    $("#P" + item.id + " .formatPromotion").html(promotion);
    setTimeout(() => {
       $.ajax({
      type: "get",
      data:{id:item.id},
      url: "index.php?act=getWishlist",
      success: function (response) {
        arr = response.split("##-##");
        if (arr[1] !='error') {
         
          result = JSON.parse(arr[1]);
          $('#P'+result.pro_id+' .btn-wishlist i').css('color', 'red');
          $('#P'+result.pro_id+' .btn-wishlist').removeClass('add-to-wishlist');
          $('#P'+result.pro_id+' .btn-wishlist').addClass('remove-to-wishlist');
        }
      },
    });
    }, 100);
   
  });
  
  if (totalProducts > 0) {
    pagination = [];
    if (currentPage > 1) {
      pagination.unshift(
        '<button class="page-item page-link prev" data-typeId="' +
          type_id +
          '" data-keyword="' +
          keyword +
          '" data-page="' +
          (currentPage - 1) +
          '">Trước đó</button>'
      );
    }
    for (let i = 1; i <= totalPages; i++) {
      pagination.push(
        '<li class="page-item"><button class="page-link page" data-typeId="' +
          type_id +
          '" data-keyword="' +
          keyword +
          '" data-page="' +
          i +
          '">' +
          i +
          "</button></li>"
      );

      $("#paginationProducts").html(pagination);

      $("#paginationProducts li button").each(function (index) {
        if (index + 1 == currentPage) {
          $(this).attr("style", "background-color:orange");
        }
      });
    }

    if (currentPage < totalPages) {
      page = parseInt(currentPage) + 1;

      $(
        '<button class="page-item page-link next" data-typeId="' +
          type_id +
          '" data-keyword="' +
          keyword +
          '" data-page="' +
          page +
          '">Tiếp theo</button>'
      ).appendTo("#paginationProducts");
    }
  } else {
    $("#paginationProducts").html("");
  }
  $(document).on("click", ".add-to-wishlist", function (e) {
    id = $(this).data("id");
    $.ajax({
      type: "post",
      url: "index.php?act=add_wishlist",
      data: { id: id },
      success: function (response) {
        arr = response.split("##-##");
        check = arr[1];
    
        if (check == "success") {
          $('#P'+id+' .btn-wishlist i').css('color', 'red');
          $('#P'+id+' .btn-wishlist').removeClass('add-to-wishlist');
          $('#P'+id+' .btn-wishlist').addClass('remove-to-wishlist');
        } else{
          alert("bạn cần phải đăng nhập");
          window.location.href="index.php?act=login"
        }
      },
    });
  });

  $(document).on("click", ".remove-to-wishlist", function (e) {
    id = $(this).data("id");
    $.ajax({
      type: "post",
      url: "index.php?act=remove_wishlist",
      data: { id: id },
      success: function (response) {
        arr = response.split("##-##");
        check = arr[1];
        if (check == "success") {
          $('#P'+id+' .btn-wishlist i').css('color', '#80bb35');
          $('#P'+id+' .btn-wishlist').removeClass('remove-to-wishlist');
          $('#P'+id+' .btn-wishlist').addClass('add-to-wishlist');
        }
      },
    });
  });
  $(document).on("click", ".add-cart", function (e) {
    e.preventDefault();
    id = $(this).attr("id");
    $.ajax({
      type: "post",
      url: "index.php?act=add_cart",
      data: { id: id },
      success: function (response) {
        arr = response.split("##-##");
        check = arr[1];
        if (check == "success") {
          alert("Thêm vào giỏ hàng thành công");
          $.ajax({
            type: "get",
            url: "index.php?act=countCart",
            success: function (response) {
              arr = response.split("##-##");

              $(".countCart").html(arr[1]);
            },
          });
        } else {
          alert("Lỗi bất định");
        }
      },
    });
  });

  $.ajax({
    type: "post",
    url: "index.php?act=rating",
    data: { products: currentProducts },

    success: function (response) {
      arr = response.split("##-##");
      arrRating = JSON.parse(arr[1]);

      $.each(arrRating, function (index, rating) {
        if (rating.sumStar == null) {
          rating.sumStar = 0.0;
        }

        average = rating.sumStar / rating.countCmt;

        if (average == 0) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star0.png" alt="" class="w-100">'
          );
        } else if (average > 0 && average < 1) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star0_5.png" alt="" class="w-100">'
          );
        } else if (average >= 1 && average < 1.5) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star1.png" alt="" class="w-100">'
          );
        } else if (average >= 1.5 && average < 2) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star1_5.png" alt="" class="w-100">'
          );
        } else if (average >= 2 && average < 2.5) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star1.png" alt="" class="w-100">'
          );
        } else if (average >= 2.5 && average < 3) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star2_5.png" alt="" class="w-100">'
          );
        } else if (average >= 3 && average < 3.5) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star3.png" alt="" class="w-100">'
          );
        } else if (average >= 3.5 && average < 4) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star3_5.png" alt="" class="w-100">'
          );
        } else if (average >= 4 && average < 4.5) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star4.png" alt="" class="w-100">'
          );
        } else if (average >= 4.5 && average < 5) {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star4_5.png" alt="" class="w-100">'
          );
        } else {
          $("#P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star5.png" alt="" class="w-100">'
          );
        }
      });
    },
  });
}
$(document).ready(function () {
  urlParam = new URLSearchParams(window.location.href);
  type_id = urlParam.get("type_id");
  keyword = urlParam.get("keyword");

  if (type_id == null) {
    type_id = 0;
  }
  if (keyword == null) {
    keyword = "";
  }

  arrValue = [];
  $.ajax({
    type: "get",
    url: "index.php?act=products_act",
    data: {
      type_id: type_id,
      keyword: keyword,
    },
    success: function (response) {
      arr = response.split("##-##");
      result = JSON.parse(arr[1]);
      products = result;
      appendListProduct(products, type_id, keyword);
      // chèn các thẻ HTML để hiển thị phân trang
    },
  });

  $.ajax({
    type: "get",
    url: "index.php?act=typeProduct",
    success: function (response) {
      arr = response.split("##-##");

      result = JSON.parse(arr[1]);
      htmls = [
        // '<label><input id="0" type="checkbox" class="type" value="0">Tất cả</label>',
      ];
      result.forEach((value) => {
        htmls.push(
          `<label class="container">` +
            value.type_name +
            `
            <input id=` +
            value.type_id +
            ` name="typeProduct" type="checkbox" class="type" value="` +
            value.type_id +
            `"><span class="checkmark"></span></label>`
        );
      });
      $("#type").html(htmls);

      if (type_id == 0) {
        // $('input[id="0"]').prop("checked", true);
        $('input[name="typeProduct"]').prop("checked", true);
      } else {
        arr = type_id.split(",");
        arr.forEach((item) => {
          $('input[id="' + item + '"][name="typeProduct"]').prop(
            "checked",
            true
          );
        });
      }
      check = 0;
      $('input[name="typeProduct"]').each(function () {
        if (this.checked == true) {
          check++;
          arrValue.push($(this).val());
        }
      });
      if (check == $('input[name="typeProduct"]').length) {
        // $('input[id="0"]').prop("checked", true);
      }
    },
  });

  $(document).on("click", ".page", function () {
    type_id = $(this).data("typeid") != null ? $(this).data("typeid") : 0;
    keyword = $(this).data("keyword") != null ? $(this).data("keyword") : "";
    page = $(this).data("page") != null ? $(this).data("page") : 0;
    $.ajax({
      type: "get",
      url: "index.php?act=products_act",
      data: {
        type_id: type_id,
        keyword: keyword,
      },
      success: function (response) {
        arr = response.split("##-##");
        result = JSON.parse(arr[1]);
        products = result;
        appendListProduct(products, type_id, keyword, page);
        // chèn các thẻ HTML để hiển thị phân trang
      },
    });
  });
  $(document).on("click", ".next", function () {
    type_id = $(this).data("typeid") != null ? $(this).data("typeid") : 0;
    keyword = $(this).data("keyword") != null ? $(this).data("keyword") : "";
    page = $(this).data("page") != null ? $(this).data("page") : 0;
    $.ajax({
      type: "get",
      url: "index.php?act=products_act",
      data: {
        type_id: type_id,
        keyword: keyword,
      },
      success: function (response) {
        arr = response.split("##-##");
        result = JSON.parse(arr[1]);
        products = result;
        appendListProduct(products, type_id, keyword, page);
        // chèn các thẻ HTML để hiển thị phân trang
      },
    });
  });
  $(document).on("click", ".prev", function () {
    type_id = $(this).data("typeid") != null ? $(this).data("typeid") : 0;
    keyword = $(this).data("keyword") != null ? $(this).data("keyword") : "";
    page = $(this).data("page") != null ? $(this).data("page") : 0;
    $.ajax({
      type: "get",
      url: "index.php?act=products_act",
      data: {
        type_id: type_id,
        keyword: keyword,
      },
      success: function (response) {
        arr = response.split("##-##");
        result = JSON.parse(arr[1]);
        products = result;
        appendListProduct(products, type_id, keyword, page);
        // chèn các thẻ HTML để hiển thị phân trang
      },
    });
  });
  $(document).on("change", 'input[name="typeProduct"]', function () {
    check = 0;
    for (i = 0; i < $('input[name="typeProduct"]').length; i++) {
      if ($('input[name="typeProduct"]')[i].checked == true) {
        check++;
      }
    }

    // if (check == $('input[name="typeProduct"]').length) {
    //   $('input[id="0"]').prop("checked", true);
    // } else {
    //   $('input[id="0"]').prop("checked", false);
    // }

    if ($(this).prop("checked") == true) {
      if (arrValue.length > 0) {
        if (!arrValue.includes(0)) {
          if (arrValue.includes($(this).val())) {
            return arrValue;
          } else {
            arrValue.push($(this).val());
          }
        } else {
          arrValue = [];
          arrValue.push($(this).val());
        }
      } else {
        arrValue = [];
        arrValue.push($(this).val());
      }
      data = $('input[name="price"]:checked').val();
      $.ajax({
        type: "post",
        url: "index.php?act=filedProduct",
        data: { data: data, typeId: arrValue, keyword: keyword },
        success: function (response) {
          arr = response.split("##-##");
          products = JSON.parse(arr[1]);

          appendListProduct(products, arrValue, keyword);
        },
      });
    } else {
      arrValue = arrValue.filter((item) => {
        return item != $(this).val();
      });

      if (arrValue == "") {
        arrValue = 0;
      }

      data = $('input[name="price"]:checked').val();
      $.ajax({
        type: "post",
        url: "index.php?act=filedProduct",
        data: { data: data, typeId: arrValue, keyword: keyword },
        success: function (response) {
          arr = response.split("##-##");
          products = JSON.parse(arr[1]);

          appendListProduct(products, arrValue, keyword);
        },
      });
    }
  });

  $(document).on("change", 'input[name="price"]', function () {
    data = $(this).val();

    $.ajax({
      type: "post",
      url: "index.php?act=filedProductByPrice",
      data: { data: data, typeId: type_id, keyword: keyword },

      success: function (response) {
        arr = response.split("##-##");
        products = JSON.parse(arr[1]);
        appendListProduct(products, arrValue, keyword);
        // window.location.href = "index.php?act=products&type_id=" + arrValue;
      },
    });
  });
});
