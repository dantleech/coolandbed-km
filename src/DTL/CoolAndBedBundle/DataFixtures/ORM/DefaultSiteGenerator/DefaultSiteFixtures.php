<?php

namespace DTL\CoolAndBedBundle\DataFixtures\ORM\DefaultSiteGenerator;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Kunstmaan\AdminBundle\Entity\DashboardConfiguration;
use Kunstmaan\MediaBundle\Entity\Media;
use Kunstmaan\MediaBundle\Helper\RemoteVideo\RemoteVideoHelper;
use Kunstmaan\MediaBundle\Helper\Services\MediaCreatorService;
use Kunstmaan\NodeBundle\Helper\Services\PageCreatorService;
use Kunstmaan\PagePartBundle\Helper\Services\PagePartCreatorService;
use Kunstmaan\TranslatorBundle\Entity\Translation;

use DTL\CoolAndBedBundle\Entity\Pages\ContentPage;
use DTL\CoolAndBedBundle\Entity\Pages\HomePage;
use DTL\CoolAndBedBundle\Entity\Pages\FormPage;
use DTL\CoolAndBedBundle\Entity\Satellite;
use DTL\CoolAndBedBundle\Entity\Pages\SatelliteOverviewPage;
use DTL\CoolAndBedBundle\Entity\Pages\DefaultPage;

/**
 * DefaultSiteFixtures
 */
class DefaultSiteFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * Username that is used for creating pages
     */
    const ADMIN_USERNAME = 'Admin';

    /**
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var PageCreatorService
     */
    private $pageCreator;

    /**
     * @var PagePartCreatorService
     */
    private $pagePartCreator;

    /**
     * @var MediaCreatorService
     */
    private $mediaCreator;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->pageCreator = $this->container->get('kunstmaan_node.page_creator_service');
        $this->pagePartCreator = $this->container->get('kunstmaan_pageparts.pagepart_creator_service');
        $this->mediaCreator = $this->container->get('kunstmaan_media.media_creator_service');

        $this->createTranslations();
//        $this->createMedia();
        $this->createHomePage();
        $this->createContentCoolAndBed();
//        $this->createContentPages();
//        $this->createAdminListPages();
        // $this->createStylePage();
        $this->createFormPage();
        $this->createDashboard();
    }

    /**
     * Create the dashboard
     */
    private function createDashboard()
    {
        /** @var $dashboard DashboardConfiguration */
        $dashboard = $this->manager->getRepository("KunstmaanAdminBundle:DashboardConfiguration")->findOneBy(array());
        if (is_null($dashboard)) {
            $dashboard = new DashboardConfiguration();
        }
        $dashboard->setTitle("Dashboard");
        $dashboard->setContent('<div class="alert alert-info"><strong>Important: </strong>please change these items to the graphs of your own site!</div><iframe src="https://rpm.newrelic.com/public/charts/jjPIEE7OHz9" width="100%" height="300" scrolling="no" frameborder="no"></iframe><iframe src="https://rpm.newrelic.com/public/charts/hmDWR0eUNTo" width="100%" height="300" scrolling="no" frameborder="no"></iframe><iframe src="https://rpm.newrelic.com/public/charts/fv7IP1EmbVi" width="100%" height="300" scrolling="no" frameborder="no"></iframe>');
        $this->manager->persist($dashboard);
        $this->manager->flush();
    }

    /**
     * Create a Homepage
     */
    private function createHomePage()
    {
        $homePage = new HomePage();
        $homePage->setTitle('Home');

        $translations = array();
        $translations[] = array('language' => 'en', 'callback' => function($page, $translation, $seo) {
            $translation->setTitle('Home');
            $translation->setSlug('');
        });
        $translations[] = array('language' => 'fr', 'callback' => function($page, $translation, $seo) {
            $translation->setTitle('Accueil');
            $translation->setSlug('');
        });

        $options = array(
            'parent' => null,
            'page_internal_name' => 'homepage',
            'set_online' => true,
            'hidden_from_nav' => false,
            'creator' => self::ADMIN_USERNAME
        );

        $this->pageCreator->createPage($homePage, $translations, $options);

        $pageparts = array();
        $pageparts['left_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'First column heading',
                'setNiv'   => 1
            )
        );
        $pageparts['left_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
            )
        );
        $pageparts['right_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Third column heading',
                'setNiv'   => 1
            )
        );
        $pageparts['right_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.'
            )
        );

        $this->pagePartCreator->addPagePartsToPage('homepage', $pageparts, 'en');

        $pageparts = array();
        $pageparts['left_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Eerste title',
                'setNiv'   => 1
            )
        );
        $pageparts['left_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de standaard proeftekst in deze bedrijfstak sinds de 16e eeuw, toen een onbekende drukker een zethaak met letters nam en ze door elkaar husselde om een font-catalogus te maken.'
            )
        );
        $pageparts['right_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\HeaderPagePart',
            array(
                'setTitle' => 'Derde titel',
                'setNiv'   => 1
            )
        );
        $pageparts['right_column'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\PagePartBundle\Entity\TextPagePart',
            array(
                'setContent' => 'Het standaard stuk van Lorum Ipsum wat sinds de 16e eeuw wordt gebruikt is hieronder, voor wie er interesse in heeft, weergegeven. Secties 1.10.32 en 1.10.33 van "de Finibus Bonorum et Malorum" door Cicero zijn ook weergegeven in hun exacte originele vorm, vergezeld van engelse versies van de 1914 vertaling door H. Rackham.'
            )
        );

        $this->pagePartCreator->addPagePartsToPage('homepage', $pageparts, 'fr');
    }

    private function createContentCoolAndBed()
    {
        $nodeRepo = $this->manager->getRepository('KunstmaanNodeBundle:Node');
        $homePage = $nodeRepo->findOneBy(array('internalName' => 'homepage'));

        $pages = array(
            'dormir' => array(
                'title' => 'Sleep',
                'translations' => array(
                    array(
                        'language' => 'en', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Sleep');
                            $translation->setSlug('sleep');
                            $translation->setWeight(20);
                        },
                    ),
                    array(
                        'language' => 'fr', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Dormir');
                            $translation->setSlug('dormir');
                            $translation->setWeight(20);
                        },
                    ),
                ),
            ),
            'reserver' => array(
                'title' => 'Book',
                'translations' => array(
                    array(
                        'language' => 'en', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Reserve');
                            $translation->setSlug('reserve');
                            $translation->setWeight(20);
                        },
                    ),
                    array(
                        'language' => 'fr', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Reserver');
                            $translation->setSlug('reserver');
                            $translation->setWeight(20);
                        },
                    ),
                ),
            ),
            'venir' => array(
                'title' => 'Find us',
                'translations' => array(
                    array(
                        'language' => 'en', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Find us');
                            $translation->setSlug('findus');
                            $translation->setWeight(20);
                        },
                    ),
                    array(
                        'language' => 'fr', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Reserver');
                            $translation->setSlug('reserver');
                            $translation->setWeight(20);
                        },
                    ),
                ),
            ),
            'bouger' => array(
                'title' => 'Transport',
                'translations' => array(
                    array(
                        'language' => 'en', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Transport');
                            $translation->setSlug('transport');
                            $translation->setWeight(20);
                        },
                    ),
                    array(
                        'language' => 'fr', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Bouger');
                            $translation->setSlug('bouger');
                            $translation->setWeight(20);
                        },
                    ),
                ),
            ),
            'visiter' => array(
                'title' => 'Visit',
                'translations' => array(
                    array(
                        'language' => 'en', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Visit');
                            $translation->setSlug('visit');
                            $translation->setWeight(20);
                        },
                    ),
                    array(
                        'language' => 'fr', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Visiter');
                            $translation->setSlug('visiter');
                            $translation->setWeight(20);
                        },
                    ),
                ),
            ),
            'galerie' => array(
                'title' => 'Gallery',
                'translations' => array(
                    array(
                        'language' => 'en', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Gallery');
                            $translation->setSlug('gallery');
                            $translation->setWeight(20);
                        },
                    ),
                    array(
                        'language' => 'fr', 
                        'callback' => function($page, $translation, $seo) {
                            $translation->setTitle('Galerie');
                            $translation->setSlug('gallery');
                            $translation->setWeight(20);
                        },
                    ),
                ),
            ),
        );

        foreach (array_reverse($pages) as $name => $page) {
            $contentPage = new DefaultPage();
            $contentPage->setTitle($page['title']);

            $options = array(
                'parent' => $homePage,
                'page_internal_name' => $name,
                'set_online' => true,
                'hidden_from_nav' => false,
                'creator' => self::ADMIN_USERNAME
            );

            $this->pageCreator->createPage($contentPage, $page['translations'], $options);
        }
    }

    /**
     * Create a FormPage
     */
    private function createFormPage()
    {
        $nodeRepo = $this->manager->getRepository('KunstmaanNodeBundle:Node');
        $homePage = $nodeRepo->findOneBy(array('internalName' => 'homepage'));

        $formPage = new FormPage();
        $formPage->setTitle('Contact form');

        $translations = array();
        $translations[] = array('language' => 'en', 'callback' => function($page, $translation, $seo) {
            $translation->setTitle('Contact');
            $translation->setSlug('contact');
            $translation->setWeight(60);
        });
        $translations[] = array('language' => 'nl', 'callback' => function($page, $translation, $seo) {
            $translation->setTitle('Contact');
            $translation->setSlug('contact');
            $translation->setWeight(60);
        });

        $options = array(
            'parent' => $homePage,
            'page_internal_name' => 'contact',
            'set_online' => true,
            'hidden_from_nav' => true,
            'creator' => self::ADMIN_USERNAME
        );

        $node = $this->pageCreator->createPage($formPage, $translations, $options);

        $nodeTranslation = $node->getNodeTranslation('en', true);
        $nodeVersion = $nodeTranslation->getPublicNodeVersion();
        $page = $nodeVersion->getRef($this->manager);
        $page->setThanks("<p>We have received your submission.</p>");
        $this->manager->persist($page);

        $nodeTranslation = $node->getNodeTranslation('nl', true);
        $nodeVersion = $nodeTranslation->getPublicNodeVersion();
        $page = $nodeVersion->getRef($this->manager);
        $page->setThanks("<p>Bedankt, we hebben je bericht succesvol ontvangen.</p>");
        $this->manager->persist($page);

        $pageparts = array();
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\SingleLineTextPagePart',
            array(
                'setLabel' => 'Name',
                'setRequired' => true,
                'setErrorMessageRequired' => 'Name is required'
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\EmailPagePart',
            array(
                'setLabel' => 'Email',
                'setRequired' => true,
                'setErrorMessageRequired' => 'Email is required',
                'setErrorMessageInvalid' => 'Fill in a valid email address'
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\ChoicePagePart',
            array(
                'setLabel' => 'Subject',
                'setRequired' => true,
                'setErrorMessageRequired' => 'Subject is required',
                'setChoices' => "I want to make a website with the Kunstmaan bundles \n I'm testing the website \n I want to get a quote for a website built by Kunstmaan"
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\MultiLineTextPagePart',
            array(
                'setLabel' => 'Message',
                'setRequired' => true,
                'setErrorMessageRequired' => 'Message is required'
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\SubmitButtonPagePart',
            array(
                'setLabel' => 'Send'
            )
        );

        $this->pagePartCreator->addPagePartsToPage('contact', $pageparts, 'en');

        $pageparts = array();
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\SingleLineTextPagePart',
            array(
                'setLabel' => 'Naam',
                'setRequired' => true,
                'setErrorMessageRequired' => 'Naam is verplicht'
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\EmailPagePart',
            array(
                'setLabel' => 'Email',
                'setRequired' => true,
                'setErrorMessageRequired' => 'Email is verplicht',
                'setErrorMessageInvalid' => 'Vul een geldif email adres in'
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\ChoicePagePart',
            array(
                'setLabel' => 'Onderwerp',
                'setRequired' => true,
                'setErrorMessageRequired' => 'Onderwerp is verplicht',
                'setChoices' => "Ik wil een website maken met de Kunstmaan bundles \n Ik ben een website aan het testen \n Ik wil dat Kunstmaan een website voor mij maakt"
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\MultiLineTextPagePart',
            array(
                'setLabel' => 'Bericht',
                'setRequired' => true,
                'setErrorMessageRequired' => 'Bericht is verplicht'
            )
        );
        $pageparts['main'][] = $this->pagePartCreator->getCreatorArgumentsForPagePartAndProperties('Kunstmaan\FormBundle\Entity\PageParts\SubmitButtonPagePart',
            array(
                'setLabel' => 'Verzenden'
            )
        );

        $this->pagePartCreator->addPagePartsToPage('contact', $pageparts, 'nl');

        $this->manager->flush();
    }

    /**
     * Insert all translations
     */
    private function createTranslations()
    {
        // SplashPage
        $trans['contact_us']['en'] = 'Contact us!';
        $trans['contact_us']['fr'] = 'Contacter nous';
        $trans['contact_us']['es'] = 'Contact us';

        foreach ($trans as $key => $array) {
            foreach ($array as $lang => $value) {
                $t = new Translation;
                $t->setKeyword($key);
                $t->setLocale($lang);
                $t->setText($value);
                $t->setDomain('messages');
                $t->setCreatedAt(new \DateTime());
                $t->setFlag(Translation::FLAG_NEW);

                $this->manager->persist($t);
            }
        }

        $this->manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 51;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
