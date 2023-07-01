<div class="container" id="sectionProfile">
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile">
                            <div class="wrap">
                                <form enctype="multipart/form-data" id="editAvatarForm">
                                    <div class="profile">
                                        <div class="avatar" id="avatar">
                                            <div id="preview"><img id="avatar-image" class="avatar_img">
                                            </div>
                                            <div class="avatar_upload">
                                                <label class="upload_label">Upload
                                                    <input type="file" id="upload" name="uploadAvatar">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <h5 class="username"></h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <form id="editProfileForm">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Thông tin chi tiết</h6>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Họ và tên</label>
                                    <input type="text" class="form-control" id="fullName" name="fullName" readonly>
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" readonly>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phoneNumber">Số điện thoại</label>
                                    <input type="number" class="form-control" id="phoneNumber" name="phoneNumber" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row gutters mt-5">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right container-btn">
                                    <button type="button" id="editProfile" name="submit" class="btn-edit"><i class="far fa-edit"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./../Assets/js/jquery/admin/jqueryProfile.js"></script>