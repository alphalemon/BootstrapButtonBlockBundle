<?php

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AlphaLemon\AlphaLemonCmsBundle\Core\Form\ModelChoiceValues\ChoiceValues;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;

class JstreeDropdownButtonController extends Controller
{
    public function showAction()
    {
        $request = $this->container->get('request');
        
        $factoryRepository = $this->container->get('alpha_lemon_cms.factory_repository');
        $blocksRepository = $factoryRepository->createRepository('Block');
        $block = $blocksRepository->fromPk($request->get('idBlock'));
        
        $items = AlBlockManagerJsonBlock::decodeJsonContent($block->getContent());
        $item = $items[0];
        $attributes = $item["items"]; 
        
        $seoRepository = $factoryRepository->createRepository('Seo');
        
        $options = array(               
            'attributes' => $attributes,                 
            'jstree_nodes' => json_encode($attributes), 
            'attributes_form' => 'BootstrapButtonBlockBundle:Jstree:_jstree_attribute.html.twig',                
            'pages' => ChoiceValues::getPermalinks($seoRepository, $request->get('languageId')),
        );
        
        return $this->container->get('templating')->renderResponse('JstreeBundle:Jstree:_jstree.html.twig', $options);
    }
}
