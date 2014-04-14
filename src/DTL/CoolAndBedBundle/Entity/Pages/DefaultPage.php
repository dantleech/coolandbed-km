<?php

namespace DTL\CoolAndBedBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;

/**
 * DefaultPage
 *
 * @ORM\Table(name="dtl_coolandbedbundle_default_pages")
 * @ORM\Entity
 */
class DefaultPage extends \Kunstmaan\NodeBundle\Entity\AbstractPage implements \Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface
{


    /**
     * Returns the default backend form type for this page
     *
     * @return \DTL\CoolAndBedBundle\Form\Pages\DefaultPageAdminType
     */
    public function getDefaultAdminType()
    {
        return new \DTL\CoolAndBedBundle\Form\Pages\DefaultPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return array(
            'DTLCoolAndBedBundle:default-two-column-left',
            'DTLCoolAndBedBundle:default-one-column',
        );
    }
    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array(
            'DTLCoolAndBedBundle:main',
            'DTLCoolAndBedBundle:left-sidebar',
        );
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'DTLCoolAndBedBundle:Pages:Common/view.html.twig';
    }
}
