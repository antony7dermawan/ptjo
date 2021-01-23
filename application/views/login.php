<?php
// Cek apakah terdapat session nama message
if($this->session->flashdata('message')){ // Jika ada
	echo '<div class="alert alert-danger">'.$this->session->flashdata('message').'</div>'; // Tampilkan pesannya
}
?>

<form class="login100-form validate-form flex-sb flex-w" method="post" action="<?php echo base_url('auth/login'); ?>">
					<span class="login100-form-title p-b-32">
						Login Sistem
					</span>

					<span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
						<input class="input100" type="text" name="username" >
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="password" >
						<span class="focus-input100"></span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>

				</form>
