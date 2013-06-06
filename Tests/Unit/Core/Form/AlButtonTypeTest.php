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

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Tests\Unit\Core\Form;

use AlphaLemon\AlphaLemonCmsBundle\Tests\Unit\Core\Form\Base\AlBaseType;
use AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Form\AlButtonType;

/**
 * AlThumbnailTypeTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlButtonTypeTest extends AlBaseType
{
    protected function configureFields()
    {
        return array(
            'button_text',
            'button_type',
            'button_attribute',
            'button_block',
            'button_enabled',
        );
    }
    
    protected function getForm()
    {
        return new AlButtonType();
    }
    
    public function testDefaultOptions()
    {
        $this->assertEquals(array('csrf_protection' =>false), $this->getForm()->getDefaultOptions(array()));
    }
    
    public function testGetName()
    {
        $this->assertEquals('al_json_block', $this->getForm()->getName());
    }
}
