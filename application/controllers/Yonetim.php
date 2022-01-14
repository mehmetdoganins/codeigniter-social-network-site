<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Yonetim extends CI_Controller {

	function guvenlik(){
		$giris= $this->session->userdata('login');
		if (!$giris) {
			redirect('yonetim');
		}
	}
	function ggiris(){
		$giris= $this->session->userdata('login');
		if ($giris) {
			redirect('yonetim/anasayfa');
		}
	}
	
	public function index(){
		$this->ggiris();
		$this->load->view('back/login');
	}
	public function girisyap(){
		$this->form_validation->set_rules('email','E-mail','trim|required|valid_email');
		$this->form_validation->set_rules('sifre', 'Şifre', 'trim|required');

		$errors_message = array(
			'required' 	=> '{field} Alanını boş bırakmayınız.', 
			'valid_email'	=>'{field} alanına geçerli bir {field} giriniz.'
		);
		$this->form_validation->set_message($errors_message);
		if ($this->form_validation->run()== FALSE) {
			$this->load->view('back/login');
		} else{
			$email= $this->input->post('email');
			$sifre= $this->input->post('sifre');
			$kontrol= $this->dtbs->kontrol($email,$sifre);
			if ($kontrol) {
				$this->session->set_userdata('login',true);
				$this->session->set_userdata('info',$kontrol);
				$data = array('songiris' =>date('d-m-Y H:i:s'));
				$this->dtbs->timeupdate($kontrol->id,$data);
				redirect('Yonetim/anasayfa');
			}else{
				$this->session->set_flashdata('durum',' Kullanıcı adı ve şifreniz yanlış');
				$this->load->view('back/login');
			}
		}
	}
	public function anasayfa(){
		$this->guvenlik();
		$this->load->view('back/anasayfa');
	}

	public function cikis()
	{
		$this->session->sess_destroy();
		redirect('Yonetim');
	}
	public function ayar(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$sonuc=$this->dtbs->liste('site_ayar',$dil);
		$data['bilgi']=$sonuc;
		$this->load->view('back/ayar',$data);
	}
	public function ayarekle(){
		$this->load->view('back/ayarekle');
		
	}
	public function ayaredit($id){
		$this->guvenlik();
		$sonuc=$this->dtbs->cek($id,'site_ayar');
		$data['bilgi']=$sonuc;
		$this->load->view('back/ayaredit',$data);
	}
	
	public function ayarupdate(){
		$this->guvenlik();
		$id=$this->input->post('id');
		$dil=$this->session->userdata('kimo');
		
		$data = array(
			'site_title' => $title=	$this->input->post('title'),
			'fax'		=>	$fax=	$this->input->post('fax'),
			'twi'	=>	$etikat=$this->input->post('twi'),
			'sky'	=>	$etikat=$this->input->post('sky'),
			'lin'	=>	$etikat=$this->input->post('lin'),
			'goo'	=>	$etikat=$this->input->post('goo'),
			'you'	=>	$etikat=$this->input->post('you'),
			'fli'	=>	$etikat=$this->input->post('fli'),
			'fac'	=>	$etikat=$this->input->post('fac'),
			'ins'	=>	$etikat=$this->input->post('ins'),
			'etikat1'	=>	$etikat=$this->input->post('etikat1'),
			'etikat2'	=>	$etikat=$this->input->post('etikat2'),
			'etikat3'	=>	$etikat=$this->input->post('etikat3'),
			'etikat4'	=>	$etikat=$this->input->post('etikat4'),
			'etikat5'	=>	$etikat=$this->input->post('etikat5'),
			'etikat6'	=>	$etikat=$this->input->post('etikat6'),
			'etikat7'	=>	$etikat=$this->input->post('etikat7'),
			'etikat8'	=>	$etikat=$this->input->post('etikat8'),
			'etikat9'	=>	$etikat=$this->input->post('etikat9'),
			'dil'		=>	$dil,
			'site_url'	=> 	$url=  	$this->input->post('url'),
			'site_desc' => 	$desc=  $this->input->post('desc'),
			'site_keyw'	=>	$keyw=	$this->input->post('keyw'),
			'site_mail'	=>	$mail=	$this->input->post('mail'),
			'site_tlf'	=>	$tlf=	$this->input->post('tlf'),
			'site_bilgi'=>  $bilgi=  $this->input->post('bilgi'),
			'site_adres'=>	$adres=	$this->input->post('adres'),
			'harita'    =>  $harita= $this->input->post('harita')
		);
		
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','config');
			if (resim_sil_veri($id,'site_ayar')) {
				$yol  = resim_sil_veri($id,'site_ayar');
				unlink($yol);
			}
		}

		if ($_FILES['icon']['size']>0) {
			$data['icon']=image_upload('icon','config');
			if (resim_sil_verim($id,'site_ayar')) {
				$yol  = resim_sil_verim($id,'site_ayar');
				unlink($yol);
			}
		}

		$sonuc= $this->dtbs->guncelle($id,'site_ayar',$data);

		if ($sonuc) {
			$this->ayaredit($id);
			
		}

	}

	public function ayarinsert(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$data = array(
			'site_title' => $title=	$this->input->post('title'),
			'fax'		=>	$fax=	$this->input->post('fax'),
			'twi'	=>	$etikat=$this->input->post('twi'),
			'sky'	=>	$etikat=$this->input->post('sky'),
			'lin'	=>	$etikat=$this->input->post('lin'),
			'goo'	=>	$etikat=$this->input->post('goo'),
			'you'	=>	$etikat=$this->input->post('you'),
			'fli'	=>	$etikat=$this->input->post('fli'),
			'fac'	=>	$etikat=$this->input->post('fac'),
			'ins'	=>	$etikat=$this->input->post('ins'),
			'etikat1'	=>	$etikat=$this->input->post('etikat1'),
			'etikat2'	=>	$etikat=$this->input->post('etikat2'),
			'etikat3'	=>	$etikat=$this->input->post('etikat3'),
			'etikat4'	=>	$etikat=$this->input->post('etikat4'),
			'etikat5'	=>	$etikat=$this->input->post('etikat5'),
			'etikat6'	=>	$etikat=$this->input->post('etikat6'),
			'etikat7'	=>	$etikat=$this->input->post('etikat7'),
			'etikat8'	=>	$etikat=$this->input->post('etikat8'),
			'etikat9'	=>	$etikat=$this->input->post('etikat9'),
			'dil'		=>	$dil,
			'site_url'	=> 	$url=  	$this->input->post('url'),
			'site_desc' => 	$desc=  $this->input->post('desc'),
			'site_keyw'	=>	$keyw=	$this->input->post('keyw'),
			'site_mail'	=>	$mail=	$this->input->post('mail'),
			'site_tlf'	=>	$tlf=	$this->input->post('tlf'),
			'site_bilgi'=>  $bilgi=  $this->input->post('bilgi'),
			'site_adres'=>	$adres=	$this->input->post('adres'),
			'harita'    =>  $harita= $this->input->post('harita')
		);
		$data['resim']=image_upload('resim','config');
		$sonuc= $this->dtbs->guncelle($id,'site_ayar',$data);

		$sonuc= $this->dtbs->ekle('site_ayar',$data);

		if ($sonuc) {
			eflash();
			$this->ayar($id);
			
		}

	}

	public function ekip(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$sonuc=$this->dtbs->liste('ekip',$dil);
		$data['bilgi']=$sonuc;
		$this->load->view('back/ekipler',$data);
	}
	public function ekipekle(){
		$this->guvenlik();
		$this->load->view('back/ekipekle');
	}
	public function ekipinsert(){
		$this->guvenlik();
		$config['upload_path'] = FCPATH.'assets/front/image/ekip';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';

		
		$this->load->library('upload', $config);
		$dil=$this->session->userdata('kimo');
		if ( ! $this->upload->do_upload('resim')){
			$resim = $this->upload->data();
			$resimyolu=$resim['file_name'];
			$resimkayit='assets/front/image/ekip/'.$resimyolu.'';
			$data = array(
				'isim' 		=>$this->input->post('isim'),
				'durum' 	=>$this->input->post('durum'),
				'dil'		=>$dil,
				'gorevi'	=>$this->input->post('gorevi'),
				'yetenek'	=>$this->input->post('yetenek'),
				'icerik'	=>$this->input->post('icerik')

			);
			$sonuc =$this->dtbs->ekle('ekip',$data);
			$this->ekip();
		}
		else{
			$dil=$this->session->userdata('kimo');
			$resim = $this->upload->data();
			$resimyolu=$resim['file_name'];
			$resimkayit='assets/front/image/ekip/'.$resimyolu.'';
			$data = array(
				'isim' 		=>$this->input->post('isim'),
				'durum' 	=>$this->input->post('durum'),
				'gorevi'	=>$this->input->post('gorevi'),
				'dil'		=>$dil,
				'yetenek'	=>$this->input->post('yetenek'),
				'resim'		=>$resimkayit,
				'icerik'	=>$this->input->post('icerik')
			);
			$sonuc =$this->dtbs->ekle('ekip',$data);
			$this->ekip();
		}
	}




	public function sayfaekle(){
		$this->load->view('back/sayfaekle');
	}
	public function sayfainsert(){

		$dil=$this->session->userdata('kimo');
		$kat_id=$this->input->post('kat_id');
		if ($kat_id=='') {
			$kat_id=$this->input->post('kati_id');
		}
		$data = array(
			'isim' 		=>$this->input->post('isim'),
			'desc' 		=>$this->input->post('desc'),
			'yazar'		=>$this->input->post('yazar'),
			'cevirmen'	=>$this->input->post('cevirmen'),
			'icerik' 	=> $this->input->post('icerik'),
			'ceviri'	=>$this->input->post('ceviri'),
			'dil'		=>  $dil,
			'sef'		=>seflink($this->input->post('isim')),
			'tarih'		=>date("d.m.Y  H:i:s"),
			'kat_id'  	=>$kat_id
		);
		$kati_id=$this->uri->segment(3);

		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','sayfa');
		}
		$sonuc=$this->dtbs->ekle('sayfa',$data);
		redirect('Yonetim/sayfaKategori/'.$kat_id.'');
	}

	

	public function sayfaduzenle($id){
		$sonuc=$this->dtbs->cek($id,'sayfa');
		$data['bilgi']=$sonuc;
		$this->load->view('back/sayfaduzenle',$data);

	}

	public function sayfaupdate(){

		$data = array(
			'id'	=>	$id=$this->input->post('id'),
			'isim' 	=> 	$this->input->post('isim'),
			'desc' =>$this->input->post('desc'),
			'icerik'	=> $this->input->post('icerik'),
			'sef'		=>seflink($this->input->post('isim')),
			'tarih'		=>date("d.m.Y  H:i:s"),
			'kat_id'	=>$this->input->post('kat_id')
		);
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','sayfa');
			if (resim_sil_veri($id,'sayfa')) {
				$yol  = resim_sil_veri($id,'sayfa');
				unlink($yol);
			}
		}
		$sonuc= $this->dtbs->guncelle($id,'sayfa',$data);
		gflash();
		redirect('Yonetim/sayfaduzenle/'.$id.'');
	}

	public function sayfasil($id){
		$this->guvenlik();
		if (resim_sil_veri($id,'sayfa')) {
			$yol  = resim_sil_veri($id,'sayfa');
			unlink($yol);
		}
		$where = array('id' =>$id );
		$sonuc = $this->dtbs->sil($where,'sayfa');
		sflash();
		$kat_id=$this->uri->segment(4);
		redirect('Yonetim/sayfaKategori/'.$kat_id.'');

	}
	public function sayfaResimsil($id){
		$this->guvenlik();
		if (resim_sil_veri($id,'sayfa')) {
			$yol  = resim_sil_veri($id,'sayfa');
			unlink($yol);
		}
		$data = array('id' =>$id,
			'resim'=>'' );
		$sonuc= $this->dtbs->guncelle($id,'sayfa',$data);
		sflash();
		redirect('yonetim/sayfaduzenle/'.$id.'');

	}
	
	public function sayfaKategori(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$kat_id=$this->uri->segment(3);
		
		if ($kat_id=='') {
			$kosul=array('kat_id'=>0);
		}else{
			$kosul=array('kat_id'=>$kat_id);
		}
		$limit='';
		$bilgi=$this->dtbs->listele_kosul('skategori',$limit,$kosul,$dil);
		$data['bilgi']= $bilgi;
		$this->load->view('back/sayfa', $data);

	}

	public function sayfaKategoriekle()
	{
		$this->guvenlik();
		$this->load->view('back/sayfaKategoriEkle');
	}
	public function sayfaKategoriinsert()
	{
		$kim=$this->session->userdata('kimo');
		$this->guvenlik();
		$kat_id=$this->input->post('kat_id');
		if ($kat_id==0) {
			$kat_id=$this->input->post('kati_id');
		}

		$data = array(
			'isim' 		=> 	$isim=$this->input->post('isim'),
			'durum' 	=>	$this->input->post('durum'),
			'dil' 		=>	$kim,
			'icerik'	=>	$this->input->post('icerik'),
			'kat_id' 	=>	$kat_id,
			'sef'		=>	seflink($isim)
		);
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','skategori');
		}
		$this->dtbs->ekle('skategori',$data);
		redirect('yonetim/sayfaKategoriekle');
	}

	public function sayfaKategoriDuzenle($id)
	{
		$sonuc=$this->dtbs->cek($id,'skategori');
		$data['bilgi']=$sonuc;
		$this->load->view('back/sayfaKategoriDuzenle', $data);
	}

	public function sayfaKategoriupdate(){

		$this->guvenlik();
		$kat_id=$this->input->post('kat_id');
		if ($kat_id==0) {
			$kat_id=$this->input->post('kati_id');
		}
		$data = array(
			'id' 		=>	$id=$this->input->post('id'),
			'isim' 		=> 	$isim=$this->input->post('isim'),
			'icerik'	=>$this->input->post('icerik'),
			'durum' 	=> 	$this->input->post('durum'),
			'kat_id' 	=> 	$kat_id,
			'sef'		=>	seflink($isim)
		);
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','skategori');
			if (resim_sil_veri($id,'skategori')) {
				$yol  = resim_sil_veri($id,'skategori');
				unlink($yol);
			}
		}
		$sonuc= $this->dtbs->guncelle($id,'skategori',$data);
		redirect('yonetim/sayfaKategori');

	}

	public function skategorisil($id)
	{
		if (resim_sil_veri($id,'skategori')) {
			$yol  = resim_sil_veri($id,'skategori');
			unlink($yol);
		}
		$where = array('id' => $id );
		$sonuc=$this->dtbs->sil($where,'skategori');
		sflash();
		redirect('yonetim/sayfaKategori');
	}

	public function yoneticiler(){
		$this->guvenlik();
		$sonuc=$this->dtbs->listele('yonetici');
		$data['bilgi']=$sonuc;
		$this->load->view('back/yoneticiler',$data);
	}

	public function yoneticiduzenle($id){
		$this->guvenlik();
		$sonuc=$this->dtbs->cek($id,'yonetici');
		$data['bilgi']=$sonuc;
		$this->load->view('back/yoneticiduzenle',$data);
	}


	public function yoneticiekle(){
		$this->guvenlik();
		$this->load->view('back/yoneticiekle');
	}

	public function yoneticiinsert(){
		$this->guvenlik();
		$data = array(
			'isim' =>$this->input->post('isim'),
			'email'=>$this->input->post('email'),
			'sifre'=>$this->input->post('sifre'),
			'durum'=>$this->input->post('durum')
		);
		$data['resim']=image_upload('resim','avatar');
		$sonuc=$this->dtbs->ekle('yonetici',$data);
		$this->session->set_flashdata('yonetici', 'value');
		eflash();
		$this->yoneticiler();
	}

	public function yoneticiupdate()
	{
		$this->guvenlik();
		$data = array(
			'id'    => $id=$this->input->post('id'),
			'isim' 	=>$this->input->post('isim'),
			'email' =>$this->input->post('email'),
			'sifre' =>$this->input->post('sifre'),
			'durum' =>$this->input->post('durum')
		);
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','avatar');
			if (resim_sil_veri($id,'yonetici')) {
				$yol  = resim_sil_veri($id,'yonetici');
				unlink($yol);
			}
		}
		$sonuc=$this->dtbs->guncelle($id,'yonetici',$data);
		gflash();
		$this->yoneticiler();
	}

	public function yoneticisil($id){
		$this->guvenlik();
		if (resim_sil_veri($id,'yonetici')) {
			$yol  = resim_sil_veri($id,'yonetici');
			unlink($yol);
		}
		$where = array('id' =>$id );
		$sonuc = $this->dtbs->sil($where,'yonetici');
		sflash();
		$this->yoneticiler();
	}
	public function galeri()
	{
		$this->guvenlik();
		$this->load->view('back/galeri');
	}
	public function galeriinsert()
	{
		$this->guvenlik();
		$data = array(
			'page_id'   =>$this->input->post('page_id'),
			'dil'		=>$this->input->post('dil')
		);
		$data['file']=image_upload('file','galeri');
		$sonuc=$this->dtbs->ekle('galeri',$data);
		redirect('yonetim/galeri');
	} 
	public function galeriinsert_urun()
	{
		$this->guvenlik();
		$data = array(
			'urun_id'   =>$this->input->post('urun_id'),
			'dil'		=>$this->input->post('dil')
		);
		$data['file']=image_upload('file','galeri');
		$sonuc=$this->dtbs->ekle('galeri',$data);
		redirect('yonetim/galeri');
	}
	public function galeriSil($id){
		$this->guvenlik();
		if (image_del($id,'galeri','file')) {
			$yol  = image_del($id,'galeri','file');
			unlink($yol);
		}
		$where = array('id' =>$id );
		$sonuc = $this->dtbs->sil($where,'galeri');
		sflash();
		$yol= $this->uri->segment(4).'/'.$this->uri->segment(5); 
		redirect('yonetim/'.$yol.'');
		
	}
	public function slider(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$sonuc=$this->dtbs->liste('slider',$dil);
		$data['bilgi']=$sonuc;
		$this->load->view('back/slider', $data);
	}

	public function sliderekle(){
		$this->guvenlik();
		$this->load->view('back/sliderekle');

	}

	public function sliderduzenle($id){
		$this->guvenlik();
		$sonuc=$this->dtbs->cek($id,'slider');
		$data['bilgi']=$sonuc;
		$this->load->view('back/sliderduzenle',$data);
		
	}
	
	public function sliderinsert(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$data = array(
			'isim' =>$this->input->post('isim'),
			'durum'=>$this->input->post('durum'),
			'dil' =>$dil,
			'icerik'=>$this->input->post('icerik'),
			'desc'=>$this->input->post('desc'),
		);
		$data['resim']=image_upload('resim','slider');
		$sonuc=$this->dtbs->ekle('slider',$data);
		$this->slider();
		eflash();
	}
	public function sliderupdate(){
		$this->guvenlik();
		$data = array(
			'id' =>$id=$this->input->post('id'),
			'isim' =>$this->input->post('isim'),
			'durum'=>$this->input->post('durum'),
			'icerik'=>$this->input->post('icerik'),
			'desc'  =>$this->input->post('desc'),
			'etiket'=>$this->input->post('etiket')
		);
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','slider');
			if (resim_sil_veri($id,'slider')) {
				$yol  = resim_sil_veri($id,'slider');
				unlink($yol);
			}
		}
		$sonuc=$this->dtbs->guncelle($id,'slider',$data);
		gflash();
		$this->slider();
	}		
	public function slidersil($id){
		$this->guvenlik();
		if (resim_sil_veri($id,'slider')) {
			$yol  = resim_sil_veri($id,'slider');
			unlink($yol);
		}
		$where = array('id' =>$id );
		$sonuc = $this->dtbs->sil($where,'slider');
		sflash();
		$this->slider();
		
	}
	public function anakategori(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$kat_id=$this->uri->segment(3);
		
		if ($kat_id=='') {
			$kosul=array('kat_id'=>0);
		}else{
			$kosul=array('kat_id'=>$kat_id);
		}
		$limit='';
		$bilgi=$this->dtbs->listele_kosul('kategori',$limit,$kosul,$dil);
		$data['bilgi']= $bilgi;
		$this->load->view('back/urunler', $data);

	}

	public function kategoriListele(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$kat_id=$this->uri->segment(3);
		$limit='';
		$kosul=array('kat_id'=>$kat_id);
		$bilgi=$this->dtbs->listele_kosul('kategori',$limit,$kosul,$dil);
		$data['bilgi']= $bilgi;
		$this->load->view('back/kategori-listele', $data);
	}

	public function kategori(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$bilgi=$this->dtbs->liste('kategori',$dil);
		$data['bilgi']= $bilgi;
		$this->load->view('back/kategori', $data);
	}
	public function kategoriduzenle($id){
		$this->guvenlik();
		$bilgi=$this->dtbs->cek($id,'kategori');
		$data['bilgi']=$bilgi;
		$this->load->view('back/kategoriduzenle', $data);
	}
	public function kategoriupdate(){
		$dil=$this->session->userdata('kimo');
		$kat_id=$this->input->post('kat_id');
		if ($kat_id=='') {
			$kat_id=$this->uri->segment(3);
		}
		$data = array(
			'id'		=>	$id=$this->input->post('id'),
			'isim' 		=> 	$this->input->post('isim'),
			'icerik'	=>	$this->input->post('icerik'),
			'durum' 	=>	$this->input->post('durum'),
			'sef'		=>	seflink($this->input->post('isim')),
			'dil'		=>	$dil,
			'kat_id'	=>	$kat_id
		);

		if ($_FILES['resim']['size']>0) {
			
			if (resim_sil_veri($id,'kategori')) {
				$yol  = resim_sil_veri($id,'kategori');
				unlink($yol);
			}
			$data['resim']=image_upload('resim','kategori');
		}
		
		$sonuc= $this->dtbs->guncelle($id,'kategori',$data);
		gflash();
		$this->kategoriduzenle($id);
		
		
	}

	public function kategorisil($id){	
		$this->guvenlik();
		$where = array('id' => $id);
		
		if (resim_sil_veri($id,'kategori')) {
			$yol  = resim_sil_veri($id,'kategori');
			unlink($yol);
		}
		$sonuc=$this->dtbs->sil($where,'kategori');
		sflash();
		redirect('yonetim/anakategori');
	}


	public function kategoriekle(){
		$this->guvenlik();
		$this->load->view('back/kategoriekle');
	}

	public function kategoriinsert(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$data = array(
			'isim' 		=>$this->input->post('isim'),
			'icerik'	=>	$this->input->post('icerik'),
			'dil'		=>$dil,
			'sef'		=>seflink($this->input->post('isim')),
			'durum'		=>$this->input->post('durum'),
			'kat_id'	=>$this->input->post('kat_id')
		);
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','kategori');
		}
		$sonuc = $this->dtbs->ekle('kategori',$data);
		if ($sonuc) {
			eflash();
			$this->load->view('back/kategoriekle');
		}else{
			echo "başarısız";
		}
	}

	public function urunler(){
		$dil=$this->session->userdata('kimo');
		$kat_id=$this->uri->segment(3);
		$kosul=array('kat_id'=>$kat_id);
		$limit='';
		$sonuc=$this->dtbs->listele_kosul('urun',$limit,$kosul,$dil);
		$data['bilgi']=$sonuc;
		$this->load->view('back/urunler', $data);

	}
	public function urunlistele(){
		$dil=$this->session->userdata('kimo');
		$kat_id=$this->uri->segment(3);
		$sonuc=$this->dtbs->listele_kosul('urun',$kat_id,$dil);
		$data['bilgi']=$sonuc;
		$this->load->view('back/urun-listele', $data);

	}



	public function urunekle(){
		$dil=$this->session->userdata('kimo');
		$this->load->view('back/urunekle');
	}
	public function uruninsert(){

		$dil=$this->session->userdata('kimo');
		$data = array(
			'isim' 		=>$this->input->post('isim'),
			'desc'		=>$this->input->post('desc'),
			'icerik' 	=>$this->input->post('icerik'),
			'dil'		=>$dil,
			'sef'		=>seflink($this->input->post('isim')),
			'kat_id'   	=>$this->input->post('kat_id')
		);
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','urun');
		}
		$sonuc=$this->dtbs->ekle('urun',$data);
		redirect('yonetim/urunekle');
		
	}

	

	public function urunduzenle($id){
		$sonuc=$this->dtbs->cek($id,'urun');
		$data['bilgi']=$sonuc;
		$this->load->view('back/urunduzenle',$data);

	}

	public function urunlerupdate(){
		$kat_idi=$this->input->post('kat_idi');
		if ($kat_idi) { 
			$kat_id=$kat_idi;
		}else{
			$kat_id=$this->input->post('kat_id');
		}
		$data = array(
			'id'	=>	$id=$this->input->post('id'),
			'isim' 	=> 	$this->input->post('isim'),
			'desc'		=>$this->input->post('desc'),
			'icerik'	=> $this->input->post('icerik'),
			'sef'		=>seflink($this->input->post('isim')),
			'kat_id'	=>$kat_id
			
		);

		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','urun');
			if (resim_sil_veri($id,'urun')) {
				$yol  = resim_sil_veri($id,'urun');
				unlink($yol);
			}
		}
		$sonuc= $this->dtbs->guncelle($id,'urun',$data);
		gflash();
		$this->urunduzenle($id);
		
	}


	public function urunsil($id){
		
		$this->guvenlik();
		if (resim_sil_veri($id,'urun')) {
			$yol  = resim_sil_veri($id,'urun');
			unlink($yol);
		}
		$where = array('id' =>$id );
		$sonuc = $this->dtbs->sil($where,'urun');
		sflash();
		redirect('Yonetim/anakategori/'.$this->uri->segment(4).'');	
	}


	public function bloglar(){
		$this->guvenlik();
		$dil=$this->session->userdata('kimo');
		$sonuc=$this->dtbs->liste('blog',$dil);
		$data['bilgi']=$sonuc;
		$this->load->view('back/bloglar', $data);
	}

	public function blogekle(){
		$this->load->view('back/blogekle');
		
	}

	public function bloginsert(){

		$config['upload_path'] = FCPATH.'/assets/front/image/blog';
		$config['allowed_types'] = 'gif|jpg|png|JPEG';


		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('resim')){
			$dil=$this->session->userdata('kimo');
			$data = array(
				'isim' 		=> $this->input->post('isim'),
				'icerik'	=> $this->input->post('icerik'),
				'dil'		=>$dil,
				'sef'		=>seflink($this->input->post('isim')),
				'desc'		=>substr($this->input->post('desc'),0,250),
				'keyw'		=>$this->input->post('keyw')
			);
			$sonuc=$this->dtbs->ekle('blog',$data);
			redirect('Yonetim/bloglar');	
		}
		else{
			$resim= $this->upload->data();
			$resimyolu=$resim['file_name'];
			$resimkayit='assets/front/image/blog/'.$resimyolu.'';
			$dil=$this->session->userdata('kimo');
			$data = array(
				'isim' =>$this->input->post('isim'),
				'resim'=>$resimkayit,
				'icerik'	=> $this->input->post('icerik'),
				'dil'		=>$dil,
				'sef'		=>seflink($this->input->post('isim')),
				'desc'		=>substr($this->input->post('desc'),0,250),
				'keyw'		=>$this->input->post('keyw')
			);
			$sonuc=$this->dtbs->ekle('blog',$data);
			redirect('Yonetim/bloglar');	
		}

	}

	public function blogduzenle($id){
		
		$sonuc=$this->dtbs->cek($id,'blog');
		$data['bilgi']=$sonuc;
		$this->load->view('back/blogduzenle',$data);
	}

	public function blogupdate(){
		$config['upload_path'] = FCPATH.'/assets/front/image/blog';
		$config['allowed_types'] = 'gif|jpg|png|JPEG';
		
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('resim')){
			
			$data = array(
				'id' =>$id=$this->input->post('id'),
				'isim' 		=> $this->input->post('isim'),
				'icerik'	=> $this->input->post('icerik'),
				'sef'		=>seflink($this->input->post('isim')),
				'desc'		=>substr($this->input->post('desc'),0,250),
				'keyw'		=>$this->input->post('keyw') 
			);
			$sonuc=$this->dtbs->guncelle($id,'blog',$data);
			gflash();
			redirect('Yonetim/bloglar');	

		}else{

			$resim =$this->upload->data();
			$resimyolu=$resim['file_name'];
			$resimkayit='assets/front/image/blog/'.$resimyolu.'';
			$data = array(
				'id' =>$id=$this->input->post('id'),
				'isim' =>$this->input->post('isim'),
				'resim'=>$resimkayit,
				'icerik'	=> $this->input->post('icerik'),
				'sef'		=>seflink($this->input->post('isim')),
				'desc'		=>substr($this->input->post('desc'),0,250),
				'keyw'		=>$this->input->post('keyw')
			);
			if (resim_sil_veri($id,'blog')) {
				$yol  = resim_sil_veri($id,'blog');
				unlink($yol);
			}
			$sonuc=$this->dtbs->guncelle($id,'blog',$data);
			gflash();
			redirect('Yonetim/bloglar');	
			
		}
	}

	public function blogsil($id){
		
		$this->guvenlik();
		if (resim_sil_veri($id,'blog')) {
			$yol  = resim_sil_veri($id,'blog');
			unlink($yol);
		}
		$where = array('id' =>$id );
		$sonuc = $this->dtbs->sil($where,'blog');
		sflash();
		redirect('Yonetim/bloglar');	
	}


	public function izmir(){
		$this->guvenlik();
		$sonuc=$this->dtbs->listele('gizli_yayin');
		$data['bilgi']=$sonuc;
		$this->load->view('back/izmir',$data);

	}
	public function izmirekle(){
		$this->load->view('back/izmirekle');
	}
	public function izmirinsert(){
		$config['upload_path'] = FCPATH.'/assets/front/image/izmir';
		$config['allowed_types'] = 'gif|jpg|png';
		
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('resim')){
			$dil=$this->session->userdata('kimo');

			$data = array(
				'isim' 		=> $this->input->post('isim'),
				'icerik'	=> $this->input->post('icerik'),
				'dil'		=>$dil,
				'sef'		=>seflink($this->input->post('isim')),
				'desc'		=>substr($this->input->post('desc'),0,250),
				'keyw'		=>$this->input->post('keyw')
			);
			$sonuc=$this->dtbs->ekle('gizli_yayin',$data);
			redirect('Yonetim/izmir');
		}
		else{
			$resim= $this->upload->data();
			$resimyolu=$resim['file_name'];
			$resimkayit='assets/front/image/izmir/'.$resimyolu.'';
			$dil=$this->session->userdata('kimo');

			$data = array(
				'isim' =>$this->input->post('isim'),
				'resim'=>$resimkayit,
				'dil'	=>$dil,
				'icerik'	=> $this->input->post('icerik'),
				'sef'		=>seflink($this->input->post('isim')),
				'desc'		=>substr($this->input->post('desc'),0,250),
				'keyw'		=>$this->input->post('keyw')
			);
			$sonuc=$this->dtbs->ekle('gizli_yayin',$data);
			redirect('Yonetim/izmir');
		}
	}

	public function izmirduzenle($id){
		
		$sonuc=$this->dtbs->cek($id,'gizli_yayin');
		$data['bilgi']=$sonuc;
		$this->load->view('back/izmirduzenle',$data);
	}

	public function izmirupdate(){
		$config['upload_path'] = FCPATH.'/assets/front/image/izmir';
		$config['allowed_types'] = 'gif|jpg|png';
		
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('resim')){
			
			$data = array(
				'id' =>$id=$this->input->post('id'),
				'isim' 		=> $this->input->post('isim'),
				'icerik'	=> $this->input->post('icerik'),
				'sef'		=>seflink($this->input->post('isim')),
				'desc'		=>substr($this->input->post('desc'),0,250),
				'keyw'		=>$this->input->post('keyw') 
			);
			$sonuc=$this->dtbs->guncelle($id,'gizli_yayin',$data);
			gflash();
			redirect('Yonetim/izmir');
		}else{
			$resim =$this->upload->data();
			$resimyolu=$resim['file_name'];
			$resimkayit='assets/front/image/izmir/'.$resimyolu.'';
			$data = array(
				'id' =>$id=$this->input->post('id'),
				'isim' =>$this->input->post('isim'),
				'resim'=>$resimkayit,
				'icerik'	=> $this->input->post('icerik'),
				'sef'		=>seflink($this->input->post('isim')),
				'desc'		=>substr($this->input->post('desc'),0,250),
				'keyw'		=>$this->input->post('keyw')
			);
			if (resim_sil_veri($id,'gizli_yayin')) {
				$yol  = resim_sil_veri($id,'gizli_yayin');
				unlink($yol);
			}
			$sonuc=$this->dtbs->guncelle($id,'gizli_yayin',$data);
			gflash();
			redirect('Yonetim/izmir');		
		}
	}

	public function izmirsil($id){
		
		$this->guvenlik();
		if (resim_sil_veri($id,'gizli_yayin')) {
			$yol  = resim_sil_veri($id,'gizli_yayin');
			unlink($yol);
		}
		$where = array('id' =>$id );
		$sonuc = $this->dtbs->sil($where,'gizli_yayin');
		sflash();
		redirect('Yonetim/izmir');
	}

	function message(){
		$sonuc=$this->dtbs->listele('iletisim');
		$data['bilgi']=$sonuc;
		$this->load->view('back/message',$data);

	}

	public function iletisim_gor($id,$durum)			
	{		
		$this->guvenlik();
		if ($durum==0) {
			$durum=1;
			$data = array(
				'id' 	=>$id,
				'durum' =>$durum
			);
			$sonuc=$this->dtbs->guncelle($id,'iletisim',$data);
		}
		
		$sonuc= $this->dtbs->cek($id,'iletisim');
		$data['bilgi']=$sonuc;
		$this->load->view('back/iletisim_gor', $data);

	}

	public function message_sil($id){
		$this->guvenlik();
		if (resim_sil_veri($id,'iletisim')) {
			$yol  = resim_sil_veri($id,'iletisim');
			unlink($yol);
		}
		$where=array('id'=>$id);
		$sonuc=$this->dtbs->sil($where,'iletisim');
		redirect('Yonetim/message');
	}

	function teklifler(){
		$sonuc=$this->dtbs->listele('teklif_iste');
		$data['bilgi']=$sonuc;
		$this->load->view('back/teklifler',$data);

	}
	public function teklif_gor($id,$durum)			
	{		
		$this->guvenlik();
		if ($durum==0) {
			$durum=1;
			$data = array(
				'id' 	=>$id,
				'durum' =>$durum
			);
			$sonuc=$this->dtbs->guncelle($id,'teklif_iste',$data);
		}
		
		$sonuc= $this->dtbs->cek($id,'teklif_iste');
		$data['bilgi']=$sonuc;
		$this->load->view('back/teklif_gor', $data);

	}
	public function teklif_sil($id)
	{
		$this->guvenlik();
		$where=array('id'=>$id);
		$sonuc=$this->dtbs->sil($where,'teklif_iste');
		redirect('Yonetim/teklifler');
	}
}









