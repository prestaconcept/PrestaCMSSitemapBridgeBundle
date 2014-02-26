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
     * @var array
     */
    protected $configurations;

    public function __construct()
    {
        $this->configurations = array();
    }

    /**
     * @param  array $urlConfiguration
     * @return $this
     */
    public function addUrlConfiguration(array $urlConfiguration)
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
        $excludedUrls = array();

        if (isset($this->configurations['url']['excluded'])) {
            $excludedUrls = $this->configurations['url']['excluded'];
        }

        return $excludedUrls;
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
