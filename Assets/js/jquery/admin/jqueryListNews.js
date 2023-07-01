$(document).ready(function () {
  $.ajax({
    type: "get",
    url: "admin.php?act=listNews",
    success: function (response) {
      currentPage = urlParam.get("page");
      if (currentPage == null) {
        currentPage = 1; // trang hiện tại
      }
      arr = response.split("##-##");
      news = JSON.parse(arr[1]);

      newsPerPage = 3; // số lượng sản phẩm trên mỗi trang
      totalNews = news.length; // tổng số sản phẩm
      totalPages = Math.ceil(totalNews / newsPerPage); // tổng số trang
      startIndex = (currentPage - 1) * newsPerPage;
      endIndex = startIndex + newsPerPage;
      if (endIndex > totalNews) {
        endIndex = totalNews;
      }

      currentNews = news.slice(startIndex, endIndex);

      if (news.length > 0) {
        htmls = [];
        currentNews.forEach((item) => {
          html =
            `<tr id="` +
            item.id +
            `">
                <td class="idNews">` +
            item.id +
            `</td>
            <td class="categoryNews">
            </td>
              <td class=""><div class="containerImage"><img src="./../Assets/img/` +
            item.image +
            `" class="w-100" alt=""></div></td>
            <td class="titleNews">` +
            item.title +
            `</td>
                <td class="containerBtn">
                <div class="d-flex">
                      <a class="btn-edit edit" href="admin.php?act=editNews&id=` +
            item.id +
            `"><i class="far fa-edit"></i></a>
                      <button type="button" class="btn-remove remove" data-id="` +
            item.id +
            `"><i class="fas fa-trash-alt"></i></button>
                </div></td>
  
            </tr>`;

          htmls.push(html);
        });
        $("#listNews").html(htmls);

        if (currentPage > 1) {
          $(
            '<a class="page-item page-link prev" href="admin.php?act=news&page=' +
              (currentPage - 1) +
              '">Trước đó</a>'
          ).appendTo("#paginationNews");
        }

        for (let i = 1; i <= totalPages; i++) {
          $("#paginationNews").append(
            '<li class="page-item page"><a class="page-link" href="admin.php?act=news' +
              "&page=" +
              i +
              '">' +
              i +
              "</a></li>"
          );

          $("#paginationNews li a").each(function (index) {
            if (index + 1 == currentPage) {
              $(this).attr("style", "background-color:orange");
            }
          });
        }
        if (currentPage < totalPages) {
          page = parseInt(currentPage) + 1;

          $(
            '<a class="page-item page-link next" href="admin.php?act=news&page=' +
              page +
              '">Tiếp theo</a>'
          ).appendTo("#paginationNews");
        }

        // chèn các thẻ HTML để hiển thị phân trang

        currentNews.forEach((item) => {
          if (item.status == 0) {
            i =
              '<button class="btn-hide hide" data-id="' +
              item.id +
              '"><i class="fas fa-eye"></i></button>';
            $("#listNews #" + item.id).addClass("opacity-100");
          } else {
            i =
              '<button class="btn-hide hide" data-id="' +
              item.id +
              '"><i class="fas fa-eye-slash"></i></button>';
            $("#listNews #" + item.id).addClass("opacity-25");
          }
          $("#listNews #" + item.id + " .containerBtn .d-flex").append(i);

          $("#listNews #" + item.id + " .hide").click(function () {
            dataId = $(this).data("id");
            $.ajax({
              type: "post",
              url: "admin.php?act=statusNews",
              data: {
                id: dataId,
              },

              success: function (response) {
                arr = response.split("##-##");
                result = arr[1];

                if (result == 1) {
                  $("#listNews #" + item.id + " .hide").html(
                    '<i class="fas fa-eye-slash"></i>'
                  );
                  $("#listNews #" + item.id).attr("class", "opacity-25");
                } else {
                  $("#listNews #" + item.id + " .hide").html(
                    '<i class="fas fa-eye"></i>'
                  );
                  $("#listNews #" + item.id).attr("class", "opacity-100");
                }
              },
            });
          });

          $("#listNews #" + item.id + " .remove").click(function () {
            dataId = $(this).data("id");
            $.ajax({
              type: "post",
              url: "admin.php?act=removeNews",
              data: {
                id: dataId,
              },

              success: function (response) {
                arr = response.split("##-##");
                result = arr[1];

                if (result == "success") {
                  alert("Đã xóa tin tức");
                  window.location.reload();
                } else {
                  alert("Xóa tin tức thất bại");
                  window.location.reload();
                }
              },
            });
          });

          $.ajax({
            type: "get",
            url: "admin.php?act=getCategory",

            success: function (response) {
              arr = response.split("##-##");
              arrCategory = JSON.parse(arr[1]);
              arrCategory.forEach((cate)=>{
                
                if(cate.id==item.idCategoryMultiple){
                  $("#listNews #" + item.id +" .categoryNews").append(cate.name);
                }
              })
            },
          });
        });
      }
    },

    //
  });

  $("input[name='uploadImageNews']").change(function () {
    file = $(this)[0].files[0];
    fileReader = new FileReader();
    fileReader.readAsDataURL(file);
    fileReader.onloadend = function (e) {
      $("#avatar-image").attr("src", e.target.result);
    };
  });
  $("#addNewsForm").submit(function (e) {
    e.preventDefault();
    data = new FormData(this);
    $.ajax({
      type: "post",
      url: "admin.php?act=addNews_act",
      data: data,
      processData: false,
      contentType: false,
      success: function (response) {
        arr = response.split("##-##");
        result = arr[1];
        if (result == "success") {
          alert("thêm tin tức thành công");
          $("#addNewsForm").trigger("reset");
          $("#avatar-image").removeAttr("src");
        } else if (result == "insert error") {
          alert("thêm tin tức thất bại");
        } else {
          alert(result);
        }
      },
    });
  });
});
