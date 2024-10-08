<?php  
namespace Alim\LaravelSandle;

use Alim\LaravelSandle\Models\SendleLog;
use Alim\LaravelSandle\Traits\Logger;
use Alim\LaravelSandle\Traits\Order;
use Alim\LaravelSandle\Traits\Returns;
use Alim\LaravelSandle\Traits\ShippingManifests;
use Alim\LaravelSandle\Traits\Testing;
use Alim\LaravelSandle\Traits\Tracking;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

final class SendleProcessor {

    use Order,
        ShippingManifests,
        Returns,
        Tracking,
        Testing,
        Logger;

    protected array $config;
    protected string $api_base;
    protected Client $client;

    public function __construct( $config = [] )
    {
        $this->config = $config;
        $this->api_base = $config['mode'] == 'sandbox' ? $config['sandbox_url'] : $config['production_url'];
        $this->client  = new Client([
            'base_uri'  => $this->api_base
        ]);
    }

    protected function request( string $method, string $uri,string|int $idempotency = '', array $body = [],array $query = [],$headers = [] )
    {
        try {
            $event = $uri;

            if ( ! empty($query) ) {
                $uri .= '?' . http_build_query($query);
            }
            $headers = array_merge([
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->config['api_id'].':'.$this->config['api_key'])
            ],$headers);
 
            if ( ! empty( $idempotency ) ) {
                $headers['Idempotency-Key'] = $idempotency;
            }

            $request  = new Request($method,$uri,$headers);

            $options  = [];

            if ( ! empty($body) ) {
                if (strtoupper($method) == 'POST' || strtoupper($method) == 'PUT' || strtoupper($method) == 'PATCH') {
                    $options['json'] = $body;
                }
            }

            $response = $this->client->sendAsync( $request,$options )->wait();

            
            SendleLog::create([
                'eventname'  => $event,
                'logs'       => $response->getBody(),
                'created_at' => Carbon::now()
            ]);

            return json_decode($response->getBody(),true);
        } catch (\Throwable $th) {
            Log::emergency($th->getMessage());
            throw $th;
        }
    }
}