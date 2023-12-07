<!DOCTYPE html>
<html>

<head>
	<title>Login</title>
	<?php $this->load->view('css'); ?>
	<style>
		html,
		body {
			height: 100%;
		}

		.container {
			height: 100%;
		}

		.bg-form-login{
			border-color: #F4F5F9;
			background-color: #F4F5F9;
		}
	</style>
</head>

<body class="bg-gradient-primary position-relative" style="overflow: hidden;">
	<img id="foto-1" src="<?= base_url() ?>asset/image/fitri-2.png" alt="homepage" class="img-fluid position-absolute" style="top: -11%; left: -7%;" />
	<img id="foto-2" src="<?= base_url() ?>asset/image/girl-1.png" alt="homepage" class="img-fluid position-absolute" style="right: 0; top: 23%;" />
	<div class="container">
		<div class="h-100 row align-items-center justify-content-center text-center">
			<div class="col-12">
				<img src="<?= base_url() ?>asset/images/logo-basic.png" alt="homepage" class="dark-logo text-center" width="169px" height="100px" />
				<div class="card my-5 shadow-lg d-block mx-auto py-5 px-5" style="max-width: 27rem; border-radius: 1rem !important;">
					<div class="card-body p-0">
						<div class="text-center mb-4">
							<h5 class="font-weight-bold">Login Antrian</h5>
							<h5>Student Service Center</h5>
						</div>
						<form id="form-login" method="post">
							<div class="form-group">
								<input type="text" class="form-control py-2 bg-form-login text-muted" name="username" placeholder="Username">
							</div>
							<div class="form-group">
								<input type="password" class="form-control py-2 bg-form-login text-muted" name="password" placeholder="Password">
							</div>
							<button type="button" class="btn btn-ssc mt-3 w-100 py-2" onclick="login()">Login</button>
						</form>
					</div>
				</div>
			</div>


		</div>
	</div>
	<?php $this->load->view('script'); ?>
	<script type="text/javascript">
		// Execute a function when the user releases a key on the keyboard
		// input.addEventListener("keyup", function(event) {
		// Cancel the default action, if needed
		// event.preventDefault();
		// Number 13 is the "Enter" key on the keyboard
		// if (event.keyCode === 13) {
		// Trigger the button element with a click
		// login();
		// }
		// }); 


		function login() {
			var data = $('#form-login').serialize();
			$.ajax({
				url: '<?= site_url("login/cek_login") ?>',
				data: data,
				type: 'POST',
				dataType: 'JSON',
				success: function(response) {
					if (response == 1) {
						location.replace('<?= site_url('dashboard'); ?>');
					} else if (response == 2) {
						alert('Komputer tidak terdaftar sebagai loket pendaftaran, segera hubungi admin');
					} else if (response == 3) {
						location.replace('<?= site_url('admin'); ?>');
					} else {
						alert("Password atau username salah atau tidak terdaftar");
					}
				}
			});

		}
	</script>
</body>

</html>