<?php
class PaymentCtrl {
    public static function displayPayment($row): string {
        $shipping = 100;

        $total = $row['price'] + $shipping;

        return <<<HTML
        <div class="cic-image-wrapper">
            <img src="https://placehold.co/224x224/8b5cf6/ffffff/png?text=Blanket" alt="A soft, woven linen throw blanket." class="cic-image">
        </div>
        <div class="cic-details">
            <h3 class="cic-title">{$row['product_name']}</h3>
            <p class="cic-attributes">{$row['description']}</p>
        </div>
        <div class="cic-actions">
            <p class="cic-price">Price: R{$row['price']}</p>
        </div>
        
        <label for="shipping">Shipping = R100 </label>
            <div class="payment_total">
                <p>Total: R{$total}</p>
            </div>
            
        <div class="payment_info">Bank Payment Information</div>
            <div class="payment_info">
                <p>Bank Name: </p>
                <label for="options">Bank:</label>
                <select id="options" name="options" required>
                    <option value="ABSA">ABSA</option>
                    <option value="Capitec">Capitec</option>
                    <option value="Netbank">Netbank</option>
                    <option value="FNB">FNB</option>
                </select>
                <p>Card Number: </p>
                <input type="text" placeholder="Example: 4242 4242 4242 4242" required>
                <p>Expiry Date: </p>
                <input type="date" placeholder="MM/YY" required>
                <p>CVV: </p>
                <input type="text" placeholder="Example: 123" required>
            </div>
        
            <div class="payment_button">
                <button class="view" onclick="location.href='/buyer/buyer.php'">Pay</button>
            </div>
            <button class="view" onclick="location.href='../../buyer/home.php'">Cancel</button>
        HTML;
    }
}
