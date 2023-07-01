<?php
//index.php

$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if (isset($_POST["submit"])) {
	if (empty($_POST["name"])) {
		$error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
	} else {
		$name = clean_text($_POST["name"]);
		if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
			$error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
		}
	}
	if (empty($_POST["email"])) {
		$error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
	} else {
		$email = clean_text($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error .= '<p><label class="text-danger">Invalid email format</label></p>';
		}
	}
	// if(empty($_POST["subject"]))
	// {
	// 	$error .= '<p><label class="text-danger">Subject is required</label></p>';
	// }
	// else
	// {
	// 	$subject = clean_text($_POST["subject"]);
	// }
	if (empty($_POST["message"])) {
		$error .= '<p><label class="text-danger">Message is required</label></p>';
	} else {
		$message = clean_text($_POST["message"]);
	}
	if ($error == '') {
		$mail = new PHPMailer;
		$mail->IsSMTP();								//Sets Mailer to send message using SMTP
		$mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port = 587;								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = 'haiduong07112k3@gmail.com';					//Sets SMTP username
		$mail->Password = 'nedfmpujtfeoergu'; //Phplytest20@php					//Sets SMTP password
		$mail->SMTPSecure = 'tls';							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->From = "haiduong07112k3@gmail.com";					//Sets the From email address for the message
		$mail->FromName = "HiddenFruitsShop";				//Sets the From name of the message
		$mail->AddAddress("haiduong07112k3@gmail.com", $_POST['name']);		//Adds a "To" address
		//$mail->AddCC($_POST["email"], $_POST["name"]);	//Adds a "Cc" address
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->IsHTML(true);							//Sets message type to HTML				
		$mail->Subject = "Feedback from customers";				//Sets the Subject of the message
		$mail->Body = "Email: " . $_POST["email"] . "
						=>Content:" . $_POST["message"];				//An HTML or plain text message body
		if ($mail->Send())								//Send an Email. Return true on success or false on error
		{
			$error = '<label class="text-success">Thank you for contacting us</label>';
		} else {
			$error = '<label class="text-danger">There is an Error</label>';
		}
		$name = '';
		$email = '';
		$subject = '';
		$message = '';
	}
}

?>
<section class="sectionContact">
	<iframe class="mb-5" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3017743992777!2d106.62078854961354!3d10.78818329227582!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752c06abeab0d9%3A0x7f20262dd55f6c84!2zMTIgVsO1IEhvw6BuaCwgUGjDuiBUaOG7jSBIb8OgLCBUw6JuIFBow7osIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sfr!2s!4v1678328064058!5m2!1sfr!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	<div class="row">
		<div class="col-lg-6 col-sm-12 info">
			<div class="col-inner">
				<h4><span>Liên Hệ Với Hidden Foot Shop</span></h3>
					<ul>
						<li><a href="https://goo.gl/maps/LYfAifHVSHyJGqGPA"><i class="fas fa-map-marker-alt"></i>12 Võ Hoành, Phú Thọ Hòa, Tân Phú, TP.HCM</li></a>
						<li><a href="tel:19001008"><i class="fa fa-phone"></i> 19001008</a></li>
						<li><a href="mailto:footshophidden@gmail.com"><i class="fas fa-envelope-open-text"></i>footshophidden@gmail.com</a></li>
						<li>
							<a href="https://www.facebook.com/" class="fab fa-facebook"></a>
							<a href="https://www.youtube.com/" class="fab fa-youtube"></a>
							<a href="https://www.instagram.com/" class="fab fa-instagram"></a>
							<a href="https://www.google.com/" class="fab fa-google"></a>
							<a href="https://www.linkedin.com/" class="fab fa-linkedin"></a>
							<a href="https://twitter.com/" class="fab fa-twitter"></a>
						</li>
					</ul>
			</div>
		</div>
		<div class="col-lg-6 col-sm-12 sendInfo">
			<?php echo $error ?>
			<form method="post" class="border border-success p-3">
				<h4>Liên Hệ Tư Vấn Mua Hàng</h1>
					<div>
						<input class="form-control mt-3" type="text" name="name" id="" placeholder="Họ Và Tên Của Ban...">
					</div>
					<div>
						<input class="form-control mt-3" type="email" name="email" id="" placeholder="Email Của Ban...">
					</div>
					<div>
						<textarea class="form-control mt-3" name="message" id="" rows="5" placeholder="Nội dung cần tư vấn..."></textarea>

					</div>
					<div>
						<input class="form-control mt-3" type="submit" name="submit" id="" value="Gửi Liên Hệ">
					</div>
			</form>
		</div>
	</div>
	<hr class="mt-5">
</section>