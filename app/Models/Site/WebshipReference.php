<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class WebshipReference extends Model
{
    protected $table = 'tbl_webship_reference';
    protected $primaryKey = 'id';
    protected $fillable = ['webship_reference', 'tracking_number'];
    public $timestamps = false;
    
    public function saveWebshipOrderReference($webship_id,$od_id){
        $this->webship_reference = $webship_id;
        $this->order_id = $od_id;
        $this->last_updated_on = '';
        $this->save();
        return $this->id;
    }

    /**
     * To check shipment status from database default status is "Booked"
     * @return string
     */
    public function checkWebshipOrderTrackingStatus($tracking_number) {
        $existingTrackingNumber = DB::table($this->table)->where('tracking_number', $tracking_number)->get();
        if (count($existingTrackingNumber) > 0) {
            $order_id = $existingTrackingNumber[0]->order_id;
            $orderDetails = DB::table('tbl_order')
                            ->join('tbl_order_item', 'tbl_order.od_id', '=', 'tbl_order_item.od_id')
                            ->join('tbl_product', 'tbl_order_item.pd_id', '=', 'tbl_product.pd_id')
                            ->join('tbl_webship_reference', 'tbl_order.od_id', '=', 'tbl_webship_reference.order_id')
                            ->select('tbl_order.od_id', 'tbl_webship_reference.tracking_number', 'tbl_product.pd_thumbnail', 'tbl_product.pd_name', 'tbl_order_item.od_qty' )
                            ->where('tbl_order.od_id', '=', $order_id)
                            ->get();
        } else {
            return false;
        }
        return $orderDetails;
    }
}
