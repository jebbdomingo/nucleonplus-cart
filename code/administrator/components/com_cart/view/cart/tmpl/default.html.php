<?
/**
 * Nucleon Plus
 *
 * @package     Nucleon Plus
 * @copyright   Copyright (C) 2015 - 2020 Nucleon Plus Co. (http://www.nucleonplus.com)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        https://github.com/jebbdomingo/nucleonplus for the canonical source repository
 */

defined('KOOWA') or die; ?>

<?= helper('behavior.koowa'); ?>

<?= helper('behavior.validator'); ?>
<?= helper('com:cart.behavior.deletable'); ?>

<ktml:style src="media://koowa/com_koowa/css/koowa.css" />

<div class="row-fluid">

    <div class="span12">

        <fieldset class="form-vertical">

            <form method="post" class="-koowa-grid">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= translate('Cart') ?></h3>
                    </div>
                    <div class="panel-body">
                        <?= import('default_list.html') ?>

                    </div>
                    <div style="text-align: right">
                        <h4>Total: <strong>&#8369;<?= number_format($cart->getAmount(), 2) ?></strong></h4>
                    </div>
                </div>

            </form>

        </fieldset>

    </div>

</div>