<?php
class ProductReportCtrl {
    public static function displayReportedProduct($row): string {
        return <<<HTML
        <p>
        <h2 class="topic-heading">Reported Product</h2>
        </p>
        <form method="POST">
        <div class="box-products">
            <div class="product">
                <img src="/media/coffee.jpeg" class="product-img" alt="coffee" />
                <div class="product-text">
                    <h2 class="topic-heading">{$row['product_name']}</h2>
                    <h2 class="topic">R{$row['price']}</h2>
                    <h2 class="topic">{$row['description']}</h2>
                </div>
            </div>
        </div>

        <div>
            <label for="report">Report Reason</label>  
            <textarea name="report" id="report" cols="30" rows="10" required placeholder="Enter the reason for your report here..."></textarea>      
        </div>
        <button class="view" type="submit">Report Product</button>
        </form>
        HTML;
    }
}
