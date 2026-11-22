```html
<!-- =========================
     ORDER REQUEST HEADER
========================= -->

<div class="order-header">

    <span class="section-label">
        PHARMASIA B2B ORDERING
    </span>

    <h1>
        Submit Order Request
    </h1>

    <p>
        Provide your verified buyer information.
        Our sales team will confirm availability,
        pricing and delivery details.
    </p>

</div>


<!-- =========================
     ORDER FORM
========================= -->

<div class="order-form-card">

    <div class="form-title">

        <div class="form-icon">
            +
        </div>

        <div>
            <h2>
                Buyer Information
            </h2>

            <p>
                Please provide accurate business details.
            </p>
        </div>

    </div>


    <div class="form-grid">

        <!-- Pharmacy -->

        <div class="form-group full">

            <label>
                Pharmacy / Institution Name
            </label>

            <input
                type="text"
                name="pharmacy"
                required
                placeholder="Enter pharmacy or institution name">

        </div>


        <!-- Contact Person -->

        <div class="form-group">

            <label>
                Contact Person
            </label>

            <input
                type="text"
                name="owner"
                required
                placeholder="Enter contact person">

        </div>


        <!-- Phone -->

        <div class="form-group">

            <label>
                Phone Number
            </label>

            <input
                type="tel"
                name="phone"
                required
                placeholder="Enter phone number">

        </div>


        <!-- License -->

        <div class="form-group full">

            <label>
                Drug License Number
            </label>

            <input
                type="text"
                name="license"
                required
                placeholder="Enter drug license number">

        </div>


        <!-- Address -->

        <div class="form-group full">

            <label>
                Delivery Address
            </label>

            <textarea
                name="address"
                required
                placeholder="Enter complete delivery address"
                rows="4"></textarea>

        </div>

    </div>


    <!-- Submit -->

    <div class="form-footer">

        <small>
            Your information will be used for
            order verification and sales communication.
        </small>

        <button
            type="submit"
            class="btn order-submit">

            Submit Request
            <span>→</span>

        </button>

    </div>

</div>
```

### Success Message HTML

```html
<!-- =========================
     ORDER SUCCESS
========================= -->

<div class="order-success">

    <div class="success-icon">
        ✓
    </div>

    <span class="section-label">
        REQUEST SUBMITTED
    </span>

    <h2>
        Order request received.
    </h2>

    <p>
        Your request has been successfully recorded
        and is now waiting for sales verification.
    </p>

    <a
        class="btn"
        href="products.php">

        Continue Browsing
        <span>→</span>

    </a>

</div>
```
