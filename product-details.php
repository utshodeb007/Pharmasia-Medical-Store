<?php

$id = (int)($_GET['id'] ?? 0);

$p = product_find($id);

$title = ($p ? $p['name'] : 'Product') . ' | Medical Store Ltd.';

include 'header.php';


if (!$p) {

    echo '<section class="page-hero">
            <h1>Product not found</h1>
          </section>';

    include 'footer.php';

    exit;
}


$stock = product_stock($p['id']);


/*
 * Find available alternative products.
 * The function checks the same generic name
 * and prioritizes the same strength.
 */
$alternatives = alternative_products($p['id']);

?>

<section class="details reveal">

    <img
        src="<?= h($p['image_url']) ?>"
        alt="<?= h($p['name']) ?>">

    <div>

        <small>
            <?= h($p['category']) ?>
        </small>

        <h1>
            <?= h($p['name']) ?>
        </h1>

        <p class="lead">
            <?= h($p['description']) ?>
        </p>


        <div class="specs">

            <span>
                Generic:
                <b><?= h($p['generic_name']) ?></b>
            </span>

            <span>
                Strength:
                <b><?= h($p['strength']) ?></b>
            </span>

            <span>
                Dosage:
                <b><?= h($p['dosage_form']) ?></b>
            </span>

            <span>
                Pack:
                <b><?= h($p['pack_size']) ?></b>
            </span>

        </div>


        <?php if ($stock > 0): ?>

            <!-- Available -->

            <p style="color:green;font-weight:bold;">
                ✅ In Stock (<?= (int)$stock ?>)
            </p>

            <a
                class="btn"
                href="cart.php?action=add&id=<?= (int)$p['id'] ?>">
                Add to Order Basket
            </a>


        <?php else: ?>

            <!-- Out of Stock -->

            <div class="stock-alert">

                <p style="color:#dc2626;font-weight:bold;">
                    ❌ Currently Out of Stock
                </p>

                <p>
                    This product is currently unavailable.
                    Please review the available alternatives below.
                </p>

            </div>


            <button
                class="btn"
                type="button"
                disabled
                style="opacity:.6;cursor:not-allowed;">

                Out of Stock

            </button>


            <?php if (!empty($alternatives)): ?>

                <!-- Alternative Products -->

                <div
                    class="alternatives"
                    style="margin-top:30px;">

                    <h3>
                        Available Alternative Products
                    </h3>

                    <p>
                        The following products have the same
                        generic name and are currently available.
                        Please review their details before ordering.
                    </p>


                    <div class="product-grid">


                        <?php foreach ($alternatives as $a): ?>


                            <article class="product-card">


                                <?php if (!empty($a['image_url'])): ?>

                                    <img
                                        src="<?= h($a['image_url']) ?>"
                                        alt="<?= h($a['name']) ?>">

                                <?php endif; ?>


                                <div>

                                    <small>
                                        <?= h($a['category']) ?>
                                    </small>


                                    <h3>
                                        <?= h($a['name']) ?>
                                    </h3>


                                    <p>
                                        Generic:
                                        <b>
                                            <?= h($a['generic_name']) ?>
                                        </b>
                                    </p>


                                    <p>
                                        Strength:
                                        <b>
                                            <?= h($a['strength']) ?>
                                        </b>
                                    </p>


                                    <?php if (isset($a['stock'])): ?>

                                        <p style="color:green;font-weight:bold;">

                                            ✅ Available:
                                            <?= (int)$a['stock'] ?>

                                        </p>

                                    <?php endif; ?>


                                    <a
                                        class="btn ghost"
                                        href="product-details.php?id=<?= (int)$a['id'] ?>">

                                        View Alternative

                                    </a>

                                </div>


                            </article>


                        <?php endforeach; ?>


                    </div>

                </div>


            <?php else: ?>


                <!-- No Alternative -->

                <div
                    class="alternatives"
                    style="margin-top:30px;">

                    <h3>
                        No Alternative Product Available
                    </h3>

                    <p>
                        No currently available alternative
                        product was found for this item.
                    </p>


                    <a
                        class="btn ghost"
                        href="products.php">

                        Browse All Products

                    </a>

                </div>


            <?php endif; ?>


        <?php endif; ?>

    </div>

</section>


<?php include 'footer.php'; ?>