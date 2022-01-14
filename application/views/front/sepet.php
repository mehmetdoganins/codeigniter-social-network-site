<!DOCTYPE html>
<html lang="en" data-brk-skin="brk-green-1.css">

<?php $this->load->view('front/include/head'); ?>

<body>
  <div class="brk-loader">
    <div class="brk-loader__loader"></div>
  </div>
  <style> #rev_slider_18_1_wrapper .tp-loader.spinner2{ background-color: #0071fc !important; } </style>
  <style>.brk-castom-btn.rev-btn.rev-withicon i{margin-left:0 !important; margin-right:10px !important; vertical-align:0; top:-1px}.brk-castom-btn-1.rev-btn.rev-withicon i{vertical-align:2px}</style>
  <style>.custom.tparrows{cursor:pointer;background:#000;background:rgba(0,0,0,0.5);width:40px;height:40px;position:absolute;display:block;z-index:100}.custom.tparrows:hover{background:#000}.custom.tparrows:before{font-family:"revicons";font-size:15px;color:#fff;display:block;line-height:40px;text-align:center}.custom.tparrows.tp-leftarrow:before{content:"\e824"}.custom.tparrows.tp-rightarrow:before{content:"\e825"}</style>
  <div class="main-page">
    <?php $this->load->view('front/include/header'); ?>
 
    <!-- cart section end -->
  <section class="cart-section spad">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="cart-table">
            <h3>Alışveriş Sepetiniz</h3>
            <div class="cart-table-warp">
              <table>
              <thead>
                <tr>
                  <th class="product-th">Ürün</th>
                  <th class="quy-th">Adet</th>
                  <th class="size-th">Boyut</th>
                  <th class="total-th">Fiyat</th>
                </tr>
              </thead>
              <tbody>
          <?php $sepet= $this->session->userdata('user'); 
                $dil  =   $this->session->userdata('kimo');
                $limit='';
                $kosul=array('kullanici_id'=>$sepet->id);
                $sonuc=$this->dtbs->listele_kosul('sepet',$limit,$kosul,$dil); foreach ($sonuc as $bilgi) {
                $kosul=array('id'=>$bilgi['urun_id']);
                $sonuc=$this->dtbs->listele_kosul('urun',$limit,$kosul,$dil);
                 foreach ($sonuc as $bilgi) { ?>
                <tr>
                  <td class="product-col">
                    <img src="<?php echo base_url($bilgi['resim']); ?>" alt="">
                    <div class="pc-title">
                      <h4><?php echo $bilgi['isim']; ?></h4>
                      <p>$45.90</p>
                    </div>
                  </td>
                  <td class="quy-col">
                    <div class="quantity">
                      <div class="pro-qty">
                      <input type="text" value="1">
                      </div>
                     </div>
                  </td>
                  <td class="size-col"><h4>Boyut M</h4></td>
                  <td class="total-col"><h4>$45.90</h4></td>
                </tr>
              <?php } ?>
            <?php } ?>
              </tbody>
            </table>
            </div>
            <div class="total-cost">
              <h6>Toplam <span>$99.90</span></h6>
            </div>
          </div>
        </div>
        <div class="col-lg-4 card-right">
          <form class="promo-code-form">
            <input type="text" placeholder="Varsa Promosyon kodu..">
            <button>Gönder</button>
          </form>
          <a href="" class="site-btn">Satın AL</a>
          <a href="" class="site-btn sb-dark">Ürünlere Geri Dön</a>
        </div>
      </div>
    </div>
  </section>
  <!-- cart section end -->

  <!-- Related product section -->
  <section class="related-product-section">
    <div class="container">
      <div class="section-title text-uppercase">
        <h2>Popüler Ürünler</h2>
      </div>
      <div class="row">
        <?php $dil=$this->session->userdata('kimo');
        $limit='15';
        $kosul=array();
        $sonuc=$this->dtbs->listele_kosul('urun',$limit,$kosul,$dil); foreach ($sonuc as $bilgi) { ?>
        <div class="col-lg-3 col-sm-6">
          <div class="product-item">
            <div class="pi-pic">
              <div class="tag-new">Yeni</div>
              <img src="<?php echo base_url($bilgi['resim']); ?>" alt="">
              <div class="pi-links">
                <a href="#" class="add-card"><i class="flaticon-bag"></i><span>Sepete Ekle</span></a>
                <a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
              </div>
            </div>
            <div class="pi-text">
              <h6>$35,00</h6>
              <p><?php echo $bilgi['isim']; ?></p>
            </div>
          </div>
        </div>
         <?php } ?>
      </div>
    </div>
  </section>
  <!-- Related product section end -->
    
 
  </div>
  <a href="#top" id="toTop"></a>
 <?php $this->load->view('front/include/script'); ?>
</body>

</html>