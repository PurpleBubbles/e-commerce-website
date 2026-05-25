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
            <div class="card text-black " style="border-radius: 10px">
                <div  class="card-body p-md-3">
                    <div class=row justify-content-center">
                        <img style="width: auto" src="/media/image-break.png" class="product-img" alt="coffee" />
                        
                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">{$row['product_name']}</p>
                        <p class="text-start h2 bold">R{$row['price']}</p>
                        <p class="text-center">{$row['description']}</p>
                        
                        <button style="width: auto " type="button" class="btn btn-primary btn-lg m-1"  onclick="location.href='/buyer/product.php?product={$row['product_id']}'">View</button>
                        <button style="width: auto " type="button" class="btn btn-primary btn-lg m-1" onclick="location.href='/buyer/payment.php?product={$row['product_id']}'">Buy</button>
                        
                    </div>
                </div>
            </div>
            HTML;
        } else{
            $image_row = $rows;
            return <<<HTML
            <div class="card text-black" style="border-radius: 10px;">
                <div class="card-body p-md-3">
                    <div class=row justify-content-center">
                        <img style="width: auto" src="/image.php?image_id={$image_row['image_id']}" class="product-img" alt="coffee" />
                       
                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">{$row['product_name']}</p>
                        <p class="text-start h2 bold">R{$row['price']}</p>
                        <p class="text-center">{$row['description']}</p>
                        
                        <button style="width: auto " type="button" class="btn btn-primary btn-lg m-1" onclick="location.href='/buyer/product.php?product={$row['product_id']}'">View</button>
                        <button style="width: auto " type="button" class="btn btn-primary btn-lg m-1" onclick="location.href='/buyer/payment.php?product={$row['product_id']}'">Buy</button>
                    </div>
                </div>
            </div>
            HTML;
        }
    }
}
