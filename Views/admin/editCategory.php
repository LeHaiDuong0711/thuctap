<div class="sectionEditProduct">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Chỉnh Sửa danh mục</h3>
        </div>

    </div>
    <div class="row">
        <form method="post" id="editCategoryForm">
            <div class="row">

                <div class="col-lg-3">
                    <label for="idCategory" class="form-label">Mã Danh Mục</label>
                    <input type="number" name="idCategory" class="form-control" id="idCategory" value="" readonly />
                </div>
                <div class="col-lg-3">
                    <label for="categoryParent" class="form-label">Danh mục cha</label>
                    <select id="category" class="form-select categoryParent" name="parentId">
                        <option value="0"></option>


                    </select>
                </div>

                <div class="col-lg-3">
                    <label for="nameCategory" class="form-label">Tên danh mục</label>
                    <input type="text" name="nameCategory" class="form-control" id="nameCategory" value="" />
                </div>
                <div class="col-lg-3">
                    <label for="titleCategory" class="form-label">Đường dẫn</label>
                    <input type="text" name="titleCategory" class="form-control" id="titleCategory" value="" />
                </div>
                <div class="mt-5">
                    <button class="btn-save float-end"><i class="far fa-save"></i></button><button id="back" type="button" class="btn-cancel float-end"><i class="fas fa-window-close"></i></button>
                </div>
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
            url: "admin.php?act=editCategory_act",
            data: {
                id: id
            },

            success: function(response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);

                $('#idCategory').val(result.id);
                $('#nameCategory').val(result.name);
                $('#titleCategory').val(result.title);
                $.ajax({
                    type: "get",
                    url: "admin.php?act=getCategory",

                    success: function(response) {
                        arr = response.split("##-##");
                        arrCategory = JSON.parse(arr[1]);

                        // showCategories(arrCategory)
                        function showCategories(arrCategory, parent_id = 0, char = '') {
                            arrCategory.forEach((item, key) => {
                                if (id != item.id) {
                                    if (item.parent_id == parent_id) {

                                        $('#category').append($('<option>', {
                                            value: item.id,
                                            html: char + item['name']
                                        }));

                                        delete arrCategory[key];

                                        showCategories(arrCategory, item.id, char + '|---');
                                    }

                                }

                            })


                        }
                        $('#category').append(showCategories(arrCategory))
                        

                      $("#category option").each((index,value)=>{
                
                        if(value.value==result.parent_id){
                            value.selected= true
                    
                        }

                      })
                    }
                });

            }
        });


        $('#editCategoryForm').submit(function(e) {
            e.preventDefault();
            data = $(this).serialize();
      
            $.ajax({
                type: "post",
                url: "admin.php?act=editCategory_action",
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