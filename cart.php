<?php
require_once 'config/db.php';

$action=$_GET['action']??'';
$id=(int)($_GET['id']??0);

if($action==='add' && $id){
    if(product_stock($id)>0){
        $_SESSION['cart'][$id]=($_SESSION['cart'][$id]??0)+1;
    }
    header('Location: cart.php');
    exit;
}

if($action==='remove' && $id){
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit;
}

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['qty'])){
    foreach($_POST['qty'] as $pid=>$qty){
        $qty=max(0,(int)$qty);

        if(product_stock($pid)<=0){
            unset($_SESSION['cart'][(int)$pid]);
            continue;
        }

        if($qty){
            $_SESSION['cart'][(int)$pid]=$qty;
        }else{
            unset($_SESSION['cart'][(int)$pid]);
        }
    }

    header('Location: checkout.php');
    exit;
}

$title='Order Basket | Pharmasia';
include 'header.php';
$cart=$_SESSION['cart']??[];
?>

<section class="page-hero">
<h1>Order Basket</h1>
<p>Review products before checkout.</p>
</section>

<form method="post" class="cart-box reveal">
<table>
<tr>
<th>Product</th>
<th>Stock</th>
<th>Qty</th>
<th>Price</th>
<th></th>
</tr>

<?php
$total=0;
foreach($cart as $pid=>$qty):
$p=product_find($pid);
if(!$p) continue;
$stock=product_stock($pid);
$total+=$p['price']*$qty;
?>

<tr>
<td><b><?=h($p['name'])?></b><br><small><?=h($p['generic_name'])?></small></td>

<td>
<?php if($stock>0): ?>
<span style="color:green"><?= $stock ?></span>
<?php else: ?>
<span style="color:red">Out of Stock</span>
<?php endif; ?>
</td>

<td>
<input type="number"
name="qty[<?= (int)$pid ?>]"
min="0"
max="<?= $stock ?>"
value="<?= (int)$qty ?>"
<?= $stock==0?'disabled':'' ?>>
</td>

<td>৳<?=h($p['price'])?></td>

<td><a href="cart.php?action=remove&id=<?= (int)$pid ?>">Remove</a></td>
</tr>

<?php endforeach; ?>
</table>

<h3>Estimated Total: ৳<?= $total ?></h3>

<button class="btn">Proceed to Checkout</button>

</form>

<?php include 'footer.php'; ?>
