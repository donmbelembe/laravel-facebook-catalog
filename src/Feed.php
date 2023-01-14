<?php

namespace Donmbelembe\LaravelFacebookCatalog;

use Spatie\ArrayToXml\ArrayToXml;

class Feed
{
    protected $xml = [];

    protected $products = [];

    protected $title = '';

    protected $description = '';

    protected $link = '';

    protected $currency = 'USD';

    private $requiredAttributes = [
        'id',
        'title',
        'description',
        'availability',
        'condition',
        'price',
        'link',
        'image_link',
        'brand',
    ];

    public function __construct()
    {
    }

    public function setTitle($title = '')
    {
        $this->title = $title;
    }

    public function setDescription($description = '')
    {
        $this->description = $description;
    }

    public function setLink($link = '')
    {
        $this->link = $link;
    }

    public function addItem($item)
    {
        $product = [];

        // check for required keys
        foreach ($this->requiredAttributes as $attr) {
            if (! array_key_exists($attr, $item)) {
                throw new \Exception('Missing required keys: '.$attr, 1);
            }
        }

        foreach ($item as $key => $value) {
            $product[$key] = $value;
        }

        $product['link'] = $product['link'].'?utm_source=facebook&utm_medium=facebookCatalog&utm_campaign=';
        $product['description'] = strip_tags($product['description']);
        $product['price'] = number_format($product['price'], 2, '.', ',').' '.$this->currency;

        $this->products[] = $product;
    }

    public function generate()
    {
        $this->xml = [
            'rss' => [
                '_attributes' => [
                    'xmlns:g' => 'http://base.google.com/ns/1.0',
                    'version' => '2.0',
                ],
                'channel' => [
                    'title' => $this->title,
                    'description' => $this->description,
                    'link' => $this->link,
                ],
            ],
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
            '/item_[0-9][0-9][0-9][0-9]/',
            '/item_[0-9][0-9][0-9]/',
            '/item_[0-9][0-9]/',
            '/item_[0-9]/',
        ], 'item', $xml);

        return $xml;
    }

    public function display()
    {
        return response($this->generate())->header('Content-Type', 'text/xml');
    }
}
