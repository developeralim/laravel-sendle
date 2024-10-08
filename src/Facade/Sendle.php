<?php
namespace Alim\LaravelSandle\Facade;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for the Sendle service.
 *
 * @method static array ping(string|int $idempotency = '')
 * @method static array createOrder(array $data = [],string|int $idempotency = '')
 * @method static array getOrder( string $orderId,string|int $idempotency = '' )
 * @method static array getQuote(array $data = [],string|int $idempotency = '')
 * @method static array cancelOrder(string $orderId,string|int $idempotency = '')
 * @method static array createReturn( array $data = [],string $orderId,string|int $idempotency = '' )
 * @method static array viewReturn( string $orderId )
 * @method static array trackParcel( string $ref,string|int $idempotency = '' )
 * @method static array createShippingManifest(array $data = [] )
 * @method static array getShippingManifests()
 * @method static array shippingManifestStatus( string $manifestId = '' )
 * @method static array OrdersOnShippingManifest( string $manifestId = '' ) 
 * @method static array downloadShippingManifest( string $manifestId = '' ) 
 */ 

class Sendle extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sendle';
    }
}