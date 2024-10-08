<?php 
namespace Alim\LaravelSendle\Traits;

trait Testing {
    public function ping( string|int $idempotency = '' )
    {
        return $this->request(
            method:'GET',
            uri:'ping',
            idempotency:$idempotency,
            body:[],
            query:[]
        );
    }
}