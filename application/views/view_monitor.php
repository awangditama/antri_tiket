<!DOCTYPE html>
<html>

<head>
	<title>Monitor</title>
	<?php $this->load->view('css'); ?>
	<style type="text/css">
		body {
			background: url('<?= base_url("asset/images/background_3.jpg"); ?>') no-repeat center center fixed;
			background-size: 100% 100%;
			-webkit-background-size: 100% 100%;
			-moz-background-size: 100% 100%;
			-o-background-size: 100% 100%;

		}
	</style>
</head>

<body>

	<div class="container">
		<div class="row" style="margin-top: 10%;">
			<div class="col-md-6">

				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<!--   <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol> -->
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
				</div>
			</div>
			<div class="col-md-6">
				<div class="row text-center" id="data-antri">

				</div>

			</div>
		</div>
		<hr>
		<div class="row" style="bottom: 0px;">
			<marquee><b>Running Text Here</b></marquee>
		</div>

	</div>


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
							data.append('<div class="col-lg-6" style="border: 2px solid;  border-radius: 15px; font-size:35px; margin:5% 10% 5%; font-family:sans-serif;"><strong>Nomor Antrian Pendaftaran : </strong><br><span style="font-size: 80px; font-weight: bold;">' + msg[i].nomor + '</span><hr><h2><b>LOKET ' + msg[i].loket_temp + '</b></h2></div>');
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
	</script>
</body>

</html>
