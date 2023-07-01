<div class="sectionEditProduct">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Chỉnh Sửa Tài Khoản</h3>
        </div>

    </div>
    <div class="row">

        <form method="post" id="editAccountUserForm">
            <div class="row">

                <div class="col-lg-2">
                    <label for="userId" class="form-label">Mã Tài Khoản</label>
                    <input type="number" name="userId" class="form-control" id="userId" value="" readonly />
                </div>
               
                <div class="col-lg-2">
                    <label for="fullName" class="form-label">Tên</label>
                    <input type="text" name="fullName" class="form-control" id="fullName" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="username" class="form-label">Tên Người Dùng</label>
                    <input type="text" name="username" class="form-control" id="username" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="phone" class="form-label">Số Điện Thoại</label>
                    <input type="number" name="phone" class="form-control" id="phone" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="" />
                </div>
                <div class="col-lg-2">
                    <label for="roleUser" class="form-label">Vai Trò</label>
                    <select id="roleUser" class="form-select" name="roleUser">
                    </select>
                </div>
                <!-- <div class="col-lg-3">
                    <label for="password" class="form-label">Mật Khẩu</label>
                    <input type="text" name="password" class="form-control" id="password" value="" />
                </div> -->

            </div>
            <div class="float-end mt-5">
                <button class="btn-save"><i class="far fa-save"></i></button><button id="back" type="button" class="btn-cancel float-end"><i class="fas fa-window-close"></i></button>
            </div>


        </form>

    </div>

</div>

<script>
    $(document).ready(function() {
        urlParam = new URLSearchParams(window.location.href);
        id = urlParam.get("id");
        $.ajax({
            type: "get",
            url: "admin.php?act=editAccountUser_act",
            data: {
                id: id
            },

            success: function(response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);
                account = result.account;
                role = result.role;
                $('#userId').val(account.user_id);
              
                $('#fullName').val(account.fullName);
                $('#email').val(account.email);
                // $('#password').val(account.password);
                $('#username').val(account.username);
                $('#phone').val(account.phone);

                role.forEach((item) => {
                    $('#roleUser').append(
                        ` <option id=` + item.id + ` value=` + item.id + `>` + item.name + `</option>`
                    );
                    if (account.role_id == item.id) {

                        $('#roleUser #' + item.id).attr('selected', true)
                    }
                })

            }
        });
        $('#editAccountUserForm').submit(function(e) {
            e.preventDefault();
            data = $(this).serialize();
            data += "&id=" + id;
            $.ajax({
                type: "post",
                url: "admin.php?act=editAccountUser_action",
                data: data,
                success: function(response) {
                    arr = response.split("##-##");


                    if (arr[1] == "success") {
                        alert("cập nhật thành công")
                    } else {
                        alert("cập nhật thất bại")
                    }
                }
            });
        });
        $(document).on("click", "#back", function() {
            window.history.back();
        });
    });
</script>