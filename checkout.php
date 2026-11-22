<?php

require_once 'config/db.php';

/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
| Saves order information into:
|   1. orders
|   2. order_items
|--------------------------------------------------------------------------
*/

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header('Location: cart.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Load cart products
|--------------------------------------------------------------------------
*/

$items = [];
$total = 0;

foreach ($cart as $pid => $qty) {

    $pid = (int)$pid;
    $qty = (int)$qty;

    if ($qty <= 0) {
        continue;
    }

    $product = product_find($pid);

    if (!$product) {
        continue;
    }

    $stock = product_stock($pid);

    // Remove unavailable product from cart
    if ($stock <= 0) {
        unset($_SESSION['cart'][$pid]);
        continue;
    }

    // Don't allow quantity above stock
    if ($qty > $stock) {
        $qty = $stock;
        $_SESSION['cart'][$pid] = $qty;
    }

    $price = (float)$product['price'];
    $subtotal = $price * $qty;

    $product['quantity'] = $qty;
    $product['subtotal'] = $subtotal;

    $items[] = $product;

    $total += $subtotal;
}


if (empty($items)) {
    header('Location: cart.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| Submit Order
|--------------------------------------------------------------------------
*/

$error = '';
$success = false;
$orderId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $owner_name = trim($_POST['owner_name'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');

    $payment_method = trim($_POST['payment_method'] ?? '');
    $payment_system = trim($_POST['payment_system'] ?? '');

    if ($owner_name === '') {
        $error = 'Please enter contact person name.';
    }

    elseif ($phone_number === '') {
        $error = 'Please enter phone number.';
    }

    elseif ($payment_method === '') {
        $error = 'Please select payment method.';
    }

    else {

        try {

            $pdo->beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | Insert every cart item into orders
            |--------------------------------------------------------------------------
            */

            $orderSql = "
                INSERT INTO orders
                (
                    owner_name,
                    phone_number,
                    medicine_name,
                    company_name,
                    quantity,
                    price,
                    payment_method,
                    payment_system,
                    order_status,
                    order_date,
                    product_id
                )
                VALUES
                (
                    :owner_name,
                    :phone_number,
                    :medicine_name,
                    :company_name,
                    :quantity,
                    :price,
                    :payment_method,
                    :payment_system,
                    'pending',
                    NOW(),
                    :product_id
                )
            ";

            $orderStmt = $pdo->prepare($orderSql);


            /*
            |--------------------------------------------------------------------------
            | Insert every cart item into order_items
            |--------------------------------------------------------------------------
            */

            $itemSql = "
                INSERT INTO order_items
                (
                    owner_name,
                    phone_number,
                    medicine_name,
                    company_name,
                    quantity,
                    price,
                    payment_method,
                    payment_system,
                    order_status,
                    order_date
                )
                VALUES
                (
                    :owner_name,
                    :phone_number,
                    :medicine_name,
                    :company_name,
                    :quantity,
                    :price,
                    :payment_method,
                    :payment_system,
                    'pending',
                    NOW()
                )
            ";

            $itemStmt = $pdo->prepare($itemSql);


            foreach ($items as $product) {

                $medicine_name = $product['name'];

                /*
                 * Your products table may use either company_name
                 * or company. This supports both.
                 */
                $company_name = '';

                if (isset($product['company_name'])) {
                    $company_name = $product['company_name'];
                }
                elseif (isset($product['company'])) {
                    $company_name = $product['company'];
                }


                $quantity = (int)$product['quantity'];
                $price = (float)$product['price'];

                // Product ID for this order
                $product_id = (int)$product['id'];


                /*
                |--------------------------------------------------------------------------
                | Check stock again before saving
                |--------------------------------------------------------------------------
                */

                $currentStock = product_stock($product_id);

                if ($currentStock < $quantity) {
                    throw new Exception(
                        'Not enough stock available for: ' . $medicine_name
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Insert into orders
                |--------------------------------------------------------------------------
                */

                $orderStmt->execute([
                    ':owner_name'     => $owner_name,
                    ':phone_number'   => $phone_number,
                    ':medicine_name'  => $medicine_name,
                    ':company_name'   => $company_name,
                    ':quantity'       => $quantity,
                    ':price'          => $price,
                    ':payment_method' => $payment_method,
                    ':payment_system' => $payment_system,
                    ':product_id'     => $product_id
                ]);


                $orderId = $pdo->lastInsertId();


                /*
                |--------------------------------------------------------------------------
                | Insert into order_items
                |--------------------------------------------------------------------------
                */

                $itemStmt->execute([
                    ':owner_name'     => $owner_name,
                    ':phone_number'   => $phone_number,
                    ':medicine_name'  => $medicine_name,
                    ':company_name'   => $company_name,
                    ':quantity'       => $quantity,
                    ':price'          => $price,
                    ':payment_method' => $payment_method,
                    ':payment_system' => $payment_system
                ]);


                /*
                |--------------------------------------------------------------------------
                | Reduce product stock
                |--------------------------------------------------------------------------
                */

                $stockStmt = $pdo->prepare("
                    UPDATE products
                    SET stock = stock - ?
                    WHERE id = ?
                      AND stock >= ?
                ");

                $stockStmt->execute([
                    $quantity,
                    $product_id,
                    $quantity
                ]);

                if ($stockStmt->rowCount() === 0) {
                    throw new Exception(
                        'Stock update failed for: ' . $medicine_name
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Everything successful
            |--------------------------------------------------------------------------
            */

            $pdo->commit();

            // Clear cart
            $_SESSION['cart'] = [];

            $success = true;

        }

        catch (Throwable $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $error = $e->getMessage();
        }
    }
}


$title = 'Checkout | Pharmasia';

include 'header.php';

?>


<section class="page-hero">

    <h1>Checkout</h1>

    <p>
        Complete your order information.
    </p>

</section>


<div
    class="checkout-container"
    style="
        max-width:900px;
        margin:40px auto;
        padding:20px;
    "
>


<?php if ($success): ?>


    <!-- SUCCESS -->

    <div
        style="
            background:#ecfdf5;
            border:1px solid #10b981;
            padding:25px;
            border-radius:12px;
            text-align:center;
        "
    >

        <h2 style="color:#047857;">
            ✅ Order Submitted Successfully
        </h2>

        <p>
            Your order has been submitted and is currently
            <b>Pending</b>.
        </p>

        <?php if ($orderId): ?>

            <p>
                Order ID:
                <strong>#<?= h($orderId) ?></strong>
            </p>

        <?php endif; ?>


        <a
            href="products.php"
            class="btn"
        >
            Continue Shopping
        </a>

    </div>


<?php else: ?>


    <?php if ($error): ?>

        <div
            style="
                background:#fef2f2;
                border:1px solid #ef4444;
                color:#b91c1c;
                padding:15px;
                border-radius:10px;
                margin-bottom:20px;
            "
        >

            ❌ <?= h($error) ?>

        </div>

    <?php endif; ?>


    <!-- ORDER SUMMARY -->

    <div
        style="
            background:#fff;
            padding:20px;
            border-radius:12px;
            margin-bottom:25px;
        "
    >

        <h2>Order Summary</h2>


        <?php foreach ($items as $item): ?>

            <div
                style="
                    display:flex;
                    justify-content:space-between;
                    gap:15px;
                    padding:15px 0;
                    border-bottom:1px solid #eee;
                "
            >

                <div>

                    <strong>
                        <?= h($item['name']) ?>
                    </strong>

                    <br>

                    <small>
                        Generic:
                        <?= h($item['generic_name'] ?? '') ?>
                    </small>

                    <br>

                    <small>
                        Quantity:
                        <?= (int)$item['quantity'] ?>
                    </small>

                </div>


                <div>

                    ৳<?= number_format(
                        (float)$item['subtotal'],
                        2
                    ) ?>

                </div>

            </div>

        <?php endforeach; ?>


        <h3
            style="
                text-align:right;
                margin-top:20px;
            "
        >

            Total:
            ৳<?= number_format($total, 2) ?>

        </h3>

    </div>


    <!-- CHECKOUT FORM -->

    <form
        method="post"
        style="
            background:#fff;
            padding:25px;
            border-radius:12px;
        "
    >

        <h2>Customer Information</h2>


        <label>
            Contact Person
        </label>

        <input
            type="text"
            name="owner_name"
            placeholder="Contact Person"
            required
            value="<?= h($_POST['owner_name'] ?? '') ?>"
            style="
                width:100%;
                padding:14px;
                margin:8px 0 18px;
                box-sizing:border-box;
            "
        >


        <label>
            Phone Number
        </label>

        <input
            type="text"
            name="phone_number"
            placeholder="Phone Number"
            required
            value="<?= h($_POST['phone_number'] ?? '') ?>"
            style="
                width:100%;
                padding:14px;
                margin:8px 0 18px;
                box-sizing:border-box;
            "
        >


        <label>
            Payment Method
        </label>

        <select
            name="payment_method"
            required
            style="
                width:100%;
                padding:14px;
                margin:8px 0 18px;
                box-sizing:border-box;
            "
        >

            <option value="">
                Select Payment Method
            </option>

            <option
                value="Cash on Delivery"
                <?= (
                    ($_POST['payment_method'] ?? '') ===
                    'Cash on Delivery'
                ) ? 'selected' : '' ?>
            >
                Cash on Delivery
            </option>

            <option
                value="Online Payment"
                <?= (
                    ($_POST['payment_method'] ?? '') ===
                    'Online Payment'
                ) ? 'selected' : '' ?>
            >
                Online Payment
            </option>

        </select>


        <label>
            Payment System
        </label>

        <select
            name="payment_system"
            style="
                width:100%;
                padding:14px;
                margin:8px 0 18px;
                box-sizing:border-box;
            "
        >

            <option value="">
                Select Payment System
            </option>

            <option
                value="bKash"
                <?= (
                    ($_POST['payment_system'] ?? '') === 'bKash'
                ) ? 'selected' : '' ?>
            >
                bKash
            </option>

            <option
                value="Nagad"
                <?= (
                    ($_POST['payment_system'] ?? '') === 'Nagad'
                ) ? 'selected' : '' ?>
            >
                Nagad
            </option>

            <option
                value="Rocket"
                <?= (
                    ($_POST['payment_system'] ?? '') === 'Rocket'
                ) ? 'selected' : '' ?>
            >
                Rocket
            </option>

            <option
                value="Bank"
                <?= (
                    ($_POST['payment_system'] ?? '') === 'Bank'
                ) ? 'selected' : '' ?>
            >
                Bank
            </option>

        </select>


        <div
            style="
                background:#f8fafc;
                padding:18px;
                border-radius:10px;
                margin:20px 0;
            "
        >

            <strong>
                Order Status:
            </strong>

            <span style="color:#d97706;">
                Pending
            </span>

            <br>

            <small>
                Your order will remain pending until it is
                confirmed by the admin.
            </small>

        </div>


        <button
            type="submit"
            class="btn"
            style="
                width:100%;
                padding:15px;
                cursor:pointer;
            "
        >

            Submit Order

        </button>


    </form>


<?php endif; ?>


</div>


<?php include 'footer.php'; ?>