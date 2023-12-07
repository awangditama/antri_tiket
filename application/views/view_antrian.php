<!DOCTYPE html>
<html>

<head>
	<!--<meta http-equiv="refresh" content="8">-->
	<title>Antrian Pendaftaran SSC</title>
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

		#countdown {
			display: flex;
			justify-content: center;
			align-items: center;
			font-size: 24px;
		}

		#countdown span {
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body class="bg-gradient-primary position-relative" style="overflow: hidden;">
	<div class="my-5">
		<img id="foto-1" src="<?= base_url() ?>asset/image/foto-irma.png" alt="homepage" class="img-fluid position-absolute" style="top: 17%; "/>
		<img id="foto-2" src="<?= base_url() ?>asset/image/fitri-1.png" alt="homepage" class="img-fluid position-absolute" style="right: 0; top: 40%;" />
		<div class="container">
			<div class="card-deck p-3 mb-5" id="print-antri">

				<div class="card bg-transparent border-0">
					<div class="text-center mb-5">
						<img src="<?= base_url() ?>asset/images/logo-basic.png" alt="homepage" class="dark-logo text-center" width="179px" height="110px" />
					</div>
					<div class="card-body">
						<div class="warp-text text-center">
							<h2 class="font-weight-bold display-4">Cetak Nomor</h2>
							<h2 class="font-weight-bold display-4 text-ssc">Antrian Anda</h2>
						</div>
						<input type="hidden" id="no-antrian" value="<?= $nomor + 1; ?>">
						<h5 class="card-title text-center text-muted w-50 d-block mx-auto mt-4 mb-5" id="ganti-text" style="font-size: 19px;">Silahkan mencetak nomer antrian. Dan mohon menunggu dengan tertib
						</h5>
						<div class="warp-end">
							<button type="button" onclick="print_antrian()" class="btn btn-lg btn-ssc d-block mx-auto px-5 font-weight-bold w-auto" style="font-size: 31px; border-radius: 10rem;"> Cetak</button>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div id="countdown" class='d-none'>
				<span id="seconds">5</span>
			</div>

		</div>
	</div>

	<?php $this->load->view('script'); ?>

	<script type="text/javascript">
		function PrintDiv() {
			var divToPrint = document.getElementById('print-antri');
			var popupWin = window.open('', '_blank', 'width=300,height=300');
			popupWin.document.open();
			popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
			popupWin.document.close();
		}


		function print_antrian() {

			$.ajax({
				url: '<?= site_url("antrian/print_antrian") ?>',
				dataType: 'JSON',
				success: function(data) {
					if (data != null) {
						var strongElement = '<strong style="font-size: 250px; text-align: center; margin: 0 auto; display: block;" id="no-antrian">' + (data) + '</strong>';
						$('#print-antri .card-body').prepend(strongElement);
						// Get the element that contains the text
						var gantiText = $('#ganti-text');

						$('#foto-1').addClass('d-none');
						$('#foto-2').addClass('d-none');
						$('.warp-text').addClass('d-none');
						$('.warp-end').addClass('d-none');
						

						// Change the text
						gantiText.text('Terima kasih, silahkan menunggu untuk dipanggil');

						// Lakukan pencetakan
						window.print();
						// Tampilkan kembali elemen yang disembunyikan
						$('#foto-1').removeClass('d-none');
						$('#foto-2').removeClass('d-none');
						$('.warp-text').removeClass('d-none');
						$('.warp-end').removeClass('d-none');
						// menampilkan kembali
						gantiText.text('Silahkan mencetak nomer antrian. Dan mohon menunggu dengan tertib');
						// Hapus elemen <strong> setelah pencetakan selesai
						$('#no-antrian').remove();
						//PrintDiv();
						countdown();
						$('.btn-ssc').attr('disabled', 'disabled');
						$('head').append('<meta http-equiv="refresh" content="4">');

					} else {
						alert('gagal generate nomor');
					}
				}
			});

		}
		$(document).ready(function() {
			$(window).on('beforeprint', function() {
				// remove classs body
				$('body').removeClass('bg-gradient-primary');
				$('.btn-ssc').hide();
			});

			$(window).on('afterprint', function() {
				// add classs body
				$('body').addClass('bg-gradient-primary');
				$('.btn-ssc').show();
			});
		});

		function countdown() {
			// Get the current time
			var now = parseInt($('#seconds').text());
			// Get the remaining seconds
			var seconds = Math.floor(now - 1);

			// Update the span element with the countdown
			document.getElementById("seconds").innerHTML = seconds;
			$('.btn-ssc').text('Anda dapat mencetak tiket selanjutnya dalam ' + seconds + '...');
			// Call the countdown function again every second
			setTimeout(countdown, 1000);
		}
	</script>
</body>

</html>