<?php

require_once __DIR__ . '/config/db.php';

$id = (int)($_GET['id'] ?? 0);

$p = product_find($id);

if (!$p) {
    http_response_code(404);

    $title = 'Product Not Found';

    include 'header.php';
    ?>

    <section class="page-hero">
        <h1>Product Not Found</h1>
        <p>The requested medicine could not be found.</p>

        <a href="products.php" class="btn">
            Back to Products
        </a>
    </section>

    <?php
    include 'footer.php';
    exit;
}


$title = h($p['name']) . ' | Medical Store Ltd.';

$stock = product_stock($p['id']);

$alternatives = alternative_products($p['id']);

include 'header.php';

?>


<style>

/* =========================================
   FULL PRODUCT VIEW
========================================= */

.product-view-page {
    min-height: calc(100vh - 120px);
    padding: 50px 5%;
    background: #f7f9fc;
}


/* Back Button */

.product-back {
    max-width: 1200px;
    margin: 0 auto 25px;
}

.product-back a {
    text-decoration: none;
}


/* Main Product Card */

.product-view-card {
    max-width: 1200px;
    margin: 0 auto;

    display: grid;
    grid-template-columns: 45% 55%;

    background: #ffffff;

    border-radius: 22px;

    overflow: hidden;

    box-shadow:
        0 15px 45px rgba(0,0,0,.08);
}


/* =========================================
   IMAGE AREA
========================================= */

.product-view-image {
    min-height: 550px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 45px;

    background: #f1f5f9;
}


.product-view-image img {
    width: 100%;
    max-width: 430px;
    height: 430px;

    object-fit: contain;

    border-radius: 18px;
}


.no-product-image {
    width: 100%;
    height: 400px;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #64748b;
    background: #e2e8f0;

    border-radius: 18px;
}


/* =========================================
   PRODUCT INFORMATION
========================================= */

.product-view-info {
    padding: 50px;
}


.product-category {
    display: inline-block;

    padding: 7px 14px;

    border-radius: 20px;

    background: #eef6ff;

    color: #2563eb;

    font-size: 13px;

    font-weight: 600;
}


.product-view-info h1 {
    margin: 15px 0 10px;

    font-size: 38px;

    line-height: 1.2;

    color: #111827;
}


.company-name {
    margin: 0 0 20px;

    color: #64748b;

    font-size: 15px;
}


.company-name strong {
    color: #111827;
}


/* Price */

.product-main-price {
    margin: 20px 0;

    font-size: 32px;

    font-weight: 800;

    color: #0f766e;
}


/* Description */

.product-description {
    color: #64748b;

    font-size: 16px;

    line-height: 1.7;

    margin-bottom: 30px;
}


/* =========================================
   SPECS
========================================= */

.product-specs {
    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 15px;

    margin-bottom: 30px;
}


.product-spec {
    padding: 16px;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    background: #fafafa;
}


.product-spec small {
    display: block;

    color: #64748b;

    margin-bottom: 5px;
}


.product-spec strong {
    color: #111827;

    font-size: 15px;
}


/* =========================================
   STOCK
========================================= */

.stock-box {
    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 18px 20px;

    margin-bottom: 22px;

    border-radius: 14px;
}


.stock-box.available {
    background: #ecfdf5;

    color: #047857;
}


.stock-box.unavailable {
    background: #fef2f2;

    color: #b91c1c;
}


.stock-number {
    font-weight: 800;
}


/* =========================================
   BUTTONS
========================================= */

.product-actions {
    display: flex;

    gap: 12px;

    flex-wrap: wrap;
}


.product-actions .btn {
    text-decoration: none;
}


/* =========================================
   ALTERNATIVE SECTION
========================================= */

.alternative-section {
    max-width: 1200px;

    margin: 45px auto 0;
}


.alternative-header {
    margin-bottom: 25px;
}


.alternative-header h2 {
    margin-bottom: 8px;

    color: #111827;
}


.alternative-header p {
    color: #64748b;
}


.alternative-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 20px;
}


.alternative-card {
    background: #ffffff;

    border-radius: 16px;

    overflow: hidden;

    border: 1px solid #e5e7eb;

    box-shadow:
        0 8px 25px rgba(0,0,0,.05);
}


.alternative-card img {
    width: 100%;

    height: 190px;

    object-fit: contain;

    background: #f8fafc;

    padding: 20px;
}


.alternative-card-body {
    padding: 20px;
}


.alternative-card-body small {
    color: #64748b;
}


.alternative-card-body h3 {
    margin: 8px 0;

    color: #111827;
}


.alternative-company {
    color: #64748b;

    font-size: 14px;
}


.alternative-price {
    margin: 10px 0;

    color: #0f766e;

    font-weight: 800;

    font-size: 18px;
}


.alternative-stock {
    color: #15803d;

    font-weight: 700;

    margin-bottom: 15px;
}


.no-alternative {
    background: #ffffff;

    padding: 30px;

    border-radius: 16px;

    text-align: center;

    color: #64748b;
}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 900px) {

    .product-view-card {
        grid-template-columns: 1fr;
    }


    .product-view-image {
        min-height: auto;
    }


    .product-view-info {
        padding: 30px;
    }


    .alternative-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}


@media (max-width: 600px) {

    .product-view-page {
        padding: 25px 15px;
    }


    .product-view-info {
        padding: 25px;
    }


    .product-view-info h1 {
        font-size: 28px;
    }


    .product-specs {
        grid-template-columns: 1fr;
    }


    .alternative-grid {
        grid-template-columns: 1fr;
    }


    .product-view-image img {
        height: 300px;
    }

}

</style>


<!-- =========================================
     PRODUCT VIEW PAGE
========================================= -->

<section class="product-view-page">


    <!-- Back -->

    <div class="product-back">

        <a
            href="products.php"
            class="btn ghost">

            ← Back to Products

        </a>

    </div>


    <!-- Main Product -->

    <div class="product-view-card">


        <!-- =====================================
             IMAGE
        ====================================== -->

        <div class="product-view-image">

            <?php if (!empty($p['image_url'])): ?>

                <img
                    src="<?= h($p['image_url']) ?>"
                    alt="<?= h($p['name']) ?>">

            <?php else: ?>

                <div class="no-product-image">

                    No Medicine Image Available

                </div>

            <?php endif; ?>

        </div>


        <!-- =====================================
             INFORMATION
        ====================================== -->

        <div class="product-view-info">


            <!-- Category -->

            <span class="product-category">

                <?= h($p['category'] ?? 'Medicine') ?>

            </span>


            <!-- Name -->

            <h1>

                <?= h($p['name']) ?>

            </h1>


            <!-- Company -->

            <?php if (!empty($p['company'])): ?>

                <p class="company-name">

                    Manufactured / Listed By:

                    <strong>
                        <?= h($p['company']) ?>
                    </strong>

                </p>

            <?php endif; ?>


            <!-- Price -->

            <?php if (isset($p['price'])): ?>

                <div class="product-main-price">

                    ৳<?= number_format(
                        (float)$p['price'],
                        2
                    ) ?>

                </div>

            <?php endif; ?>


            <!-- Description -->

            <?php if (!empty($p['description'])): ?>

                <p class="product-description">

                    <?= h($p['description']) ?>

                </p>

            <?php endif; ?>


            <!-- =================================
                 SPECIFICATIONS
            ================================== -->

            <div class="product-specs">


                <div class="product-spec">

                    <small>
                        Generic Name
                    </small>

                    <strong>
                        <?= h($p['generic_name'] ?? 'N/A') ?>
                    </strong>

                </div>


                <div class="product-spec">

                    <small>
                        Strength
                    </small>

                    <strong>
                        <?= h($p['strength'] ?? 'N/A') ?>
                    </strong>

                </div>


                <div class="product-spec">

                    <small>
                        Dosage Form
                    </small>

                    <strong>
                        <?= h($p['dosage_form'] ?? 'N/A') ?>
                    </strong>

                </div>


                <div class="product-spec">

                    <small>
                        Pack Size
                    </small>

                    <strong>
                        <?= h($p['pack_size'] ?? 'N/A') ?>
                    </strong>

                </div>


            </div>


            <!-- =================================
                 STOCK
            ================================== -->

            <?php if ($stock > 0): ?>


                <div class="stock-box available">

                    <span>
                        ✅ Available in Stock
                    </span>

                    <span class="stock-number">

                        <?= (int)$stock ?>

                    </span>

                </div>


                <!-- Actions -->

                <div class="product-actions">


                    <a
                        href="cart.php?action=add&id=<?= (int)$p['id'] ?>"
                        class="btn">

                        Add to Order Basket

                    </a>


                    <a
                        href="products.php"
                        class="btn ghost">

                        Back to Products

                    </a>


                </div>


            <?php else: ?>


                <!-- Out of stock -->

                <div class="stock-box unavailable">

                    <span>
                        ❌ Currently Out of Stock
                    </span>

                    <span class="stock-number">
                        0
                    </span>

                </div>


                <p class="product-description">

                    This product is currently unavailable.
                    Available alternative products are shown below.

                </p>


            <?php endif; ?>


        </div>

    </div>


    <!-- =========================================
         ALTERNATIVE PRODUCTS
    ========================================== -->

    <?php if ($stock <= 0): ?>

        <div class="alternative-section">


            <div class="alternative-header">

                <h2>
                    Available Alternative Medicines
                </h2>

                <p>

                    Other available products with the same
                    generic name are shown below.

                </p>

            </div>


            <?php if (!empty($alternatives)): ?>


                <div class="alternative-grid">


                    <?php foreach ($alternatives as $a): ?>


                        <article class="alternative-card">


                            <!-- Image -->

                            <?php if (!empty($a['image_url'])): ?>

                                <img
                                    src="<?= h($a['image_url']) ?>"
                                    alt="<?= h($a['name']) ?>">

                            <?php endif; ?>


                            <div class="alternative-card-body">


                                <small>

                                    <?= h(
                                        $a['category']
                                        ?? 'Medicine'
                                    ) ?>

                                </small>


                                <h3>

                                    <?= h($a['name']) ?>

                                </h3>


                                <?php if (!empty($a['company'])): ?>

                                    <p class="alternative-company">

                                        Company:

                                        <strong>
                                            <?= h($a['company']) ?>
                                        </strong>

                                    </p>

                                <?php endif; ?>


                                <p>

                                    <?= h($a['generic_name']) ?>

                                    ·

                                    <?= h($a['strength']) ?>

                                </p>


                                <?php if (isset($a['price'])): ?>

                                    <div class="alternative-price">

                                        ৳<?= number_format(
                                            (float)$a['price'],
                                            2
                                        ) ?>

                                    </div>

                                <?php endif; ?>


                                <?php if (isset($a['stock'])): ?>

                                    <div class="alternative-stock">

                                        ✅ Available:

                                        <?= (int)$a['stock'] ?>

                                    </div>

                                <?php endif; ?>


                                <div class="product-actions">


                                    <a
                                        href="view.php?id=<?= (int)$a['id'] ?>"
                                        class="btn ghost">

                                        View

                                    </a>


                                    <a
                                        href="cart.php?action=add&id=<?= (int)$a['id'] ?>"
                                        class="btn">

                                        Add

                                    </a>


                                </div>


                            </div>

                        </article>


                    <?php endforeach; ?>


                </div>


            <?php else: ?>


                <div class="no-alternative">

                    <h3>
                        No Alternative Available
                    </h3>

                    <p>

                        No currently available alternative
                        product was found for this medicine.

                    </p>


                    <a
                        href="products.php"
                        class="btn ghost">

                        Browse All Products

                    </a>

                </div>


            <?php endif; ?>


        </div>

    <?php endif; ?>


</section>


<?php include 'footer.php'; ?>