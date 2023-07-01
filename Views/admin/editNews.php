<div class="sectionEditNews" id="sectionEditNews">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Sửa tin tức</h3>

        </div>

    </div>

    <div class="row">
        <form id="editNewsForm" method="post" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="id" id="idNews">
                <div class="col-lg-8">
                    <label for="inputTitleNews" class="form-label">Tiêu đề</label>
                    <textarea class="title form-control" name="title" id="inputTitleNews" rows="2">

                    </textarea>
                </div>
                <div class="col-lg-4">
                    <label for="typeProduct" class="form-label">Danh mục</label>
                    <select id="category" class="form-select" name="category">


                    </select>
                </div>
                <div class="col-lg-4">

                    <label for="imageProduct" class="form-label">Hình Ảnh</label>
                    <input type="hidden" id="imgOld" name="imgOld" value="">
                    <div class="wrap">
                        <div class="profile">
                            <div class="image_product" id="avatar">
                                <div id="preview"><img id="avatarNews" class="avatar_img">
                                </div>
                                <div class="avatar_upload">
                                    <label class="upload_label">Upload
                                        <input type="file" id="upload" name="newImageNews">
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>






                </div>

                <div class="col-lg-8">
                    <label for="inputDescriptionNews" class="form-label">Mô Tả Ngắn</label>
                    <textarea class="form-control" name="description" id="inputDescriptionNews" rows="14">

                    </textarea>
                </div>
                <div class="col-12">
                    <label for="inputContentNews" class="form-label">Nội dung</label>
                    <textarea class="form-control description " name="content" id="inputContentNews" rows="30">

                    </textarea>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn-save float-end"><i class="far fa-save"></i></button><button id="back" type="button" class="btn-cancel float-end"><i class="fas fa-window-close"></i></button>
            </div>
        </form>

    </div>
</div>

<script>
    $(document).ready(function() {
        urlParam = new URLSearchParams(window.location.href);
        id = urlParam.get('id');
        $.ajax({
            type: "get",
            url: "admin.php?act=editNews_act",
            data: {
                id: id
            },

            success: function(response) {
                arr = response.split("##-##");
                result = JSON.parse(arr[1]);
                $('#idNews').val(result.id);
                $('#inputTitleNews').html(result.title);
                $('#inputDescriptionNews').html(result.description);
                $('#inputContentNews').html(result.content);
                $('#imgOld').val(result.image);
                $('#avatarNews').attr('src', "./../Assets/img/" + result.image);

                // $.ajax({
                //     type: "get",
                //     url: "admin.php?act=categoryChild",

                //     success: function(response) {
                //         arr = response.split("##-##");
                //         arrCategory = JSON.parse(arr[1]);
                //         htmls = ['<option value=0 id=0>Chọn</option>']
                //         arrCategory.forEach((item) => {
                //             html = '<option id=' + item.id + ' value=' + item.id + '>' + item.name + '</option>'
                //             htmls.push(html);

                //         })
                //         $('#category').html(htmls);

                //         $('#category option').each(function(index, item) {
                //             if (result.idCategoryMultiple == item.id) {

                //                 $('#category #' + item.id).attr('selected', true)
                //             }
                //         })

                //     }
                // });
                $.ajax({
                    type: "get",
                    url: "admin.php?act=getCategory",

                    success: function(response) {
                        arr = response.split("##-##");
                        arrCategory = JSON.parse(arr[1]);

                        // showCategories(arrCategory)
                        function showCategories(arrCategory, parent_id = 0, char = '') {
                            arrCategory.forEach((item, key) => {
                                if (item.parent_id == parent_id) {

                                    $('#category').append($('<option>', {
                                        value: item.id,
                                        html: char + item['name']
                                    }));

                                    delete arrCategory[key];

                                    showCategories(arrCategory, item.id, char + '|---');
                                }
                            })

                        }
                      




                        $('#category').html(showCategories(arrCategory))
                    }
                });
            }
        });



        $("input[name='newImageNews']").change(function() {
            file = $(this)[0].files[0];
            fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onloadend = function(e) {
                $("#avatarNews").attr("src", e.target.result);
            };
        });

        $('#editNewsForm').submit(function(e) {
            e.preventDefault();
            data = new FormData(this);
            $.ajax({
                type: "post",
                url: "admin.php?act=editNews_action",
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    arr = response.split("##-##");
                    result = arr[1];
                    if (result == "success") {
                        alert('cập nhật thành công')
                    } else {
                        alert('cập nhật thất bại')
                    }
                }
            });
        });
        $(document).on("click", "#back", function() {
            window.history.back();
        });
    });
</script>