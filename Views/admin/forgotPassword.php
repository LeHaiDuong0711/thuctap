<div class="sectionForgotPassword">
<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Forgot Password</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
           
				<form action="admin.php?act=auth&use=resetPassword" method="post">
					
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" name="password" class="form-control" placeholder="password" required >
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" name="passwordAgain" class="form-control" placeholder="password again" required >
					</div>
					
					<div class="form-group">
						<input type="submit" value="Áp dụng" name="submit" class="btn float-right btn-login">
					</div>


					
				</form>
			</div>
			<div class="card-footer">
				
				<div class="d-flex justify-content-center links">
				You don't want to continue?<a href="admin.php?act=auth&use=login">Back</a>
				</div>
			</div>
		</div>
	</div>
    </div>