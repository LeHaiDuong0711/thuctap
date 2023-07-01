$(document).ready(function () {
  $.ajax({
    type: "get",
    url: "index.php?act=getCategory",

    success: function (response) {
      arr = response.split("##-##");
      arrCategory = JSON.parse(arr[1]);

      // showCategories(arrCategory)
      function showCategories(arrCategory, element, parent_id = 0) {
        arrCategory.forEach((item, key) => {
          if (item.parent_id == parent_id) {
            $(element).append(
              ` <li id="dropdownMenu` +
                item.id +
                `" data-mdb-toggle="dropdown"
              aria-expanded="false"><a class="nav-link" href="index.php?act=` +
                item.title +
                `">` +
                item.name +
                `</a><ul id="menuContent` +
                item.id +
                `" class="dropdown-content" aria-labelledby="dropdownMenu` +
                item.id +
                `"></ul></li>`
            );
            // console.log($("#menuContent" + item.parent_id).children("li").length);
            if ($("#menuContent" + item.parent_id).children("li").length > 0) {
              $("#dropdownMenu" + item.parent_id).addClass("dropdownMenu");
            }
            delete arrCategory[key];

            showCategories(arrCategory, "#menuContent" + item.id, item.id);
          }
        });
      }

      showCategories(arrCategory, "#menu");
      if (window.location.search == "") {
        $("#menu li a").first().attr("style", "color:orange");
      }
      $("#menu li a").each(function () {
        var searchParams = window.location.search;
        if (searchParams==$(this).attr("href").slice(9)) {
          $(this).attr("style", "color:orange");
        }
      });
    },
  });

  // Thêm lớp "active" cho menu đang được chọn


  $.ajax({
    type: "get",
    url: "index.php?act=countCart",
    success: function (response) {
      arr = response.split("##-##");

      $(".countCart").html(arr[1]);
    },
  });

  $(document).on("click", ".logout", function () {
    // Lấy accessToken của người dùng từ localStorage
    function getAccessToken() {
      return localStorage.getItem("accessToken");
    }

    // Xóa accessToken khỏi localStorage
    function clearAccessToken() {
      localStorage.removeItem("accessToken");
    }
    // Hàm đăng xuất khỏi Facebook
    function logout() {
      let accessToken = getAccessToken();
      if (accessToken) {
        // Xóa accessToken khỏi localStorage
        clearAccessToken();
        // Hủy quyền truy cập của ứng dụng trên Facebook
        FB.api(
          "/me/permissions",
          "delete",
          {
            access_token: accessToken,
          },
          function (response) {
            if (response.success) {
              $.ajax({
                url: "index.php?act=logout",
                success: function (response) {
                  arr = response.split("##-##");
                  if (arr[1] == "success") {
                    window.location.href = "index.php?act=login";
                  }
                },
              });
            }
          }
        );
      } else {
        $.ajax({
          url: "index.php?act=logout",
          success: function (response) {
            arr = response.split("##-##");
            if (arr[1] == "success") {
              window.location.href = "index.php?act=login";
            }
          },
        });
      }
    }
    logout();
  });
});
