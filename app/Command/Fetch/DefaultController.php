<?php

namespace App\Command\Fetch;

use App\Service\CrawlerService;
use Minicli\Command\CommandController;

/**
 * ./minicrawler fetch
 * This command will fetch from an "advices" API by default,
 * or a URL provided with the url=value parameter. Contents are json_decoded before printed.
 * Class DefaultController
 * @package App\Command\Fetch
 */
class DefaultController extends CommandController
{

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $url = 'https://api.adviceslip.com/advice';

        if ($this->hasParam('url')) {
            $url = $this->getParam('url');
        }

        /** @var CrawlerService $crawler */
        $crawler = $this->getApp()->crawler;

        $this->getPrinter()->display("Fetching content...");
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