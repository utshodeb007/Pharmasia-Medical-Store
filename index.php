<?php

$title = 'Pharmasia Ltd. | Professional B2B Pharma Portal';

include 'header.php';

$cats = categories();

$items = array_slice(products(), 0, 6);

?>

<section class="hero">

```
<div class="hero-bg"></div>

<div class="hero-card reveal">

    <span>

        Trusted pharmaceutical supply

    </span>

    <h1>

        Healthcare products, ordered with confidence.

    </h1>

    <p>

        A clean digital ordering experience for licensed pharmacies,

        hospitals and distribution partners across Bangladesh.

    </p>

    <a href="products.php" class="btn">

        Explore Products

    </a>

</div>

<div class="hero-copy reveal">

    <h2>

        Pharmasia B2B Commerce

    </h2>

    <p>

        Built for responsible medicine distribution,

        verified customer onboarding,

        transparent order tracking and

        professional product presentation.

    </p>

</div>
```

</section>

<section class="split reveal">

```
<img

    src="https://images.unsplash.com/photo-1576671081837-49000212a370?auto=format&fit=crop&w=1200&q=80"

    alt="Pharma quality">

<div>

    <h2>

        Professional pharmaceutical ordering,

        not a casual medicine shop.

    </h2>

    <p>

        This platform is designed as a corporate B2B portal

        where authorized buyers can browse product presentations,

        request stock, submit orders and communicate with

        the sales team in a structured way.

    </p>

    <div class="chips">

        <span>Verified Buyers</span>

        <span>Order Tracking</span>

        <span>Sales Admin</span>

        <span>Mobile Ready</span>

    </div>

</div>
```

</section>

<section class="section-soft reveal">

```
<h2 class="center">

    Product Groups

</h2>

<p class="center muted">

    Organized by therapeutic category

    for fast professional discovery.

</p>

<div class="category-grid">

    <?php foreach($cats as $c): ?>

    <a

        href="products.php?category=<?= h($c['name']) ?>"

        class="category-card">

        <b>

            <?= h($c['name']) ?>

        </b>

        <span>

            View portfolio

        </span>

    </a>

    <?php endforeach; ?>

</div>
```

</section>

<section class="cards reveal">

```
<div class="section-title">

    <h2>

        Featured Presentations

    </h2>

    <a href="products.php">

        View all

    </a>

</div>

<div class="product-grid">

    <?php foreach($items as $p): ?>

    <article class="product-card">

        <img

            src="<?= h($p['image_url']) ?>"

            alt="<?= h($p['name']) ?>">

        <div>

            <small>

                <?= h($p['category']) ?>

            </small>

            <h3>

                <?= h($p['name']) ?>

            </h3>

            <p>

                <?= h($p['generic_name']) ?>

                ·

                <?= h($p['strength']) ?>

            </p>

            <a

                class="btn ghost"

                href="product-details.php?id=<?= (int)$p['id'] ?>">

                Details

            </a>

        </div>

    </article>

    <?php endforeach; ?>

</div>
```

</section>

<section class="steps reveal">

```
<h2>

    Order. Verify. Deliver.

</h2>

<div class="step-grid">

    <div>

        <b>

            Step 1

        </b>

        <h3>

            Register Pharmacy

        </h3>

        <p>

            Submit trade details and license information.

        </p>

    </div>

    <div>

        <b>

            Step 2

        </b>

        <h3>

            Build Order Basket

        </h3>

        <p>

            Select products and quantity based on stock need.

        </p>

    </div>

    <div>

        <b>

            Step 3

        </b>

        <h3>

            Sales Approval

        </h3>

        <p>

            Admin reviews the request

            and confirms availability.

        </p>

    </div>

    <div>

        <b>

            Step 4

        </b>

        <h3>

            Distribution Support

        </h3>

        <p>

            Delivery status and communication

            stay organized.

        </p>

    </div>

</div>
```

</section>

<?php

include 'footer.php';

?>
