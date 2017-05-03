<?php if ($cartinfo AND count($cartinfo)): ?>
    <h2><?= $text_market_cart_admin ?></h2>
    <table>
        <?php
        $total = 0;
        foreach ($cartinfo as $value):
            $total = $total + $value['total'];
            ?>

            <tr>
                <td class="first"><?= $value['title'] ?> (<?= $value['price'] ?><span> <?= $text_market_cart_price_postfix ?></span>)</td>
                <td><?= $value['qty'] ?><span> <?= $text_market_cart_qty_postfix ?></span></td>
                <td><?= $value['total'] ?><span> <?= $text_market_cart_price_postfix ?></span></td>
            </tr>
    <?php endforeach; ?>

        <tr>
            <td colspan="3"><span><?= $text_market_cart_total ?> </span><?= $total ?><span> <?= $text_market_cart_price_postfix ?></span></td>
        </tr>
    </table>
<?php endif; ?>
