<?php
/**
* This file is part of the sandbox project
 *
 * (c) PrestaConcept <www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sandbox\SitemapBundle\EventListener;

use Presta\CMSCoreBundle\Model\RouteManager;
use Presta\CMSCoreBundle\Model\WebsiteManager;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Cmf\Bundle\RoutingExtraBundle\Document\RedirectRoute;

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
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param WebsiteManager $websiteManager
     * @param RouteManager   $routerManager
     */
    public function __construct(WebsiteManager $websiteManager, RouteManager $routerManager)
    {
        $this->websiteManager   = $websiteManager;
        $this->routeManager     = $routerManager;
        $this->router           = $router;
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

        $routes = $this->routeManager->getRoutesForWebsite($website);
        foreach ($routes as $route) {
            if (strlen($route->getVariablePattern()) == 0) {
                $event->getGenerator()->addUrl(
                    new UrlConcrete($route->getPath()),
                    $website->getName()
                );
            }
        }
    }
}
