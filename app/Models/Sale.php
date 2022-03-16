<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sale extends Model
{
    public static function instanceSaved($mount, $client, $type = 'ADD', $key = 0)
    {
        $sale = null;
        if ($type == 'ADD') {
            $sale = new self();
        } else {
            $sale = self::where('id', $key)->first();
        }
        $sale->totalAmount = $mount;
        $sale->keySale = (string) Str::uuid();
        $sale->client_id = $client;
        $sale->save();
        return $sale;
    }

    public static function getSaleByUUID($uuid)
    {
        return self::where('keySale', $uuid)->first();
    }
}
