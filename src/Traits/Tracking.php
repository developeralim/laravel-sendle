<?php 
namespace Alim\LaravelSandle\Traits;

trait Tracking {
    public function trackParcel( string $ref,string|int $idempotency = '' )
    {
        return $this->request(
            method:'GET',
            uri:'tracking/' . $ref,
            idempotency:$idempotency,
            body:[],
            query:[]
        );
    }
}