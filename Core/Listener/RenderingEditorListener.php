<?php

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Listener;

use AlphaLemon\AlphaLemonCmsBundle\Core\Listener\JsonBlock\RenderingItemEditorListener;

class RenderingEditorListener extends RenderingItemEditorListener
{   
    protected function configure()
    {
        return array(
            'blockClass' => '\AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block\AlBlockManagerBootstrapButtonBlock',
            'formClass' => '\AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Form\AlButtonType',
        );
    }
}
