<div class="m-5">
    <div class="d-flex row">
        <h3 class="fs-4 mb-3 col-lg-4">Danh Sách Tài Khoản</h3>
   
         <div class="col-lg-8">
                        <input type="search" name="keyword" class="form-control searchKey" placeholder="Nhập tài khoản người dùng hoặc email">

         </div>
     

    </div>

</div>



<div class="">
    <table class="table bg-white rounded shadow-sm  table-hover " id="listAccount">
        <thead>
            <tr>
                <th>Mã Tài Khoản
                </th>
                <th>Hình Ảnh</th>
                <th>Họ Và Tên</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Tên Người Dùng</th>
                <th>Vai Trò</th>
                <th>Ngày Tạo</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="listAccountUser">

        </tbody>
    </table>
</div>

<div>
    <ul id="paginationAccountUser" class="pagination"></ul>
</div>

<script>
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
    $(document).ready(function() {
        urlParam = new URLSearchParams(window.location.href);
        keyword = urlParam.get("keyword");
        if (keyword == null) {
            keyword = "";
        } else {
            $('input[name="keyword"]').val(keyword);
        }


        $.ajax({
            type: "get",
            url: "admin.php?act=listAccountUser",
            data: {
                keyword: keyword,
            },
            success: function(response) {
                currentPage = urlParam.get("page");
                if (currentPage == null) {
                    currentPage = 1; // trang hiện tại
                }
                arr = response.split("##-##");
                accountUser = JSON.parse(arr[1]);

                accountUserPerPage = 10; // số lượng sản phẩm trên mỗi trang
                totalAccountUser = accountUser.length; // tổng số sản phẩm
                totalPages = Math.ceil(totalAccountUser / accountUserPerPage); // tổng số trang
                startIndex = (currentPage - 1) * accountUserPerPage;
                endIndex = startIndex + accountUserPerPage;
                if (endIndex > totalAccountUser) {
                    endIndex = totalAccountUser;
                }

                currentAccountUser = accountUser.slice(startIndex, endIndex);

                if (accountUser.length > 0) {
                    htmls = [];
                    currentAccountUser.forEach((item) => {
                    
                        html =
                            `
                            <tr id=` + item.user_id + `>
                                    <td>` + item.user_id + `</td>
                                    <td class="containerImage">
                                    <div class="wrap">
                                <form enctype="multipart/form-data" id="editAvatarForm` + item.user_id + `">
                                <input type="hidden" name="id" value="` + item.user_id + `"/>
                                    <div class="profile">
                                        <div class="avatar" id="avatar">
                                            <div id="preview"><img id="avatar-image" class="avatar_img" src="./../Assets/img/` + item.image + `">
                                            </div>
                                            <div class="avatar_upload">
                                                <label class="upload_label">Tải lên
                                                    <input type="file" id="upload" name="uploadAvatar">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                                    </td>
                                    <td>` + item.fullName+ `</td>
                                    <td>` + item.phone + `</td>
                                    <td>` + item.email + `</td>
                                    <td>` + item.username + `</td>
                    


                                    <td class="role">
                                    </td>
                                    <td>
                                    ` + formatDate(item.date_create)  + `
                                    </td>
                                    <td class="containerBtn"><div class="d-flex"><a class="btn-edit edit" href="admin.php?act=editAccountUser&id=` +
                            item.user_id +
                            `"><i class="far fa-edit"></i></a>
             <button type="button" class="btn-remove remove" data-id="` +
                            item.user_id +
                            `"><i class="fas fa-trash-alt"></i></button>
                            <button type="button" class="btn-edit reset" data-id="` +
                            item.user_id +
                            `"><i class="fas fa-sync-alt"></i></button>
              
             </div> </td>

                                </tr>`;

                        htmls.push(html);
                    });
                    $("#listAccountUser").html(htmls);

                    if (currentPage > 1) {
                        if (keyword != "") {
                            $(
                                '<a class="page-item page-link prev" href="admin.php?act=accountUser&keyword=' +
                                keyword +
                                "&page=" +
                                (currentPage - 1) +
                                '">Trước đó</a>'
                            ).appendTo("#paginationAccountUser");
                        } else {
                            $(
                                '<a class="page-item page-link prev" href="admin.php?act=accountUser&page=' +
                                (currentPage - 1) +
                                '">Trước đó</a>'
                            ).appendTo("#paginationAccountUser");
                        }
                    }

                    for (let i = 1; i <= totalPages; i++) {
                        if (keyword != "") {
                            $("#paginationAccountUser").append(
                                '<li class="page-item page"><a class="page-link" href="admin.php?act=accountUser&keyword=' +
                                keyword +
                                "&page=" +
                                i +
                                '">' +
                                i +
                                "</a></li>"
                            );
                        } else {
                            $("#paginationAccountUser").append(
                                '<li class="page-item page"><a class="page-link" href="admin.php?act=accountUser' +
                                "&page=" +
                                i +
                                '">' +
                                i +
                                "</a></li>"
                            );
                        }

                        $("#paginationAccountUser li a").each(function(index) {
                            if (index + 1 == currentPage) {
                                $(this).attr("style", "background-color:orange");
                            }
                        });
                    }
                    if (currentPage < totalPages) {
                        page = parseInt(currentPage) + 1;

                        if (keyword != "") {
                            $(
                                '<a class="page-item page-link next" href="admin.php?act=accountUser&keyword=' +
                                keyword +
                                "&page=" +
                                page +
                                '">Tiếp theo</a>'
                            ).appendTo("#paginationAccountUser");
                        } else {
                            $(
                                '<a class="page-item page-link next" href="admin.php?act=accountUser&page=' +
                                page +
                                '">Tiếp theo</a>'
                            ).appendTo("#paginationAccountUser");
                        }
                    }

                    // chèn các thẻ HTML để hiển thị phân trang



                    currentAccountUser.forEach((item) => {

                        if (item.status == 0) {
                            i =
                                '<button class="btn-hide hide" data-id="' +
                                item.user_id +
                                '"><i class="fas fa-eye"></i></button>';
                            $("#listAccountUser #" + item.user_id).addClass("opacity-100");
                        } else {
                            i =
                                '<button class="btn-hide hide" data-id="' +
                                item.user_id +
                                '"><i class="fas fa-eye-slash"></i></button>';
                            $("#listAccountUser #" + item.user_id).addClass("opacity-25");
                        }
                        $.ajax({
                            type: "get",
                            url: "admin.php?act=getRole",
                            success: function(response) {
                                arr = response.split("##-##");
                                result = JSON.parse(arr[1]);
                                result.forEach((role) => {
                                    if (role.id == item.role_id) {
                                        $("#listAccountUser #" + item.user_id + " .role").html(role.name);
                                    }
                                })
                            }
                        });

                        $("#listAccountUser #" + item.user_id + " .containerBtn .d-flex").append(i);

                        $("#listAccountUser #" + item.user_id + " .hide").click(function() {
                            dataId = $(this).data("id");
                            $.ajax({
                                type: "post",
                                url: "admin.php?act=statusAccountUser",
                                data: {
                                    id: dataId,
                                },

                                success: function(response) {
                                    arr = response.split("##-##");
                                    result = JSON.parse(arr[1]);
                          

                                    if (result.status == 1) {
                                        $("#listAccountUser #" + item.user_id + " .hide").html(
                                            '<i class="fas fa-eye-slash"></i>'
                                        );
                                        $("#listAccountUser #" + item.user_id).attr("class", "opacity-25");
                                    } else {
                                        $("#listAccountUser #" + item.user_id + " .hide").html(
                                            '<i class="fas fa-eye"></i>'
                                        );
                                        $("#listAccountUser #" + item.user_id).attr("class", "opacity-100");
                                    }
                                },
                            });
                        });

                        $("#listAccountUser #" + item.user_id + " .remove").click(function() {
                            dataId = $(this).data("id");
                            $.ajax({
                                type: "post",
                                url: "admin.php?act=removeAccountUser",
                                data: {
                                    id: dataId,
                                },

                                success: function(response) {
                                    arr = response.split("##-##");
                                    result = arr[1];

                                    if (result == "success") {
                                        alert("Đã xóa tài khoản");
                                        window.location.reload();
                                    } else {
                                        alert("Xóa tài khoản thất bại");
                                        window.location.reload();
                                    }
                                },
                            });
                        });
                        $("#listAccountUser #" + item.user_id + " .reset").click(function() {
                            dataId = $(this).data("id");
                            $.ajax({
                                type: "post",
                                url: "admin.php?act=resetPasswordUser",
                                data: {
                                    id: dataId,
                                },

                                success: function(response) {
                                    arr = response.split("##-##");
                                    result = arr[1];

                                    if (result == "success") {
                                        alert("Cập nhật thành công");

                                    } else {
                                        alert("Cập nhật thất bại");

                                    }
                                },
                            });
                        });



                        $("#listAccountUser #" + item.user_id + " input[name='uploadAvatar']").change(function() {
                            data = new FormData(document.getElementById("editAvatarForm"+item.user_id));

                         

                            $.ajax({
                                url: "admin.php?act=uploadAvatarUser",
                                method: "POST",
                                data: data,
                                contentType: false,
                                processData: false,
                                success: function(response) {
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
                                        $("#listAccountUser #" + item.user_id +" #avatar-image").attr("src", "./../Assets/img/" + result.image);
                                        $("#listAccountUser #" + item.user_id +" #infoAdmin img").attr('src', "./../Assets/img/" + result.image);
                                    }
                                },
                            });
                        });
                    });
                }

            },


            //
        });


$(document).on("input", '.searchKey',function () {

    keyword = $(this).val();
    $.ajax({
            type: "get",
            url: "admin.php?act=listAccountUser",
            data: {
                keyword: keyword,
            },
            success: function(response) {
                currentPage = urlParam.get("page");
                if (currentPage == null) {
                    currentPage = 1; // trang hiện tại
                }
                arr = response.split("##-##");
                accountUser = JSON.parse(arr[1]);

                accountUserPerPage = 10; // số lượng sản phẩm trên mỗi trang
                totalAccountUser = accountUser.length; // tổng số sản phẩm
                totalPages = Math.ceil(totalAccountUser / accountUserPerPage); // tổng số trang
                startIndex = (currentPage - 1) * accountUserPerPage;
                endIndex = startIndex + accountUserPerPage;
                if (endIndex > totalAccountUser) {
                    endIndex = totalAccountUser;
                }

                currentAccountUser = accountUser.slice(startIndex, endIndex);

                if (accountUser.length > 0) {
                    htmls = [];
                    currentAccountUser.forEach((item) => {
                        html =
                            `
                            <tr id=` + item.user_id + `>
                                    <td>` + item.user_id + `</td>
                                    <td class="containerImage">
                                    <div class="wrap">
                                <form enctype="multipart/form-data" id="editAvatarForm">
                                <input type="hidden" name="id" value="` + item.user_id + `"/>
                                    <div class="profile">
                                        <div class="avatar" id="avatar">
                                            <div id="preview"><img id="avatar-image" class="avatar_img" src="./../Assets/img/` + item.image + `">
                                            </div>
                                            <div class="avatar_upload">
                                                <label class="upload_label">Tải lên
                                                    <input type="file" id="upload" name="uploadAvatar">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                                    </td>
                                    <td>` + item.Last_name + " " + item.First_name + `</td>
                                    <td>` + item.phone + `</td>
                                    <td>` + item.email + `</td>
                                    <td>` + item.username + `</td>
                    


                                    <td class="role">
                                    </td>
                                    <td>
                                    ` + item.date_create + `
                                    </td>
                                    <td class="containerBtn"><div class="d-flex"><a class="btn-edit edit" href="admin.php?act=editAccountUser&id=` +
                            item.user_id +
                            `"><i class="far fa-edit"></i></a>
             <button type="button" class="btn-remove remove" data-id="` +
                            item.user_id +
                            `"><i class="fas fa-trash-alt"></i></button>
                            <button type="button" class="btn-edit reset" data-id="` +
                            item.user_id +
                            `"><i class="fas fa-sync-alt"></i></button>
              
             </div> </td>

                                </tr>`;

                        htmls.push(html);
                    });
                    $("#listAccountUser").html(htmls);

                    // if (currentPage > 1) {
                    //     if (keyword != "") {
                    //         $(
                    //             '<a class="page-item page-link prev" href="admin.php?act=accountUser&keyword=' +
                    //             keyword +
                    //             "&page=" +
                    //             (currentPage - 1) +
                    //             '">Trước đó</a>'
                    //         ).appendTo("#paginationAccountUser");
                    //     } else {
                    //         $(
                    //             '<a class="page-item page-link prev" href="admin.php?act=accountUser&page=' +
                    //             (currentPage - 1) +
                    //             '">Trước đó</a>'
                    //         ).appendTo("#paginationAccountUser");
                    //     }
                    // }

                    // for (let i = 1; i <= totalPages; i++) {
                    //     if (keyword != "") {
                    //         $("#paginationAccountUser").append(
                    //             '<li class="page-item page"><a class="page-link" href="admin.php?act=accountUser&keyword=' +
                    //             keyword +
                    //             "&page=" +
                    //             i +
                    //             '">' +
                    //             i +
                    //             "</a></li>"
                    //         );
                    //     } else {
                    //         $("#paginationAccountUser").append(
                    //             '<li class="page-item page"><a class="page-link" href="admin.php?act=accountUser' +
                    //             "&page=" +
                    //             i +
                    //             '">' +
                    //             i +
                    //             "</a></li>"
                    //         );
                    //     }

                    //     $("#paginationAccountUser li a").each(function(index) {
                    //         if (index + 1 == currentPage) {
                    //             $(this).attr("style", "background-color:orange");
                    //         }
                    //     });
                    // }
                    // if (currentPage < totalPages) {
                    //     page = parseInt(currentPage) + 1;

                    //     if (keyword != "") {
                    //         $(
                    //             '<a class="page-item page-link next" href="admin.php?act=accountUser&keyword=' +
                    //             keyword +
                    //             "&page=" +
                    //             page +
                    //             '">Tiếp theo</a>'
                    //         ).appendTo("#paginationAccountUser");
                    //     } else {
                    //         $(
                    //             '<a class="page-item page-link next" href="admin.php?act=accountUser&page=' +
                    //             page +
                    //             '">Tiếp theo</a>'
                    //         ).appendTo("#paginationAccountUser");
                    //     }
                    // }

                    // chèn các thẻ HTML để hiển thị phân trang



                    
                }

            },


            //
        });
    
});





    });
</script>