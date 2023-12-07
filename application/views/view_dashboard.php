<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="refresh" content="30">
	<title>Antrian SSC ITTS</title>
	<?php $this->load->view('css'); ?>
	<style type="text/css">
		@media print {
			body * {
				visibility: hidden;
			}

			#print-antri * {
				visibility: visible;
			}
		}
	</style>
</head>

<body class="bg-gradient-primary">
	<audio id="suarabel" src="<?= base_url('asset'); ?>/Airport_Bell.mp3"></audio>
	<audio id="suarabelnomorurut" src="<?= base_url('asset'); ?>/rekaman/nomor-urut.wav"></audio>
	<audio id="suarabelsuarabelloket" src="<?= base_url('asset'); ?>/rekaman/loket.wav"></audio>

	<audio id="belas" src="<?= base_url('asset'); ?>/rekaman/belas.wav"></audio>
	<audio id="sebelas" src="<?= base_url('asset'); ?>/rekaman/sebelas.wav"></audio>
	<audio id="puluh" src="<?= base_url('asset'); ?>/rekaman/puluh.wav"></audio>
	<audio id="sepuluh" src="<?= base_url('asset'); ?>/rekaman/sepuluh.wav"></audio>
	<audio id="ratus" src="<?= base_url('asset'); ?>/rekaman/ratus.wav"></audio>
	<audio id="seratus" src="<?= base_url('asset'); ?>/rekaman/seratus.wav"></audio>
	<audio id="suarabelloket1" src="<?= base_url('asset'); ?>/rekaman/<?= $this->session->userdata('loket_temp'); ?>.wav"></audio>
	<div id="suara"></div>
	<div class="container">

	</div>
	<nav class="navbar navbar-light bg-white justify-content-between py-3 align-items-center">
		<div class="container">
			<div class="d-flex align-items-center">
				<img src="<?= base_url() ?>asset/images/logo-basic.png" alt="homepage" width="70px" height="40px" />
				<h3 id="currentDate" class="navbar-brand mb-0 ml-3 py-0"></h3>
			</div>
			<div class="d-flex align-items-center">
				<button type="button" id="clock" class="btn btn-ssc px-4 py-1 mr-2"></button>
				<button type="button" class="btn btn-outline-ssc px-4 py-1" onclick="logout()">Logout</button>
			</div>

		</div>

	</nav>
	<section class="my-5">
		<div class="container">
			<h1 class="text-center mb-4 font-weight-normal">
				<span class="font-weight-bold">Welcome, </span><?= $this->session->userdata('nama'); ?>
			</h1>
			<div class="row">
				<div class="col-md-5">
					<div class="card" style="border-radius: 0.75rem;">
						<div class="card-body p-0">
							<div class="rounded py-3 text-center font-weight-semibold" style="font-size: 17px;">Nomor Antrian Pendaftaran :</div>
							<hr class="border border-muted w-100 my-0">
							<h2 class="text-center text-ssc" id="no-waiting" style="font-size: 9rem;"><?= $data_waiting->nomor; ?></h2>
							<!-- <div class="card-body">
									<h5 class="card-title text-center">Terima Kasih Telah Menunggu</h5>
								</div> -->
							<div class="border-bottom-right-left color-primary-400 py-3 text-white text-center font-weight-bold" id="status-waiting" style="font-size: 21px;">Menuggu dipanggil</div>
						</div>

					</div>
					<button type="button" onclick="panggil()" class="btn btn-lg btn-ssc font-weight-bold mt-3 w-100" style="font-size: 25px;"> Panggil</button>
				</div>
				<div class="col-md-7">
					<div class="card" style="border-radius: 1rem;">
						<div class="card-body p-0">
							<div class="rounded py-3 text-center font-weight-semibold" style="font-size: 17px;">Nomor Antrian Pendaftaran :</div>
							<hr class="border border-muted w-100 my-0">
							<h2 class="text-center text-ssc" id="no-servicing" style="font-size: 12.5rem;"><?= $data_servicing->nomor; ?></h2>
							<!-- <div class="card-body">
								<h5 class="card-title text-center">Terima Kasih Telah Menunggu</h5>
							</div> -->
							<div class="border-bottom-right-left bg-cream py-3 text-ssc text-center font-weight-bold" id="status-servicing" style="font-size: 21px;">Sedang dilayani</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>

	<?php $this->load->view('script'); ?>

	<script type="text/javascript">
		// Function to format the date as "dddd, DD MMMM YYYY"
		function formatDate(date) {
			const options = {
				weekday: 'long',
				day: 'numeric',
				month: 'long',
				year: 'numeric'
			};
			return new Date(date).toLocaleDateString('id-ID', options);
		}

		// Update the HTML element with the formatted date
		function updateCurrentDate() {
			const currentDateElement = document.getElementById('currentDate');
			const currentDate = new Date();
			const formattedDate = formatDate(currentDate);

			// Extract the day from the formatted date
			const day = formattedDate.split(',')[0].trim();

			// Create HTML with the day in bold
			const htmlContent = `<span class="font-weight-bold">${day}, </span><span>${formattedDate.slice(day.length + 1)}</span>`;

			// Update the element with the formatted date
			currentDateElement.innerHTML = htmlContent;
		}

		// Call the function to update the current date on page load
		updateCurrentDate();

		function updateClock() {
			var date = new Date();
			var hours = date.getHours();
			var minutes = date.getMinutes();
			var seconds = date.getSeconds();

			// Add leading zeros if necessary
			if (hours < 10) {
				hours = "0" + hours;
			}
			if (minutes < 10) {
				minutes = "0" + minutes;
			}
			if (seconds < 10) {
				seconds = "0" + seconds;
			}

			// Set the clock display
			document.getElementById("clock").innerHTML = hours + ":" + minutes + ":" + seconds;
		}

		// Update the clock every second
		setInterval(updateClock, 10);

		function panggil() {

			$.ajax({
				url: '<?= site_url("dashboard/panggil_antrian") ?>',
				dataType: 'JSON',
				success: function(data) {
					if (data == 0) {
						alert('antrian habiss!!');
					} else if (data != null) {
						data_servicing = data.data_servicing;
						data_waiting = data.data_waiting;
						$("#no-waiting").html(data_waiting.nomor);
						$("#status-waiting").html('Menuggu dipanggil');
						$("#no-servicing").html(data_servicing.nomor);
						$("#status-servicing").html('Sedang dilayani');
						// $('#no-waiting').html(data.nomor);
						// var nomor = parseInt(data_waiting.nomor-1);
						mulai(data_servicing.nomor);
					} else {
						alert('gagal generate nomor');
					}
				}
			});

		}

		function logout() {

			$.ajax({
				url: '<?= site_url("login/logout") ?>',
				dataType: 'JSON',
				success: function(response) {
					if (response == 1) {
						location.replace("<?= site_url('login'); ?>");
					}
				}
			});
		}

		$(document).ready(function() {
			$("#play").click(function() {
				document.getElementById('suarabel').play();
			});


		});

		function mulai(antrian) {

			suara = $('#suara');
			suara.html('');
			for (var i = 0; i < antrian.length; i++) {
				suara.append('<audio id="suarabel' + i + '" src="<?= base_url('asset/rekaman'); ?>/' + antrian.substr(i, 1) + '.wav" ></audio>');
			}

			//MAINKAN SUARA BEL PADA SAAT AWAL
			document.getElementById('suarabel').pause();
			document.getElementById('suarabel').currentTime = 0;
			document.getElementById('suarabel').play();

			//SET DELAY UNTUK MEMAINKAN REKAMAN NOMOR URUT		
			totalwaktu = document.getElementById('suarabel').duration * 1000;

			//MAINKAN SUARA NOMOR URUT		
			setTimeout(function() {
				document.getElementById('suarabelnomorurut').pause();
				document.getElementById('suarabelnomorurut').currentTime = 0;
				document.getElementById('suarabelnomorurut').play();
			}, totalwaktu);
			totalwaktu = totalwaktu + 1000;

			//JIKA KURANG DARI 10 MAKA MAIKAN SUARA ANGKA1
			if (antrian < 10) {
				setTimeout(function() {
					document.getElementById('suarabel0').pause();
					document.getElementById('suarabel0').currentTime = 0;
					document.getElementById('suarabel0').play();
				}, totalwaktu);

				totalwaktu = totalwaktu + 1000;
			} else if (antrian == 10) {

				//JIKA 10 MAKA MAIKAN SUARA SEPULUH
				setTimeout(function() {
					document.getElementById('sepuluh').pause();
					document.getElementById('sepuluh').currentTime = 0;
					document.getElementById('sepuluh').play();
				}, totalwaktu);
				totalwaktu = totalwaktu + 1000;
			} else if (antrian == 11) {

				//JIKA 11 MAKA MAIKAN SUARA SEBELAS
				setTimeout(function() {
					document.getElementById('sebelas').pause();
					document.getElementById('sebelas').currentTime = 0;
					document.getElementById('sebelas').play();
				}, totalwaktu);
				totalwaktu = totalwaktu + 1000;

			} else if (antrian < 20) {

				//JIKA 12-20 MAKA MAIKAN SUARA ANGKA2+"BELAS"
				setTimeout(function() {
					document.getElementById('suarabel1').pause();
					document.getElementById('suarabel1').currentTime = 0;
					document.getElementById('suarabel1').play();
				}, totalwaktu);
				totalwaktu = totalwaktu + 1000;
				setTimeout(function() {
					document.getElementById('belas').pause();
					document.getElementById('belas').currentTime = 0;
					document.getElementById('belas').play();
				}, totalwaktu);
				totalwaktu = totalwaktu + 1000;

			} else if (antrian < 100) {

				//JIKA PULUHAN MAKA MAINKAN SUARA ANGKA1+PULUH+AKNGKA2
				setTimeout(function() {
					document.getElementById('suarabel0').pause();
					document.getElementById('suarabel0').currentTime = 0;
					document.getElementById('suarabel0').play();
				}, totalwaktu);
				totalwaktu = totalwaktu + 1000;
				setTimeout(function() {
					document.getElementById('puluh').pause();
					document.getElementById('puluh').currentTime = 0;
					document.getElementById('puluh').play();
				}, totalwaktu);
				totalwaktu = totalwaktu + 1000;
				setTimeout(function() {
					document.getElementById('suarabel1').pause();
					document.getElementById('suarabel1').currentTime = 0;
					document.getElementById('suarabel1').play();
				}, totalwaktu);
				totalwaktu = totalwaktu + 1000;

			} else {

				//JIKA LEBIH DARI 100 
				//Karena aplikasi ini masih sederhana maka logina konversi hanya sampai 100
				//Selebihnya akan langsung disebutkan angkanya saja 
				//tanpa kata "RATUS", "PULUH", maupun "BELAS"
				var panjang = antrian.length;
				for (i = 0; i < panjang; i++) {
					totalwaktu = totalwaktu + 1000;
					setTimeout(function() {
						document.getElementById('suarabel' + i).pause();
						document.getElementById('suarabel' + i).currentTime = 0;
						document.getElementById('suarabel' + i).play();
					}, totalwaktu);
				}

			}

			totalwaktu = totalwaktu + 1000;
			setTimeout(function() {
				document.getElementById('suarabelsuarabelloket').pause();
				document.getElementById('suarabelsuarabelloket').currentTime = 0;
				document.getElementById('suarabelsuarabelloket').play();
			}, totalwaktu);

			totalwaktu = totalwaktu + 1000;
			setTimeout(function() {
				document.getElementById('suarabelloket1').pause();
				document.getElementById('suarabelloket1').currentTime = 0;
				document.getElementById('suarabelloket1').play();
			}, totalwaktu);
		}
	</script>

</body>

</html>