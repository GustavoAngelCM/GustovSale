<?php

namespace App\Validators;

use App\Rules\ClientRules;
use App\Rules\SaleDetailRules;
use App\Rules\SaleRules;

class SaleValidate
{
    private $request;
    private $type;

    public function __construct($request, $type='ADD')
    {
        $this->type = $type;
        $this->request = $request;
    }

    public function validate()
    {
        if ($this->type === 'ADD') {
            // here code validate json SALE
        }
        return false;
    }
}