<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Validators\SaleValidate;
use App\Builders\SaleBuilder;

use App\Models\Sale;

class SaleController extends Controller
{
    public function register(Request $request)
    {
        $rules = new SaleValidate($request);
        $validationResponse = $rules->validate();
        if (is_array($validationResponse) || $validationResponse === false)
        {
            return $this->jsonAnswer('Formato de envio incorrecto [SALE_REGISTER].', null, $validationResponse, false, 400);
        }
        DB::beginTransaction();
        try
        {
            $newSale = new SaleBuilder($request);
            $responseAfterExecutingSaleSave = $newSale->add();
            if ( $responseAfterExecutingSaleSave === true )
            {
                DB::commit();
                return $this->jsonAnswer('Venta registrada satisfactoriamente.', $newSale, null, true, 200);
            }
            DB::rollback();
            throw new Throwable($responseAfterExecutingSaleSave);
        }
        catch (\Throwable $th)
        {
            DB::rollback();
            return $this->jsonAnswer('Error al registrar venta.', null, $th->message, false, 400);
        }
    }

    public function report()
    {
        return $this->jsonAnswer('Reporte del dia.', 
            Sale::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->whereDay('created_at', Carbon::now()->day)->get(), 
        null, true, 200);
    }
}
