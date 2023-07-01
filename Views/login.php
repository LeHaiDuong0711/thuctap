<div class="sectionLogin">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Đăng Nhập</h3>
                <div class="d-flex justify-content-end social_icon">

                    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                    </fb:login-button>
                    <!-- <span><a href="https://www.facebook.com/dialog/oauth?client_id=1966806493681346&redirect_uri=https://fruitshops.local/fruitShops/index.php?act=loginFb&scope=public_profile,email"><i class="fab fa-facebook-f"></i></a></span>  -->

                </div>
            </div>
            <div class="card-body">
                <form id="loginForm" method="post">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user" style="color: #7ddd00;"></i></span>
                        </div>
                        <input type="text" id="usernameLogin" class="form-control text-success" placeholder="Tên đăng nhập hoặc email" name="usernameLogin">

                    </div>
                    <div class="errUsernameLogin text-danger"></div>
                    <div class="input-group form-group group-password">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key" style="color: #7ddd00;"></i></span>
                        </div>
                        <input style="border-radius:0 5px 5px 0" type="password" id="passwordLogin" class="form-control password" placeholder="Mật Khẩu" name="passwordLogin">
                        <button type="button" class="btn-showPass"><i class="far fa-eye"></i></button>
                    </div>
                    <div class="errPasswordLogin text-danger"></div>
                 
                    <div class="form-group">
                        <button type="submit" class="btn btn-login">Đăng Nhập</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    Bạn Chưa Có Tài Khoản? <a href="index.php?act=register">Đăng Ký</a>
                </div>
                <div class="d-flex justify-content-center links">
                    <a href="index.php?act=changePassword">Đổi mật khẩu?</a>
                </div>
                <div class="d-flex justify-content-center links">
                    <a href="index.php?act=forgotPassword">Quên mật khẩu?</a>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function saveAccessToken(accessToken) {

        localStorage.setItem('accessToken', accessToken);
    }

    function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().  

        // The current login status of the person.
        if (response.status === 'connected') { // Logged into your webpage and Facebook.
            Login(response.authResponse.accessToken);
            saveAccessToken(response.authResponse.accessToken)
        }
    }


    function checkLoginState() { // Called when a person is finished with the Login Button.
        FB.getLoginStatus(function(response) { // See the onlogin handler
            statusChangeCallback(response);
        });
    }


    window.fbAsyncInit = function() {
        FB.init({
            appId: '1966806493681346',
            cookie: true, // Enable cookies to allow the server to access the session.
            xfbml: true, // Parse social plugins on this webpage.
            version: 'v17.0' // Use this Graph API version for this call.
        });


        FB.getLoginStatus(function(response) { // Called after the JS SDK has been initialized.
            statusChangeCallback(response); // Returns the login status.
        });
    };

    function Login(accessToken) { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
        FB.api('/me', {
            locale: 'en_US',
            fields: 'id,first_name,last_name,birthday,email,locale,picture',
            accessToken: accessToken
        }, function(response) {
            if (response.id != null) {
                $.ajax({
                    type: "post",
                    url: "index.php?act=loginFb",
                    data: {
                        id: response.id,
                        fullName: response.last_name+" "+response.first_name,
                        image: response.picture.data.url,
                        email: response.email,
                    },

                    success: function(response) {
                        arr = response.split("##-##");
                        result = arr[1]
                        if (result == "success") {
                            window.location.href = "index.php?act=home"
                        } else {
                            alert("Đăng nhập bằng facebook bị lỗi")
                        }
                    }
                });
            }


        });
    }
</script>