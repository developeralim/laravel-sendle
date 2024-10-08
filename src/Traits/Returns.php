<?php 
namespace Alim\LaravelSendle\Traits;

trait Returns {
    public function createReturn( array $data = [],string $orderId,string|int $idempotency = '' )
    {
        return $this->request(
            method:'POST',
            uri:'orders/' . $orderId . '/return',
            idempotency:$idempotency,
            body:$data,
            query:[]
        );
    }

    public function viewReturn( string $orderId,string|int $idempotency = '' )
    {
        return $this->request(
            method:'GET',
            uri:'orders/' . $orderId . '/return',
            idempotency:$idempotency,
            body:[],
            query:[]
        );
    }
}