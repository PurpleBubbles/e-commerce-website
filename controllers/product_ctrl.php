<?php
class ProductCtrl {
    public static function displayProduct($row): string {
        return <<<HTML
        <div class="box-products">
            <div class="product">
                <img src="/media/coffee.jpeg" class="product-img" alt="coffee" />
                <div class="product-text">
                    <h2 class="topic-heading">{$row['product_name']}</h2>
                    <h2 class="topic">Product price</h2>
                    <h2 class="topic">Location</h2>
                </div>
            </div>
        </div>
        HTML;
    }
}
