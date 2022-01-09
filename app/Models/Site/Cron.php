<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;
use Carbon\Carbon;

class Cron extends Model
{
    protected $table = 'tbl_webship_reference';
    protected $primaryKey = 'id';
    protected $fillable = ['webship_reference', 'tracking_number'];
    public $timestamps = false;
	
    public function checkExistingReference($ref_no){
        $recordCount = DB::table($this->table)->where('webship_reference', '=', $ref_no)->count();
        if($recordCount > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateTrackingNumber($ref_no, $tracking_number) {
        $current_date_time = Carbon::now()->toDateTimeString();
        DB::table($this->table)->where('webship_reference', $ref_no)->update(array('tracking_number' => $tracking_number, 'last_updated_on' => $current_date_time));
    }
}
