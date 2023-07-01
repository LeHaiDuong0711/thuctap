<div class="sectionVeriForgotPassword">
<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Quên mật khẩu</h3>
				
			</div>
			<div class="card-body">
           
				<form action="index.php?act=updatePassword" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="number" name="otp" class="form-control" placeholder="enter otp" required >
					</div>
					
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