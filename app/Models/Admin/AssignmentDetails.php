<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class AssignmentDetails extends Model
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
    // protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function campNameWithLink()
	{
		return '<a href="'.url('admin/manageCamps/'.$this->id.'/edit').'">'.$this->camp_focus.'</a>';
	}
	public function getCoachName($coachId)
	{
		$coach = DB::table('tbl_coach')->select('first_name', 'last_name')->where('id', $coachId)->get();
		if(count($coach) > 0) {
			return $coach[0]->first_name.' '.$coach[0]->last_name;
		}
	}
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function getStateCode()
	{
		return $this->belongsTo('App\Models\Admin\ManageStates', 'State');
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
