<?php
/*
 * This file is part of the APYBreadcrumbTrailBundle.
 *
 * (c) Abhoryo <abhoryo@free.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace APY\BreadcrumbTrailBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder() : TreeBuilder
    {
        $treeBuilder = new TreeBuilder('apy_breadcrumb_trail');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('template')
                    ->defaultValue('@APYBreadcrumbTrail/breadcrumbtrail.html.twig')
                ->end() // template
            ->end()
        ;

        return $treeBuilder;
    }
}
