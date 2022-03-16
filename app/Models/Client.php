<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public static function instanceSaved($ci, $name, $type = 'ADD', $key = 0)
    {
        $client = null;
        if ($type == 'ADD') {
            $client = new self();
        } else {
            $client = self::where('id', $key)->first();
        }
        $client->ciNit = strtoupper($ci);
        $client->nameReason = strtoupper($name);
        $client->save();
        return $client;
    }

    public static function getClientByCI($ci)
    {
        return self::where('ciNit', $ci)->first();
    }
}
