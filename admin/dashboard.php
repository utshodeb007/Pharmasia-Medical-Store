<?php

session_start();

require_once '../config/db.php';


/*
|--------------------------------------------------------------------------
| ADMIN LOGIN CHECK
|--------------------------------------------------------------------------
*/

if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| UPDATE ORDER STATUS
|--------------------------------------------------------------------------
|
| When an order is changed to "cancelled":
| - Get the order's product_id
| - Get the ordered quantity
| - Add that quantity back to products.stock
| - Then change the order status to cancelled
|
| Important:
| Stock is returned ONLY the first time the order becomes cancelled.
| This prevents stock from being added multiple times.
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['update_status'])
) {

    $orderId = (int)($_POST['order_id'] ?? 0);
    $newStatus = $_POST['order_status'] ?? '';

    $allowedStatuses = [
        'pending',
        'confirmed',
        'cancelled'
    ];


    if (
        $orderId > 0 &&
        in_array($newStatus, $allowedStatuses, true)
    ) {

        try {

            /*
            |--------------------------------------------------------------------------
            | Start database transaction
            |--------------------------------------------------------------------------
            */

            $pdo->beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | Get current order information
            |--------------------------------------------------------------------------
            */

            $orderStmt = $pdo->prepare("
                SELECT
                    id,
                    product_id,
                    quantity,
                    order_status
                FROM orders
                WHERE id = ?
                FOR UPDATE
            ");

            $orderStmt->execute([
                $orderId
            ]);

            $order = $orderStmt->fetch(PDO::FETCH_ASSOC);


            if (!$order) {

                throw new Exception(
                    'Order not found.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Current order status
            |--------------------------------------------------------------------------
            */

            $oldStatus = strtolower(
                $order['order_status'] ?? 'pending'
            );


            /*
            |--------------------------------------------------------------------------
            | RETURN STOCK WHEN ORDER IS CANCELLED
            |--------------------------------------------------------------------------
            |
            | Only return stock if:
            |
            | old status != cancelled
            | AND
            | new status == cancelled
            |
            | This prevents duplicate stock restoration.
            |--------------------------------------------------------------------------
            */

            if (
                $newStatus === 'cancelled'
                && $oldStatus !== 'cancelled'
            ) {

                $productId = (int)($order['product_id'] ?? 0);
                $quantity = (int)($order['quantity'] ?? 0);


                /*
                |--------------------------------------------------------------------------
                | Make sure product_id and quantity are valid
                |--------------------------------------------------------------------------
                */

                if (
                    $productId <= 0 ||
                    $quantity <= 0
                ) {

                    throw new Exception(
                        'Invalid product ID or quantity for this order.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Add cancelled quantity back to product stock
                |--------------------------------------------------------------------------
                */

                $stockStmt = $pdo->prepare("
                    UPDATE products
                    SET stock = stock + ?
                    WHERE id = ?
                ");

                $stockStmt->execute([
                    $quantity,
                    $productId
                ]);


                /*
                |--------------------------------------------------------------------------
                | Make sure product actually exists
                |--------------------------------------------------------------------------
                */

                if ($stockStmt->rowCount() === 0) {

                    throw new Exception(
                        'Product stock could not be restored.'
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Update order status
            |--------------------------------------------------------------------------
            */

            $statusStmt = $pdo->prepare("
                UPDATE orders
                SET order_status = ?
                WHERE id = ?
            ");

            $statusStmt->execute([
                $newStatus,
                $orderId
            ]);


            /*
            |--------------------------------------------------------------------------
            | Commit everything
            |--------------------------------------------------------------------------
            */

            $pdo->commit();

        }

        catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Rollback if anything goes wrong
            |--------------------------------------------------------------------------
            */

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            /*
            |--------------------------------------------------------------------------
            | Optional error message
            |--------------------------------------------------------------------------
            */

            // You can log this if needed.
            // For now, dashboard simply redirects.
        }
    }


    header('Location: dashboard.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| PRODUCTS
|--------------------------------------------------------------------------
*/

$items = products();


/*
|--------------------------------------------------------------------------
| PRODUCT STOCK COUNTS
|--------------------------------------------------------------------------
*/

$availableProducts = 0;
$outOfStockProducts = 0;

foreach ($items as $p) {

    $stock = product_stock(
        $p['id']
    );

    if ($stock > 0) {

        $availableProducts++;

    } else {

        $outOfStockProducts++;
    }
}


/*
|--------------------------------------------------------------------------
| RECENT ORDERS
|--------------------------------------------------------------------------
*/

$orders = [];

try {

    $orders = db_all(
        "SELECT
            id,
            product_id,
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
         FROM orders
         ORDER BY id DESC
         LIMIT 50"
    );

} catch (Exception $e) {

    $orders = [];
}


/*
|--------------------------------------------------------------------------
| ORDER COUNTS
|--------------------------------------------------------------------------
*/

$totalOrders = count($orders);

$pendingOrders = 0;
$confirmedOrders = 0;
$cancelledOrders = 0;

foreach ($orders as $order) {

    $status = strtolower(
        $order['order_status'] ?? 'pending'
    );


    if ($status === 'pending') {

        $pendingOrders++;

    }

    elseif ($status === 'confirmed') {

        $confirmedOrders++;

    }

    elseif ($status === 'cancelled') {

        $cancelledOrders++;
    }
}


?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width,initial-scale=1"
    >

    <title>
        Admin Dashboard
    </title>


    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >


    <style>

        .admin {
            padding: 30px;
        }


        .metric-grid {

            display: grid;

            grid-template-columns:
                repeat(5, 1fr);

            gap: 20px;

            margin-top: 25px;
        }


        .metric-card {

            padding: 25px;

            background: #ffffff;

            border-radius: 15px;

            box-shadow:
                0 8px 25px rgba(0,0,0,.06);

            border: 1px solid #e5e7eb;
        }


        .metric-card b {

            display: block;

            font-size: 30px;

            margin-bottom: 5px;
        }


        .metric-card span {

            color: #64748b;
        }


        .admin-table-wrapper {

            width: 100%;

            overflow-x: auto;
        }


        .admin-table {

            width: 100%;

            border-collapse: collapse;

            background: #ffffff;

            min-width: 1200px;
        }


        .admin-table th {

            background: #f1f5f9;

            font-weight: 700;
        }


        .admin-table th,
        .admin-table td {

            padding: 12px;

            border: 1px solid #e2e8f0;

            text-align: left;

            vertical-align: middle;
        }


        .admin-table tr:hover {

            background: #f8fafc;
        }


        .medicine-name {

            font-weight: 700;

            color: #111827;
        }


        .company-name {

            color: #64748b;

            font-size: 13px;
        }


        .quantity {

            font-weight: 700;
        }


        .status {

            display: inline-block;

            padding: 6px 10px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 700;
        }


        .status-pending {

            background: #fef3c7;

            color: #92400e;
        }


        .status-confirmed {

            background: #dcfce7;

            color: #166534;
        }


        .status-cancelled {

            background: #fee2e2;

            color: #991b1b;
        }


        .available-text {

            color: #15803d;

            font-weight: 700;
        }


        .out-stock-text {

            color: #dc2626;

            font-weight: 700;
        }


        .status-form {

            display: flex;

            gap: 6px;

            align-items: center;
        }


        .status-form select {

            padding: 7px;

            border: 1px solid #cbd5e1;

            border-radius: 6px;
        }


        .status-form button {

            padding: 7px 10px;

            border: 0;

            border-radius: 6px;

            cursor: pointer;
        }


        @media (max-width: 900px) {

            .metric-grid {

                grid-template-columns:
                    repeat(2, 1fr);
            }


            .admin {

                padding: 15px;
            }
        }


        @media (max-width: 500px) {

            .metric-grid {

                grid-template-columns: 1fr;
            }
        }

    </style>

</head>


<body>


<main class="admin">


    <h1>
        Medicine Store Admin Dashboard
    </h1>


    <!-- =====================================================
         DASHBOARD METRICS
    ====================================================== -->

    <div class="metric-grid">


        <div class="metric-card">

            <b>
                <?= count($items) ?>
            </b>

            <span>
                Total Products
            </span>

        </div>


        <div class="metric-card">

            <b>
                <?= $totalOrders ?>
            </b>

            <span>
                Recent Orders
            </span>

        </div>


        <div class="metric-card">

            <b>
                <?= $pendingOrders ?>
            </b>

            <span>
                Pending Orders
            </span>

        </div>


        <div class="metric-card">

            <b>
                <?= $confirmedOrders ?>
            </b>

            <span>
                Confirmed Orders
            </span>

        </div>


        <div class="metric-card">

            <b>
                <?= $cancelledOrders ?>
            </b>

            <span>
                Cancelled Orders
            </span>

        </div>


    </div>



    <!-- =====================================================
         RECENT ORDERS
    ====================================================== -->

    <h2 style="margin-top:40px;">

        Recent Orders

    </h2>


    <div class="admin-table-wrapper">


        <table class="admin-table">


            <thead>

            <tr>

                <th>
                    Order ID
                </th>

                <th>
                    Owner
                </th>

                <th>
                    Phone
                </th>

                <th>
                    Medicine
                </th>

                <th>
                    Company
                </th>

                <th>
                    Quantity
                </th>

                <th>
                    Price
                </th>

                <th>
                    Payment Method
                </th>

                <th>
                    Payment System
                </th>

                <th>
                    Order Status
                </th>

                <th>
                    Date
                </th>

                <th>
                    Action
                </th>

            </tr>

            </thead>


            <tbody>


            <?php if ($orders): ?>


                <?php foreach ($orders as $o): ?>


                    <?php

                    $status =
                        $o['order_status']
                        ?? 'pending';


                    $statusLower =
                        strtolower($status);


                    $statusClass =
                        'status-pending';


                    if (
                        $statusLower ===
                        'confirmed'
                    ) {

                        $statusClass =
                            'status-confirmed';

                    }

                    elseif (
                        $statusLower ===
                        'cancelled'
                    ) {

                        $statusClass =
                            'status-cancelled';
                    }

                    ?>


                    <tr>


                        <!-- Order ID -->

                        <td>

                            <strong>
                                #<?= (int)$o['id'] ?>
                            </strong>

                        </td>


                        <!-- Owner -->

                        <td>

                            <?= h(
                                $o['owner_name']
                            ) ?>

                        </td>


                        <!-- Phone -->

                        <td>

                            <?= h(
                                $o['phone_number']
                            ) ?>

                        </td>


                        <!-- Medicine -->

                        <td>

                            <div class="medicine-name">

                                <?= h(
                                    $o['medicine_name']
                                ) ?>

                            </div>

                        </td>


                        <!-- Company -->

                        <td>

                            <div class="company-name">

                                <?= h(
                                    $o['company_name']
                                ) ?>

                            </div>

                        </td>


                        <!-- Quantity -->

                        <td>

                            <span class="quantity">

                                <?= (int)
                                    $o['quantity']
                                ?>

                            </span>

                        </td>


                        <!-- Price -->

                        <td>

                            ৳<?= number_format(
                                (float)$o['price'],
                                2
                            ) ?>

                        </td>


                        <!-- Payment Method -->

                        <td>

                            <?= h(
                                $o['payment_method']
                            ) ?>

                        </td>


                        <!-- Payment System -->

                        <td>

                            <?= h(
                                $o['payment_system']
                                ?? 'N/A'
                            ) ?>

                        </td>


                        <!-- Order Status -->

                        <td>

                            <span
                                class="status
                                <?= $statusClass ?>"
                            >

                                <?= h($status) ?>

                            </span>

                        </td>


                        <!-- Date -->

                        <td>

                            <?= h(
                                $o['order_date']
                            ) ?>

                        </td>


                        <!-- Action -->

                        <td>


                            <form
                                method="post"
                                class="status-form"
                            >


                                <input
                                    type="hidden"
                                    name="order_id"
                                    value="<?= (int)$o['id'] ?>"
                                >


                                <select
                                    name="order_status"
                                >

                                    <option
                                        value="pending"
                                        <?= $statusLower === 'pending'
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        Pending
                                    </option>


                                    <option
                                        value="confirmed"
                                        <?= $statusLower === 'confirmed'
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        Confirmed
                                    </option>


                                    <option
                                        value="cancelled"
                                        <?= $statusLower === 'cancelled'
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        Cancelled
                                    </option>

                                </select>


                                <button
                                    type="submit"
                                    name="update_status"
                                >
                                    Update
                                </button>


                            </form>


                        </td>


                    </tr>


                <?php endforeach; ?>


            <?php else: ?>


                <tr>

                    <td
                        colspan="12"
                        style="
                            text-align:center;
                            padding:30px;
                        "
                    >

                        No orders found.

                    </td>

                </tr>


            <?php endif; ?>


            </tbody>


        </table>


    </div>



    <!-- =====================================================
         PRODUCTS
    ====================================================== -->

    <h2 style="margin-top:40px;">

        Products

    </h2>


    <div class="admin-table-wrapper">


        <table class="admin-table">


            <thead>

            <tr>

                <th>
                    Product
                </th>

                <th>
                    Generic
                </th>

                <th>
                    Company
                </th>

                <th>
                    Category
                </th>

                <th>
                    Price
                </th>

                <th>
                    Stock
                </th>

                <th>
                    Availability
                </th>

            </tr>

            </thead>


            <tbody>


            <?php foreach ($items as $p): ?>


                <?php

                $stock =
                    product_stock(
                        $p['id']
                    );

                ?>


                <tr>


                    <td>

                        <?= h(
                            $p['name']
                        ) ?>

                    </td>


                    <td>

                        <?= h(
                            $p['generic_name']
                        ) ?>

                    </td>


                    <td>

                        <?= h(
                            $p['company']
                            ?? 'N/A'
                        ) ?>

                    </td>


                    <td>

                        <?= h(
                            $p['category']
                        ) ?>

                    </td>


                    <td>

                        ৳<?= number_format(
                            (float)$p['price'],
                            2
                        ) ?>

                    </td>


                    <td>

                        <?= (int)$stock ?>

                    </td>


                    <td>


                        <?php if ($stock > 0): ?>

                            <span class="available-text">

                                ✅ Available

                            </span>

                        <?php else: ?>

                            <span class="out-stock-text">

                                ❌ Out of Stock

                            </span>

                        <?php endif; ?>


                    </td>


                </tr>


            <?php endforeach; ?>


            </tbody>


        </table>


    </div>



    <!-- =====================================================
         WEBSITE LINK
    ====================================================== -->

    <p style="margin-top:25px">

        <a
            class="btn"
            href="../index.php"
        >

            View Website

        </a>

    </p>


</main>


</body>

</html>