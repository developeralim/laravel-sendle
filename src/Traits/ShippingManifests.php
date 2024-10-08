<?php 
namespace Alim\LaravelSendle\Traits;

trait ShippingManifests {
    public function createShippingManifest(array $data = [] )
    {
        return $this->request(
            method:'POST',
            uri:'manifests',
            body:$data,
        );
    }

    public function getShippingManifests()
    {
        return $this->request(
            method:'GET',
            uri:'manifests',
        );
    }

    public function shippingManifestStatus( string $manifestId = '' )
    {
        return $this->request(
            method:'GET',
            uri:'manifests/'.$manifestId.'/status',
        );
    }

    public function OrdersOnShippingManifest( string $manifestId = '' ) 
    {
        return $this->request(
            method:'GET',
            uri:'manifests/'.$manifestId.'/orders',
        );
    }

    public function downloadShippingManifest( string $manifestId = '' ) 
    {
        return $this->request(
            method:'GET',
            uri:'manifests/'.$manifestId.'/download',
            headers : [
                'Accept' => 'application/pdf',
            ]
        );
    }
}