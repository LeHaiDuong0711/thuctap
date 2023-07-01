function formatDate(dateFormat) {
  date = new Date(dateFormat);
  day = date.getDate();
  month = date.getMonth() + 1;
  year = date.getFullYear();
  formattedDate = day + "-" + month + "-" + year;
  if(formattedDate=="NaN-NaN-NaN"){
    return "";
  } else{
   return formattedDate; 
  }
  
}
$(document).ready(function () {
  urlParam = new URLSearchParams(window.location.href);
  keyword = urlParam.get("keyword");
  if (keyword == null) {
    keyword = "";
  }

  $.ajax({
    type: "get",
    url: "admin.php?act=listCategory",
    data: {
      keyword: keyword,
    },
    success: function (response) {
      currentPage = urlParam.get("page");
      if (currentPage == null) {
        currentPage = 1; // trang hiện tại
      }
      arr = response.split("##-##");
      category = JSON.parse(arr[1]);

      categoryPerPage = 10; // số lượng sản phẩm trên mỗi trang
      totalCategory = category.length; // tổng số sản phẩm
      totalPages = Math.ceil(totalCategory / categoryPerPage); // tổng số trang
      startIndex = (currentPage - 1) * categoryPerPage;
      endIndex = startIndex + categoryPerPage;
      if (endIndex > totalCategory) {
        endIndex = totalCategory;
      }

      currentCategory = category.slice(startIndex, endIndex);

      if (category.length > 0) {
        htmls = [];
        currentCategory.forEach((item) => {
          html =
            `<tr id="` +
            item.id +
            `">
              <td class="idCategory">` +
            item.id +
            `</td>
              <td class="categoryParent">` +
            `</td>
              <td class="titleCategory">` +
            item.name +
            `
              <td class="nameCategory">` +
            item.title +
            `</td>
          
              <td class="containerBtn"><div class="d-flex"><a class="btn-edit edit" href="admin.php?act=editCategory&id=` +
            item.id +
            `"><i class="far fa-edit"></i></a>
             <button type="button" class="btn-remove remove" data-id="` +
            item.id +
            `"><i class="fas fa-trash-alt"></i></button>
              
             </div> </td>

          </tr>`;

          htmls.push(html);
        });
        $("#listCategory").html(htmls);

        if (currentPage > 1) {
          if (keyword != "") {
            $(
              '<a class="page-item page-link prev" href="admin.php?act=category&keyword=' +
                keyword +
                "&page=" +
                (currentPage - 1) +
                '">Trước đó</a>'
            ).appendTo("#paginationCategory");
          } else {
            $(
              '<a class="page-item page-link prev" href="admin.php?act=category&page=' +
                (currentPage - 1) +
                '">Trước đó</a>'
            ).appendTo("#paginationCategory");
          }
        }

        for (let i = 1; i <= totalPages; i++) {
          if (keyword != "") {
            $("#paginationCategory").append(
              '<li class="page-item page"><a class="page-link" href="admin.php?act=category&keyword=' +
                keyword +
                "&page=" +
                i +
                '">' +
                i +
                "</a></li>"
            );
          } else {
            $("#paginationCategory").append(
              '<li class="page-item page"><a class="page-link" href="admin.php?act=category' +
                "&page=" +
                i +
                '">' +
                i +
                "</a></li>"
            );
          }

          $("#paginationCategory li a").each(function (index) {
            if (index + 1 == currentPage) {
              $(this).attr("style", "background-color:orange");
            }
          });
        }
        if (currentPage < totalPages) {
          page = parseInt(currentPage) + 1;

          if (keyword != "") {
            $(
              '<a class="page-item page-link next" href="admin.php?act=category&keyword=' +
                keyword +
                "&page=" +
                page +
                '">Tiếp theo</a>'
            ).appendTo("#paginationCategory");
          } else {
            $(
              '<a class="page-item page-link next" href="admin.php?act=category&page=' +
                page +
                '">Tiếp theo</a>'
            ).appendTo("#paginationCategory");
          }
        }

        // chèn các thẻ HTML để hiển thị phân trang

        currentCategory.forEach((item) => {
          $.ajax({
            type: "get",
            url: "admin.php?act=getCategory",

            success: function (response) {
              arr = response.split("##-##");
              category = JSON.parse(arr[1]);
              category.forEach((cate)=>{
             
                if(cate.id==item.parent_id){
           
                  $("#listCategory #" + item.id +" .categoryParent").append(cate.name);
                }
              })
            },
          });
          if (item.status == 0) {
            i =
              '<button class="btn-hide hide" data-id="' +
              item.id +
              '"><i class="fas fa-eye"></i></button>';
            $("#listCategory #" + item.id).addClass("opacity-100");
          } else {
            i =
              '<button class="btn-hide hide" data-id="' +
              item.id +
              '"><i class="fas fa-eye-slash"></i></button>';
            $("#listCategory #" + item.id).addClass("opacity-25");
          }
          $("#listCategory #" + item.id + " .containerBtn .d-flex").append(
            i
          );

          $("#listCategory #" + item.id + " .hide").click(function () {
            dataId = $(this).data("id");
            $.ajax({
              type: "post",
              url: "admin.php?act=statusCategory",
              data: {
                id: dataId,
              },

              success: function (response) {
                arr = response.split("##-##");
                result = arr[1];

                if (result == 1) {
                  $("#listCategory #" + item.id + " .hide").html(
                    '<i class="fas fa-eye-slash"></i>'
                  );
                  $("#listCategory #" + item.id).attr(
                    "class",
                    "opacity-25"
                  );
                } else {
                  $("#listCategory #" + item.id + " .hide").html(
                    '<i class="fas fa-eye"></i>'
                  );
                  $("#listCategory #" + item.id).attr(
                    "class",
                    "opacity-100"
                  );
                }
              },
            });
          });

          $("#listCategory #" + item.id + " .remove").click(function () {
            dataId = $(this).data("id");
            $.ajax({
              type: "post",
              url: "admin.php?act=removeCategory",
              data: {
                id: dataId,
              },

              success: function (response) {
                arr = response.split("##-##");
                result = arr[1];

                if (result == "success") {
                  alert("Đã xóa danh mục");
                  window.location.reload();
                } else {
                  alert("Xóa danh mục thất bại");
                  window.location.reload();
                }
              },
            });
          });
        });
      }
    },

    //
  });
});
