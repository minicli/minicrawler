<?php

namespace App\Command\Fetch;

use App\Service\CrawlerService;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $url = 'https://api.adviceslip.com/advice';
        // ./minicli fetch url=blablabla
        if ($this->hasParam('url')) {
            $url = $this->getParam('url');
        }

        /** @var CrawlerService $crawler */
        $crawler = $this->getApp()->crawler;

        $content = $crawler->fetch($url);

        if ($content['code'] == 200) {
            $parsed = json_decode($content['body'], true);
            $this->getPrinter()->info("Content obtained:");
            print_r($parsed);
        } else {
            $this->getPrinter()->error("An error ocurred while trying to contact this API.");
        }
    }
}