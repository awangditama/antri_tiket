<!DOCTYPE html>
<html>

<head>
	<title>Monitor</title>
	<?php $this->load->view('css'); ?>
	<style type="text/css">
	</style>
</head>

<body class="bg-gradient-primary">
	<nav class="navbar navbar-light bg-white justify-content-between py-3 align-items-center">
		<div class="container">
			<div class="d-flex align-items-center">
				<img src="<?= base_url() ?>asset/images/logo-basic.png" alt="homepage" width="70px" height="40px" />
				<h3 id="currentDate" class="navbar-brand mb-0 ml-3 py-0"></h3>
			</div>
			<div class="d-flex align-items-center">
				<button type="button" id="clock" class="btn btn-ssc px-4 py-1 mr-2"></button>
			</div>

		</div>

	</nav>
	<section class="my-5">
		<div class="container">
			
			<div class="text-center mb-5">
				<h2 class="display-3 font-weight-bold">Antrian SSC</h2>
			</div>
			<div class="row mb-5" id="data-antri">
			</div>

		</div>
		<div class="bg-white text-center py-3 mt-4">
			<p class="text-primary-400 mb-0 font-weight-bold" style="font-size: 29px;">Silahkan untuk mengambil antrian ditempat yang sudah disediakan</p>
		</div>
	</section>


	<!-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					  <ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					</ol>
					<div class="carousel-inner" role="listbox">
					<?php
					$no = 1;
					foreach ($data_slider as $data) { ?>
							<div class="carousel-item <?php if ($no == 1) echo 'active'; ?>">
								<img class="d-block img-responsive img-fluid" src="<?= base_url('asset/image/' . $data['gambar']); ?>">
							</div>
						<?php $no++;
					} ?>
					</div>
					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div> -->


	<?php $this->load->view('script'); ?>
	<script type="text/javascript">
		$('.carousel').carousel({
			interval: 2000
		})

		function get_monitor() {

			$.ajax({
				url: '<?= site_url('monitor/get_data'); ?>',
				dataType: 'JSON',
				success: function(msg) {
					var data = $('#data-antri');
					data.html('');
					if (msg !== null) {
						for (i = 0; i < msg.length; i++) {
							// data.append('<tr><td>'+msg[i].nomor+'</td><td>'+msg[i].status+'</td><td>'+msg[i].nama+'</td></tr>');	
							data.append(
								'<div class="col-md-6"><div class="card" style="border-radius: 0.75rem;"><div class="card-body p-0"><div class="rounded py-3 text-center font-weight-semibold" style="font-size: 17px;">Nomor Antrian Pendaftaran :</div><hr class="border border-muted w-100 my-0"><h2 class="text-center text-ssc" id="no-waiting" style="font-size: 10rem;">' + msg[i].nomor + '</h2><div class="border-bottom-right-left color-primary-400 py-3 text-white text-center font-weight-bold" id="status-waiting" style="font-size: 21px;">LOKET ' + msg[i].loket_temp + '</div></div></div></div>'
							);
						}
					}
					setTimeout(get_monitor, 2000);
				},
				error: function() {
					setTimeout(get_monitor, 2000);
				}
			});
		}
		//window.setInterval(get_monitor, 2000);

		get_monitor();

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
	</script>
</body>

</html>