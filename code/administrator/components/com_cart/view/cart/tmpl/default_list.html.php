<table class="table table-striped">
    <thead>
        <th>Item</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Action</th>
    </thead>
    <tbody>
        <? if (count($cart->getItems()) > 0): ?>
            <? foreach ($cart->getItems() as $item): ?>
                <tr>
                    <td>
                        <h6><?= $item->name ?></h6>
                        <h6><small><?= $item->description ?></small></h6>
                    </td>
                    <td><h6><strong>&#8369;<?= number_format($item->price, 2) ?></strong></h6></td>
                    <td>
                        <input type="text" name="quantity[<?= $item->id ?>]" value="<?= $item->quantity ?>" style="width: 30px" />
                    </td>
                    <td>
                        <button type="button" class="cartItemDeleteAction btn btn-link btn-xs" data-id="<?= $item->id ?>">
                            <span>Delete</span>
                        </button>
                    </td>
                </tr>
            <? endforeach ?>
        <? else: ?>
            <tr>
                <td colspan="4">
                    <p class="text-center">Cart is empty</p>
                </td>
            </tr>
        <? endif ?>
    </tbody>
</table>
