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

``` 
    \Alim\LaravelSandle\Facade\Sendle::getQuote([
        'weight_value'      => 1,
        'weight_units'      => 'kg',
        'receiver_postcode' => '12345',
        'receiver_suburb'   => 'Receiver State',
        'receiver_country'  => 'US',
        'sender_country'    => 'US',
        'sender_postcode'   => '12345',
        'sender_suburb'     => 'Sender State'
    ]);
```

**Create Order**
####Creates an order to ship a parcel to the given delivery address.

You can send parcels domestically inside Australia, Canada, and the United States. International parcels can be shipped from Australia and the United States to countries around the globe, or from Canada to the United States. With our API you can tell us the parcel size, origin, and destination, and we'll do the work to find the best route and price for your order.

```
    \Alim\LaravelSandle\Facade\Sendle::createOrder([
        "sender" => [
            "address" => [
                "country"       => "US",
                "suburb"        => "Sender State",
                "postcode"      => 12346,
                "state_code"    => "Arizona",
                "state_name"    => "Arizona",
                "address_line1" => "Hello world"
            ],
            "contact" => [
                "name" => "Name"
            ]
        ],
        "receiver" => [
            "address" => [
                "country" => "US",
                "suburb" => "Receiver State",
                "postcode" => 12345,
                "state_code" => "Arizona",
                "state_name" => "Arizona",
                "address_line1" => "Hi world"
            ],
            "instructions" => "Handle it carefully",
            "contact" => [
                "name" => "Contact Name"
            ]
        ],
        "weight" => [
            "units" => "kg",
            "value" => 1
        ],
        "description"  => "Hello world"
    ]);
```

**View an Order**
####Returns the given order including its status, the public tracking URL, and the metadata you passed when creating it.

Viewing an order should include everything that you need to know about it! Aside from the tracking endpoint, of course. Importantly, the is_cancellable key under the scheduling section tells you whether you can cancel the order.

```
    \Alim\LaravelSandle\Facade\Sendle::getOrder('<ORDER_ID>');
```

**Cancel an Order**
####Cancels the given order.

An order can be cancelled so long as it hasn't been collected by a driver. The way to see whether an order can still be cancelled is with the is_cancellable key when viewing an order.

If the order has already been cancelled a 200 response will be returned – this is why an idempotency key isn't needed for this endpoint. If the order has already been collected a 422 failure response will be returned.

Note: Cancelled orders aren't deleted from the system and should still be viewable on your dashboard in the 'cancelled' state.


```
    \Alim\LaravelSandle\Facade\Sendle::cancelOrder('<ORDER_ID>');
```

### Shipping Manifests

**Create shipping manifest**
####Creates shipping manifest(s) for the given orders.

Shipping manifests let a driver collect multiple parcels while scanning one barcode on US Domestic orders. Today we have one type of shipping manifest – USPS SCAN Forms.

```
    \Alim\LaravelSandle\Facade\Sendle::createShippingManifest([
        'order_id' => []
    ]);
```


**Get all shipping manifests**
####Returns all shipping manifests for your account.

Shipping manifests let a driver collect multiple parcels while scanning one barcode on US Domestic orders. Today we have one type of shipping manifest – USPS SCAN Forms.

```
    \Alim\LaravelSandle\Facade\Sendle::getShippingManifests();
```


**Get status of shipping manifest get**
####Returns status of a shipping manifest.

Shipping manifests let a driver collect multiple parcels while scanning one barcode on US Domestic orders. Today we have one type of shipping manifest – USPS SCAN Forms.

```
    \Alim\LaravelSandle\Facade\Sendle::shippingManifestStatus('<MANIFEST_ID>');
```

**Get orders on shipping manifest**
####Returns all orders on a shipping manifest.

Shipping manifests let a driver collect multiple parcels while scanning one barcode on US Domestic orders. Today we have one type of shipping manifest – USPS SCAN Forms.

```
    \Alim\LaravelSandle\Facade\Sendle::OrdersOnShippingManifest('<MANIFEST_ID>');
```

**Download shipping manifest**
####Returns the printable shipping manifest.

Shipping manifests let a driver collect multiple parcels while scanning one barcode on US Domestic orders. Today we have one type of shipping manifest – USPS SCAN Forms.

```
    \Alim\LaravelSandle\Facade\Sendle::downloadShippingManifest('<MANIFEST_ID>');
```

### Returns

**Return an order**

####Creates a return label, letting receivers easily send orders back to the original sender.

Senders can use this endpoint to prepare an order to be returned. Returns can only be placed for domestic orders.

After creating the return order, you can get a label using the URLs in the response. The sender can then include the return label in the parcel before it's shipped (because they aren't added to your invoice until they're used), or send the label file to the customer for them to print it out. If the receiver will be printing it, try to use A4/Letter sizes since most receivers don't have dedicated label printers.

If you want a convenient page receivers can read – which includes packaging directions – here are our AU Returns and US Returns articles. After attaching the return label to the parcel, the receiver will need to leave the parcel at a valid drop off location.

```
    \Alim\LaravelSandle\Facade\Sendle::createReturn([
        'id' => '<ORDER_ID>'
    ],'<ORDER_ID>');
```


**View a return order**

####Views the given return order, including the label URLs.

You can get a label using the URLs in this response. The sender can then include the return label in the parcel before it's shipped (because they aren't added to your invoice until they're used), or send the label file to the customer for them to print it out. If the receiver will be printing it, try to use A4/Letter sizes since most receivers don't have dedicated label printers.

If you want a convenient page receivers can read – which includes packaging directions – here are our AU Returns and US Returns articles. After attaching the return label to the parcel, the receiver will need to leave the parcel at a valid drop off location.

```
    \Alim\LaravelSandle\Facade\Sendle::viewReturn('<ORDER_ID>');
```

### Tracking

**Track a Parcel**

####Returns tracking details for the given parcel, including when different events happened to it.

This endpoint doesn't contain precise personal location information, but can contain the city where events happen and some names (e.g. 'Parcel was signed for by JIMMY'). To get the public tracking URL that can be shared with the receiver, see the tracking_url key in the response from the create or view an order endpoints.

Note: The Sendle API does not currently expose webhooks, and this endpoint is the only way to retrieve tracking information. For updates, keep an eye on our Changelog!

We recommend getting new tracking information for each parcel once per hour.

You should limit your requests to this endpoint to 10 per second per unique IP. If you need a higher limit, reach out to our team.


```
    \Alim\LaravelSandle\Facade\Sendle::trackParcel('<ORDER_REFERENCE>');
```

## Credits
1. [Muhammad Alim Khan](https://github.com/developeralim)

## References 
1. [Sendle Documentation](https://developers.sendle.com/reference/welcome)