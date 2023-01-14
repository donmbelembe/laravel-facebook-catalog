<?php

namespace Donmbelembe\LaravelFacebookCatalog;

use Spatie\ArrayToXml\ArrayToXml;

class Feed{

	protected $xml 			= [];
	protected $products		= [];
	protected $title		= "";
	protected $description	= "";
	protected $link			= "";
	protected $currency 	= "USD";
    private $requiredAttributes = [
        "id",
        "title",
        "description",
        "availability",
        "condition",
        "price",
        "link",
        "image_link",
        "brand",
    ];

	public function __construct()
	{

	}

	public function setTitle($title = "")
	{
		$this->title = $title;
	}

	public function setDescription($description = "")
	{
		$this->description = $description;
	}

	public function setLink($link = "")
	{
		$this->link = $link;
	}

    // [
	// 	"id" 	            		    => "", // Unique Example SKU
	// 	"title" 	            		    => "", // Max 150 Characters
	// 	"description"            	    => "",
	// 	"availability"           	    => "in stock", // values: in stock, available for order, out of stock
	// 	"condition" 	            	    => "new", // values: new, refurbished, used
	// 	"price" 		            	    => 0.00,
	// 	"link"		                    => "",
	// 	"image_link"		                => "",
	// 	"brand" 		            	    => "",
    //     // required fileds for payments in USA only and optional everywhere else
    //     "quantity_to_sell_on_facebook"   => 10, // previously name "inventory"
    //     "google_product_category"        => "",
    //     "fb_product_category"            => null,
    //     "size"                           => null,
    //     // required in india and optional everywhere else
    //     "origin_country"                 => null, // Ex: US
    //     "importer_name"                  => null, // if the origin country is not INDIA
    //     "importer_address"               => null,
    //     "manufacturer_info"              => null,
    //     "wa_compliance_category"         => null,
    //     // Optional fields
    //     "sale_price"                     => null,
    //     "sale_price_effective_date"      => null,
    //     "item_group_id"                  => null,
    //     "status"                         => null, // Values: active, archived (or staging)
    //     "additional_image_link"          => null,
    //     "gender"                         => null,
    //     "color"                          => null,
    //     "age_group"                      => null, // Values: adult, all ages, teen, kids, todler, infant, newborn.
	// 	"material" 	                    => null,
	// 	"patern"	                        => null,
    //     "shipping"                       => null,
    //     "shipping_weight"                => null,
	// ]

	public function addItem($item)
    {
        $product = [];

        // check for required keys
        foreach ($this->requiredAttributes as $attr) {
            if(!array_key_exists($attr, $item))
            {
                throw new Exception("Missing required keys", 1);
            }
        }

        foreach ($item as $key => $value) {
            $product[$key] = $value;
        }

        $product['link'] = $product['link'] . "?utm_source=facebook&utm_medium=facebookCatalog&utm_campaign=";
        $product['description'] = strip_tags($product['description']);
        $product['price'] = number_format($product['price'], 2, ".", ",") . " " . $this->currency;

		$this->products[] = $product;
	}

	public function generate()
	{
		$this->xml = [
		    'rss' 	=> [
		        '_attributes' 	=> [
		            'xmlns:g' 		=> 'http://base.google.com/ns/1.0',
		            'version' 		=> '2.0',
		        ],
		        'channel' 		=> [
		        	'title'			=> $this->title,
		        	'description'	=> $this->description,
		        	'link'			=> $this->link,
		        ]
		    ]
		];

		$i = 0;

		foreach ($this->products as $product) {
			$this->xml['rss']['channel']['item_'.$i] = $product;
			$i++;
		}

        $arrayToXml = new ArrayToXml($this->xml);
        $xml = $arrayToXml->prettify()->toXml();

        $xml = str_replace(['    ', '<root>', '</root>', '<remove>remove</remove>'], '', $xml);
		$xml = preg_replace([
			"/item_[0-9][0-9][0-9][0-9]/",
			"/item_[0-9][0-9][0-9]/",
			"/item_[0-9][0-9]/",
			"/item_[0-9]/",
		], "item", $xml);
		return $xml;

	}

	public function display()
	{
		return response($this->generate())->header('Content-Type', 'text/xml');
	}

}
