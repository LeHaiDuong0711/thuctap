<div class="sectionVeriForgotPassword">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Đổi mật khẩu</h3>

			</div>
			<div class="card-body">

				<form action="index.php?act=change_action" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
						</div>
						<input type="email" name="email" class="form-control" placeholder="nhập email">
					</div>
					<div class="text-danger errEmail"></div>

					<div class="form-group">
						<input type="submit" name="submit" value="Tiếp tục" class="btn float-right btn-login">
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