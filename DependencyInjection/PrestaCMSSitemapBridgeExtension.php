<?php
/**
 * This file is part of the PrestaCMSSitemapBridgeBundle
 *
 * (c) PrestaConcept <www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSSitemapBridgeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Alain Flaus <aflaus@prestaconcept.net>
 */
class PrestaCMSSitemapBridgeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('listener.xml');
        $loader->load('manager.xml');

        // Init filters_page configuration
        $cmsSitemapBridgeManager = $container->getDefinition('presta_cms.manager.sitemap_bridge');
        if (isset($config['url'])) {
            $cmsSitemapBridgeManager->addMethodCall('addUrlConfiguration', array($config['url']));
        }
    }
}
