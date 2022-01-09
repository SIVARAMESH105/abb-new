<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class WebShipments extends Model
{
	protected $table = 'tbl_webship_reference';
    protected $primaryKey = 'id';
    protected $fillable = ['webship_reference', 'tracking_number'];
    public $timestamps = false;
	
    /*
        * This function is used to get list of affiliate report
        * 
        * return object
    */
    public function getTrackWebShipmentList() {
        $trackWebShipmentList = DB::table('tbl_webship_reference')
                            ->join('tbl_order_item', 'tbl_webship_reference.order_id', '=', 'tbl_order_item.od_id')
                            ->join('tbl_product', 'tbl_order_item.pd_id', '=', 'tbl_product.pd_id')
                            ->join('tbl_order', 'tbl_webship_reference.order_id', '=', 'tbl_order.od_id')
                            ->select('tbl_webship_reference.tracking_number', 'tbl_product.pd_thumbnail', 'tbl_product.pd_name', 'tbl_order_item.od_qty' )
                            ->get();
        return $trackWebShipmentList;
    }
}
