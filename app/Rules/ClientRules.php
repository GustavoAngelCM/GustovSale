<?php

namespace App\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientRules
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
        $validator = Validator::make($this->inputClientAdd(), $this->rulesClientAdd());
        if ($validator->fails())
        {
            return $validator->errors()->messages();
        }
        return true;
    }

    public function inputClientAdd(): array
    {
        return [
            'ciNit' => $this->request['ciNit'],
            'nameReason' => $this->request['nameReason']
        ];
    }
    
    public function rulesClientAdd(): array
    {
        return [
            'ciNit' => 'bail|required|string|max:20',
            'nameReason' => 'bail|required|string|max:400'
        ];
    }
}