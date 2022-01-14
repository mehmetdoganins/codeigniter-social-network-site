<!DOCTYPE html>
<html lang="tr">
<?php $this->load->view('front/include/head'); ?>
<body>
	<?php $this->load->view('front/include/header'); ?>
	<!-- Page Content-->
	<hr class="my-0" />
	<!-- Features Section-->
	<section class="py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 d-flex justify-content-center">
					<img class="img-fluid rounded" src="https://via.placeholder.com/700x450" alt="..." /></div>
					<?php foreach ($info as $info) { ?>
						
						<div class="col-lg-12 text-center">
							<h5 class="mb-4 mt-4"><?php echo $info['isim']; ?></h5>
							<div class="col-md-6 float-left text-left">
								<p class="d-none">The Modern Business template by Start Bootstrap includes:</p>
								
								<p><?php echo $info['icerik'] ?></p>
							</div>
							<div class="col-md-6 float-left text-left">
								<p class="d-none">The Modern Business template by Start Bootstrap includes:</p>
								
								<p><?php echo $info['ceviri'] ?></p>
							</div>

						</div>

					<?php } ?>
				</div>
				<div class=" d-flex border">
					<div class="col-3 float-left"><span>Nivîskar:</span> <?php echo $info['yazar']; ?></div>
					<div class="col-3 float-left"><span>Nivîskar:</span> <?php echo $info['cevirmen']; ?></div>
					<div class="col-3 float-left"><i class="far fa-eye"></i> <?php echo $info['yazar']; ?></div>
					<div class="col-3 float-left"><i class="far fa-eye"></i> <?php echo $info['hit']; ?></div>
				</div>
			</div>
			
		</section>
		<!-- Call to Action-->
		<aside class="py-5 bg-light">
			<div class="container">
				<div class="row">
					<div class="col-md-8"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p></div>
					<div class="col-md-4"><a class="btn btn-lg btn-secondary btn-block" href="#!">Call to Action</a></div>
				</div>
			</div>
		</aside>
		<?php $this->load->view('front/include/footer'); ?>
		<?php $this->load->view('front/include/script'); ?>
	</body>
	</html>
