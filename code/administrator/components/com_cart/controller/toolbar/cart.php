<?php

/**
 * Nucleon Plus
 *
 * @package     Nucleon Plus
 * @copyright   Copyright (C) 2015 - 2020 Nucleon Plus Co. (http://www.nucleonplus.com)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        https://github.com/jebbdomingo/nucleonplus for the canonical source repository
 */

class ComCartControllerToolbarCart extends ComKoowaControllerToolbarActionbar
{
    protected function _initialize(KObjectConfig $config)
    {
        $config->append(array(
            'title' => ucfirst($this->getName()),
            'icon'  => $this->getName(),
        ));

        parent::_initialize($config);
    }

    protected function _commandUpdate(KControllerToolbarCommand $command)
    {
        $command->icon = 'icon-32-save';

        $command->append(array(
            'attribs' => array(
                'data-action'     => 'updatecart',
                'data-novalidate' => 'novalidate', // This is needed for koowa-grid and view without form
                'accesskey'       => 'u'
            )
        ));

        $command->label = 'Update Cart';
    }

    protected function _commandDeleteitem(KControllerToolbarCommand $command)
    {
        $command->icon = 'icon-32-delete';

        $command->append(array(
            'attribs' => array(
                'data-action' => 'deleteitem'
            )
        ));

        $command->label = 'Delete Item';
    }

    protected function _commandAdd(KControllerToolbarCommand $command)
    {
        $command->icon = 'icon-32-apply';

        $command->append(array(
            'attribs' => array(
                'data-action'     => 'add',
                'data-novalidate' => 'novalidate', // This is needed for koowa-grid and view without form
                'accesskey'       => 'a'
            )
        ));

        $command->label = 'Add Item';
    }

    protected function _commandCheckout(KControllerToolbarCommand $command)
    {
        $command->icon = 'icon-32-save';

        $command->append(array(
            'attribs' => array(
                'data-action'     => 'checkout',
                'data-novalidate' => 'novalidate', // This is needed for koowa-grid and view without form
                'accesskey'       => 'c'
            )
        ));

        $command->label = 'Checkout';
    }

    protected function _afterRead(KControllerContextInterface $context)
    {
        $this->_addReadCommands($context);

        parent::_afterRead($context);
        
        $this->removeCommand('apply');
        $this->removeCommand('save');
    }
    
    /**
     * Add read view toolbar buttons
     *
     * @param KControllerContextInterface $context
     *
     * @return void
     */
    protected function _addReadCommands(KControllerContextInterface $context)
    {
        $controller = $this->getController();
        $allowed    = true;

        if (isset($context->result) && $context->result->isLockable() && $context->result->isLocked()) {
            $allowed = false;
        }

        if ($controller->isEditable() && $controller->canSave()) {
            $this->addCommand('add', [
                'allowed' => $allowed,
            ]);
        }

        if ($controller->isEditable() && $controller->canSave()) {
            $this->addCommand('update', [
                'allowed' => $allowed,
            ]);
        }

        if ($controller->isEditable() && $controller->canSave()) {
            $this->addCommand('checkout', [
                'allowed' => $allowed,
            ]);
        }

        if ($controller->isEditable() && $controller->canSave()) {
            $this->addCommand('deleteitem', [
                'allowed' => $allowed,
            ]);
        }
    }
}
