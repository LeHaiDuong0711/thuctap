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
function appendProductDetail(id) {
  $.ajax({
    type: "get",
    url: "index.php?act=productDetail_act",
    data: {
      id: id,
    },
    success: function (response) {
      arr = response.split("##-##");

      result = JSON.parse(arr[1]);
      product = result.product;
      supplier = result.supplier;
      comments = result.comments;
      arrRating = result.arrRating;
      productsWillLove = result.productsWillLove;

      $(".product-main-img img").attr(
        "src",
        "./Assets/img/" + product.pro_image
      );
      $(".product-details").html(
        ` 
                <h2 class="product-name">` +
          product.name +
          `</h2>
                <div class="product-price"></div>
                <form  class="cart" method="post">
                    <div class="quantity row">
                    <div class="col-lg-6"> <input class="form-control" type="number" size="4" name="quantity" min="1" value=1></div>
                        <div class="col-lg-6"> <span class="quantity">Trong Kho:` +
          product.quantity +
          ` </span>
          </div>
                   </div>
                   <div id="properties" class="d-flex">

                   </div>
                       
                    
                    <div class="containerBtn mt-5 mb-5">
                    <button type="button" class="btn-wishlist add-to-wishlist" data-id="` +
          product.id +
          `"><i class="fa fa-heart"></i></button>
                       
                    </div>
                </form>
                <div>
                    <p><b>Mô tả sản phẩm: </b>` +
          product.description +
          `</p> <p><b>Ngày nhập: </b>` +
          formatDate(product.date_add) +
          `</p>
          <p><b>Hạn sử dụng: </b>` +
          formatDate(product.expiry) +
          `</p>
                    <p><b>Nhà Cung Cấp: </b>` +
          supplier.name +
          `</p>
                    <p><b>Địa chỉ nhà Cung Cấp: </b>` +
          supplier.address +
          `</p>
                    <p><b>Số điện thoại nhà Cung Cấp: </b>` +
          supplier.phone +
          `</p>
                </div>`
      );
      if (product.promotion == 0) {
        $(".product-details .product-price").append(
          '<h4 class="price">' + formatCurrency(product.price) + "</h4>"
        );
      } else {
        $(".product-details .product-price").append(
          '<h4 class="price"><span class="">' +
            formatCurrency(product.promotion) +
            ' </span><del class="text-dark oldPrice">' +
            formatCurrency(product.price) +
            " </del></h4>"
        );
      }

      if (product.quantity > 0) {
        $(
          '<button type="submit" id="submitProDetail" class="add-to-cart-btn mt-3 mb-5"  data-proId="' +
            product.id +
            '"><i class="fa fa-shopping-cart" aria-hidden="true"></i> thêm vào giỏ</button>'
        ).appendTo(".containerBtn");
      } else {
        $(
          '<button name="submit" disabled class="btn-out-of-stock">Hết Hàng</button>'
        ).appendTo(".containerBtn");
      }

      $.ajax({
        type: "get",
        url: "index.php?act=getProductProperty",
        data: { id: product.id },
        success: function (response) {
          arr = response.split("##-##");

          result = JSON.parse(arr[1]);
          if (result.length > 0) {
            $("#submitProDetail").prop("disabled", true);
            $("#submitProDetail").css("opacity", "25%");
            result.forEach((item) => {
              keys = Object.keys(item);

              halfKey = keys.slice(keys.length / 2);

              halfKey = halfKey.slice(4);
              halfKey = halfKey.slice(0, -5);
              version = "";

              halfKey.forEach((item1) => {
                if (item[item1] != null && item[item1] != "") {
                  version += item[item1] + " / ";
                }
              });
              version = version.slice(0, -2);

              $("#properties").append(
                '<input id="' +
                  version +
                  '" type="radio" name="property" class="btn-properties" value="' +
                  item.id +
                  '"><label for="' +
                  version +
                  '">' +
                  version +
                  "</label>"
              );
            });
          }
        },
      });

      $(document).on(
        "click",
        'input[type="radio"][name="property"]',
        function () {
          idPropProd = $(this).val();
          $.ajax({
            type: "get",
            url: "index.php?act=getPropertyById",
            data: { id: idPropProd },
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              $("#submitProDetail").prop("disabled", false);
              $("#submitProDetail").css("opacity", "100%");
              $(".product-main-img img").attr(
                "src",
                "./Assets/img/" + result.image
              );

              if (result.promotion == 0) {
                $(".product-details .product-price").html("");
                $(".product-details .product-price").append(
                  '<h4 class="price">' + formatCurrency(result.price) + "</h4>"
                );
              } else {
                $(".product-details .product-price").html("");
                $(".product-details .product-price").append(
                  '<h4 class="price"><span class="">' +
                    formatCurrency(result.promotion) +
                    ' </span><del class="text-dark oldPrice">' +
                    formatCurrency(result.price) +
                    " </del></h4>"
                );
              }
              $(".product-details span.quantity").html(
                `Trong Kho:` + result.quantity
              );
            },
          });
        }
      );

      $("#submitProDetail").click(function (e) {
        e.preventDefault();

        $.ajax({
          type: "post",
          url: "index.php?act=add_cart",
          data: {
            id: id,
            property: $('input[type="radio"][name="property"]:checked').val(),
            quantity: $('input[name="quantity"]').val(),
          },

          success: function (response) {
            arr = response.split("##-##");
            console.log(arr[1]);
            if (arr[1] == "success") {
              alert("Thêm vào giỏ hàng thành công");
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

      $.ajax({
        type: "get",
        data: { id: id },
        url: "index.php?act=getWishlist",
        success: function (response) {
          arr = response.split("##-##");
          if (arr[1] != "false") {
            result = JSON.parse(arr[1]);
            $('button[data-id="' + id + '"]').css("color", "red");
            $('button[data-id="' + id + '"]').removeClass("add-to-wishlist");
            $('button[data-id="' + id + '"]').addClass("remove-to-wishlist");
          }
        },
      });

      //append products slick
      $(".products-slick").html("");
      $.each(productsWillLove, function (index, value) {
        $(".products-slick").append(
          `
               <div class="col-lg-4">
						
							<div class="product mb-5" id="P` +
            value.id +
            `">
								<div class="product-img">
									<img src="./Assets/img/` +
            value.pro_image +
            `" alt="">
									<div class="product-label">

									</div>
								</div>
								<div class="product-body">
									<a href="index.php?act=productDetail&id=` +
            value.id +
            `">
										<p class="product-category"></p>

										<h3 class="product-name">` +
            value.name +
            `</h3>
										<div class="product-price"> </div>

										<div class="product-rating">

										</div>
									</a>
                  <div class="product-btns">
          
                  <button type="button" class="btn-wishlist add-to-wishlist" data-id="` +
            value.id +
            `"><i class="fa fa-heart"></i><span class="tooltipp">Yêu thích</span></button>
                
    
              </div>
								</div>
							</div>
						
					</div>
                `
        );

        if (value.promotion == 0) {
          $(".products-slick #P" + value.id + " .product-price").html(
            '<h4 class="price">' + formatCurrency(value.price) + "</h4>"
          );
        } else {
          $(".products-slick .product-price").html(
            '<h4><span class="price">' +
              formatCurrency(value.promotion) +
              '</span> <del class="text-dark price">' +
              formatCurrency(value.price) +
              "</del></h4>"
          );
        }
        price = $(".products-slick #P" + value.id + " .formatPrice").html();
        price = parseFloat(price);
        price = new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
        }).format(price);
        $(".products-slick #P" + value.id + " .formatPrice").html(price);

        promotion = $(
          ".products-slick #P" + value.id + " .formatPromotion"
        ).html();
        promotion = parseFloat(promotion);
        promotion = new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
        }).format(promotion);
        $(".products-slick #P" + value.id + " .formatPromotion").html(
          promotion
        );

        $(".products-slick #P" + value.id + " .product-btns").html(
          `
          <div class="product-btns">
          
          <button type="button" class="btn-wishlist add-to-wishlist" data-id="` +
            value.id +
            `"><i class="fa fa-heart"></i><span class="tooltipp">Yêu thích</span></button>
        

      </div>
               
                `
        );
        if (value.quantity > 0) {
          $(".products-slick #P" + value.id).append(
            `<div class="add-to-cart">

         <button type="button" name="add_cart" id="` +
              value.id +
              `" class="add-to-cart-btn" value=""><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Thêm vào giỏ hàng</button>
                                      </div>`
          );
        } else {
          $(".products-slick #P" + value.id + " .product-label").html(
            '<span class="out-of-stock">Hết Hàng</span>'
          );
        }
        setTimeout(() => {
          $.ajax({
            type: "get",
            data: { id: value.id },
            url: "index.php?act=getWishlist",
            success: function (response) {
              arr = response.split("##-##");
              if (arr[1] != "false") {
                result = JSON.parse(arr[1]);
                $('button[data-id="' + value.id + '"]').css("color", "red");
                $('button[data-id="' + value.id + '"]').removeClass(
                  "add-to-wishlist"
                );
                $('button[data-id="' + value.id + '"]').addClass(
                  "remove-to-wishlist"
                );
              }
            },
          });
        }, 50);
      });

      $("#comments").html("");
      $.ajax({
        url: "index.php?act=getUser",

        success: function (response) {
          arr = response.split("##-##");
          user = JSON.parse(arr[1]);

          $("#comments").append(
            `<div class="mb-5">
                        <div class="comment">
                            <b>Đã có: ` +
              comments.length +
              `đánh giá về sản phẩm này</b>
                            <form id="commentForm" class="mt-5" hidden>
                                <div class="row">
                                    <div class="col-lg-2 avatar"><img src="./Assets/img/` +
              user.image +
              `" alt="" class="w-100"></div>
                                    <div class="col-lg-10">
                                        <div class="stars">
                                            <button type="button" class="star 1" data-value="1">&#9733;</button>
                                            <button type="button" class="star 2" data-value="2">&#9733;</button>
                                            <button type="button" class="star 3" data-value="3">&#9733;</button>
                                            <button type="button" class="star 4" data-value="4">&#9733;</button>
                                            <button type="button" class="star 5" data-value="5">&#9733;</button>
                                        </div>
                                        <textarea name="comment" id="content" cols="80" rows="5" placeholder="Nhập bình luận"></textarea>
                                        <br>
                                        <input type="submit" value="Gửi" class="btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mt-5">
                        <table class="table">
                                         
                                         <tbody id="listComments" class="showComments" >


                                         </tbody>
                                        
                                         </table>
                        
                        </div>
                    </div>`
          );
          if (user == false) {
            {
              $("#commentForm .avatar img").attr(
                "src",
                "./Assets/img/avatar.jpg"
              );
            }
          }
          $.ajax({
            type: "post",
            url: "index.php?act=getProductOrder",
            data: { userId: user.user_id, prodId: id },
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              if (result.length <= 0) {
                $("#commentForm").prop("hidden", true);
              } else {
                $("#commentForm").prop("hidden", false);
              }
            },
          });

          if (comments.length > 0) {
            comments.forEach((comment) => {
              $(".showComments").append(
                `
                                            
                                                     <tr id="` +
                  comment.id +
                  `">
                                                         <td  class="p-3" id="` +
                  comment.id +
                  `">
                                                            <div>
                                                                <img class="" src="./Assets/img/` +
                  comment.image +
                  `" alt="" />  <b>` +
                  comment.username +
                  `</b>
                                                            </div>
                                                            <span>` +
                  comment.date_cmt +
                  `</span>
                                                            <div class="showStar ` +
                  comment.id +
                  `"></div>
                                                            <div>` +
                  comment.content +
                  `</div>
                                                            <div>
                                                                <button class="btn like-btn parent" data-parent="` +
                  comment.id +
                  `"><i class="far fa-thumbs-up"></i></button>
                                                                <button class="btn reply-btn" data-id="` +
                  comment.id +
                  `"><i class="far fa-comments"></i></button>
                                                                <form  class="mt-5 replyCommentForm" hidden>
                                                                    <div class="row">
                                                                        <div class="col-lg-1 avatar-reply"><img src="./Assets/img/` +
                  user.image +
                  `" alt="w-100"></div>
                                                                        <div class="col-lg-11">
                                                                        <input type="hidden" value="` +
                  comment.id +
                  `" name="id">
                                                                            <textarea name="comment" id="content" cols="80" rows="5" placeholder="Nhập bình luận"></textarea>
                                                                            <br>
                                                                            <button type="submit" class="btn">Gửi</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div id="showComments` +
                  comment.id +
                  `" class="mx-5">
                                                            <table class="table listCommentsReply">
                                         
                                                           
                                                           
                                                        </table>
                                                            </div>
                                                        </td>
                                                        

                                                     </tr>
                                                    
                                             
                                             
                                      
                                `
              );
              $.ajax({
                type: "get",
                url: "index.php?act=showCommentsReply",
                data: { id: comment.id },

                success: function (response) {
                  arr = response.split("##-##");
                  result = JSON.parse(arr[1]);

                  result.forEach((commentReply) => {
                    $.ajax({
                      type: "get",
                      url: "index.php?act=getUserById",
                      data: { id: commentReply.userId },

                      success: function (res) {
                        arr1 = res.split("##-##");
                        user1 = JSON.parse(arr1[1]);
                        $(
                          "#listComments tr#" +
                            commentReply.comment_id +
                            " .listCommentsReply"
                        ).append(
                          `<tr id="` +
                            commentReply.id +
                            `">
                                                                                  <td id="` +
                            commentReply.id +
                            `">
                                                                                     <div>
                                                                                         <img class="" src="./Assets/img/` +
                            user1.image +
                            `" alt="" />  <b>` +
                            user1.username +
                            `</b>
                                                                                     </div>
                                                                                     <span>` +
                            commentReply.create_at +
                            `</span>
                                                                                     <div class="showStar ` +
                            commentReply.id +
                            `"></div>
                                                                                     <div>` +
                            commentReply.content +
                            `</div>
                                                                                     <div>
                                                                                         <button class="btn like-btn child" data-parent="` +
                            comment.id +
                            `" data-id="` +
                            commentReply.id +
                            `"><i class="far fa-thumbs-up"></i></button>
                                                                                         <button class="btn reply-btn" data-id="` +
                            commentReply.id +
                            `"><i class="far fa-comments"></i></button>
                                                                                         <form  class="mt-5 replyCommentForm" hidden>
                                                                                             <div class="row">
                                                                                                 <div class="col-lg-1 avatar-reply"><img src="./Assets/img/` +
                            user.image +
                            `" alt="w-100"></div>
                                                                                                 <div class="col-lg-11">
                                                                                                 <input type="hidden" value="` +
                            comment.id +
                            `" name="id">
                                                                                                     <textarea name="comment" id="content" cols="80" rows="5" placeholder="Nhập bình luận"></textarea>
                                                                                                     <br>
                                                                                                     <button type="submit" class="btn">Gửi</button>
                                                                                                 </div>
                                                                                             </div>
                                                                                         </form>
                                                                                     </div>
                         
                                                                                
                                                                                 </td>
                                                                                 
                         
                                                                              </tr>`
                        );
                      },
                    });
                  });
                },
              });
            });
          } else {
            $(".showComments").hide();
          }

          data = 0;
          $(".star").on("click", function () {
            data = $(this).data("value");
            $.each($(".star"), function (index, value) {
              if (index < data) {
                $(value).css("color", "orange");
              } else {
                $(this).css("color", "black");
              }
            });
          });

          $.each(comments, function (index, value) {
            for (let i = 1; i <= 5; i++) {
              if (i <= value.star_rating) {
                $("#" + value.id + " .showStar").append(
                  '<span style="color:orange">&#9733;</span>'
                );
              } else {
                $("#" + value.id + " .showStar").append(
                  '<span style="color:black">&#9733;</span>'
                );
              }
            }
          });

          $("#commentForm").submit(function (e) {
            e.preventDefault();
            content = $("#content").val();

            $.ajax({
              type: "post",
              url: "index.php?act=comment",
              data: {
                content: content,
                starRating: data,
                id: id,
              },
              success: function (response) {
                arr = response.split("##-##");
                if (arr[1] == '"userErr"') {
                  if (confirm("vui lòng đăng nhập!") == true) {
                    window.location.href = "index.php?act=login";
                  }
                } else {
                  window.location.reload();
                }
              },
            });
          });
        },
      });

      $.ajax({
        type: "get",
        url: "index.php?act=getLike",
        success: function (response) {
          arr = response.split("##-##");
          if (arr[1] != "error") {
            result = JSON.parse(arr[1]);
            result.forEach((item) => {
              $.ajax({
                type: "get",
                url: "index.php?act=getUser",
                success: function (res) {
                  arr1 = res.split("##-##");
                  result1 = JSON.parse(arr1[1]);

                  if (
                    $("button.like-btn").data("parent") == item.comment_id &&
                    item.comment_reply_id == 0 &&
                    result1.user_id == item.user_id
                  ) {
                    $(".parent[data-parent='" + item.comment_id + "']").html(
                      '<i class="fas fa-thumbs-up text-warning"></i>'
                    );
                    $(
                      ".parent[data-parent='" + item.comment_id + "']"
                    ).removeClass("like-btn");
                    $(
                      ".parent[data-parent='" + item.comment_id + "']"
                    ).addClass("unlike-btn");
                  } else if (
                    $("button.like-btn").data("parent") == item.comment_id &&
                    item.comment_reply_id != 0 &&
                    result1.user_id == item.user_id
                  ) {
                    $(
                      ".child[data-parent='" +
                        item.comment_id +
                        "'][data-id='" +
                        item.comment_reply_id +
                        "']"
                    ).html('<i class="fas fa-thumbs-up text-warning"></i>');
                    $(
                      ".child[data-parent='" +
                        item.comment_id +
                        "'][data-id='" +
                        item.comment_reply_id +
                        "']"
                    ).removeClass("like-btn");
                    $(
                      ".child[data-parent='" +
                        item.comment_id +
                        "'][data-id='" +
                        item.comment_reply_id +
                        "']"
                    ).addClass("unlike-btn");
                  }
                },
              });
            });
          }
        },
      });

      $(document).on("click", ".reply-btn", function () {
        parentId = $(this).data("id");
        $("tr .replyCommentForm").prop("hidden", true);
        $("tr#" + parentId + " .replyCommentForm").prop("hidden", false);
      });
      $(document).on("click", ".like-btn", function () {
        id = $(this).data("id");
        parent = $(this).data("parent");
        $.ajax({
          type: "post",
          url: "index.php?act=likeComment",
          data: { id: id, parent: parent },

          success: function (response) {
            arr = response.split("##-##");
            result = arr[1];
            if (result == "success") {
              if (id == null) {
                $(".parent[data-parent='" + parent + "']").html(
                  '<i class="fas fa-thumbs-up text-warning"></i>'
                );
                $(".parent[data-parent='" + parent + "']").removeClass(
                  "like-btn"
                );
                $(".parent[data-parent='" + parent + "']").addClass(
                  "unlike-btn"
                );
              } else {
                $(
                  ".child[data-parent='" + parent + "'][data-id='" + id + "']"
                ).html('<i class="fas fa-thumbs-up text-warning"></i>');
                $(
                  ".child[data-parent='" + parent + "'][data-id='" + id + "']"
                ).removeClass("like-btn");
                $(
                  ".child[data-parent='" + parent + "'][data-id='" + id + "']"
                ).addClass("unlike-btn");
              }
            } else if ("user doesn't exits") {
              alert("vui lòng đăng nhập");
              window.location.href = "index.php?act=login";
            }
          },
        });
      });

      $(document).on("click", ".unlike-btn", function () {
        id = $(this).data("id");
        parent = $(this).data("parent");

        $.ajax({
          type: "post",
          url: "index.php?act=unlikeComment",
          data: { id: id, parent: parent },

          success: function (response) {
            arr = response.split("##-##");
            result = arr[1];
            if (result == "success") {
              if (id == null) {
                $(".parent[data-parent='" + parent + "']").html(
                  '<i class="far fa-thumbs-up"></i>'
                );
                $(".parent[data-parent='" + parent + "']").removeClass(
                  "unlike-btn"
                );
                $(".parent[data-parent='" + parent + "']").addClass("like-btn");
              } else {
                $(
                  ".child[data-parent='" + parent + "'][data-id='" + id + "']"
                ).html('<i class="far fa-thumbs-up"></i>');
                $(
                  ".child[data-parent='" + parent + "'][data-id='" + id + "']"
                ).removeClass("unlike-btn");
                $(
                  ".child[data-parent='" + parent + "'][data-id='" + id + "']"
                ).addClass("like-btn");
              }
            } else if ("user doesn't exits") {
              alert("vui lòng đăng nhập");
              window.location.href = "index.php?act=login";
            }
          },
        });
      });

      $(document).on("submit", ".replyCommentForm", function (e) {
        e.preventDefault();
        data = $(this).serialize();
        $.ajax({
          type: "post",
          url: "index.php?act=commentReply",
          data: data,
          success: function (response) {
            arr = response.split("##-##");
            if (arr[1] == '"userErr"') {
              if (confirm("vui lòng đăng nhập!") == true) {
                window.location.href = "index.php?act=login";
              }
            } else if (arr[1] == '"error"') {
              console.log("lỗi");
            } else if (arr[1] == '"insert error"') {
              console.log("lỗi1");
            } else {
              result = JSON.parse(arr[1]);
              $("tr .replyCommentForm").prop("hidden", true);
              setTimeout(
                $(
                  "#listComments tr#" +
                    result.comment_id +
                    " .listCommentsReply"
                ).append(
                  `<tr id="` +
                    result.id +
                    `">
                                                                        <td id="` +
                    result.id +
                    `">
                                                                           <div>
                                                                               <img class="" src="./Assets/img/` +
                    result.image +
                    `" alt="" />  <b>` +
                    result.username +
                    `</b>
                                                                           </div>
                                                                           <span>` +
                    result.create_at +
                    `</span>
                                                                           <div class="showStar ` +
                    result.id +
                    `"></div>
                                                                           <div>` +
                    result.content +
                    `</div>
                                                                           <div>
                                                                               <button class="btn"><i class="far fa-thumbs-up"></i></button>
                                                                               <button class="btn reply-btn" data-id="` +
                    result.id +
                    `"><i class="far fa-comments"></i></button>
                                                                               <form  class="mt-5 replyCommentForm" hidden>
                                                                                   <div class="row">
                                                                                       <div class="col-lg-1 avatar-reply"><img src="./Assets/img/` +
                    user.image +
                    `" alt="w-100"></div>
                                                                                       <div class="col-lg-11">
                                                                                       <input type="hidden" value="` +
                    result.id +
                    `" name="id">
                                                                                           <textarea name="comment" id="content" cols="80" rows="5" placeholder="Nhập bình luận"></textarea>
                                                                                           <br>
                                                                                           <button type="submit" class="btn">Gửi</button>
                                                                                       </div>
                                                                                   </div>
                                                                               </form>
                                                                           </div>
               
                                                                      
                                                                       </td>
                                                                       
               
                                                                    </tr>`
                ),
                3000
              );
            }
          },
        });
      });
      //         //append rating
      $.each(arrRating, function (index, rating) {
        if (rating.sumStar == null) {
          rating.sumStar = 0.0;
        }

        average = rating.sumStar / rating.countCmt;

        if (average == 0) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star0.png" alt="">'
          );
        } else if (average > 0 && average < 1) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star0_5.png" alt="">'
          );
        } else if (average >= 1 && average < 1.5) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star1.png" alt="">'
          );
        } else if (average >= 1.5 && average < 2) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star1_5.png" alt="">'
          );
        } else if (average >= 2 && average < 2.5) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star1.png" alt="">'
          );
        } else if (average >= 2.5 && average < 3) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star2_5.png" alt="">'
          );
        } else if (average >= 3 && average < 3.5) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star3.png" alt="">'
          );
        } else if (average >= 3.5 && average < 4) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star3_5.png" alt="">'
          );
        } else if (average >= 4 && average < 4.5) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star4.png" alt="">'
          );
        } else if (average >= 4.5 && average < 5) {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star4_5.png" alt="">'
          );
        } else {
          $(".products-slick #P" + rating.id + " .product-rating").html(
            '<img src="./Assets/img/star5.png" alt="">'
          );
        }
      });
    },
  });
}
$(document).ready(function () {
  url = new URLSearchParams(window.location.href);
  id = url.get("id");
  appendProductDetail(id);
  $(document).on("click", ".add-to-wishlist", function (e) {
    id = $(this).data("id");
    $.ajax({
      type: "post",
      url: "index.php?act=add_wishlist",
      data: { id: id },
      success: function (response) {
        arr = response.split("##-##");
        check = arr[1];
        console.log(check);
        if (check == "success") {
          $("button[data-id=" + id + "]").css("color", "red");
          $("button[data-id=" + id + "]").removeClass("add-to-wishlist");
          $("button[data-id=" + id + "]").addClass("remove-to-wishlist");
        } else {
          alert("bạn cần phải đăng nhập");
          window.location.href = "index.php?act=login";
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
          $('button[data-id="' + id + '"]').css("color", "#80bb35");
          $('button[data-id="' + id + '"]').removeClass("remove-to-wishlist");
          $('button[data-id="' + id + '"]').addClass("add-to-wishlist");
        }
      },
    });
  });
});
