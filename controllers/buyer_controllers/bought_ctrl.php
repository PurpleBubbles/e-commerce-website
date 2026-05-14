<?php
class BoughtCtrl {
    public static function displayBoughtProducts($rows): string {
        return <<<HTML
        <div class="box-products">
            <div class="product">
                <img src="/media/coffee.jpeg" class="product-img" alt="coffee" />
                <div class="product-text">
                    <h2 class="topic-heading">{$rows['product_name']}</h2>
                    <h2 class="topic">R{$rows['price']}</h2>
                    <h2 class="topic">{$rows['description']}</h2>
                    <button class="view" onclick="location.href='/buyer/product.php?product={$rows['product_id']}'">View</button>
                    <button class="view" onclick="location.href='/buyer/report.php?product={$rows['product_id']}'">Report</button>
                </div>
            </div>
        </div>
        HTML;
    }
}
