<?php

namespace DTL\CoolAndBedBundle\Helper\Menu;

use Kunstmaan\AdminBundle\Helper\Menu\TopMenuItem;
use Kunstmaan\AdminBundle\Helper\Menu\MenuItem;
use Kunstmaan\AdminBundle\Helper\Menu\MenuBuilder;
use Kunstmaan\AdminBundle\Helper\Menu\MenuAdaptorInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class AdminMenuAdaptor implements MenuAdaptorInterface
{
    private $securityContext;

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * In this method you can add children for a specific parent, but also remove and change the already created children
     *
     * @param MenuBuilder $menu The MenuBuilder
     * @param MenuItem[]  &$children The current children
     * @param MenuItem $parent  The parent Menu item
     * @param Request  $request The Request
     */
    public function adaptChildren(MenuBuilder $menu, array &$children, MenuItem $parent = null, Request $request = null)
    {
    }
}
