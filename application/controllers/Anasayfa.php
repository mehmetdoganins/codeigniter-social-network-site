<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anasayfa extends CI_Controller {

	public function index(){
		$dil=$this->session->userdata('kimo');
		if ($dil=='') {
			$this->session->set_userdata('kimo','tr');
		}
		$this->load->view('front/anasayfa');		
	}
	public function security()
	{
		if ($this->session->userdata('info')==null){
			redirect('Anasayfa');
		}
	}
	public function iletisimekle(){
		$this->form_validation->set_rules('isim', 'isim', 'required');
		$this->form_validation->set_rules('telefon', 'telefon', 'required');
		$this->form_validation->set_rules('icerik', 'içerik', 'required');
		$errors_message = array(
			'required' 	=> '{field} Alanını boş bırakmayınız.', 
		);
		$this->form_validation->set_message($errors_message);
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('iletisimh', '<div class="alert alert-rounded fade alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
				<button type="button" class="close font__size-18" data-dismiss="alert">
				<span aria-hidden="true">
				<i class="fal fa-times"></i>
				</span>
				<span class="sr-only">Close</span>
				</button>
				<i class="start-icon far fa-times-circle"></i>
				<strong class="font__weight-semibold">Merhaba.</strong> Lütfen iletişim formundaki tüm alanları doldurun.!
				</div>');
			redirect('Anasayfa');
		} else {
			$data = array(
				'isim' => $this->input->post('isim'),
				'email' =>$email=$this->input->post('email'),
				'telefon' =>$this->input->post('telefon'),
				'icerik'  =>$icerik=$this->input->post('icerik')
			);
			$sonuc= $this->dtbs->ekle('iletisim',$data);

			$this->session->set_flashdata('iletisim', '<div class="alert alert-success text-center" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Merhaba</strong> Mesajınızı aldık, en kısa sürede dönüş sağlayacağız.!
				</div>');

			redirect('Anasayfa');
		}
		
	}

	public function login()
	{
		if ($this->session->userdata('info')) {
			redirect('Anasayfa');
		}
		$this->load->view('front/login');
	}
	public function loginn(){
		$this->form_validation->set_rules('email','E-mail','trim|required|valid_email');
		$this->form_validation->set_rules('sifre', 'Şifre', 'trim|required');

		$errors_message = array(
			'required' 	=> '{field} Alanını boş bırakmayınız.', 
			'valid_email'	=>'{field} alanına geçerli bir {field} giriniz.'
		);
		$this->form_validation->set_message($errors_message);
		if ($this->form_validation->run()== FALSE) {
			$this->load->view('front/login');
		} else{
			$email= $this->input->post('email');
			$sifre= $this->input->post('sifre');
			$kontrol= $this->dtbs->kontrol($email,$sifre);
			if ($kontrol) {
				$this->session->set_userdata('login',true);
				$this->session->set_userdata('info',$kontrol);
				$data = array('songiris' =>date('d-m-Y H:i:s'));
				$this->dtbs->timeupdate($kontrol->id,$data);
				redirect('Anasayfa');
			}else{
				$this->session->set_flashdata('durum',' Kullanıcı adı ve şifreniz yanlış');
				$this->load->view('front/login');
			}
		}
	}
	public function register()
	{
		$this->load->view('front/register');
	}
	public function registeri(){
		$this->form_validation->set_rules("name","Ad Soyad","required|trim");
		$this->form_validation->set_rules("email", "E-posta", "required|trim|valid_email|is_unique[yonetici.email]");
		$this->form_validation->set_rules("username", "User Name", "required|trim|is_unique[yonetici.username]");
		$this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[6]|max_length[200]");
		$this->form_validation->set_rules("re_password", "Tekrar Şifre", "required|trim|min_length[6]|max_length[200]|matches[password]");

		$error_messages = array(
			"required"  	=> "<strong>{field}</strong>   alanını doldurmak zorundasınız",
			"valid_email"   => "Lütfen geçerli bir {field} adresi giriniz",
			"is_unique"     => "Girmiş olduğunuz {field} ile zaten bir kayıt vardır",
			"matches"       => "Girmiş olduğunuz şifreler birbirleriyle uyuşmuyor"
		);

		$this->form_validation->set_message($error_messages);
		if ($this->form_validation->run()== FALSE) {
			$this->load->view('front/register');
		} else{
			
			$data = array(
				'isim' =>$this->input->post('name'),
				'username' =>sefusername($this->input->post('username')),
				'email'=>$this->input->post('email'),
				'sifre'=>$this->input->post('password')
			);
			$sonuc=$this->dtbs->ekle('yonetici',$data);

			$kontrol= $this->dtbs->kontrol($email,$sifre);
			eflash();
			redirect('Anasayfa/login');
			
		}
	}
	public function nameupdate(){

		$id=$this->input->post('id');
		$this->form_validation->set_rules('name', 'isim', 'trim|required');
		$errors_message = array(
			"required"  	=> "<strong>{field}</strong>   alanını doldurmak zorundasınız",
		);
		$this->form_validation->set_message($errors_message);
		if ($this->form_validation->run()== FALSE) {
			$this->useredit($id);
		} else{
			$data = array(
				'id'    => $id=$this->input->post('id'),
				'isim' 	=>$this->input->post('name')
			);
			$sonuc=$this->dtbs->guncelle($id,'yonetici',$data);
			$this->useredit($id);
		}

	}

	public function usernameupdate(){

		$id=$this->input->post('id');
		$this->form_validation->set_rules("username", "User Name", "required|trim|is_unique[yonetici.username]");
		$errors_message = array(
			"valid_email"   => "Lütfen geçerli bir {field} adresi giriniz",
			"is_unique"     => "Girmiş olduğunuz {field} ile zaten bir kayıt vardır"
		);
		$this->form_validation->set_message($errors_message);
		if ($this->form_validation->run()== FALSE) {
			$this->useredit($id);
		} else{
			$data = array(
				'id'    => $id=$this->input->post('id'),
				'username' 	=>$this->input->post('username')
			);
			$sonuc=$this->dtbs->guncelle($id,'yonetici',$data);
			$this->useredit($id);
		}

	}


	public function emailupdate(){

		$id=$this->input->post('id');
		$this->form_validation->set_rules("email", "E-posta", "required|trim|valid_email|is_unique[yonetici.email]");
		$errors_message = array(
			"valid_email"   => "Lütfen geçerli bir {field} adresi giriniz",
			"is_unique"     => "Girmiş olduğunuz {field} ile zaten bir kayıt vardır"
		);
		$this->form_validation->set_message($errors_message);
		if ($this->form_validation->run()== FALSE) {
			$this->useredit($id);
		} else{
			$data = array(
				'id'    => $id=$this->input->post('id'),
				'email' 	=>$this->input->post('email')
			);
			$sonuc=$this->dtbs->guncelle($id,'yonetici',$data);
			$this->useredit($id);
		}

	}

	public function passwordupdate(){

		$id=$this->input->post('id');
		$this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[5]|max_length[100]|matches[password]");
		$this->form_validation->set_rules("re_password", "Tekrar Şifre", "required|trim|min_length[5]|max_length[100]|matches[password]");
		$errors_message = array(
			"required"  	=> "<strong>{field}</strong>   alanını doldurmak zorundasınız",
			"matches"       => "Girmiş olduğunuz şifreler birbirleriyle uyuşmuyor"
		);
		$this->form_validation->set_message($errors_message);
		if ($this->form_validation->run()== FALSE) {
			$this->useredit($id);
		} else{
			$data = array(
				'id'    => $id=$this->input->post('id'),
				'sifre' 	=>$this->input->post('password')
			);
			$sonuc=$this->dtbs->guncelle($id,'yonetici',$data);
			$this->useredit($id);
		}

	}

	public function infoupdate(){

		$id=$this->input->post('id');
		$this->form_validation->set_rules("info", "Personel Information", "required|trim|max_length[200]");
		$errors_message = array(
			"required"  	=> "<strong>{field}</strong>   alanını doldurmak zorundasınız",
			"matches"       => "Girmiş olduğunuz şifreler birbirleriyle uyuşmuyor"
		);
		$this->form_validation->set_message($errors_message);
		if ($this->form_validation->run()== FALSE) {
			$this->useredit($id);
		}else{
			$data = array(
				'id'    => $id=$this->input->post('id'),
				'infos' 	=>$this->input->post('info')
			);
			$sonuc=$this->dtbs->guncelle($id,'yonetici',$data);
			$this->useredit($id);
		}

	}
	public function ppupdate()
	{
		$data = array(
			'id'    => $id=$this->input->post('id'),
			
		);
		if ($_FILES['resim']['size']>0) {
			$data['resim']=image_upload('resim','avatar');
			if (resim_sil_veri($id,'yonetici')) {
				$yol  = resim_sil_veri($id,'yonetici');
				unlink($yol);
			}
		}
		$sonuc=$this->dtbs->guncelle($id,'yonetici',$data);

		redirect('Anasayfa/useredit/'.$id.'');
		
	}

	public function profile()
	{
		if ($this->uri->segment(3)=='') {
			redirect('Anasayfa');
		}
		$this->load->view('front/profile');
	}

	public function postinsert(){

		$info=$this->session->userdata('info');
		$data = array(
			'title'			=>$this->input->post('title'),
			'content' 		=>$this->input->post('post'),
			'kullanici_id'	=>$info->id,
			'tarih'			=>date('d-m-Y H:i:s'),
		);
		
		if ($_FILES['img']['size']>0) {
			$success=$data['file']=image_upload('img','avatar');

			if (!$success) {
				flash('danger','Message','You are trying to upload in an unsupported format.');
				redirect('anasayfa/profile/'.$info->id.'');

			}
		}

		$sonuc=$this->dtbs->ekle('posts',$data);


		$id=$this->db->insert_id();
		$data = array(
			'idi' 	=>$id
		);

		$sonuc=$this->dtbs->guncelle($id,'posts',$data);
		redirect('anasayfa/profile/'.$info->id.'');
	}
	public function commentsinsert()
	{
		$uri=$this->input->post('uri');
		$uri1=$this->input->post('uri1');
		$uri2=$this->input->post('uri2');
		$receiver_id=$this->input->post('receiver_id');
		$type=$this->input->post('type');



		$data = array(
			'comment' => $this->input->post('comment'),
			'user_id' => $ipaddress=$this->input->post('user_id'),
			'post_id' => $storyid=$this->input->post('post_id'),
			'date' => date('d-m-Y H:i:s')

		);

		$sonuc=$this->dtbs->ekle('comments',$data);

		
		

		$id=$this->db->insert_id();
		$data = array(
			'idi' 	=>$id
		);
		$sonuc=$this->dtbs->guncelle($id,'comments',$data);
		$data=array('post_id'=>$storyid,'sender_id'=>$ipaddress,'receiver_id'=>$receiver_id,'type'=>$type,'commentsId'=>$id);
		$this->db->insert('notifications',$data);

		if ($sonuc){
			if ($uri1=="fetchi" or $uri1=="fetchip") {
				redirect('Anasayfa/postDetail/'.$this->input->post('post_id').'');
			}else{
				redirect($uri.'/'.$uri1.'/'.$uri2.'');
			}
		}
	}

	public function postsil($id){
		
		if (image_del($id,'posts','file')) {
			$yol  = image_del($id,'posts','file');
			unlink($yol);
		};
		$this->db->where("id", $id)->delete("posts");
		$this->dtbs->kategoriListesi($id); 
		$pid=$this->session->userdata('info')->id;
		redirect('Anasayfa/profile/'.$pid.'');

	}
	public function commentssil($id){
		$cek=$this->dtbs->cek($id,'comments'); 
		$sesi=$cek['post_id'];
		$sess=$this->session->set_userdata('posti',$sesi);

		$this->db->where("id", $id)->delete("comments");
		$this->dtbs->kategoriListesi($id); 
		$id=$this->session->userdata('posti');
		redirect('Anasayfa/commentDetail/'.$id.'');
		

	}
	public function postedit($id)
	{
		$result=$this->dtbs->cek($id,'posts');
		$data['infoedit']=$result;
		$this->load->view('front/postedit',$data);
	}
	public function follow($teden,$tedilen)
	{

		$data = array(
			'teden' 	=>$teden,
			'tedilen'	=>$tedilen,
			'date'		=>date('d-m-Y H:i:s')
		);

		$result=$this->dtbs->ekle('friends',$data);
		redirect('Anasayfa/profile/'.$tedilen.'');
	}
	public function unfollow($id,$profile){
		$where = array('id' =>$id );
		$sonuc = $this->dtbs->sil($where,'friends');
		redirect('Anasayfa/profile/'.$profile.'');
	}
	public function useredit($id){
		$user=$this->session->userdata('info');
		if ($user->id==$id) {
			$sonuc=$this->dtbs->cek($id,'yonetici');
			$data['bilgi']=$sonuc;
			$this->load->view('front/useredit',$data);
		}else{
			redirect('Anasayfa/profile/'.$user->id.'');
		}
		
	}

	

	public function dil()
	{

		$seg=$this->uri->segment(3);

		$kontrol= $seg;

		$this->session->set_userdata('kimo',$kontrol);
		$kim=$this->session->userdata('kimo');
		echo $kim;
		redirect('anasayfa');

	}

	public function arama(){
		$dil=$this->session->userdata('kimo');
		$kelime=$this->input->post('kelime');
		$sonuc=$this->dtbs->listele_kelime('urun',$kelime,$dil); 
		$data['bilgi']=$sonuc;
		$this->load->view('front/arama', $data);
	}
	public function postDetail($id)
	{

		$result=$this->dtbs->postDetaylist($id);
		if (!$result) {
			redirect('Anasayfa');
		}
		$data['row']=$result;
		$commentlist=$this->dtbs->commentlist($id);
		$data['comment']=$commentlist;
		$this->load->view('front/postDetail',$data);
	}
	public function commentDetail($id)
	{
		$result=$this->dtbs->commentDetaylist($id);
		$data['row']=$result;
		$commentlist=$this->dtbs->commentlist($id);
		$data['comment']=$commentlist;
		if (!$result) {
			redirect('Anasayfa/postDetail/'.$id.'');
		}
		$this->load->view('front/commentDetail',$data);

	}

	function fetch()
	{
		echo $this->dtbs->fetch_data($this->uri->segment(3));
	}
	function fetchi()
	{

		$kosul=$info=$this->session->userdata('info')->id;
		$output = '';
		$limit=$this->input->post('limit'); $start=$this->input->post('start');
		$test=$this->dtbs->postList($kosul,$limit,$start); foreach ($test as $row) { 
			$sart = array('post_id' =>$row['idi']);
			$comment_count=$this->dtbs->listele_sart('comments',$sart);
			$countt=count($comment_count);
			
			if ($row['resim']=="") {
				$img='assets/front/image/unisexavatar.jpg';
			}else{
				$img=$row['resim'];
			}

			if ($info) {
				$display="";
			}else{
				$display="d-none";
			}
			if (substr(strrchr($row['file'],'.'),1)=="mp4" or substr(strrchr($row['file'],'.'),1)=="mp4") {
				$file='<video class="videoo" controls>
				<source src="'.base_url().$row['file'].'" type="video/'.substr(strrchr($row['file'],'.'),1).'">
				<source src="'.base_url().$row['file'].'" type="video/ogg">
				Your browser does not support the video tag.
				</video><br>';
			}elseif($row['file']==null){
				$file="";
			}elseif(substr(strrchr($row['file'],'.'),1)=="pdf"){
				$file='<embed class="pdff" src="'.base_url().$row['file'].'" type="application/pdf"">';

			}elseif(substr(strrchr($row['file'],'.'),1)=="wav" or substr(strrchr($row['file'],'.'),1)=="amr" or substr(strrchr($row['file'],'.'),1)=="mp3" ){ 
				$file='<audio controls>
				<source src="'.base_url().$row['file'].'" type="audio/ogg">
				<source src="'.base_url().$row['file'].'" type="audio/'.substr(strrchr($row['file'],'.'),1).'">
				Tarayıcınız audio elementini desteklemiyor.
				</audio><br>';
			}else{
				$file='<a href="'.base_url().$row['file'].'?text=1" data-toggle="lightbox" data-gallery="gallery'.$row['idi'].'">
				<img src="'.base_url().$row['file'].'" class="img-fluid videoo mb-2" alt="white sample"/>
				</a><br>';
			}

			$output .= '

			<div class="post">
			<div class="user-block">
			<img class="img-circle img-bordered-sm" src="'.base_url().$img.'">
			<span class="username">


			<a href="'.base_url('Anasayfa/profile/'.$row['kullanici_id'].'').'">'.$row['isim'].'</a>
			</span>
			<span class="description">Shared publicly - '.$row['tarih'].'</span>
			</div>


			<!-- /.user-block -->
			<a class="nav-link text-gray-dark" href="'.base_url('Anasayfa/postDetail/'.$row['idi'].'/'.seflink($row['title']).'').'">
			<b><h6>'.$row['title'].'</h6></b>
			<p>'.$row['content'].'
			</p></a>
			'.$file.'
			<a href="#" class="link-black text-sm mr-2 d-none"><i class="fas fa-share mr-1"></i> Share</a>
			<a onclick="javascript:savelike('.$row['idi'].');">
			<i class="fa fa-thumbs-up"></i> 
			<span id="like_'.$row['idi'].'">
			'.$row['likes'].'
			</span></a>
			<a href="'.base_url('Anasayfa/postDetail/'.$row['idi'].'').'" class="link-black text-sm float-right mb-2">
			<i class="far fa-comments mr-1"></i> Comments ('.$countt.')
			</a>
			<form class="form-horizontal '.$display.'" action="'.base_url('Anasayfa/commentsinsert').'" method="post">
			<div class="input-group input-group-sm mb-0">
			<input class="form-control form-control-sm" name="comment" placeholder="Response">
			<input type="hidden" value="'.$kosul.'" name="user_id">
			<input type="hidden" value="'.$row['idi'].'" name="post_id">
			<input type="hidden" value="'.$row['kullanici_id'].'" name="receiver_id">
			<input type="hidden" name="type" value="post">
			<input type="hidden" name="uri" value="'.$this->uri->segment(1).'">
			<input type="hidden" name="uri1" value="'.$this->uri->segment(2).'">
			<input type="hidden" name="uri2" value="">
			<div class="input-group-append">
			<button type="submit" class="btn btn-danger">Send</button>
			</div>
			</div>
			</form>
			</div>
			';
		}
		echo $output;
	}


	function fetchip()
	{
		$info=$this->session->userdata('info');
		$kosul=$this->input->post('kosul');
		$outputp = '';
		$limit=$this->input->post('limit'); $start=$this->input->post('start');
		$test=$this->dtbs->profil_post_list($kosul,$limit,$start); foreach ($test as $row) { 
			$sart = array('post_id' =>$row['idi']);
			$comment_count=$this->dtbs->listele_sart('comments',$sart);
			$countt=count($comment_count);
			
			if (!$info=="" and $row['kullanici_id']==$info->id) {
				$dropdown= '<div class="btn-group dropleft float-right">
				<button type="button" class="btn btn-ligt dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				</button>
				<div class="dropdown-menu">
				<ul>
				<li class="nav-link"><a href="'.base_url('Anasayfa/postsil/'.$row['idi'].'').'" class="nav-item text-danger"> <i class="far fa-trash-alt"></i> Delete</a></li>
				</ul>
				</div>
				</div>';
			}else{
				$dropdown='';
			}
			if ($info) {
				$display="";
			}else{
				$display="d-none";
			}
			if (substr(strrchr($row['file'],'.'),1)=="mp4") {
				$file='<video class="videoo" controls>
				<source src="'.base_url().$row['file'].'" type="video/mp4">
				<source src="'.base_url().$row['file'].'" type="video/ogg">
				Your browser does not support the video tag.
				</video><br>';
			}elseif($row['file']==null){
				$file="";
			}elseif(substr(strrchr($row['file'],'.'),1)=="pdf"){
				$file='<embed class="pdff" src="'.base_url().$row['file'].'" type="application/pdf"">';

			}elseif(substr(strrchr($row['file'],'.'),1)=="wav" or substr(strrchr($row['file'],'.'),1)=="amr" or substr(strrchr($row['file'],'.'),1)=="mp3" ){ 
				$file='<audio  controls>
				<source src="'.base_url().$row['file'].'" type="audio/ogg">
				<source src="'.base_url().$row['file'].'" type="audio/mpeg">
				Tarayıcınız audio elementini desteklemiyor.
				</audio><br>';
			}else{
				$file='<a href="'.base_url().$row['file'].'?text=1" data-toggle="lightbox" data-gallery="gallery'.$row['idi'].'">
				<img src="'.base_url().$row['file'].'" class="img-fluid mb-2" alt="white sample"/>
				</a><br>';
			}
			
				if ($row['resim']=="") {
					$img='assets/front/image/unisexavatar.jpg';
				}else{
					$img=$row['resim'];
				}
				$outputp .= '
				<div class="post">
				<div class="user-block">
				<img class="img-circle img-bordered-sm" src="'.base_url().$img.'">
				<span class="username">


				<a href="'.base_url('Anasayfa/profile/'.$row['kullanici_id'].'').'">'.$row['isim'].'</a>
				</span>
				<span class="description">Shared publicly - '.$row['tarih'].'</span>
				'.$dropdown.'
				</div>


				<!-- /.user-block -->
				<a class="nav-link text-gray-dark" href="'.base_url('Anasayfa/postDetail/'.$row['idi'].'/'.seflink($row['title']).'').'">
				
				<p>'. $row['content'].'
				</p>
				<br>
				</a>
				'.$file.'



				<a href="#" class="link-black text-sm mr-2 d-none"><i class="fas fa-share mr-1"></i> Share</a>
				<a onclick="javascript:savelike('.$row['idi'].');">
				<i class="fa fa-thumbs-up"></i> 
				<span id="like_'.$row['idi'].'">
				'.$row['likes'].'
				</span></a>


				<a href="'.base_url('Anasayfa/postDetail/'.$row['idi'].'').'" class="link-black text-sm float-right mb-2">
				<i class="far fa-comments mr-1"></i> Comments ('.$countt.')
				</a>
				<form class="form-horizontal '.$display.'" action="'.base_url('Anasayfa/commentsinsert').'" method="post">
				<div class="input-group input-group-sm mb-0">
				<input class="form-control form-control-sm" name="comment" placeholder="Response">
				<input type="hidden" value="'.$kosul.'" name="user_id">
				<input type="hidden" value="'.$row['idi'].'" name="post_id">
				<input type="hidden" value="'.$row['kullanici_id'].'" name="receiver_id">
				<input type="hidden" name="type" value="post">
				<input type="hidden" name="uri" value="'.$this->uri->segment(1).'">
				<input type="hidden" name="uri1" value="'.$this->uri->segment(2).'">
				<input type="hidden" name="uri2" value="">
				<div class="input-group-append">
				<button type="submit" class="btn btn-danger">Send</button>
				</div>
				</div>
				</form>
				</div>
				';
			


		}
		echo $outputp;
	}



	public function followersList()
	{
		$this->security();
		if ($this->uri->segment(3)=='') {
			redirect('Anasayfa');
		}
		$this->load->view('front/followList');
	}
	public function followingsList()
	{
		$this->security();
		if ($this->uri->segment(3)=='') {
			redirect('Anasayfa');
		}
		$this->load->view('front/followingList');
	}


	function fetch_follow()
	{
		$info=$this->session->userdata('info');
		$kosul=$this->input->post('kosul');
		$outputfoll = '';
		$limit=$this->input->post('limit'); $start=$this->input->post('start');
		$test=$this->dtbs->follow_list($kosul,$limit,$start); foreach ($test as $row) { 

			$outputfoll .= '
			<li class="item mt-2">
			<a href="'.base_url('Anasayfa/profile/').$row['id'].'" class="product-title nav-link"><div class="product-img">
			<img src="'.base_url().$row['resim'].'" alt="Product Image" class="user-image img-circle elevation-2 mt-2">
			</div>
			<div class="product-info">
			'.$row['isim'].'
			<span class="badge badge-warning float-right"><i class="fas fa-angle-right"></i></span>
			<span class="product-description">
			'.$row['username'].'
			</span></a>
			</div>
			</li>
			';
		}
		echo $outputfoll;
	}

	function fetch_following()
	{
		$info=$this->session->userdata('info');
		$kosul=$this->input->post('kosul');
		$outputfollowing = '';
		$limit=$this->input->post('limit'); $start=$this->input->post('start');
		$test=$this->dtbs->following_list($kosul,$limit,$start); foreach ($test as $row) { 

			$outputfollowing .= '
			<li class="item mt-2">
			<a href="'.base_url('Anasayfa/profile/').$row['id'].'" class="product-title nav-link"><div class="product-img">
			<img src="'.base_url().$row['resim'].'" alt="Product Image" class="user-image img-circle elevation-2 mt-2">
			</div>
			<div class="product-info">
			'.$row['isim'].'
			<span class="badge badge-warning float-right"><i class="fas fa-angle-right"></i></span>
			<span class="product-description">
			'.$row['username'].'
			</span></a>
			</div>
			</li>
			';
		}
		echo $outputfollowing;
	}

	public function savelikes()
	{
		$ipaddress=$this->session->userdata('info')->id;;
		$storyid=$this->input->post('Storyid');

		$result=$this->dtbs->cek($storyid,'posts');
		$receiver_id=$result['kullanici_id'];



		$fetchlikes=$this->db->query('select likes from posts where id="'.$storyid.'"');
		$result=$fetchlikes->result();

		$checklikes = $this->db->query('select * from storylikes 
			where storyid="'.$storyid.'" 
			and ipaddress = "'.$ipaddress.'"');
		$resultchecklikes = $checklikes->num_rows();

		if($resultchecklikes == '0' ){
			if($result[0]->likes=="" || $result[0]->likes=="NULL")
			{
				$this->db->query('update posts set likes=1 where id="'.$storyid.'"');
			}
			else
			{
				$this->db->query('update posts set likes=likes+1 where id="'.$storyid.'"');

				$data=array('post_id'=>$storyid,'sender_id'=>$ipaddress,'receiver_id'=>$receiver_id,'type'=>'postLike');
				$this->db->insert('notifications',$data);

			}

			$data=array('storyid'=>$storyid,'ipaddress'=>$ipaddress);
			$this->db->insert('storylikes',$data);



		}else{
			$this->db->delete('storylikes', array('storyid'=>$storyid,
				'ipaddress'=>$ipaddress));
			$this->db->query('update posts set likes=likes-1 where id="'.$storyid.'"');

			$this->db->delete('notifications', array('post_id'=>$storyid,
				'sender_id'=>$ipaddress));

		}

		$this->db->select('likes');
		$this->db->from('posts');
		$this->db->where('id',$storyid);
		$query=$this->db->get();
		$result=$query->result();

		echo $result[0]->likes;
	}

	public function saveCommetlike()
	{
		$ipaddress=$this->session->userdata('info')->id;;
		$storyid=$this->input->post('Storyid');

		$result=$this->dtbs->cek($storyid,'comments');
		$receiver_id=$result['user_id'];



		$fetchlikes=$this->db->query('select likes from comments where id="'.$storyid.'"');
		$result=$fetchlikes->result();

		$checklikes = $this->db->query('select * from commentlikes 
			where storyid="'.$storyid.'" 
			and ipaddress = "'.$ipaddress.'"');
		$resultchecklikes = $checklikes->num_rows();

		if($resultchecklikes == '0' ){
			if($result[0]->likes=="" || $result[0]->likes=="NULL")
			{
				$this->db->query('update comments set likes=1 where id="'.$storyid.'"');
			}
			else
			{
				$this->db->query('update comments set likes=likes+1 where id="'.$storyid.'"');

				$data=array('post_id'=>$storyid,'sender_id'=>$ipaddress,'receiver_id'=>$receiver_id,'type'=>'commentLike');
				$this->db->insert('notifications',$data);

			}

			$data=array('storyid'=>$storyid,'ipaddress'=>$ipaddress);
			$this->db->insert('commentlikes',$data);



		}else{
			$this->db->delete('commentlikes', array('storyid'=>$storyid,
				'ipaddress'=>$ipaddress));
			$this->db->query('update comments set likes=likes-1 where id="'.$storyid.'"');

			$this->db->delete('notifications', array('post_id'=>$storyid,
				'sender_id'=>$ipaddress));

		}

		$this->db->select('likes');
		$this->db->from('comments');
		$this->db->where('id',$storyid);
		$query=$this->db->get();
		$result=$query->result();

		echo $result[0]->likes;
	}
	function fetchii()
	{
		$output = '';
		$data = $this->dtbs->fetch_datai($this->input->post('limit'), $this->input->post('start'));
		if($data->num_rows() > 0)
		{
			foreach($data->result() as $row)
			{
				$output .= '
				<div class="post_data">
				<h3 class="text-danger">'.$row->id.'</h3>
				<p>'.$row->content.'</p>
				</div>
				';
			}
		}
		echo $output;
	}
	public function bildirimler()
	{
		$info=$this->session->userdata('info')->id;
		$limit="5";
		$kosul = array('receiver_id' =>$info );
		$query = $this->dtbs->notList($kosul,$limit);foreach ($query as $key) {
			echo $key['isim'];
			echo $key['comment'];
		}
	}
	
	public function ajaxi()
	{
		
		$con = mysqli_connect("localhost", "root", "", "new_date");
		if($_POST["view"] != '')
		{
			$update_query = "UPDATE notifications SET comment_status = 1 WHERE comment_status=0";
			mysqli_query($con, $update_query);
		}
		$info=$this->session->userdata('info')->id;
		$limit="5";
		$kosul = array('receiver_id' =>$info );
		$query = $this->dtbs->notList($kosul,$limit);
		
		$output = '';
		if ($query) {
			foreach ($query as $key) {
				if (substr(strrchr($key['file'],'.'),1)=="mp4" or substr(strrchr($key['file'],'.'),1)=="mp4") {
					$file='<video class="notiMedia" controls>
					<source src="'.base_url().$key['file'].'" type="video/'.substr(strrchr($key['file'],'.'),1).'">
					<source src="'.base_url().$key['file'].'" type="video/ogg">
					Your bitemsser does not support the video tag.
					</video><br>';
				}elseif($key['file']==null){
					$file="";
				}elseif(substr(strrchr($key['file'],'.'),1)=="pdf"){
					$file='<embed class="pdff" src="'.base_url().$key['file'].'" type="application/pdf"">';

				}elseif(substr(strrchr($key['file'],'.'),1)=="wav" or substr(strrchr($key['file'],'.'),1)=="amr" or substr(strrchr($key['file'],'.'),1)=="mp3" ){ 
					$file='<audio class="audioWidth" controls>
					<source src="'.base_url().$key['file'].'" type="audio/ogg">
					<source src="'.base_url().$key['file'].'" type="audio/'.substr(strrchr($key['file'],'.'),1).'">
					Tarayıcınız audio elementini desteklemiyor.
					</audio><br>';
				}else{
					$file='<a href="'.base_url().$key['file'].'?text=1" data-toggle="lightbox" data-gallery="gallery'.$key['idi'].'">
					<img src="'.base_url().$key['file'].'" class="img-fluid videoo mb-2" alt="white sample"/>
					</a><br>';
				}

				if ($key['type']=='post') {
					$output .= '

					<div class="media mt-1 ml-1">
					<img src="'.base_url().$key['resim'].'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
					<div class="media-body">
					<h3 class="dropdown-item-title">'.$key['isim'].'<i class="far fa-comment float-right"></i></h3>
					<small>Gönderine yorum yaptı</small>
					<p class="text-sm">'.kisalt($key['content'],200).'<br>'.$file.'</p>
					<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$key['notificationDate'].'</p>
					</div>
					</div>
					<div class="dropdown-divider"></div>
					';
				}elseif($key['type']=="comment"){

					$output .= '

					<div class="media mt-1 ml-1">
					<img src="'.base_url().$key['resim'].'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
					<div class="media-body">
					<h3 class="dropdown-item-title">'.$key['isim'].' <i class="far fa-comment float-right"></i></h3>
					<small>Yorumuna yorum yaptı</small>
					<p class="text-sm">'.kisalt($key['comment'],200).'<br>'.$file.'</p>
					<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$key['notificationDate'].'</p>
					</div>
					</div>
					<div class="dropdown-divider"></div>
					';
				}elseif($key['type']=="postLike"){
					$output .= '

					<div class="media mt-1 ml-1">
					<img src="'.base_url().$key['resim'].'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
					<div class="media-body">
					<h3 class="dropdown-item-title">'.$key['isim'].' <i class="far fa-heart text-red float-right"></i></h3>
					<small>Gönderini Beğendi</small>
					<p class="text-sm">'.kisalt($key['content'],200).'<br>'.$file.'</p>
					<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$key['notificationDate'].'</p>
					</div>
					</div>
					<div class="dropdown-divider"></div>
					';
				}else{
					$output .= '

					<div class="media mt-1 ml-1">
					<img src="'.base_url().$key['resim'].'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
					<div class="media-body">
					<h3 class="dropdown-item-title">'.$key['isim'].' <i class="far fa-heart text-red float-right"></i></h3>
					<small>Yorumunu Beğendi</small>
					<p class="text-sm">'.kisalt($key['comment'],200).'<br>'.$file.'</p>
					<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$key['notificationDate'].'</p>
					</div>
					</div>
					<div class="dropdown-divider"></div>
					';
				}

			}
			$output .= '
			<div class="dropdown-divider"></div>
			<a href="'.base_url('Anasayfa/seeAllLnotLike').'" class="dropdown-item dropdown-footer">See All Notifications</a>';
		}else{
			$output .= '
			<li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';

		}
		$status_query = "SELECT * FROM notifications WHERE receiver_id=$info And comment_status=0";
		$result_query = mysqli_query($con, $status_query);
		$count = mysqli_num_rows($result_query);
		$data = array(
			'notification' => $output,
			'unseen_notification'  => $count
		);

		echo json_encode($data);
	}
	public function follownoti()
	{
		$con = mysqli_connect("localhost", "root", "", "new_date");
		if($_POST["view"] != '')
		{
			$update_query = "UPDATE friends SET durum = 1 WHERE durum=0";
			mysqli_query($con, $update_query);
		}
		$info=$this->session->userdata('info')->id;
		$limit="5";
		$kosul = array('tedilen' =>$info );
		$query = $this->dtbs->followlist($kosul,$limit);
		$outputi = '';
		if ($query) {
			foreach ($query as $key) {
				$outputi .= '

				<div class="media mt-1 ml-1">
				<img src="'.base_url().$key['resim'].'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
				<div class="media-body">
				<h3 class="dropdown-item-title">'.$key['isim'].' <i class="fas fa-user-plus text-muted float-right"></i></h3>
				<p class="text-sm">followed you</p>
				<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$key['date'].'</p>
				</div>
				</div>
				<div class="dropdown-divider"></div>
				';

			}
			$outputi .= '
			<div class="dropdown-divider"></div>
			<a href="'.base_url('Anasayfa/seeAllnot').'" class="dropdown-item dropdown-footer">See All Notifications</a>';
		}else{
			$outputi .= '
			<li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';

		}

		$status_query = "SELECT * FROM friends WHERE tedilen=$info And durum=0";
		$result_query = mysqli_query($con, $status_query);
		$countf = mysqli_num_rows($result_query);
		$data = array(
			'notificationf' => $outputi,
			'unseen_notificationf'  => $countf
		);

		echo json_encode($data);
	}
	public function seeAllnot()
	{

		$limit="";
		$kosul = array('tedilen' =>$this->session->userdata('info')->id);
		$query = $this->dtbs->followlist($kosul,$limit);
		$data['followlist']=$query;
		$this->load->view('front/seeAllnot',$data);
	}
	public function seeAllLnotLike()
	{

		$info=$this->session->userdata('info')->id;
		$kosul = array('receiver_id' =>$info );
		$limit="";
		$query = $this->dtbs->notList($kosul,$limit);
		$data['followlist']=$query;
		$this->load->view('front/seeAllLnotLike',$data);
	}
	public function kayit()
	{
		$this->load->view('front/kayit');
	}

	public function joino()
	{

		$test=$this->dtbs->joino(); foreach ($test as $key) { ?>
			<?php echo $key['isim']; ?><br><?php echo $key['content']; ?><br>
		<?php }
	}

	public function kayitekle()
	{
		$data = array(
			'isim' => $this->input->post('isim'),
			'soyisim'=>$this->input->post('soyisim'),
			'email'		=>$this->input->post('email'),
			'parola'	=>$this->input->post('password')
		);

		$sonuc=$this->dtbs->ekle('users',$data);
		echo "başarılı";
	}

	public function giris()
	{
		$this->load->view('front/giris');
	}
	public function girisyap()
	{
		$email=$this->input->post('email');
		$sifre=$this->input->post('password');
		$kontrol=$this->dtbs->kontrol($email,$sifre);
		if ($kontrol) {
			$this->session->set_userdata('login',TRUE);
			$this->session->set_userdata('user',$kontrol);
		}
		redirect('anasayfa');
	}

	public function sepet()
	{

		$this->load->view('front/sepet');
	}

	public function sepeteekle($id)
	{

		$urun_id=$this->uri->segment(3);
		$kullanici_id=$this->uri->segment(4);
		$dil=$this->session->userdata('kimo');
		$data = array(
			'urun_id' => $urun_id,
			'kullanici_id'=>$kullanici_id,
			'dil'=>$dil
		);
		$sonuc=$this->dtbs->ekle('sepet',$data);
		redirect('anasayfa/sepet');

	}

	public function userexit()
	{
		$this->session->sess_destroy();
		redirect('anasayfa');
	}


}

?>