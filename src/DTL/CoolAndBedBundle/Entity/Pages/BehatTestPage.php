<?php

namespace DTL\CoolAndBedBundle\Entity\Pages;

use DTL\CoolAndBedBundle\Form\Pages\BehatTestPageAdminType;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Entity\AbstractPage;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;
use Symfony\Component\Form\AbstractType;

/**
 * BehatTestPage
 *
 * @ORM\Entity()
 * @ORM\Table(name="dtl_coolandbedbundle_behat_test_pages")
 */
class BehatTestPage extends AbstractPage  implements HasPageTemplateInterface
{

    /**
     * Returns the default backend form type for this page
     *
     * @return AbstractType
     */
    public function getDefaultAdminType()
    {
        return new BehatTestPageAdminType();
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
                'name'  => 'HomePage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\HomePage'
            ),
            array(
                'name'  => 'ContentPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\ContentPage'
            ),
            array(
                'name'  => 'FormPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\FormPage'
            ),
        );
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return array('DTLCoolAndBedBundle:behat-test-page');
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        return '';
    }
}
