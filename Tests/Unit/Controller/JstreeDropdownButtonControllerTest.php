<?php

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Tests\Unit\Controller;

use AlphaLemon\AlphaLemonCmsBundle\Tests\TestCase;
use AlphaLemon\Block\BootstrapButtonBlockBundle\Controller\JstreeDropdownButtonController;

/**
 * JstreeDropdownButtonControllerTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class JstreeDropdownButtonControllerTest extends TestCase
{
    public function testShow()
    {
        $value = '{
            "0": {
                "button_text": "Dropdown Button 1",
                "button_type": "",
                "button_attribute": "",
                "button_dropup" : "none",
                "items": [
                    {
                        "data" : "Item 1", 
                        "metadata" : {  
                            "type": "link",
                            "href": "#",
                            "attributes": {}
                        }
                    },
                    { 
                        "data" : "Item 2", 
                        "metadata" : {  
                            "type": "link",
                            "href": "#",
                            "attributes": {}
                        }
                    },
                    { 
                        "data" : "Item 3", 
                        "metadata" : {  
                            "type": "link",
                            "href": "#",
                            "attributes": {}
                        }
                    }
                ]
            }
        }';
        
        $requestIdBlock = 2;
        $requestIdLanguages = 2;
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request->expects($this->at(0))
            ->method('get')
            ->with('idBlock')
            ->will($this->returnValue($requestIdBlock))
        ; 
        
        $request->expects($this->at(1))
            ->method('get')
            ->with('languageId')
            ->will($this->returnValue($requestIdLanguages))
        ; 
        
        $blockRepository =
            $this->getMockBuilder('AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Propel\AlBlockRepositoryPropel')
                 ->disableOriginalConstructor()
                 ->getMock()
        ;  
        
        $blockRepository->expects($this->once())
            ->method('fromPk')
            ->with($requestIdBlock)
            ->will($this->returnValue($this->initBlock($value)))
        ; 
        
        $factoryRepository = 
            $this->getMockBuilder('AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Factory\AlFactoryRepository')
                 ->disableOriginalConstructor()
                 ->getMock()
        ;
        
        $factoryRepository->expects($this->at(0))
            ->method('createRepository')
            ->with('Block')
            ->will($this->returnValue($blockRepository))
        ; 
        
        $seoRepository =
            $this->getMockBuilder('AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Propel\AlSeoRepositoryPropel')
                 ->disableOriginalConstructor()
                 ->getMock()
        ;     
        
        $seoRepository->expects($this->at(0))
            ->method('fromLanguageId')
            ->with($requestIdLanguages)
            ->will($this->returnValue(array($this->initSeo('my-awesome-page'))))
        ; 
        
        $factoryRepository->expects($this->at(1))
            ->method('createRepository')
            ->with('Seo')
            ->will($this->returnValue($seoRepository))
        ; 
        
        $valueDecoded = json_decode($value, true);
        $items = $valueDecoded[0]['items'];
        $options = array(
            'attributes' => $items,
            'jstree_nodes' => json_encode($items),
            'attributes_form' => 'BootstrapButtonBlockBundle:Jstree:_jstree_attribute.html.twig', 
            'pages' => array(
                ' ',
                'my-awesome-page'
            ),
        );
        
        $templating = $this->getMock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $templating
             ->expects($this->once())
             ->method('renderResponse')
             ->with('JstreeBundle:Jstree:_jstree.html.twig', $options)
        ;    
        
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->at(0))
            ->method('get')
            ->with('request')
            ->will($this->returnValue($request))
        ; 
        
        $container->expects($this->at(1))
            ->method('get')
            ->with('alpha_lemon_cms.factory_repository')
            ->will($this->returnValue($factoryRepository))
        ;
        
        $container->expects($this->at(2))
            ->method('get')
            ->with('templating')
            ->will($this->returnValue($templating))
        ;

        $controller = new JstreeDropdownButtonController();
        $controller->setContainer($container);
        $controller->showAction();
    }
    
    protected function initBlock($value)
    {
        $block = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock');
        $block->expects($this->once())
              ->method('getContent')
              ->will($this->returnValue($value));

        return $block;
    }
    
    protected function initSeo($value)
    {
        $block = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Model\AlSeo');
        $block->expects($this->once())
              ->method('getPermalink')
              ->will($this->returnValue($value));

        return $block;
    }
}
