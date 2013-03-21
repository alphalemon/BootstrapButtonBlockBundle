<?php

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JstreeDropdownButtonController extends Controller
{
    public function showAction()
    {
        $request = $this->container->get('request');
        
        $factoryRepository = $this->container->get('alpha_lemon_cms.factory_repository');
        $blocksRepository = $factoryRepository->createRepository('Block');
        $block = $blocksRepository->fromPk($request->get('idBlock'));
        
        $items = \AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock::decodeJsonContent($block->getContent());
        $item = $items[0];
        $attributes = $item["items"]; 
        
        $pagesRepository = $factoryRepository->createRepository('Page');
        
        $options = array(               
            'attributes' => $attributes,                 
            'jstree_nodes' => json_encode($attributes), 
            'attributes_form' => 'BootstrapButtonBlockBundle:Jstree:_jstree_attribute.html.twig',                
            'pages' => \AlphaLemon\AlphaLemonCmsBundle\Core\Form\ModelChoiceValues\ChoiceValues::getPages($pagesRepository),
        );
        
        return $this->container->get('templating')->renderResponse('JstreeBundle:Jstree:_jstree.html.twig', $options);
    }
}
