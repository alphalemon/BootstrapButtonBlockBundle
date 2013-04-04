<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerContainer;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;

/**
 * Description of AlBlockManagerBootstrapButtonsGroupBlock
 */
class AlBlockManagerBootstrapButtonsGroupBlock extends AlBlockManagerContainer
{
    private $visibleColumns = array('button_text');
    
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
    
    public function isColumnVisible($columnName)
    {
        return in_array($columnName, $this->visibleColumns);
    }
    
    protected function renderHtml()
    {
        if (null === $this->alBlock) {
            return "";
        }
        
        $buttons = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent(), true);
        
        return array(
            "RenderView" => array(
                "view" => "BootstrapButtonBlockBundle:Button:buttons_group.html.twig",
                "options" => array(
                    "parent" => $this->alBlock,
                    "buttons" => $buttons,
                )
            )
        );
    }
    
    protected function edit(array $values)
    {
        $data = json_decode($values['Content'], true); 
        $savedValues = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock);
       
        if ($data["operation"] == "add") {
            $savedValues[] = $data["value"];
            $values = array("Content" => json_encode($savedValues));
        }
        
        if ($data["operation"] == "remove") {
            unset($savedValues[$data["item"]]);
            
            $blocksRepository = $this->container->get('alpha_lemon_cms.factory_repository');
            $repository = $blocksRepository->createRepository('Block');
            $repository->deleteIncludedBlocks($data["slotName"]);
            
            $values = array("Content" => json_encode($savedValues));
        }
        
        return parent::edit($values);
    }
}
