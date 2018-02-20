<?php
/**
 * PJAX plugin for Craft CMS 3.x
 *
 * Return only the container that PJAX expects, automagically
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\pjax\services;

use craft\web\Response;
use craft\web\Request;
use superbig\pjax\PJAX;

use Craft;
use craft\base\Component;

use Symfony\Component\DomCrawler\Crawler;
use yii\web\HttpException;

/**
 * @author    Superbig
 * @package   PJAX
 * @since     1.0.0
 */
class PJAXService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * The DomCrawler instance.
     *
     * @var Crawler
     */
    protected $crawler;

    protected $_output;

    /**
     * Handle an incoming request.
     *
     * @param $output
     *
     * @return mixed
     *
     */
    public function output($output)
    {
        $this->_output = $output;
        $request       = Craft::$app->getRequest();
        $response      = Craft::$app->getResponse();

        if (!$this->isPJAX() || $request->isCpRequest || $request->isLivePreview || $request->isConsoleRequest) {
            return $this->_output;
        }

        $this->filterResponse($this->_output, $request->headers->get('X-PJAX-Container'))
             ->setUriHeader($request, $response)
             ->setVersionHeader($output, $response);

        return $this->_output;

        // if (PJAX::$plugin->getSettings()->someAttribute) {}
    }

    public function isPJAX()
    {
        return Craft::$app->getRequest()->headers->get('X-PJAX') == true;
    }

    /**
     * @param string $response
     * @param string $container
     *
     * @return $this
     */
    protected function filterResponse(string $response, $container)
    {
        $crawler = $this->getCrawler($response);

        $this->_output = $this->makeTitle($crawler) .
            $this->fetchContainer($crawler, $container);

        return $this;
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     *
     * @return null|string
     */
    protected function makeTitle(Crawler $crawler)
    {
        $pageTitle = $crawler->filter('head > title');

        if (!$pageTitle->count()) {
            return;
        }

        return "<title>{$pageTitle->html()}</title>";
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @param string                                $container
     *
     * @return string
     * @throws HttpException
     */
    protected function fetchContainer(Crawler $crawler, $container)
    {
        $content = $crawler->filter($container);

        if (!$content->count()) {
            throw new HttpException(422, 'No content');
        }

        return $content->html();
    }

    /**
     * @param Request  $request
     *
     * @param Response $response
     *
     * @return $this
     */
    protected function setUriHeader(Request $request, Response $response)
    {
        $response->headers->set('X-PJAX-URL', $request->getUrl());

        return $this;
    }

    /**
     * @param string   $output
     *
     * @param Response $response
     *
     * @return $this
     */
    protected function setVersionHeader(string $output, Response $response)
    {
        $crawler = $this->getCrawler($this->createResponseWithLowerCaseContent($output));
        $node    = $crawler->filter('head > meta[http-equiv="x-pjax-version"]');

        if ($node->count()) {
            $response->getHeaders()->set('x-pjax-version', $node->attr('content'));
        }

        return $this;
    }

    /**
     * Get the DomCrawler instance.
     *
     * @param string $output
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function getCrawler(string $output): Crawler
    {
        if ($this->crawler) {
            return $this->crawler;
        }

        return $this->crawler = new Crawler($output);
    }

    /**
     * Make the content of the given response lowercase.
     *
     * @param string $output
     *
     * @return string
     */
    protected function createResponseWithLowerCaseContent(string $output): string
    {
        return strtolower($output);
    }
}
