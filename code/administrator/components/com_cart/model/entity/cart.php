<?php
/**
 * Nucleon Plus
 *
 * @package     Nucleon Plus
 * @copyright   Copyright (C) 2015 - 2020 Nucleon Plus Co. (http://www.nucleonplus.com)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        https://github.com/jebbdomingo/nucleonplus for the canonical source repository
 */

class ComCartModelEntityCart extends KModelEntityRow
{
    public function delete()
    {
        $cartItems = $this->getObject('com://admin/cart.model.items')->cart_id($this->id)->fetch();
        $cartItems->delete();

        parent::delete();
    }

    public function getItems()
    {
        return $this->getObject('com://admin/cart.model.items')
            ->cart_id($this->id)
            ->fetch()
        ;
    }
}
