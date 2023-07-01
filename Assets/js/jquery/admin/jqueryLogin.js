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
        }
      },
    });
  });
});
