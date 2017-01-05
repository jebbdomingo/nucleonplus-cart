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
    /**
     * Constructor.
     *
     * @param KObjectConfig $config Configuration options.
     */
    public function __construct(KObjectConfig $config)
    {
        @ini_set('max_execution_time', 300);
        
        parent::__construct($config);

        $this->addCommandCallback('before.add', '_validateAdd');
    }

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

    protected function _validateAdd(KControllerContextInterface $context)
    {
        $data       = $context->request->data;
        $translator = $this->getObject('translator');
        $result     = false;

        try
        {
            $cart     = $this->getModel()->fetch();
            $quantity = (int) $data->quantity;

            if (empty($data->row) || !$quantity) {
                throw new KControllerExceptionRequestInvalid($translator->translate('Please select an item and specify its quantity'));
            }

            $result = true;
        }
        catch(Exception $e)
        {
            $context->response->setRedirect($context->request->getReferrer(), $e->getMessage(), 'error');
            $context->response->send();
        }

        return $result;
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

    protected function _actionAdd(KControllerContextInterface $context)
    {
        $data      = $context->request->data;
        $cart      = $this->getModel()->fetch();
        $cartItems = array();

        if (count($cart))
        {
            // Add item(s) to the cart
            if ($items = $cart->getItems())
            {
                foreach ($items as $item)
                {
                    $cartItems[] = $item->row;

                    // Existing item, update quantity instead
                    if ($item->row == $data->ItemRef)
                    {
                        $item->quantity += $data->quantity;
                        $item->save();
                    }
                }
            }

            if (!in_array($data->ItemRef, $cartItems))
            {
                // New item
                $cartItemData = array(
                    'cart_id'  => $cart->id,
                    'row'      => $data->row,
                    'quantity' => $data->quantity,
                );

                $item = $this->getObject('com:cart.model.items')->create($cartItemData);
                $item->save();
            }
        }

        return $cart;
    }

    protected function _actionUpdatecart(KControllerContextInterface $context)
    {
        if (!$context->result instanceof KModelEntityInterface) {
            $cart = $this->getModel()->fetch();
        } else {
            $cart = $context->result;
        }

        if (count($cart))
        {
            $cart->setProperties($context->request->data->toArray());
            $cart->save();

            if (in_array($cart->getStatus(), array(KDatabase::STATUS_FETCHED, KDatabase::STATUS_UPDATED)))
            {
                foreach ($cart->getItems() as $item)
                {
                    $item->quantity = (int) $context->request->data->quantity[$item->id];
                    $item->save();
                }

                $context->response->addMessage('You shopping cart has been updated');
            }
            else $context->response->addMessage($cart->getStatusMessage(), 'error');
        }
    }

    protected function _actionDeleteitem(KControllerContextInterface $context)
    {
        $data  = $context->request->data;
        $ids   = $data->id;
        $items = $this->getObject('com:cart.model.items')->id($ids)->fetch();

        foreach ($items as $item) {
            $item->delete();
        }
    }
}
