<?php
/**
* This file is part of the PrestaCMSSitemapBridgeBundle
 *
 * (c) PrestaConcept <www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSSitemapBridgeBundle\EventListener;

use Presta\CMSCoreBundle\Model\RouteManager;
use Presta\CMSCoreBundle\Model\WebsiteManager;
use Presta\CMSSitemapBridgeBundle\Model\CMSSitemapBridgeManager;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

/**
 * SitemapListener
 *
 * @author Alain Flaus <aflaus@prestaconcept.net>
 */
class PrestaSitemapListener implements SitemapListenerInterface
{
    /**
     * @var WebsiteManager
     */
    protected $websiteManager;

    /**
     * @var RouteManager
     */
    protected $routerManager;

    /**
     * @var CMSSitemapBridgeManager
     */
    protected $cmsSitemapBridgeManager;

    /**
     * @param WebsiteManager            $websiteManager
     * @param RouteManager              $routerManager
     * @param CMSSitemapBridgeManager   $cmsSitemapBridgeManager
     */
    public function __construct(WebsiteManager $websiteManager, RouteManager $routerManager, CMSSitemapBridgeManager $cmsSitemapBridgeManager)
    {
        $this->websiteManager           = $websiteManager;
        $this->routeManager             = $routerManager;
        $this->cmsSitemapBridgeManager  = $cmsSitemapBridgeManager;
    }

    /**
     * @param  SitemapPopulateEvent $event
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $website = $this->websiteManager->getCurrentWebsite();

        if (is_null($website)) {
            throw new \Exception('Current website must be define');
        }

        $baseUrl = $this->websiteManager->getBaseUrlForLocale($website->getLocale());
        $routes  = $this->routeManager->getRoutesForWebsite($website);
        foreach ($routes as $route) {
            if ($this->cmsSitemapBridgeManager->isValidRoute($route)) {
                $event->getGenerator()->addUrl(
                    new UrlConcrete($baseUrl . $route->getPath()),
                    $website->getName()
                );
            }
        }
    }
}
