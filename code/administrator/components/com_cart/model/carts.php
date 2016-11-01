<?php
/**
 * Nucleon Plus Cart
 *
 * @package     Nucleon Plus
 * @copyright   Copyright (C) 2015 - 2020 Nucleon Plus Co. (http://www.nucleonplus.com)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        https://github.com/jebbdomingo/nucleonplus for the canonical source repository
 */

abstract class ComCartModelCarts extends KModelDatabase
{
    public function __construct(KObjectConfig $config)
    {
        parent::__construct($config);

        $this->getState()
            ->insert('customer', 'int')
            ->insert('cart_id', 'int')
        ;
    }

    protected function _buildQueryWhere(KDatabaseQueryInterface $query)
    {
        parent::_buildQueryWhere($query);

        $state = $this->getState();

        if ($state->customer) {
            $query->where('tbl.customer = :customer')->bind(['customer' => $state->customer]);
        }

        if ($state->cart_id) {
            $query->where('tbl.cart_id = :cart_id')->bind(['cart_id' => $state->cart_id]);
        }
    }

    /**
     * Get the total amount of this cart
     *
     * @return decimal
     */
    abstract public function getAmount();

    /**
     * Get the total weight of this order
     *
     * @return integer
     */
    abstract public function getWeight();
}
