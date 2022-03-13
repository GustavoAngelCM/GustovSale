<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Validators\SaleValidate;

class SaleController extends Controller
{
    public function register(Request $request)
    {
        $rules = new SaleValidate($request);
        $validationResponse = $rules->validate();
        if (is_array($validationResponse) || $validationResponse === false) {
            return $this->jsonAnswer('Formato de envio incorrecto [SALE_REGISTER].', null, $validationResponse, false, 400);
        }
    }
}
