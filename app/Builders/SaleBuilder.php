<?php

namespace App\Builders;

use App\Models\Client;
use App\Models\Sale;
use App\Models\SaleDetail;

use Carbon\Carbon;

class SaleBuilder
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function add()
    {
        $client = $this->getClient();
        if($client)
        {
            return $this->addSaleAndDetail($client->id);
        }
        else
        {
            $client = $this->addClient();
            if ($client)
            {
                return $this->addSaleAndDetail($client->id);
            }
            return [ 'client' => 'No se han podido registrar el cliente.' ];
        }
    }

    public function addSaleAndDetail($client)
    {
        $sale = $this->addSale($client);
        if($sale)
        {
            $errorsDishes = [];
            foreach ($this->request->input('dishes') as $dish)
            {
                $responseSaleDetail= $this->addSaleDetail($dish['dish'], $dish['quantity'], $dish['subTotal'], $sale->id);
                if (!$responseSaleDetail)
                {
                    $errorsDishes[] = [ 'sale' => 'No se han podido registrar el detalle del plato [' . strtoupper($dish['dish']) . '].' ];
                }
            }
            return count($errorsDishes) > 0 ? $errorsDishes : true;
        }
        return [ 'sale' => 'No se han podido registrar la venta.' ];
    }

    public function addSaleDetail($dish, $quantity, $subTotal, $sale)
    {
        return SaleDetail::instanceSaved($dish, $quantity, $subTotal, $sale);
    }

    public function addSale($client)
    {
        return Sale::instanceSaved(
            $this->request->input('mount'),
            $client
        );
    }

    public function getClient()
    {
        return Client::getClientByCI(strtoupper($this->request->input('client.ciNit')));
    }

    public function addClient()
    {
        return Client::instanceSaved(
            $this->request->input('client.ciNit'),
            $this->request->input('client.nameReason')
        );
    }
}