<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="6">
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
	</style>	
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
			<div class="card-deck shadow-lg p-3 mb-5 bg-white rounded" id="print-antri">
			  <div class="card">
			      <div class="card-header text-center" style="font-size: 50px; font-weight: bold">SSC ITTS</div>
			  	<!-- <strong style="font-size: 370px; text-align: center;" id="no-antrian"><?= $nomor+1; ?></strong> -->
					<input type="hidden" id="no-antrian" value="<?= $nomor+1; ?>">
				  <img src="<?= base_url() ?>asset/images/logo-basic.png" alt="homepage" class="dark-logo" width="150px" height="100px" style="margin: 0 auto;" />
			    <div class="card-body">
			      <h5 class="card-title text-center" style="font-size: 25px; font-weight: bold">Terima Kasih Telah Menunggu</h5>
			    </div>
			  </div>
			</div>		
			<br>
			<button type="button" onclick="print_antrian()" class="btn btn-lg btn-primary" style="width:100%;"> Print</button>	
		</div>
		<div class="col-md-2">
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
			url:'<?= site_url("antrian/print_antrian") ?>',
			dataType:'JSON',
			success:function(data){
				if (data!=null) {
					var strongElement = '<strong style="font-size: 250px; text-align: center; margin-left: 25%;" id="no-antrian">' + (data + 1) + '</strong>';
               		 $('#print-antri .card-body').prepend(strongElement);

                // Lakukan pencetakan
               		 window.print();

                // Hapus elemen <strong> setelah pencetakan selesai
               		 $('#no-antrian').remove();
					 //PrintDiv();
				}else{
					alert('gagal generate nomor');
				}
			}
		});	

	}

</script>
</body>
</html>
