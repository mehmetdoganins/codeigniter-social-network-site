<?php 
defined('BASEPATH') OR exit(' No diect script access allowed');

class Dtbs extends CI_Model{

	function kontrol($email,$sifre){
		$sonuc=$this->db->select('*')->from('yonetici')
		->where('email',$email)->where('sifre',$sifre)
		->get()->row();
		return $sonuc;
	}
	function timeupdate($id,$data=array()){
		$sonuc= $this->db->where('id',$id)->update('yonetici',$data);
		return $sonuc;
	}
	function listele_kosul($from,$limit,$kosul=array(),$dil){
		$sonuc= $this->db->select('*')->limit($limit)->from($from)->where($kosul)->order_by('id','asc')->get()->result_array();
		return $sonuc;
	}function listen($from,$limit,$kosul=array()){
		$sonuc= $this->db->select('*')->limit($limit)->from($from)->where($kosul)->order_by('id','desc')->get()->result_array();
		return $sonuc;
	}
	function listenPosts($from,$limit,$start,$kosul=array()){
		$sonuc= $this->db->select('*')->limit($limit,$start)->from($from)->where($kosul)->order_by('id','desc')->get()->result_array();
		return $sonuc;
	}
	function listele_kosul_siralama($from,$limit,$kosul=array(),$dil){
		$sonuc= $this->db->select('*')->limit($limit)->from($from)->where($kosul)->where('dil',$dil)->order_by('id','desc')->get()->result_array();
		return $sonuc;
	}
	function listele_sart($from,$sart){
		$sonuc= $this->db->select('*')->from($from)->where($sart)->order_by('id','asc')->get()->result_array();
		return $sonuc;
	}

	function listele_id($from,$id,$dil){
		$sonuc= $this->db->select('*')->from($from)->where('id',$id)->where('dil',$dil)->order_by('id','asc')->get()->result_array();
		return $sonuc;
	}
	function listele_kelime($from,$kelime,$dil){
		$sonuc= $this->db->select('*')->from($from)->where('isim',$kelime)->where('dil',$dil)->order_by('id','asc')->get()->result_array();
		return $sonuc;
	}
	function liste($from,$dil){
		$sonuc= $this->db->select('*')->from($from)->where('dil',$dil)->order_by('id','desc')->get()->result_array();
		return $sonuc;
	}
	function listet($from,$dil){
		$sonuc= $this->db->select('*')->from($from)->where('dil',$dil)->order_by('id','asc')->get()->result_array();
		return $sonuc;
	}
	function listele($from){
		$sonuc= $this->db->select('*')->from($from)->order_by('id','desc')->get()->result_array();
		return $sonuc;
	}
	function liste_limit($from,$limit)
	{
		$sonuc=$this->db->select('*')->limit($limit)->from($from)->order_by('id','desc')->get()->result_array();
		return $sonuc;
	}
	function cek($id,$from){
		$sonuc=$this->db->select('*')->from($from)->where('id',$id)->get()->row_array();
		return $sonuc;
	}
	function cek_id($dil,$id,$from){
		$sonuc=$this->db->select('*')->from($from)->where('id',$id)->where('dil',$dil)->get()->row_array();
		return $sonuc;
	}
	function cek_seflink($dil,$sef,$from){
		$sonuc=$this->db->select('*')->from($from)->where('dil',$dil)->where('sef',$sef)->get()->row_array();
		return $sonuc;
	}
	public function postList($kosul,$limit,$start)
	{
		$sonuc= $this->db->select('*')->from('posts')
		->join('yonetici','yonetici.id=posts.kullanici_id','righet')
		->join('friends','friends.tedilen=posts.kullanici_id','righet')
		->where('friends.teden',$kosul)
		->order_by('posts.id','desc')->limit($limit, $start)->get()->result_array();
		return $sonuc;
	}
	public function profil_post_list($kosul,$limit,$start)
	{
		$sonuc= $this->db->select('*')->from('posts')
		->join('yonetici','yonetici.id=posts.kullanici_id','righet')
		->where('posts.kullanici_id',$kosul)
		->order_by('posts.id','desc')->limit($limit, $start)->get()->result_array();
		return $sonuc;
	}
	public function postDetaylist($id)
	{
		$sonuc= $this->db->select('*')->from('posts')
		->join('yonetici','yonetici.id=posts.kullanici_id','righet')
		->where('posts.id',$id)
		->get()->row_array();
		return $sonuc;
	}
	public function commentlist($id)
	{
		$sonuc= $this->db->select('*')->from('comments')
		->join('yonetici','yonetici.id=comments.user_id','righet')
		->where('comments.post_id',$id)
		->order_by('comments.id','desc')
		->get()->result_array();
		return $sonuc;
	}


	public function commentDetaylist($id)
	{
		$sonuc= $this->db->select('*')->from('comments')
		->join('yonetici','yonetici.id=comments.user_id','righet')
		->where('comments.id',$id)
		->get()->row_array();
		return $sonuc;
	}
	

	public function KategoriListesi($id) {
		$query = $this->db->where("post_id", $id)->get("comments")->result();
		if ($query) {
			foreach ($query as $row) {
				$this->db->where("post_id", $id)->delete("comments");
				
				$this->KategoriListesi($row->id);

			}
		}
	}


	public function follow_list($kosul,$limit,$start)
	{
		$sonuc= $this->db->select('*')->from('friends')
		->join('yonetici','yonetici.id=friends.teden','righet')
		->where('friends.tedilen',$kosul)
		->order_by('friends.id','desc')->limit($limit, $start)->get()->result_array();
		return $sonuc;
	}
	public function following_list($kosul,$limit,$start)
	{
		$sonuc= $this->db->select('*')->from('friends')
		->join('yonetici','yonetici.id=friends.tedilen','righet')
		->where('friends.teden',$kosul)
		->order_by('friends.id','desc')->limit($limit, $start)->get()->result_array();
		return $sonuc;
	}
	public function notList($kosul=array(),$limit)
	{
		$sonuc= $this->db->select('*')->from('notifications')
		->join('yonetici','yonetici.id=notifications.sender_id','righet')
		->join('comments','comments.id=notifications.post_id','left')
		->join('posts','posts.id=notifications.post_id','left')
		->where($kosul)
		->order_by('notifications.id','desc')->limit($limit)->get()->result_array();
		return $sonuc;
	}
	public function followlist($kosul,$limit)
	{
		$sonuc= $this->db->select('*')->from('friends')
		->join('yonetici','yonetici.id=friends.teden','righet')
		->where($kosul)
		->order_by('friends.id','desc')->limit($limit)->get()->result_array();
		return $sonuc;
	}

	function guncelle($id,$from,$data=array()){
		$sonuc =$this->db->where('id',$id)->update($from,$data);
		return $sonuc;
	}

	function ekle($from,$data=array()){
		$sonuc=$this->db->insert($from,$data);
		return $sonuc;
	}
	function sil($where=array(),$from){
		$sonuc =$this->db->where($where)->delete($from);
		return $sonuc;
	}

	function fetch_data($query){
		$this->db->like('isim', $query);
		$query = $this->db->get('yonetici');
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				$output[] = array(
					'name'  => $row["isim"],
					'image'  => $row["resim"],
					'id'  => $row["id"]

				);
			}
			echo json_encode($output);
		}
	}

	function fetch_datai($limit, $start)
	{

		$this->db->select("*");
		$this->db->from("posts");
		$this->db->order_by("id", "DESC");
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query;
	}

	public function topla($id)
	{
$this->db->count_all_results('sayfa');  // Produces an integer, like 25
$this->db->like('urun',$id);
$this->db->from('sayfa');
}

public function arama($kelime,$dil){
	$sonuc=$this->db->like('isim',$kelime)->from('urun')->where('dil',$dil)->get()->result_array();
	return $sonuc;

}

function sepet($id){
	$sonuc=$this->db->select('*')->from('urun')
	->where('id',$id)
	->get()->row();
	return $sonuc;
}


}


?>