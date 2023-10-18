<?php
	function format_tgl_indo($date){
		date_default_timezone_set('Asia/Jakarta');
		// array hari dan bulan
		$Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		$Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

		// Attempt to parse the date using strtotime
		$timestamp = strtotime($date);

		if ($timestamp !== false) {
			// Extract the year, month, day, and time
			$tahun = date('Y', $timestamp);
			$bulan = date('n', $timestamp);
			$tgl = date('j', $timestamp);
			// $waktu = date('H:i', $timestamp);
			$hari = date('w', $timestamp);

			$result = $Hari[$hari].", ".$tgl." ".$Bulan[$bulan-1]." ".$tahun." ";
			return $result;
		} else {
			return "Invalid date format or date not recognized.";
		}
	}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Monitor</title>
	<?php $this->load->view('css'); ?>
	<style type="text/css">
	</style>
</head>

<body>
	<section class="my-5">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center mb-4">
				<div class="font-weight-bold" style="font-size: 27px;"> <?= format_tgl_indo(date('l, d F Y')); ?></div>
				<div>
					<div id="clock" class="btn btn-ssc" style="font-size: 27px;"></div>
				</div>
				
			</div>
			<div class="text-center mb-4">
				<h2 class="display-2 font-weight-bold">Antrian SSC</h2>
			</div>
			<div class="row mb-4" id="data-antri">
			</div>
				
		</div>
		<footer class="bg-gradient-primary py-3">
			<marquee>
				<p class="text-primary-400 mb-0 font-weight-bold" style="font-size: 31px;">Silahkan untuk mengambil antrian ditempat yang sudah disediakan</p>
			</marquee>
		</footer>
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
								'<div class="col-md-6"><div class="card-deck p-3 bg-white rounded"><div class="card"><div class="card-header text-center color-primary-400 text-white font-weight-bold" style="font-size: 21px;">Nomor Antrian Pendaftaran :</div><h2 class="text-center py-4" id="no-waiting" style="font-size: 10rem;">' + msg[i].nomor + '</h2><div class="card-footer bg-light text-center font-weight-bold" id="status-waiting" style="font-size: 2rem;">LOKET ' + msg[i].loket_temp + '</div></div></div></div>'
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
		setInterval(updateClock, 1000);
	</script>
</body>

</html>
