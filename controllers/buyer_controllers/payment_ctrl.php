<?php
class PaymentCtrl {
    public static function displayPayment($row): string {
        $shipping = 100;

        $total = $row['price'] + $shipping;

        return <<<HTML
        <div class="col col-sm-4 col-lg-4 my-3">
                <div class="h-100 card text-black " style="border-radius: 10px">
                    <img style="max-height: 300px;" src="/media/image-break.png" class="card-img-top object-fit-cover p-1" alt="broken" />
                    <div  class="card-body p-md-3">
                        <div class=justify-content-center">
                            
                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">{$row['product_name']}</p>
                            <p class="text-center">{$row['description']}</p>
                            <p class="text-start h2 bold">R{$row['price']}</p>
                            
                        </div>
                    </div>
                </div>
        </div>    
        <div class="col col-sm-4 col-lg-4 my-3">
        
            <p class="text-start h2 bold">Price: R{$row['price']}</p>
            <p class="text-start h2 bold">Shipping = R100 </p>
            <p class=" h1 fw-bold ">Total: R{$total}</p>
            
        </div> 
        HTML;
    }
}
