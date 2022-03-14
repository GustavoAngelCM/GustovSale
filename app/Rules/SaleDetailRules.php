<?php

namespace App\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SaleDetailRules
{
    private $request;
    private $type;

    public function __construct($request, $type='ADD', $requestClass=false)
    {
        $this->type = $type;
        $this->request = ($requestClass === true) ? $request->all() : $request;
    }

    public function validate()
    {
        if ($this->type === 'ADD')
        {
            return $this->validateAdd();
        }
        return false;
    }

    public function validateAdd()
    {
        $validator = Validator::make($this->inputSaleDetailAdd(), $this->rulesSaleDetailAdd());
        if ($validator->fails())
        {
            return $validator->errors()->messages();
        }
        return true;
    }

    public function inputSaleDetailAdd(): array
    {
        return [
            'dishKey' => $this->request['dish'],
            'quantity' => $this->request['quantity'],
            'subTotal' => $this->request['subTotal']
        ];
    }

    public function rulesSaleDetailAdd(): array
    {
        return [
            'dishKey' => 'bail|required|string|max:70',
            'quantity' => 'bail|required|numeric',
            'subTotal' => 'bail|required|numeric'
        ];
    }
}