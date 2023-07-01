$(document).ready(function () {
  $.ajax({
    type: "get",
    url: "admin.php?act=infoAdminLogin",
    success: function (response) {
      arr = response.split("##-##");

      if (arr[1]) {
        result = JSON.parse(arr[1]);
        $("#infoAdmin .name").html(result.fullName);
        $("#infoAdmin img").attr('src', "./../Assets/img/admin/"+result.image);
      }
    },
  });
});
