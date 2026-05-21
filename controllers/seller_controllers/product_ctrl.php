<?php

class ProductCtrl {
    public static function displayProduct($conn, $row): string {

        $product_id = $row['product_id'];

        $sql = "SELECT * FROM PRODUCT_IMAGES WHERE product_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$product_id]);
        $rows = $stmt->fetch();

        if (empty($rows)) {
            return <<<HTML
            <div class="box-products">
                <div class="product">
                    <img src="/media/image-break.png" class="product-img" alt="coffee" />
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
        } else{
            $image_row = $rows;
            return <<<HTML
            <div class="box-products">
                <div class="product">
                    <img src="/image.php?image_id={$image_row['image_id']}" class="product-img" alt="coffee" />
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
}
