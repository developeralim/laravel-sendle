<?php 
namespace Alim\LaravelSendle\Traits;

trait Order {

    public function getQuote($data = [],string|int $idempotency = '')
    {
        return $this->request(
            method:'GET',
            uri:'products',
            idempotency:$idempotency,
            body:[],
            query:$data
        );
    }

    public function createOrder( $data = [],string|int $idempotency = '')
    {
        return $this->request(
            method:'POST',
            uri:'orders',
            idempotency:$idempotency,
            body:$data,
            query:[]
        );
    }

    public function getOrder( string $orderId,string|int $idempotency = '' )
    {
        return $this->request(
            method:'GET',
            uri:'orders/' . $orderId,
            idempotency:$idempotency,
            body:[],
            query:[]
        );
    }

    public function CancelOrder( string $orderId,string|int $idempotency = '' )
    {
        return $this->request(
            method:'DELETE',
            uri:'orders/' . $orderId,
            idempotency:$idempotency,
            body:[],
            query:[]
        );
    }
}