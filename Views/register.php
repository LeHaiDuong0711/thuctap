<div class="sectionRegister">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Đăng Ký</h3>

			</div>
			<div class="card-body">
				<form id="registerForm" method="post">

					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" name="fullName" class="form-control" placeholder="Họ và tên">

					</div>
					<div>
						<div class="text-danger errFullName"></div>
					</div>

					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" name="username" class="form-control" placeholder="Tên tài khoản người dùng">

					</div>
					<div>
						<div class="text-danger errUsername"></div>
					</div>
					<div class="input-group form-group group-password">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input style="  border-radius: 0 5px 5px 0;" type="password" name="password" class="form-control password" placeholder="Mật khẩu">
						<button type="button" class="btn-showPass"><i class="far fa-eye"></i></button>
					</div>

					<div class="text-danger errPassword">
					</div>
					<div class="input-group form-group group-password">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>

						<input style=" border-radius: 0 5px 5px 0;" type="password" name="passwordAgain" class="form-control password" placeholder="Nhập lại mật khẩu">
						<button type="button" class="btn-showPass"><i class="far fa-eye"></i></button>


					</div>

					<div class="text-danger errPasswordAgain"></div>

					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-phone"></i></span>
						</div>
						<input type="text" name="phone" class="form-control" placeholder="Số điện thoại">


					</div>
					<div>
						<div class="text-danger errPhone"></div>
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
						</div>
						<input type="email" name="email" class="form-control" placeholder="email">


					</div>
					<div>
						<div class="text-danger errEmail"></div>
					</div>
					<div class="form-group">
						<button type="submit" name="submit" class="btn float-right btn-login">Đăng Ký</button>
					</div>
				</form>
			</div>
			<div class="card-footer">

				<div class="d-flex justify-content-center links">
					Bạn đã có tài khoản?<a href="index.php?act=login">Đăng nhập</a>
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