<?php

namespace DTL\CoolAndBedBundle\Entity\Pages;

use DTL\CoolAndBedBundle\Form\Pages\FormPageAdminType;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\FormBundle\Entity\AbstractFormPage;
use Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface;
use Symfony\Component\Form\AbstractType;

/**
 * FormPage
 *
 * @ORM\Entity()
 * @ORM\Table(name="dtl_coolandbedbundle_form_pages")
 */
class FormPage extends AbstractFormPage implements HasPageTemplateInterface
{

    /**
     * Returns the default backend form type for this form
     *
     * @return AbstractType
     */
    public function getDefaultAdminType()
    {
        return new FormPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array(
            array(
                'name'  => 'ContentPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\ContentPage'
            ),
            array (
                'name'  => 'FormPage',
                'class' => 'DTL\CoolAndBedBundle\Entity\Pages\FormPage'
            )
        );
    }

    /**
     * @return string[]
     */
    public function getPagePartAdminConfigurations()
    {
        return array('DTLCoolAndBedBundle:form');
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTemplates()
    {
        return array('DTLCoolAndBedBundle:formpage');
    }

    /**
     * @return string
     */
    public function getDefaultView()
    {
        return 'DTLCoolAndBedBundle:Pages\FormPage:view.html.twig';
    }
}
