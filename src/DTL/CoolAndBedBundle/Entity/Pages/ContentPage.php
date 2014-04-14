<?php

namespace DTL\CoolAndBedBundle\Entity\Pages;

use DTL\CoolAndBedBundle\Form\Pages\ContentPageAdminType;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;
use Symfony\Component\Form\AbstractType;

/**
 * ContentPage
 *
 * @ORM\Entity()
 * @ORM\Table(name="dtl_coolandbedbundle_content_pages")
 */
class ContentPage extends AbstractPage  implements HasPageTemplateInterface
{

    /**
     * Returns the default backend form type for this page
     *
     * @return AbstractType
     */
    public function getDefaultAdminType()
    {
        return new ContentPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array (
            array(
                'name'  => 'ContentPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\ContentPage'
            ),
            array(
                'name'  => 'SatelliteOverviewPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\SatelliteOverviewPage'
            )
        );
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array('DTLCoolAndBedBundle:main');
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return array('DTLCoolAndBedBundle:contentpage');
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        return 'DTLCoolAndBedBundle:Pages\ContentPage:view.html.twig';
    }
}
