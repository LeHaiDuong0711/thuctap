$(document).ready(function () {
  $("#loginForm").submit(function (e) {
    e.preventDefault();
    data = $(this).serialize();
    $.ajax({
      type: "post",
      url: "admin.php?act=login_act",
      data: data,
      success: function (response) {
        arr = response.split("##-##");
        console.log(arr);
        if (arr[1] == "success") {
          window.location.href = "admin.php?act=dashboard";
        } else {
          $('#loginForm').append('<span class="text-danger">Tài khoản hoặc mật khẩu không chính xác</span>');
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
