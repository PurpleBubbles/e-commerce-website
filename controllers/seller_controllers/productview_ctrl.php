<?php
class ViewCtrl {
    public static function displayDetailedProductView($conn, $row): string {

        $product_id = $row['product_id'];

        $sql = "SELECT * FROM PRODUCT_IMAGES WHERE product_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$product_id]);
        $rows = $stmt->fetch();

        if (empty($rows)) {
            return <<<HTML
            <div class="col col-sm-4 col-lg-4 my-3">
                <div class="h-100 card text-black " style="border-radius: 10px">
                    <img style="max-height: 300px;" src="/media/image-break.png" class="card-img-top object-fit-cover p-1" alt="broken" />
                    <div class="card-body p-md-3">
                        <div class=justify-content-center">
                        
                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">{$row['product_name']}</p>
                            <p class="text-start h2 bold">R{$row['price']}</p>
                            <p class="text-center">{$row['description']}</p>
                            
                        </div>
                    </div>
                    <div class="card-footer" style="display: flex; justify-content: center;">
                        <button style="width: auto " type="button" class="btn btn-primary btn-lg m-1" onclick="location.href='/seller/payment.php?product={$row['product_id']}'">Buy</button>
                    </div>
                </div>
            </div>
            HTML;
        } else{
            $image_row = $rows;
            return <<<HTML
            <div class="col col-sm-4 col-lg-4 my-3">
                <div class="h-100 card text-black " style="border-radius: 10px">
                    <img style="max-height: 300px;" src="/image.php?image_id={$image_row['image_id']}" class="card-img-top object-fit-cover p-1" alt="coffee" />
                    <div class="card-body p-md-3">
                        <div class=justify-content-center">
                        
                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">{$row['product_name']}</p>
                            <p class="text-start h2 bold">R{$row['price']}</p>
                            <p class="text-center">{$row['description']}</p>
                            
                        </div>
                    </div>
                    <div class="card-footer" style="display: flex; justify-content: center;">
                        <button style="width: auto " type="button" class="btn btn-primary btn-lg m-1" onclick="location.href='/seller/payment.php?product={$row['product_id']}'">Buy</button>
                    </div>  
                </div>
            </div>
            HTML;
        }
    }
}
