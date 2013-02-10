<?php
/*
 * This file is part of the BusinessDropCapBundle and it is distributed
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

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Form;

use AlphaLemon\AlphaLemonCmsBundle\Core\Form\JsonBlock\JsonBlockType;
use Symfony\Component\Form\FormBuilderInterface;

class AlButtonType extends JsonBlockType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('button_text');
        $builder->add('button_type', 'choice', array('choices' => array('' => 'base', 'btn-primary' => 'primary', 'btn-info' => 'info', 'btn-success' => 'success', 'btn-warning' => 'warning', 'btn-danger' => 'danger', 'btn-inverse' => 'inverse')));
        $builder->add('button_attribute', 'choice', array('choices' => array("" => "normal", "btn-mini" => "mini", "btn-small" => "small", "btn-large" => "large")));
        $builder->add('button_block', 'choice', array('choices' => array("" => "normal", "btn-block" => "block")));
        $builder->add('button_enabled', 'choice', array('choices' => array("" => "enabled", "disabled" => "disabled")));
    }
}
