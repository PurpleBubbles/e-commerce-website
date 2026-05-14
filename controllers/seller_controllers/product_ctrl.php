<?php
class ProductCtrl {
    public static function displayProduct($row): string {
        return <<<HTML
        <div class="box-products">
            <div class="product">
                <img src="/media/coffee.jpeg" class="product-img" alt="coffee" />
                <div class="product-text">
                    <h2 class="topic-heading">{$row['product_name']}</h2>
                    <h2 class="topic">R{$row['price']}</h2>
                    <h2 class="topic">{$row['description']}</h2>
                    <button class="view" onclick="location.href='/seller/product.php?product={$row['product_id']}'">View</button>
                    <button class="view" onclick="location.href='/seller/payment.php?product={$row['product_id']}'">Buy</button>
                </div>
            </div>
        </div>
        HTML;
    }
}
