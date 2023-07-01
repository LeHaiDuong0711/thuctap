$(document).ready(function () {
  $("#usernameLogin").on("blur", function () {
    username = $(this).val();
    // client-side validation
    if (username == "") {
      $(".errUsernameLogin").html("tên đăng nhập không được bỏ trống");
    }
    if (username != "") {
      $(".errUsernameLogin").html("");
    }
  });

  $("#passwordLogin").on("blur", function () {
    password = $(this).val();

    if (password == "") {
      $(".errPasswordLogin").html("Mật khẩu không được bỏ trống");
      return;
    }
    if (password != "") {
      $(".errPasswordLogin").html("");
    }
  });

  $("#loginForm").submit(function (event) {
    event.preventDefault();
    var username = $("#usernameLogin").val();
    var password = $("#passwordLogin").val();

    // client-side validation

    // AJAX call to server-side authentication script
    $.ajax({
      method: "POST",
      url: "index.php?act=login_act",
      data: {
        username: username,
        password: password,
      },
      success: function (response) {
        arr = response.split("##-##");

        if (arr[1] == "success") {
          domain = "thuctap.vinateks.vn";
          domain1 = "footshop.local";
          pathname = "/Duong/fruitShops/index.php";
          pathname1 = "/fruitShops/index.php";
          search = "?act=register";
         

          oldHref = document.referrer;
          if (oldHref) {
            newHref = new URL(oldHref);
            console.log(newHref.search != search);
            if (newHref.hostname == domain) {
              if (newHref.pathname == pathname) {
                if (newHref.search != search) {
                  window.history.back();
                } else {
                  window.location.href = "index.php?act=home";
                }
              } else {
                window.location.href = "index.php?act=home";
              }
            } else if (newHref.hostname == domain1) {
              if (newHref.pathname == pathname1) {
                if (newHref.search != search) {
                  window.history.back();
                } else {
                  window.location.href = "index.php?act=home";
                }
              } else {
                window.location.href = "index.php?act=home";
              }
            } else {
              window.location.href = "index.php?act=home";
            }
          } else {
            window.location.href = "index.php?act=home";
          }

          // redirect to homepage or wherever on successful login

          // window.location.href = "index.php?act=home";
        } else if (arr[1] == "account is locked") {
          alert("Tài khoản đã bị khóa");
        } else {
          $(".errPasswordLogin").html(
            "tài khoản hoặc mật khẩu không chính xác"
          );
        }
      },
    });
  });
  $("#registerForm").submit(function (event) {
    event.preventDefault();
    var username = $('input[name="username"]').val();
    var password = $('input[name="password"]').val();
    var fullName = $('input[name="fullName"]').val();
    var passwordAgain = $('input[name="passwordAgain"]').val();
    var phone = $('input[name="phone"]').val();
    var email = $('input[name="email"]').val();

    // client-side validation

    if (username == "") {
      $(".errUsername").html("Tên người dùng không được để trống");
    }

    var regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

    if (password == "") {
      $(".errPassword").html("Mật khẩu không được để trống");
    } else if (!regexPassword.test(password)) {
      $(".errPassword").html(
        "Mật khẩu không đúng định dạng(Chứ kí tự đầu tiên là in hoa, độ dài tối thiểu 8 ký tự, không ký tự đặc biệt)"
      );
    } else {
      $(".errPassword").html("");
    }

    if (fullName == "") {
      $(".errFullName").html("Họ và tên không được để trống");
    }

    var regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email == "") {
      $(".errEmail").html("Email không được để trống");
    } else if (!regexEmail.test(email)) {
      $(".errEmail").html("Email không đúng định dạng");
    } else {
      $(".errEmail").html("");
    }

    var regexPhone = /^(02|03|04|05|06|07|08|09)(\d{8})$/;
    if (phone == "") {
      $(".errPhone").html("Số điện thoại không được để trống");
    } else if (!regexPhone.test(phone)) {
      $(".errPhone").html("Số điện thoại không hợp lệ");
    } else {
      $(".errPhone").html("");
    }
    if (passwordAgain == "") {
      $(".errPasswordAgain").html("Mật khẩu lặp lại không được để trống");
    } else if (password != passwordAgain) {
      $(".errPasswordAgain").html("Mật khẩu lặp lại không trùng khớp");
    } else {
      $(".errPasswordAgain").html("");
    }

    // AJAX call to server-side authentication script

    $.ajax({
      method: "POST",
      url: "index.php?act=register_act",
      data: {
        fullName: fullName,

        username: username,
        password: password,
        passwordAgain: passwordAgain,
        phone: phone,
        email: email,
      },
      success: function (response) {
        arr = response.split("##-##");
        if (arr[1] == "errEmail") {
          alert("Email đã tồn tại");
        } else if (arr[1] == "errUsername") {
          alert("Tên người dùng đã tồn tại");
        } else if (arr[1] == "success") {
          // redirect to homepage or wherever on successful login
          alert("Đăng Ký thành công");
          window.location.href = "index.php?act=login";
        } else {
          alert("Đăng Ký thất bại");
        }
      },
    });
  });
  $(document).on("click", ".group-password .btn-showPass", function () {
    $(this).html('<i class="fas fa-eye-slash"></i>');
    $(this).siblings('input[type="password"].password').attr("type", "text");

    $(this).removeClass("btn-showPass");
    $(this).addClass("btn-hidePass");
  });
  $(document).on("click", ".group-password .btn-hidePass", function () {
    $(this).html('<i class="fas fa-eye"></i>');
    $(this).siblings('input[type="text"].password').attr("type", "password");
    $(this).removeClass("btn-hidePass");
    $(this).addClass("btn-showPass");
  });
  $(document).on("click", ".back", function () {
    window.history.back();
  });
});
