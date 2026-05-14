<?php
class ViewCtrl {
    public static function displayDetailedProductView($row): string {
        return <<<HTML
        <div class="box-products">
            <div class="product">
                <img src="/media/coffee.jpeg" class="product-img" alt="coffee" />
                <div class="product-text">
                    <h2 class="topic-heading">{$row['product_name']}</h2>
                    <h2 class="topic">R{$row['price']}</h2>
                    <h2 class="topic">{$row['description']}</h2>
                    <button class="view" onclick="location.href='/home/payment.php?product={$row['product_id']}'">Buy</button>
                    <button class="view" onclick="location.href='/home/home.php'">Report</button>
                </div>
            </div>
        </div>
        HTML;
    }
}
