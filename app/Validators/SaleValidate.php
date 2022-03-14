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
        if ($this->type === 'ADD')
        {
            // variable to detected error (dish)
            $errorsDishes = [];
            // method for validate Sale
            $responseSale = $this->validateSale();
            if ($responseSale !== true)
            {
                return [ 'sale' => $responseSale ];
            }
            // method for validate Client
            $responseClient = $this->validateClient();
            if ($responseClient !== true)
            {
                return [ 'client' => $responseClient ];
            }
            // method for validate SaleDetail
            foreach ($this->request->input('dishes') as $dish)
            {
                $responseDish = $this->validateDish($dish['dish'], $dish['quantity'], $dish['subTotal']);
                if ($responseDish !== true)
                {
                    $errorsDishes[] = $responseDish;
                }
            }
            // ternary operator for return detected ishues 
            return count($errorsDishes) > 0 ? $errorsDishes : true ;
        }
        return false;
    }

    public function validateSale()
    {
        $saleRules = new SaleRules($this->request->all());
        return $saleRules->validate();
    }

    public function validateDish($dish, $quantity, $subTotal)
    {
        $dishRules = new SaleDetailRules([
            "dish" => $dish,
            "quantity" => $quantity,
            "subTotal" => $subTotal
        ]);
        return $dishRules->validate();
    }

    public function validateClient()
    {
        $clientRules = new ClientRules([
            "ciNit" => $this->request->input('client.ciNit'),
            "nameReason" => $this->request->input('client.nameReason')
        ]);
        return $clientRules->validate();
    }
}