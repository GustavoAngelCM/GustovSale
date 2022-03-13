<?php

namespace App\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SaleRules
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
        $validator = Validator::make($this->inputSaleAdd(), $this->rulesSaleAdd());
        if ($validator->fails())
        {
            return $validator->errors()->messages();
        }
        return true;
    }

    public function inputSaleAdd(): array
    {
        return [
            'mount' => $this->request['mount'],
            'dishes' => $this->request['dishes'],
            'client' => $this->request['client']
        ];
    }

    public function rulesSaleAdd(): array
    {
        return [
            'mount' => 'bail|required|numeric',
            'dishes' => 'required',
            'client' => 'required'
        ];
    }
}