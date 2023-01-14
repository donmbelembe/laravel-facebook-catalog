# Laravel Facebook Catalog Package that exports formatted XML data feed

[![Latest Version on Packagist](https://img.shields.io/packagist/v/donmbelembe/laravel-facebook-catalog.svg?style=flat-square)](https://packagist.org/packages/donmbelembe/laravel-facebook-catalog)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/donmbelembe/laravel-facebook-catalog/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/donmbelembe/laravel-facebook-catalog/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/donmbelembe/laravel-facebook-catalog/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/donmbelembe/laravel-facebook-catalog/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/donmbelembe/laravel-facebook-catalog.svg?style=flat-square)](https://packagist.org/packages/donmbelembe/laravel-facebook-catalog)

Laravel Facebook Catalog Package that exports formatted XML data feed.

## Installation

You can install the package via composer:

```bash
composer require donmbelembe/laravel-facebook-catalog
```

## Usage

```php
use Donmbelembe\LaravelFacebookCatalog\LaravelFacebookCatalog;

LaravelFacebookCatalog::setTitle('Example feed');
LaravelFacebookCatalog::setDescription('Example feed of the Example shop');
LaravelFacebookCatalog::setLink('https://example.shop');

LaravelFacebookCatalog::addItem([
    'link' => 'https://example.shop/p/foo-bar',
    'id' => 'SKU123',
    'title' => 'Foo bar',
    'image_link' => 'https://example.shop/images/foo-bar.png',
    'description' => 'Foo bar best product',
    'availability' => 'new',
    // "price" => 99.99,
    'brand' => 'Foo brand',
    'condition' => 'new',
]);

return LaravelFacebookCatalog::display();
```

An example of the expected array

```php
[
    "id" 	            		    => "", // Unique Example SKU
    "title" 	            		    => "", // Max 150 Characters
    "description"            	    => "",
    "availability"           	    => "in stock", // values: in stock, available for order, out of stock
    "condition" 	            	    => "new", // values: new, refurbished, used
    "price" 		            	    => 0.00,
    "link"		                    => "",
    "image_link"		                => "",
    "brand" 		            	    => "",
    // required fileds for payments in USA only and optional everywhere else
    "quantity_to_sell_on_facebook"   => 10, // previously name "inventory"
    "google_product_category"        => "",
    "fb_product_category"            => null,
    "size"                           => null,
    // required in india and optional everywhere else
    "origin_country"                 => null, // Ex: US
    "importer_name"                  => null, // if the origin country is not INDIA
    "importer_address"               => null,
    "manufacturer_info"              => null,
    "wa_compliance_category"         => null,
    // Optional fields
    "sale_price"                     => null,
    "sale_price_effective_date"      => null,
    "item_group_id"                  => null,
    "status"                         => null, // Values: active, archived (or staging)
    "additional_image_link"          => null,
    "gender"                         => null,
    "color"                          => null,
    "age_group"                      => null, // Values: adult, all ages, teen, kids, todler, infant, newborn.
    "material" 	                    => null,
    "patern"	                        => null,
    "shipping"                       => null,
    "shipping_weight"                => null,
]
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [don mbelembe](https://github.com/donmbelembe)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
