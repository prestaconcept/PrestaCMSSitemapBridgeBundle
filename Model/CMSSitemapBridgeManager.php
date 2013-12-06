<?php
/**
 * This file is part of the PrestaCMSSitemapBridgeBundle
 *
 * (c) PrestaConcept <www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSSitemapBridgeBundle\Model;

use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

/**
 * CMSSitemapBridge Manager
 *
 * @author Nicolas Joubert <njoubert@prestaconcept.net>
 */
class CMSSitemapBridgeManager
{
    /**
     * array
     */
    protected $configurations;

    public function __construct()
    {
    }

    /**
     * @param array $configuration
     *
     * @return $this
     */
    public function addUrlConfiguration($urlConfiguration)
    {
        $initialUrlConfiguration = array(
            'excluded' => array()
        );

        $this->configurations['url'] = $urlConfiguration + $initialUrlConfiguration;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfigurations()
    {
        return $this->configurations;
    }

    /**
     * @return array
     */
    public function getExcludedUrls()
    {
        return $this->configurations['url']['excluded'];
    }

    /**
     * @param Route $route
     * @return bool
     */
    public function isValidRoute(Route $route)
    {
        return strlen($route->getVariablePattern()) == 0 && !in_array($route->getPath(), $this->getExcludedUrls());
    }
}
