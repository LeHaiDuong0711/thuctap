<div class="sectionForgotPassword">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Quên mật khẩu</h3>

			</div>
			<div class="card-body">

				<form action="index.php?act=resetPassword" method="post">

					<div class="input-group form-group group-password">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input style="  border-radius: 0 5px 5px 0;" type="password" name="password" class="form-control password" placeholder="Mật khẩu" required>
						<button type="button" class="btn-showPass"><i class="far fa-eye"></i></button>

					</div>
					<div class="text-danger errPassword"></div>
					<div class="input-group form-group group-password">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input style="  border-radius: 0 5px 5px 0;" type="password" name="passwordAgain" class="form-control password" placeholder="Nhập lại mật khẩu" required>
						<button type="button" class="btn-showPass"><i class="far fa-eye"></i></button>
					</div>
					<div class="text-danger errPasswordAgain"></div>
					<div class="form-group">
						<input type="submit" value="Áp dụng" name="submit" class="btn float-right btn-login">
					</div>



				</form>
			</div>
			<div class="card-footer">

				<div class="d-flex justify-content-center links">
					Bạn có muốn tiếp tục không?<button class="back btn-back">Trở lại</button>
				</div>
			</div>
		</div>
	</div>
</div>