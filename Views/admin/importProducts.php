<div class="sectionEditProduct">
    <div class="my-5">
        <div class="d-flex">
            <h3 class="fs-4 mb-3">Import</h3>

        </div>
    </div>


    <div class="row">
        <form action="admin.php?use=import-action" method="post" enctype="multipart/form-data">


            <div class="col-5">
                <label for="file" class="form-label">File</label>
                <input type="file" name="file" class="form-control" id="file" value="" />
            </div>
            <div class="mt-3">
                <button class="btn-edit" type="submit" name="submit_file">import</button>
            </div>
        </form>

    </div>

</div>
<script src="./../Assets/js/jquery/admin/jqueryListProducts.js"></script>