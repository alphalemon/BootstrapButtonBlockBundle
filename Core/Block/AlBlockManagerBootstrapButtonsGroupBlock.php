<?php
/*
 * This file is part of the BootstrapButtonBlockBundle and it is distributed
 * under the MIT LICENSE. To use this application you must leave intact this copyright 
 * notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 * 
 * @license    MIT LICENSE
 * 
 */

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerContainer;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlockCollection;

/**
 * Defines the Block Manager to handle a Bootstrap Buttons group
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapButtonsGroupBlock extends AlBlockManagerJsonBlockCollection
{
    private $visibleColumns = array('button_text');
    
    /**
     * {@inheritdoc}
     */
    public function getDefaultValue()
    {        
        $value =
        '{
            "0" : {
                "type": "BootstrapButtonBlock"
            },
            "1" : {
                "type": "BootstrapButtonBlock"
            },
            "2" : {
                "type": "BootstrapButtonBlock"
            }
        }';
        
        return array('Content' => $value);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderHtml()
    {
        if (null === $this->alBlock) {
            return "";
        }
        
        $buttons = $this->decodeJsonContent($this->alBlock->getContent(), true);
        
        return array(
            "RenderView" => array(
                "view" => "BootstrapButtonBlockBundle:Button:buttons_group.html.twig",
                "options" => array(
                    "buttons" => $buttons,
                )
            )
        );
    }
}
