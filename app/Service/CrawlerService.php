<?php


namespace App\Service;


use Minicli\App;
use Minicli\Curly\Client;
use Minicli\ServiceInterface;

class CrawlerService implements ServiceInterface
{
    protected $client;

    public function load(App $app)
    {
        //well, we can also instantiate the client here, instead of using the constructor
        // this makes use of lazy loading to avoid bloating the app if the service is not going to be used
        $this->client = new Client();
    }

    public function fetch($url, $headers = [])
    {
        return $this->client->get($url);
    }
}