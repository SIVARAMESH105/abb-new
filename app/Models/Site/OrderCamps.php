<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class OrderCamps extends Model
{
    protected $table = 'tbl_order_camp';
    protected $primaryKey = 'od_id';
    protected $fillable = ['title'];
	public $timestamps = false;
	
	
	public function saveOrderCampDetails(array $rosters,$od_id){
		$this->od_id= $od_id;
		$this->camp_id 	= $rosters[0]->camp_id;
		$this->roster_id= $rosters[0]->id;
		$this->save();
		return true;
	}
}
