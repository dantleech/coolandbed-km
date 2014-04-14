<?php

namespace DTL\CoolAndBedBundle\Entity\Pages;

use DTL\CoolAndBedBundle\Form\Pages\HomePageAdminType;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;
use Symfony\Component\Form\AbstractType;

/**
 * HomePage
 *
 * @ORM\Entity()
 * @ORM\Table(name="dtl_coolandbedbundle_home_pages")
 */
class HomePage extends AbstractPage  implements HasPageTemplateInterface
{

    /**
     * Returns the default backend form type for this page
     *
     * @return AbstractType
     */
    public function getDefaultAdminType()
    {
        return new HomePageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array(
            array(
                'name' => 'DefaultPage',
                'class'=> 'DTL\CoolAndBedBundle\Entity\Pages\DefaultPage'
            ),
            array(
                'name'  => 'ContentPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\ContentPage'
            ),
            array(
                'name'  => 'FormPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\FormPage'
            ),
            array(
                'name'  => 'BehatTestPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\BehatTestPage'
            )
        );
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array('DTLCoolAndBedBundle:middle-column', 'DTLCoolAndBedBundle:slider', 'DTLCoolAndBedBundle:left-column', 'DTLCoolAndBedBundle:right-column');
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return array('DTLCoolAndBedBundle:homepage', 'DTLCoolAndBedBundle:homepage-no-slider');
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        return 'DTLCoolAndBedBundle:Pages\HomePage:view.html.twig';
    }
}
