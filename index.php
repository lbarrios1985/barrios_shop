<?php
session_start(); //start session
include 'config.inc.php'; //include config file
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Barrio´s Shop Center</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<script  src="js/jquery-1.11.2.min.js"></script>




</head>
<body>
<div align="center">
<h3>The Best Site for Shopping</h3>
</div>
<?php
if($_SESSION['cantidad']){
	foreach ($_SESSION['cantidad'] as $key) {
		$cash = '<div id="'.$key['product_name'].'"></div>';
		echo $cash;
	}
}


if (!$_SESSION['cash']) {
	$_SESSION['cash']=100;
}
$cash = '<div id="cash">Cash Available:'.$_SESSION['cash'].'</div> ';
echo $cash;
?>

<a href="#" class="cart-box" id="cart-info" title="View Cart">
<?php
if (isset($_SESSION['products'])) {
    echo count($_SESSION['products']);
} else {
    echo 0;
}
?>
</a>

<div class="shopping-cart-box">
<a href="#" class="close-shopping-cart-box" >Close</a>
<h3>Your Shopping Cart</h3>
    <div id="shopping-cart-results">
    </div>
</div>

<?php
//List products from database
$results = $mysqli_conn->query('SELECT * FROM products');
//Display fetched records as you please

$products_list = '<ul class="products-wrp">';

while ($row = $results->fetch_assoc()) {
    $products_list .= <<<EOT
<li>
<form class="form-item">
<h4>{$row['product_name']}</h4>
<div><img src="images/{$row['product_image']}"></div>
<div>Price : USD {$row['product_price']}<div>

<div>Rating :  {$row['current_rating']} / 5 (of {$row['people_rating']} votes)<div>
<div class="item-box">
    <div>

	<div>
    Qty :

    <input id="product_qty{$row['id']}" name="product_qty" type="number" min="1">

	</div>

	<div id="producto{$row['id']}" style="display:block">
    Rate :
    <INPUT TYPE=RADIO name="curent_rate" Value=1 ;><img src=images/star.gif> <INPUT TYPE=RADIO name="curent_rate" Value=2 ;><img src=images/star.gif><img src=images/star.gif> <INPUT TYPE=RADIO name="curent_rate" Value=3 ;><img src=images/star.gif><img src=images/star.gif><img src=images/star.gif> <INPUT TYPE=RADIO name="curent_rate" Value=4 ;><img src=images/star.gif><img src=images/star.gif><img src=images/star.gif><img src=images/star.gif> <INPUT TYPE=RADIO name="curent_rate" Value=5 ;><img src=images/star.gif><img src=images/star.gif><img src=images/star.gif><img src=images/star.gif><img src=images/star.gif>
	</div>
	</div>

    <input name="product_code" type="hidden" value="{$row['product_code']}">
    <button type="submit">Add to Cart</button>
</div>
</form>
</li>
EOT;
}
$products_list .= '</ul></div>';

echo $products_list;
?>

<div class="transport">
	 <h3>choose a transport type</h3>
	 <form class="" action="index.html" method="post">

	 <div>
	    Transport :
	    <select id="opt_transport">
	    <option class="transport-type" value="2">Select</option>
	    <option class="transport-type" value="0">pick up ($0)</option>
	    <option class="transport-type" value="5">UPS ($5)</option>
	    </select>
	</div>

	 </form>
</div>

<script>
$(document).ready(function(){
	if (document.getElementById('Apple')) {
      document.getElementById('producto1').style.display='none';
    }
    if (document.getElementById('Water')) {
      document.getElementById('producto3').style.display='none';
    }
    if (document.getElementById('Cheese')) {
      document.getElementById('producto4').style.display='none';
    }
    if (document.getElementById('beer')) {
      document.getElementById('producto2').style.display='none';
    }
	
		$('body').find(".form-item").submit(function(e){
			var form_data = $(this).serialize();
			var button_content = $(this).find('button[type=submit]');
			var cantidad=form_data.substring(12,13); 
			var ter=form_data.split('=');
			console.log(form_data);
			//$('#cantidad').append("<div id='"+ter[3]+"'></div>");

			if(cantidad=='&'){
				alert("the quantity can not be empty"); //alert user
			}

			else{
				button_content.html('Adding...');
				$.ajax({
					url: "cart_process.php",
					type: "POST",
					dataType:"json",
					data: form_data
				}).done(function(data){ //on Ajax success
					$("#cart-info").html(data.items); //total items in cart-info element
					button_content.html('Add to Cart'); //reset button text to original text
					alert("Item added to Cart!"); //alert user
					if($(".shopping-cart-box").css("display") == "block"){ //if cart box is still visible
						$(".cart-box").trigger( "click" ); //trigger click to update the cart box.
					}
				})
			}
			
			e.preventDefault();
		});

	//Show Items in Cart
	$( ".cart-box").click(function(e) {
		e.preventDefault();
		if ($("#opt_transport").val()!=2){
			$(".shopping-cart-box").fadeIn(); //display cart box
			$("#shopping-cart-results").html('<img src="images/ajax-loader.gif">');
			$("#shopping-cart-results" ).load( "cart_process.php", {"load_cart":"1"});
		}
		else{
			alert('you have to select a transport method');
		}
	});

	//Close Cart
	$( ".close-shopping-cart-box").click(function(e){
		e.preventDefault();
		$(".shopping-cart-box").fadeOut(); //close cart-box
	});

	//Remove items from cart
	$("#shopping-cart-results").on('click', 'a.remove-item', function(e) {
		e.preventDefault();
		var pcode = $(this).attr("data-code"); //get product code
		$(this).parent().fadeOut(); //remove item element from box
		$.getJSON( "cart_process.php", {"remove_code":pcode} , function(data){
			$("#cart-info").html(data.items);
			$(".cart-box").trigger( "click" );
		});
	});

	//update transport means
	$("#opt_transport").on('change',function(){
		  if ($(this).val()==0 ||$(this).val()==5 ){
		  	$.post('cart_process.php',{cost:$(this).val()}).done(function(){
				alert('transport type updated');
			});
		  }
		  else{
		  	alert('you have to select a method');
		  }			
	 });
});
</script>
</body>
</html>
