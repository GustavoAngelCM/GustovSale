<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    public static function instanceSaved($dish, $quantity, $subTotal, $sale, $type = 'ADD', $key = 0)
    {
        $saleDetail = null;
        if ($type == 'ADD') {
            $saleDetail = new self();
        } else {
            $saleDetail = self::where('id', $key)->first();
        }
        $saleDetail->dishKey = $dish;
        $saleDetail->quantity = $quantity;
        $saleDetail->subTotal = $subTotal;
        $saleDetail->sale_id = $sale;
        $saleDetail->save();
        return $saleDetail;
    }
}
