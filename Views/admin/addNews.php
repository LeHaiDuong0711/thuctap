<div class="sectionEditProduct">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Thêm Tin Tức</h3>

        </div>
        <!-- <a href="admin.php?use=import-file" class="float-end "><i class="fa fa-file-import"></i> Import File</a> -->

    </div>



    <div class="row">
        <form id="addNewsForm" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-lg-8">
                    <label for="inputTitleNews" class="form-label">Tiêu đề</label>
                    <textarea class="form-control title" name="title" id="inputTitleNews" rows="2">

                    </textarea>
                </div>
                <div class="col-lg-4">
                    <label for="typeProduct" class="form-label">Danh mục</label>
                    <select id="category" class="form-select" name="category" value="">
                        <option value=0>Chọn</option>

                    </select>
                </div>
                <div class="col-lg-4">

                    <label for="imageProduct" class="form-label">Hình Ảnh</label>

                    <div class="wrap">
                        <div class="profile">
                            <div class="image_product" id="avatar">
                                <div id="preview"><img id="avatar-image" class="avatar_img" src="./../Assets/img/default.jpg">
                                </div>
                                <div class="avatar_upload">
                                    <label class="upload_label">Upload
                                        <input type="file" id="upload" name="uploadImageNews">
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>






                </div>

                <div class="col-lg-8">
                    <label for="inputDescriptionNews" class="form-label">Mô Tả Ngắn</label>
                    <textarea class="form-control description" name="description" id="inputDescriptionNews" rows="10">

                    </textarea>
                </div>
                <div class="col-12">
                    <label for="inputContentNews" class="form-label">Nội dung</label>
                    <textarea class="form-control description" name="content" id="inputContentNews" rows="50">

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
        $(document).on("click", "#back", function() {
            window.history.back();
        });

        // $.ajax({
        //     type: "get",
        //     url: "admin.php?act=categoryChild",

        //     success: function(response) {
        //         arr = response.split("##-##");
        //         arrCategory = JSON.parse(arr[1]);
        //         htmls = ['<option id=0 value=0>Chọn</option>']
        //         arrCategory.forEach((item) => {
        //             html = '<option id=' + item.id + ' value=' + item.id + '>' + item.name + '</option>'
        //             htmls.push(html);
        //         })

        //         $('#category').html(htmls);
        //     }
        // });
    });
</script>