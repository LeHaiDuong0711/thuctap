$(document).ready(function () {
  $('input[name="username"]').on("blur", function () {
    if ($(this).val() == "") {
      $(".errUsername").html("Tên người dùng không được để trống");
    } else {
      $(".errUsername").html("");
    }
  });
  $('input[name="password"]').on("blur", function () {
    var password = $(this).val();
    var regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

    if ($(this).val() == "") {
      $(".errPassword").html("Mật khẩu không được để trống");
    } else if (!regexPassword.test(password)) {
      $(".errPassword").html(
        "Mật khẩu không đúng định dạng(Chứ kí tự đầu tiên là in hoa, độ dài tối thiểu 8 ký tự, không ký tự đặc biệt,có ít nhất 1 ký tự số)"
      );
    } else {
      $(".errPassword").html("");
    }
  });
  $('input[name="oldPassword"]').on("blur", function () {
    if ($(this).val() == "") {
      $(".errOldPassword").html("Mật khẩu củ không được để trống");
    } else {
      $(".errOldPassword").html("");
    }
    
  });
  $('input[name="newPassword"]').on("blur", function () {
    var password = $(this).val();
    var regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if ($(this).val() == "") {
      $(".errNewPassword").html("Mật khẩu mới không được để trống");
    } else if (!regexPassword.test(password)) {
      $(".errNewPassword").html(
        "Mật khẩu không đúng định dạng(Chứ kí tự đầu tiên là in hoa, độ dài tối thiểu 8 ký tự, không ký tự đặc biệt,có ít nhất 1 ký tự số)"
      );
    } else {
      $(".errNewPassword").html("");
    }
    if (
      $('input[name="passwordAgain"]').val() !=
        $('input[name="password"]').val() &&
      $('input[name="passwordAgain"]').val() !=
        $('input[name="newPassword"]').val()
    ) {
      $(".errPasswordAgain").html("Mật khẩu lặp lại không trùng khớp");
    } else{
       $(".errPasswordAgain").html("");
    }
  });
  $('input[name="fullName"]').on("blur", function () {
    if ($(this).val() == "") {
      $(".errFullName").html("Họ và tên không được để trống");
    } else {
      $(".errFullName").html("");
    }
  });

  $('input[name="email"]').on("blur", function () {
    var email = $(this).val();
    var regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if ($(this).val() == "") {
      $(".errEmail").html("Email không được để trống");
    } else if (!regexEmail.test(email)) {
      $(".errEmail").html("Email không đúng định dạng");
    } else {
      $(".errEmail").html("");
    }
  });
  $('input[name="phone"]').on("blur", function () {
    var phone = $(this).val();
    var regexPhone = /^(02|03|04|05|06|07|08|09)(\d{8})$/;
    if ($(this).val() == "") {
      $(".errPhone").html("Số điện thoại không được để trống");
    } else if (!regexPhone.test(phone)) {
      $(".errPhone").html("Số điện thoại không hợp lệ");
    } else {
      $(".errPhone").html("");
    }
  });
  $('input[name="passwordAgain"]').on("blur", function () {
    if ($(this).val() == "") {
      $(".errPasswordAgain").html("Mật khẩu lặp lại không được để trống");
    } else if (
      $(this).val() != $('input[name="password"]').val() &&
      $(this).val() != $('input[name="newPassword"]').val()
    ) {
      $(".errPasswordAgain").html("Mật khẩu lặp lại không trùng khớp");
    } else {
      $(".errPasswordAgain").html("");
    }
  });
  $('input[name="address"]').on("blur", function () {
    if ($(this).val() == "") {
      $(".errAddress").html("Địa chỉ không được để trống");
    } else {
      $(".errAddress").html("");
    }
  });
  $(".country").on("blur", function () {
    if ($(this).val() == "") {
      $(".errCountry").html("Vui lòng chọn Tỉnh/Thành phố");
    } else {
      $(".errCountry").html("");
    }
  });
  $(".district").on("blur", function () {
    if ($(this).val() == "") {
      $(".errDistrict").html("Vui lòng chọn Quận/Huyện");
    } else {
      $(".errDistrict").html("");
    }
  });
  $(".commune").on("blur", function () {
    if ($(this).val() == "") {
      $(".errCommune").html("Vui lòng chọn Phường/Xã");
    } else {
      $(".errCommune").html("");
    }
  });
});
