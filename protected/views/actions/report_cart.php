<?php
$printer=Equipment::model()->findByPk($model->details);
$cart=$printer->findMyCart();
$cart_inv=(!empty($cart))?$cart->inv:'';
?>

<input type=text name=inv_cart id=inv_cart value="" placeholder='Инв. номер устанавливаемого картриджа'>
<input type=text name=inv_cart_old id=inv_cart_old placeholder='Инв. номер возвращаемого картриджа' value="<?php echo $cart_inv;?>">
<input type=text name=num_str id=num_str value="" placeholder='Число страниц'><br>
<input type='radio' name='return_place' value='0' checked style="width: 10px;"> В пустые
<input type='radio' name='return_place' value='1' style="width: 10px;"> В полные
