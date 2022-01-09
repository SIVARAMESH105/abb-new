<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Campcart extends Model
{
	protected $table = 'tbl_campcart';
    protected $primaryKey = 'campct_id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	public function saveCampcart(array $Inputarr,$roster_id){
		
		$date = date("Y-m-d");
		$sid = session_id();
		$this->roster_id = $roster_id; 
		$this->camp_id = $Inputarr["camp_id"]; 
		$this->campct_date = $Inputarr["date"]; 
		$this->campct_session_id = $sid; 
		$this->campct_date = $date;
		$this->save();
		$cart_camp_id = $this->campct_id;
		return $cart_camp_id;
	}
	
	public function deleteCampcart($cid){
		
		$delete_camp = $this::where('camp_id',$cid)->delete();
		return;
	}
}
