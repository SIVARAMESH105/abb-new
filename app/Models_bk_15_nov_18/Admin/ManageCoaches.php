<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class ManageCoaches extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_coach';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['first_name', 'last_name', 'email', 'user_id', 'gender', 'tshirt_size', 'dob', 'emp_startdate', 'address', 'city', 'state', 'zip', 'country', 'home_phone', 'cellphone', 'work_phone', 'notes'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function mergeCoachName()
	{
		return $this->first_name.' '.$this->last_name;
	}
	
	public function getEmailLink()
	{
		return '<a href="mailto:'.$this->email.'">'.$this->email.'</a>';
	}
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function tshirtSize()
	{
		return $this->belongsTo('App\Models\Admin\tshirtSize', 'tshirt_size');
	}
	
	public function country()
	{
		return $this->belongsTo('App\Models\Admin\ManageCountry', 'country');
	}
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
