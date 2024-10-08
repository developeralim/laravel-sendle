# Sendle Courier integration with Laravle

![Sendle api](https://api-doc.sendle.com/images/logo.png)


## Instructions
follow the instruction below :)

1. Install the package first 
2. publish the config file : `php artisan vendor:publish --provider="Alim\LaravelSandle\SendleServiceProvider" --tag="config"`
3. run the migration : `php artisan migrate`
4. Go to config > sendle.php and put your credentials like api_key,api_id and set mode either  sandbox (for testing ) or production (for development)


### Testing integration 
`\Alim\LaravelSandle\Facade\Sendle::ping()` will return an array with timestamp and ping status otherwise will thrown exception if credentials mismatch or not right

### Quoteing & Ordering 
**Get Products**
#### Returns how much you'll expect to pay to send a parcel, given the shipping details and your current plan.
You'll receive one quote for each shipping product Sendle supports for the given route. Products are separated by details like service type (e.g. Standard vs Express) and first-mile option (whether a driver will pickup the parcel or the sender will drop it off at a valid Sendle location). When booking the delivery with a quote from this endpoint, you need to send the selected product code along with your order.

You can get quotes for both domestic and international shipments. International parcels can be shipped from Australia and the United States to countries around the globe, or from Canada to the United States.

```\Alim\LaravelSandle\Facade\Sendle::getQuote([
    'weight_value'      => 1,
    'weight_units'      => 'kg',
    'receiver_postcode' => '12345',
    'receiver_suburb'   => 'Receiver State',
    'receiver_country'  => 'US',
    'sender_country'    => 'US',
    'sender_postcode'   => '12345',
    'sender_suburb'     => 'Sender State'
]);
