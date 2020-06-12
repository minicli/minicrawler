<?php


namespace App\Command\Fetch;

use App\Service\CrawlerService;
use App\Service\DBService;
use Minicli\Command\CommandController;

/**
 * ./minicrawler fetch tutorials
 * Command to fetch views from DigitalOcean tutorials and save stats
 * Class TutorialsController
 * @package App\Command\Fetch
 */
class TutorialsController extends CommandController
{
    public function handle()
    {
        $tutorial_urls = $this->getApp()->config->tutorial_urls;

        if (!is_array($tutorial_urls)) {
            $this->getPrinter()->error("You must define an array with urls to fetch.");
            return;
        }

        /** @var DBService $db */
        $db = $this->getApp()->db;

        /** @var CrawlerService $crawler */
        $crawler = $this->getApp()->crawler;
        $this->getPrinter()->display("Fetching content...");

        foreach ($tutorial_urls as $url) {
            $content = $crawler->fetch($url);

            if ($content['code'] == 200) {
                $views = $this->getTutorialViews($content['body']);
                $db->insertData($url, $views);
                $this->getPrinter()->success("Views: " . $views);
            } else {
                $this->getPrinter()->error("An error occurred while trying to contact this API.");
            }
        }
    }

    public function getTutorialViews(string $content)
    {
        $body = $content;
        $doc = new \DOMDocument();
        @$doc->loadHTML($body);

        $finder = new \DOMXPath($doc);
        $classname="views-count";
        $nodes = $finder->query("//*[contains(@class, '$classname')]");

        $this->getPrinter()->info("Content obtained:");

        $views = "";

        foreach ($nodes as $node) {
            $views = $node->nodeValue;
        }

        return $this->parseViewsString($views);
    }

    public function parseViewsString(string $content)
    {
        if (strchr($content, 'k')) {
            $number = str_replace('k', '', $content);
            return (int) ((float)$number * 1000);
        }
        return (int) $content;
    }
}