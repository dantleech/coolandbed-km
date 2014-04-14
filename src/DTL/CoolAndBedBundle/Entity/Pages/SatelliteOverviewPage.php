<?php

namespace DTL\CoolAndBedBundle\Entity\Pages;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\NodeBundle\Helper\RenderContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * SatelliteOverviewPage
 *
 * @ORM\Table(name="dtl_coolandbedbundle__satellite_overview_page")
 * @ORM\Entity
 */
class SatelliteOverviewPage extends \Kunstmaan\NodeBundle\Entity\AbstractPage implements \Kunstmaan\PagePartBundle\Helper\HasPageTemplateInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25, nullable=true)
     */
    private $type;

    /**
     * Set type
     *
     * @param string $type
     * @return SatelliteOverviewPage
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the default backend form type for this page
     *
     * @return \DTL\CoolAndBedBundle\Form\Pages\SatelliteOverviewPageAdminType
     */
    public function getDefaultAdminType()
    {
        return new \DTL\CoolAndBedBundle\Form\Pages\SatelliteOverviewPageAdminType();
    }

    /**
     * @return array
     */
    public function getPossibleChildTypes()
    {
        return array();
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
        return array('DTLCoolAndBedBundle:satelliteoverviewpage');
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'DTLCoolAndBedBundle:Pages:SatelliteOverviewPage/view.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function service(ContainerInterface $container, Request $request, RenderContext $renderContext)
    {
        $renderContext['satellites'] = array();

        if ($this->getType() != '') {
            $renderContext['satellites'] = $container->get('doctrine')
                ->getRepository('DTLCoolAndBedBundle:Satellite')
                ->findBy(array('type' => $this->type), array('launched' => 'ASC'));
        }
    }
}