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

<body>
	<div class="my-5">
		<div class="container">
			<div class="card-deck p-3 mb-5 bg-white rounded" id="print-antri">

				<div class="card border-0">
					<div class="text-center mb-5">
						<img src="<?= base_url() ?>asset/images/logo-basic.png" alt="homepage" class="dark-logo text-center" width="200px" height="150px" />
					</div>
					<div class="card-body">
						<input type="hidden" id="no-antrian" value="<?= $nomor + 1; ?>">
					</div>
					<div>
						<button type="button" onclick="print_antrian()" class="btn btn-lg btn-ssc font-weight-bold" style="width:100%; font-size: 27px;"> Cetak no antrian </button>
						<h5 class="card-title text-center font-weight-bold mt-4" id="ganti-text" style="font-size: 25px">Silahkan mencetak nomer antrian. Dan mohon menunggu dengan tertib
						</h5>
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
						var strongElement = '<strong style="font-size: 250px; text-align: center; margin-left: 35%;" id="no-antrian">' + (data) + '</strong>';
						$('#print-antri .card-body').prepend(strongElement);
						// Get the element that contains the text
						var gantiText = $('#ganti-text');

						// Change the text
						gantiText.text('Terima kasih, silahkan menunggu untuk dipanggil');

						// Lakukan pencetakan
						window.print();
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
				$('.btn-ssc').hide();
			});

			$(window).on('afterprint', function() {
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