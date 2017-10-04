<?php
session_start(); //start session
include 'config.inc.php';
setlocale(LC_MONETARY, 'en_US'); // US national format (see : http://php.net/money_format)
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Review Your Cart Before Buying</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div style="text-align:center">
    <input type="submit" value="Home" onclick = "location='/barriosshop'"/>
</div >

<h3 style="text-align:center">Review Your Cart Before Buying</h3>
<?php
if (isset($_SESSION['products']) && count($_SESSION['products']) > 0) {
    $total = 0;
    $list_tax = '';
    $cart_box = '<ul class="view-cart">';
    $shipping_cost = (isset($_SESSION['tp_cost'])) ? $_SESSION['tp_cost'] : 0;
    foreach ($_SESSION['products'] as $product) { //Print each item, quantity and price.
        $product_name = $product['product_name'];
        if (isset($_SESSION['cantidad'])) {
            foreach ($_SESSION['cantidad'] as $key) {
                if($key['product_name']!=[$product_name]){
                    array_push($_SESSION['cantidad'], $product);
                }
            }
        }
        else{
            $_SESSION['cantidad']=$_SESSION['products'];
        }
        $product_qty = $product['product_qty'];
        $product_price = $product['product_price'];
        $product_code = $product['product_code'];
        $item_price = sprintf('%01.2f', ($product_price * $product_qty));  // price x qty = total item price
        $cart_box        .=  "<li> $product_code &ndash;  $product_name (Qty : $product_qty ) <span> $currency. $item_price </span></li>";
        $subtotal = ($product_price * $product_qty); //Multiply item quantity * price
        $total = ($total + $subtotal); //Add up to total price
    }
    
    unset($_SESSION['products']);
    $grand_total = $total + $shipping_cost; //grand total
    $balance = 100 - $grand_total;
    $shipping_cost = ($shipping_cost) ? 'Shipping Cost : '.$currency.sprintf('%01.2f', $shipping_cost).'<br />' : '';
    //Print Shipping, VAT and Total
    if ($balance>=0) {
        $_SESSION['cash']=$balance;
        $cart_box .= "<li class=\"view-cart-total\">$shipping_cost  $list_tax
                      <hr>Payable Amount : $currency ".sprintf('%01.2f', $grand_total).'<hr>  Avalible Cash: $100 <hr> Change:'.$balance.'</li>';                               
        $cart_box .= '</ul>';
    echo $cart_box;
    }
    else{
        $cart_box='<h1>You dont have money</h1>';
        echo $cart_box;
    }
} else {
    echo 'Your Cart is empty';
}
?>
<div style="text-align:center">
    <a href="logout.php">EXIT</a>
</div>
</body>
</html>
