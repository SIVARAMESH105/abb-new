<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class DirectorListReports extends Model 
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
     protected $table = 'users';
    
    public function getDirectorList()
    {     
        $directorList = DB::table($this->table)
                        ->select('id','name','email','address','city','home_phone')
                        ->where('user_type', '=', '4')
                        ->orderBy('email')
                        ->get();
        return $directorList;
    }
}

?>