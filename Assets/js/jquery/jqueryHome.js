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
    url: "index.php?act=home_act",
    success: function (response) {
      arr = response.split("##-##");
      result = JSON.parse(arr[1]);
      proNewType1 = result.proNewType1;
      proNewType2 = result.proNewType2;
      proNewType3 = result.proNewType3;
      arrRatingProNew = result.arrRatingProNew;
      proSelling1 = result.proSelling1;
      proSelling2 = result.proSelling2;
      proSelling3 = result.proSelling3;
      arrRatingProSelling = result.arrRatingProSelling;

      $.each(proNewType1, function (index, value) {
        $(".newProductsEveryday #type1").append(
          `
          <div class="col-lg-4">
						
          <div class="product mb-5" id="`+value.id +`">
            <div class="product-img">
              <img src="./Assets/img/`+value.pro_image +`" alt="">
              <div class="product-label">

              </div>
            </div>
            <div class="product-body">
              <a href="index.php?act=productDetail&id=`+value.id +`">
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

        if (value.quantity <= 0) {
          $("#" + value.id + " .product-label").html(
            '<span class="out-of-stock">Hết Hàng</span>'
          );
        } else {
          $.ajax({
            type: "get",
            url: "index.php?act=getProductProperty",
            data: {id:value.id},
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              if(result.length>0){
                $("#" + value.id).append(
                  `<div class="add-to-cart">
      
                <a href="index.php?act=productDetail&id=`+value.id+`"> <button class="add-to-cart-btn" value=""><i class="far fa-eye" aria-hidden="true"></i>Xem chi tiết</button></a>
                                              </div>`
                );

              } else{
                $("#" + value.id).append(
                  `<div class="add-to-cart">
      
                 <button type="button" id="` +
                    value.id +
                    `" class="add-to-cart-btn add-cart" value=""><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Thêm vào giỏ hàng</button>
                                              </div>`
                );
              }
            }
          });
         
        }
        if (value.promotion > 0) {
          $("#" + value.id + " .product-price").html(
            '<h4 ><span class="price formatPromotion">' +
              value.promotion +
              ' </span><del class="price text-dark formatPrice">' +
              value.price +
              " </del></h4>"
          );
        } else {
          $("#" + value.id + " .product-price").html(
            '<h4 class="price formatPrice">' + value.price + "</h4>"
          );
        }
        price = formatCurrency($("#" + value.id + " .formatPrice").html());
        $("#" + value.id + " .formatPrice").html(price);

        promotion = formatCurrency(
          $("#" + value.id + " .formatPromotion").html()
        );
        $("#" + value.id + " .formatPromotion").html(promotion);
      });

      $.each(proNewType2, function (index, value) {
        $(".newProductsEveryday #type2").append(
          `
          <div class="col-lg-4">
						
          <div class="product mb-5" id="`+value.id +`">
            <div class="product-img">
              <img src="./Assets/img/`+value.pro_image +`" alt="">
              <div class="product-label">

              </div>
            </div>
            <div class="product-body">
              <a href="index.php?act=productDetail&id=`+value.id +`">
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

        if (value.quantity <= 0) {
          $("#" + value.id + " .product-label").html(
            '<span class="out-of-stock">Hết Hàng</span>'
          );
        } else {
          $.ajax({
            type: "get",
            url: "index.php?act=getProductProperty",
            data: {id:value.id},
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              if(result.length>0){
                $("#" + value.id).append(
                  `<div class="add-to-cart">
      
                <a href="index.php?act=productDetail&id=`+value.id+`"> <button class="add-to-cart-btn" value=""><i class="far fa-eye" aria-hidden="true"></i>Xem chi tiết</button></a>
                                              </div>`
                );

              } else{
                $("#" + value.id).append(
                  `<div class="add-to-cart">
      
                 <button type="button" id="` +
                    value.id +
                    `" class="add-to-cart-btn add-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Thêm vào giỏ hàng</button>
                                              </div>`
                );
              }
            }
          });
        }

        if (value.promotion > 0) {
          $("#" + value.id + " .product-price").html(
            '<h4><span class="price formatPromotion">' +
              value.promotion +
              ' </span><del class="price text-dark formatPrice">' +
              value.price +
              " </del></h4>"
          );
        } else {
          $("#" + value.id + " .product-price").html(
            '<h4 class="price formatPrice">' + value.price + "</h4>"
          );
        }
        price = formatCurrency($("#" + value.id + " .formatPrice").html());
        $("#" + value.id + " .formatPrice").html(price);

        promotion = formatCurrency(
          $("#" + value.id + " .formatPromotion").html()
        );
        $("#" + value.id + " .formatPromotion").html(promotion);
      });
      $.each(proNewType3, function (index, value) {
        $(".newProductsEveryday #type3").append(
          `
          <div class="col-lg-4">
						
          <div class="product mb-5" id="`+value.id +`">
            <div class="product-img">
              <img src="./Assets/img/`+value.pro_image +`" alt="">
              <div class="product-label">

              </div>
            </div>
            <div class="product-body">
              <a href="index.php?act=productDetail&id=`+value.id +`">
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

        if (value.quantity <= 0) {
          $(".newProductsEveryday #" + value.id + " .product-label").html(
            '<span class="out-of-stock">Hết Hàng</span>'
          );
        } else {
          $.ajax({
            type: "get",
            url: "index.php?act=getProductProperty",
            data: {id:value.id},
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              if(result.length>0){
                $("#" + value.id).append(
                  `<div class="add-to-cart">
      
                <a href="index.php?act=productDetail&id=`+value.id+`"> <button class="add-to-cart-btn" value=""><i class="far fa-eye" aria-hidden="true"></i>Xem chi tiết</button></a>
                                              </div>`
                );

              } else{
                $("#" + value.id).append(
                  `<div class="add-to-cart">
      
                 <button type="button" id="` +
                    value.id +
                    `" class="add-to-cart-btn add-cart" value=""><i class="fa fa-shopping-cart" aria-hidden="true"></i>Thêm vào giỏ hàng</button>
                                              </div>`
                );
              }
            }
          });
        }
        if (value.promotion > 0) {
          $(".newProductsEveryday #" + value.id + " .product-price").html(
            '<h4><span class="price formatPromotion">' +
              value.promotion +
              ' </span><del class="price text-dark formatPrice">' +
              value.price +
              " </del></h4>"
          );
        } else {
          $(".newProductsEveryday #" + value.id + " .product-price").html(
            '<h4 class="price formatPrice">' + value.price + "</h4>"
          );
        }
        price = formatCurrency($("#" + value.id + " .formatPrice").html());
        $("#" + value.id + " .formatPrice").html(price);

        promotion = formatCurrency(
          $("#" + value.id + " .formatPromotion").html()
        );
        $("#" + value.id + " .formatPromotion").html(promotion);
      });

      $.each(arrRatingProNew, function (index, rating) {
        if (rating.sumStar == null) {
          rating.sumStar = 0;
        }

        average = rating.sumStar / rating.countCmt;
        if (average == 0) {
          view = '<img src="./Assets/img/star0.png" alt="">';
        } else if (average > 0 && average < 1) {
          view = '<img src="./Assets/img/star0_5.png" alt="">';
        } else if (average >= 1 && average < 1.5) {
          view = '<img src="./Assets/img/star1.png" alt="">';
        } else if (average >= 1.5 && average < 2) {
          view = '<img src="./Assets/img/star1_5.png" alt="">';
        } else if (average >= 2 && average < 2.5) {
          view = '<img src="./Assets/img/star1.png" alt="">';
        } else if (average >= 2.5 && average < 3) {
          view = '<img src="./Assets/img/star2_5.png" alt="">';
        } else if (average >= 3 && average < 3.5) {
          view = '<img src="./Assets/img/star3.png" alt="">';
        } else if (average >= 3.5 && average < 4) {
          view = '<img src="./Assets/img/star3_5.png" alt="">';
        } else if (average >= 4 && average < 4.5) {
          view = '<img src="./Assets/img/star4.png" alt="">';
        } else if (average >= 4.5 && average < 5) {
          view = '<img src="./Assets/img/star4_5.png" alt="">';
        } else {
          view = '<img src="./Assets/img/star5.png" alt="">';
        }
        $("#" + rating.id + " .product-rating").html(view);
      });

      //append products selling

      $.each(proSelling1, function (indexIn, value) {
        $("#sellingProducts  #type1").append(
          `
          <div class="col-lg-4">
						
							<div class="product mb-5" id="`+value.pro_id +`">
								<div class="product-img">
									<img src="./Assets/img/`+value.pro_image +`" alt="">
									<div class="product-label">

									</div>
								</div>
								<div class="product-body">
									<a href="index.php?act=productDetail&id=`+value.pro_id +`">
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
          value.pro_id +
          `"><i class="fa fa-heart"></i><span class="tooltipp">Yêu thích</span></button>
                
    
              </div>
								</div>
							</div>
						
					</div>
          `
        );
        if (value.quantity <= 0) {
          $("#sellingProducts  #" + value.pro_id + " .product-label").html(
            '<span class="out-of-stock">Hết Hàng</span>'
          );
        } else {
          
          $.ajax({
            type: "get",
            url: "index.php?act=getProductProperty",
            data: {id:value.pro_id},
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              if(result.length>0){
                $("#sellingProducts #" + value.pro_id).append(
                  `<div class="add-to-cart">
      
                <a href="index.php?act=productDetail&id=`+value.pro_id+`"> <button class="add-to-cart-btn" value=""><i class="far fa-eye" aria-hidden="true"></i>Xem chi tiết</button></a>
                                              </div>`
                );

              } else{
                $("#sellingProducts #" + value.pro_id).append(
                  `<div class="add-to-cart">
      
                 <button type="button" id="` +
                    value.pro_id +
                    `" class="add-to-cart-btn add-cart" value=""><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Thêm vào giỏ hàng</button>
                                              </div>`
                );
              }
            }
          });
        }
        if (value.promotion > 0) {
          $("#sellingProducts  #" + value.pro_id + " .product-price").html(
            '<h4><span class="price formatPromotion">' +
              value.promotion +
              ' </span><del class="price text-dark formatPrice">' +
              value.price +
              " </del></h4>"
          );
        } else {
          $("#sellingProducts  #" + value.pro_id + " .product-price").html(
            '<h4 class="price formatPrice">' + value.price + "</h4>"
          );
        }
        price = formatCurrency(
          $("#sellingProducts  #" + value.pro_id + " .formatPrice").html()
        );

        $("#sellingProducts  #" + value.pro_id + " .formatPrice").html(price);

        promotion = formatCurrency(
          $("#sellingProducts  #" + value.pro_id + " .formatPromotion").html()
        );

        $("#sellingProducts  #" + value.pro_id + " .formatPromotion").html(
          promotion
        );
      });

      $.each(proSelling2, function (indexIn, value) {
        $("#sellingProducts  #type2").append(
          `
          <div class="col-lg-4">
						
							<div class="product mb-5" id="`+value.pro_id +`">
								<div class="product-img">
									<img src="./Assets/img/`+value.pro_image +`" alt="">
									<div class="product-label">

									</div>
								</div>
								<div class="product-body">
									<a href="index.php?act=productDetail&id=`+value.pro_id +`">
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
          value.pro_id +
          `"><i class="fa fa-heart"></i><span class="tooltipp">Yêu thích</span></button>
                
    
              </div>
								</div>
							</div>
						
					</div>
          `
        );
        if (value.quantity <= 0) {
          $("#sellingProducts  #" + value.pro_id + " .product-label").html(
            '<span class="out-of-stock">Hết Hàng</span>'
          );
        } else {
          $.ajax({
            type: "get",
            url: "index.php?act=getProductProperty",
            data: {id:value.pro_id},
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              if(result.length>0){
                $("#sellingProducts #" + value.pro_id).append(
                  `<div class="add-to-cart">
      
                <a href="index.php?act=productDetail&id=`+value.pro_id+`"> <button class="add-to-cart-btn" value=""><i class="far fa-eye" aria-hidden="true"></i>Xem chi tiết</button></a>
                                              </div>`
                );

              } else{
                $("#sellingProducts #" + value.pro_id).append(
                  `<div class="add-to-cart">
      
                 <button type="button" id="` +
                    value.pro_id +
                    `" class="add-to-cart-btn add-cart" value=""><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Thêm vào giỏ hàng</button>
                                              </div>`
                );
              }
            }
          });
        }
        if (value.promotion > 0) {
          $("#sellingProducts  #" + value.pro_id + " .product-price").html(
            '<h4><span class="price formatPromotion">' +
              value.promotion +
              ' </span><del class="price text-dark formatPrice">' +
              value.price +
              " </del></h4>"
          );
        } else {
          $("#sellingProducts  #" + value.pro_id + " .product-price").html(
            '<h4 class="price formatPrice">' + value.price + "</h4>"
          );
        }
        price = formatCurrency(
          $("#sellingProducts  #" + value.pro_id + " .formatPrice").html()
        );

        $("#sellingProducts  #" + value.pro_id + " .formatPrice").html(price);

        promotion = formatCurrency(
          $("#sellingProducts  #" + value.pro_id + " .formatPromotion").html()
        );

        $("#sellingProducts  #" + value.pro_id + " .formatPromotion").html(
          promotion
        );
      });

      $.each(proSelling3, function (indexIn, value) {
        $("#sellingProducts  #type3").append(
          `
          <div class="col-lg-4">
						
							<div class="product mb-5" id="`+value.pro_id +`">
								<div class="product-img">
									<img src="./Assets/img/`+value.pro_image +`" alt="">
									<div class="product-label">

									</div>
								</div>
								<div class="product-body">
									<a href="index.php?act=productDetail&id=`+value.pro_id +`">
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
        if (value.quantity <= 0) {
          $("#sellingProducts  #" + value.pro_id + " .product-label").html(
            '<span class="out-of-stock">Hết Hàng</span>'
          );
        } else {
          $.ajax({
            type: "get",
            url: "index.php?act=getProductProperty",
            data: {id:value.pro_id},
            success: function (response) {
              arr = response.split("##-##");
              result = JSON.parse(arr[1]);
              if(result.length>0){
                $("#sellingProducts #" + value.pro_id).append(
                  `<div class="add-to-cart">
      
                <a href="index.php?act=productDetail&id=`+value.pro_id+`"> <button class="add-to-cart-btn"><i class="far fa-eye" aria-hidden="true"></i>Xem chi tiết</button></a>
                                              </div>`
                );

              } else{
                $("#sellingProducts #" + value.pro_id).append(
                  `<div class="add-to-cart">
      
                 <button type="button" id="` +
                    value.pro_id +
                    `" class="add-to-cart-btn add-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  Thêm vào giỏ hàng</button>
                                              </div>`
                );
              }
            }
          });
        }
        if (value.promotion > 0) {
          $("#sellingProducts  #" + value.pro_id + " .product-price").html(
            '<h4><span class="price formatPromotion">' +
              value.promotion +
              ' </span><del class="price text-dark formatPrice">' +
              value.price +
              " </del></h4>"
          );
        } else {
          $("#sellingProducts  #" + value.pro_id + " .product-price").html(
            '<h4 class="price formatPrice">' + value.price + "</h4>"
          );
        }
        price = $(
          "#sellingProducts  #" + value.pro_id + " .formatPrice"
        ).html();
        price = parseFloat(price);
        price = new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
        }).format(price);
        $("#sellingProducts  #" + value.pro_id + " .formatPrice").html(price);

        promotion = $(
          "#sellingProducts  #" + value.pro_id + " .formatPromotion"
        ).html();
        promotion = parseFloat(promotion);
        promotion = new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
        }).format(promotion);
        $("#sellingProducts  #" + value.pro_id + " .formatPromotion").html(
          promotion
        );
      });
      $.each(arrRatingProSelling, function (index, rating) {
        if (rating.sumStar == null) {
          rating.sumStar = 0;
        }

        average = rating.sumStar / rating.countCmt;
        if (average == 0) {
          view = '<img src="./Assets/img/star0.png" alt="">';
        } else if (average > 0 && average < 1) {
          view = '<img src="./Assets/img/star0_5.png" alt="">';
        } else if (average >= 1 && average < 1.5) {
          view = '<img src="./Assets/img/star1.png" alt="">';
        } else if (average >= 1.5 && average < 2) {
          view = '<img src="./Assets/img/star1_5.png" alt="">';
        } else if (average >= 2 && average < 2.5) {
          view = '<img src="./Assets/img/star1.png" alt="">';
        } else if (average >= 2.5 && average < 3) {
          view = '<img src="./Assets/img/star2_5.png" alt="">';
        } else if (average >= 3 && average < 3.5) {
          view = '<img src="./Assets/img/star3.png" alt="">';
        } else if (average >= 3.5 && average < 4) {
          view = '<img src="./Assets/img/star3_5.png" alt="">';
        } else if (average >= 4 && average < 4.5) {
          view = '<img src="./Assets/img/star4.png" alt="">';
        } else if (average >= 4.5 && average < 5) {
          view = '<img src="./Assets/img/star4_5.png" alt="">';
        } else {
          view = '<img src="./Assets/img/star5.png" alt="">';
        }
        $("#sellingProducts  #" + rating.id + " .product-rating").html(view);
      });
      $(document).on("click", ".add-cart",function (e) {
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
    
    },
  });

  var startDate = new Date("2023-06-26T00:00:00Z");
  var endDate = new Date("2023-07-02T23:59:59Z");

  // hàm để tính thời gian còn lại đến thời điểm kết thúc khuyến mãi
  function getTimeRemaining() {
    var now = new Date();
    var diff = endDate.getTime() - now.getTime();
    var days = Math.floor(diff / (1000 * 60 * 60 * 24));
    var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((diff % (1000 * 60)) / 1000);
    return {
      days: days,
      hours: hours,
      minutes: minutes,
      seconds: seconds,
    };
  }

  // hàm để cập nhật thông tin thời gian còn lại trên giao diện
  function updateTimer() {
    var remaining = getTimeRemaining();
    $("#timer-days").text(remaining.days.toString());
    $("#timer-hours").text(("0" + remaining.hours).slice(-2));
    $("#timer-minutes").text(("0" + remaining.minutes).slice(-2));
    $("#timer-seconds").text(("0" + remaining.seconds).slice(-2));
    if(remaining.days <= 0 && remaining.hours<=0 && remaining.minutes<=0&&remaining.seconds<=0){
      
      $("#hot-deal.section").remove();
    }
  }

  // cập nhật thông tin thời gian còn lại mỗi giây
  setInterval(updateTimer, 1000);


});
