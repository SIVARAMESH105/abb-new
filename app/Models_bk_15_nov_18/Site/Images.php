<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Images extends Model
{
    protected $table = 'image_gallery';
    
    public function getImages(){
        $images = DB::table($this->table)->where('status',1)->orderBy('id', 'asc')->get();
        return $images;
    }
}