<?php

$title = 'Products | Pharmasia Ltd.';
include 'header.php';


$all = products();

$q = strtolower(trim($_GET['q'] ?? ''));
$cat = trim($_GET['category'] ?? '');

$filtered = [];


foreach ($all as $p) {

    $text = strtolower(
        ($p['name'] ?? '') . ' ' .
        ($p['generic_name'] ?? '') . ' ' .
        ($p['category'] ?? '') . ' ' .
        ($p['company'] ?? '')
    );


    $matchSearch =
        ($q === '') ||
        (strpos($text, $q) !== false);


    $matchCategory =
        ($cat === '') ||
        (($p['category'] ?? '') === $cat);


    if ($matchSearch && $matchCategory) {
        $filtered[] = $p;
    }
}

?>


<!-- =========================================
     PAGE HERO
========================================= -->

<section class="page-hero">

    <h1>
        Product Portfolio
    </h1>

    <p>
        Search medicines and add them to your order.
    </p>

</section>


<!-- =========================================
     SEARCH / FILTER
========================================= -->

<form
    class="filterbar"
    method="get">

    <input
        type="text"
        name="q"
        value="<?= h($_GET['q'] ?? '') ?>"
        placeholder="Search by medicine, generic, company or category">


    <select name="category">

        <option value="">
            All categories
        </option>


        <?php foreach (categories() as $c): ?>

            <option
                value="<?= h($c['name']) ?>"
                <?= $cat === $c['name'] ? 'selected' : '' ?>>

                <?= h($c['name']) ?>

            </option>

        <?php endforeach; ?>

    </select>


    <button
        type="submit"
        class="btn">

        Search

    </button>

</form>


<!-- =========================================
     PRODUCTS
========================================= -->

<section class="cards">

    <div class="product-grid">


        <?php if (empty($filtered)): ?>

            <p>
                No products found.
            </p>

        <?php endif; ?>


        <?php foreach ($filtered as $p): ?>

            <?php

            $stock = product_stock($p['id']);

            ?>


            <article class="product-card reveal">


                <!-- PRODUCT IMAGE -->

                <?php if (!empty($p['image_url'])): ?>

                    <img
                        src="<?= h($p['image_url']) ?>"
                        alt="<?= h($p['name']) ?>">

                <?php endif; ?>


                <div>


                    <!-- CATEGORY -->

                    <small>
                        <?= h($p['category'] ?? 'Medicine') ?>
                    </small>


                    <!-- MEDICINE NAME -->

                    <h3>
                        <?= h($p['name']) ?>
                    </h3>


                    <!-- COMPANY -->

                    <?php if (!empty($p['company'])): ?>

                        <p>

                            Company:

                            <strong>
                                <?= h($p['company']) ?>
                            </strong>

                        </p>

                    <?php endif; ?>


                    <!-- GENERIC / DOSAGE / STRENGTH -->

                    <p>

                        <?= h($p['generic_name'] ?? '') ?>

                        ·

                        <?= h($p['dosage_form'] ?? '') ?>

                        ·

                        <?= h($p['strength'] ?? '') ?>

                    </p>


                    <!-- PRICE -->

                    <?php if (isset($p['price'])): ?>

                        <span class="price">

                            ৳<?= number_format(
                                (float)$p['price'],
                                2
                            ) ?>

                        </span>

                    <?php endif; ?>


                    <!-- =================================
                         IN STOCK
                    ================================= -->

                    <?php if ($stock > 0): ?>


                        <p
                            style="
                                color:green;
                                font-weight:bold;
                            ">

                            ✅ In Stock

                            (<?= (int)$stock ?>)

                        </p>


                        <div class="row">


                            <!-- VIEW BUTTON -->

                            <a
                                class="btn ghost"
                                href="view.php?id=<?= (int)$p['id'] ?>">

                                View

                            </a>


                            <!-- ADD BUTTON -->

                            <a
                                class="btn"
                                href="cart.php?action=add&id=<?= (int)$p['id'] ?>">

                                Add

                            </a>


                        </div>


                    <!-- =================================
                         OUT OF STOCK
                    ================================= -->

                    <?php else: ?>


                        <p
                            style="
                                color:red;
                                font-weight:bold;
                            ">

                            ❌ Out of Stock

                        </p>


                        <div class="row">


                            <!-- VIEW BUTTON -->

                            <a
                                class="btn ghost"
                                href="view.php?id=<?= (int)$p['id'] ?>">

                                View

                            </a>


                            <!-- DISABLED ADD BUTTON -->

                            <button
                                class="btn"
                                type="button"
                                disabled
                                style="
                                    opacity:.6;
                                    cursor:not-allowed;
                                ">

                                Out of Stock

                            </button>


                        </div>


                    <?php endif; ?>


                </div>

            </article>


        <?php endforeach; ?>


    </div>

</section>


<?php include 'footer.php'; ?>