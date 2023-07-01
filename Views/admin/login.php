<div class="sectionLogin">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Đăng nhập</h3>
                   
                </div>
                <div class="card-body">
                    <form method="post" id="loginForm">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user" style="color:orange"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="username" name="username" required>
                        </div>
                        <div class="errUsername text-danger"></div>
                        <div class="input-group form-group group-password">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key" style="color:orange"></i></span>
                            </div>
                            <input type="password" class="form-control password" placeholder="password" name="password">
                            <button type="button" class="btn-showPass"><i class="far fa-eye"></i></button>

                        </div>
                 
                       
                        <div class="form-group">
                           <button type="submit" class="btn btn-login">Đăng Nhập</button>
                        </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>

    <script src="./../Assets/js/jquery/admin/jqueryLogin.js"></script>