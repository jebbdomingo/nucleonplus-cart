<?php
/**
 * Nucleon Plus
 *
 * @package     Nucleon Plus
 * @copyright   Copyright (C) 2015 - 2020 Nucleon Plus Co. (http://www.nucleonplus.com)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        https://github.com/jebbdomingo/nucleonplus for the canonical source repository
 */


/**
 * Cart Controller
 *
 * @author  Jebb Domingo <http://github.com/jebbdomingo>
 * @package Nucleon Plus
 */
abstract class ComCartControllerCart extends ComKoowaControllerModel
{
    protected function _initialize(KObjectConfig $config)
    {
        $config->append(array(
            'model' => 'com:cart.model.carts'
        ));

        // Alias the permission
        $permission         = $this->getIdentifier()->toArray();
        $permission['path'] = array('controller', 'permission');
        $this->getObject('manager')->registerAlias('com:cart.controller.permission.cart', $permission);

        parent::_initialize($config);
    }

    protected function _actionRender(KControllerContextInterface $context)
    {
        $view = $this->getView();

        // Alias the view layout
        if ($view instanceof KViewTemplate)
        {
            $layout         = $view->getIdentifier()->toArray();
            $layout['name'] = $view->getLayout();

            unset($layout['path'][0]);

            $alias            = $layout;
            $alias['package'] = 'cart';

            $this->getObject('manager')->registerAlias($layout, $alias);
        }

        return parent::_actionRender($context);
    }
}
