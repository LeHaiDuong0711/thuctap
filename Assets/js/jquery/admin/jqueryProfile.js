$(document).ready(function () {
  $.ajax({
    type: "get",
    url: "admin.php?act=profile_act",

    success: function (response) {
      arr = response.split("##-##");
      if (arr[1] != "error") {
        result = JSON.parse(arr[1]);
        $("#sectionProfile .avatar_img").attr(
          "src",
          "./../Assets/img/admin/" + result.image
        );
        $("#sectionProfile .username").text(result.userName);

        $('#sectionProfile input[name="fullName"]').val(result.fullName);

        $('#sectionProfile input[name="email"]').val(result.email);
        $('#sectionProfile input[name="phoneNumber"]').val(result.phone);
      }
    },
  });

  $(document).on("click", "#editProfile", function (e) {
    $('input[name="firstName"]').attr("readonly", false);
    $('input[name="email"]').attr("readonly", false);
    $('input[name="phoneNumber"]').attr("readonly", false);
    $('input[name="fullName"]').attr("readonly", false);
    $('input[name="fullName"]').trigger("focus");

    $(".container-btn").html(
      `<button type="submit" class="btn-save" id="submitEditProfile"><i class="far fa-save"></i></button>  
                <button type="button" id="cancelEdit" class="btn-cancel"><i class="far fa-window-close"></i></button>
            `
    );
  });
  $(document).on("click", "#cancelEdit", function () {
    console.log("a");
    $('input[name="fullName"]').attr("readonly", true);
    $('input[name="email"]').attr("readonly", true);
    $('input[name="phoneNumber"]').attr("readonly", true);
   
    $(".container-btn").html(
      ` <button type="button" id="editProfile" name="submit" class="btn-edit"><i class="far fa-edit"></i></button>

            `
    );
  });

  $("#editProfileForm").submit(function (e) {
    e.preventDefault();
    data = $(this).serialize();
    $.ajax({
      type: "post",
      url: "admin.php?act=editProfile",
      data: data,

      success: function (response) {
        arr = response.split("##-##");
        if (arr[1] == "success") {
          alert("cập nhật thành công");
          $('input[name="fullName"]').attr("readonly", true);
          $('input[name="email"]').attr("readonly", true);
          $('input[name="phoneNumber"]').attr("readonly", true);
       
          $(".container-btn").html(
            ` <button type="button" id="editProfile" name="submit" class="btn-edit"><i class="far fa-edit"></i></button>`
          );
        } else {
          alert("cập nhật thất bại");
        }
      },
    });
  });
  $("input[name='uploadAvatar']").change(function () {
    data = new FormData(document.getElementById("editAvatarForm"));

    $.ajax({
      url: "admin.php?act=uploadAvatar",
      method: "POST",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        arr = response.split("##-##");

        if (result == "update error") {
          alert("Cập Nhật Thất Bại");
        } else if (result == "image name already exists") {
          alert("tên hình ảnh đã tồn tại");
        } else if (result == "images exceed 500kb") {
          alert("ảnh vượt quá 500kb");
        } else if (result == "file is not an image format") {
          alert("file không đúng định dạng hình ảnh (jpg, jpeg, png, gif)");
        } else if (result == "file image does not exis") {
          alert("file ảnh không tồn tại");
        } else {
          result = JSON.parse(arr[1]);
          $("#avatar-image").attr(
            "src",
            "./../Assets/img/admin/" + result.image
          );
          $("#infoAdmin img").attr(
            "src",
            "./../Assets/img/admin/" + result.image
          );
        }
      },
    });
  });
});
