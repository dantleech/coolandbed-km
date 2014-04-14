<?php

namespace DTL\CoolAndBedBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * SlidePagePart
 *
 * @ORM\Table(name="dtl_coolandbedbundle_gallery_page_part")
 * @ORM\Entity
 */
class GalleryPagePart extends \Kunstmaan\PagePartBundle\Entity\AbstractPagePart
{
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Folder")
     */
    private $folder;

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'DTLCoolAndBedBundle:PageParts:GalleryPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \DTL\CoolAndBedBundle\Form\Pageparts\SlidePagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \DTL\CoolAndBedBundle\Form\PageParts\GalleryPagePartAdminType();
    }

    public function getFolder() 
    {
        return $this->folder;
    }
    
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }
    
}

