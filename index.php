<?php
session_start();
include "db.php"; // DB connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Property Payment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="index.css" />
  <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<!-- Your navbar and properties section remain the same -->
 <!-- Navbar --> <nav class="navbar navbar-expand-lg">
   <div class="container"> 
    <a class="navbar-brand" href="#">Property</a> 
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"> <span class="navbar-toggler-icon"></span> </button> 
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav"> 
      <ul class="navbar-nav"> <li class="nav-item"><a class="nav-link active" href="#">Home</a></li> 
      <li class="nav-item"><a class="nav-link" href="#">Properties</a></li> 
      <li class="nav-item"><a class="nav-link" href="#">Services</a></li> 
      <li class="nav-item"><a class="nav-link" href="#">About</a></li> 
      <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li> 
    </ul> 
  </div> 
</div> 
</nav> 
<!-- Hero Section --> 
 <section class="hero"> 
  <div class="hero-content"> 
    <h1>Easiest way to find your dream home</h1> 
    <form action="#" class="search-bar"> 
      <input type="text" placeholder="Your ZIP code or City. e.g. New York"> 
      <button type="submit">Search</button> 
    </form> 
  </div>
 </section>

<section class="properties py-5">
  <div class="container">
    <h2 class="fw-bold mb-4">Popular Properties</h2>
    <form id="propertyForm">
      <div class="row g-4">

        <div class="col-md-4">
          <div class="property-card shadow-sm p-2 text-center">
            <img src="images/img_5.jpg" class="img-fluid mb-2" />
            <p>5232 California Fake, Ave. 21BC</p>
            <input type="checkbox" name="properties[]" value='{"image":"images/img_5.jpg","address":"5232 California Fake, Ave. 21BC"}' /> Select
          </div>
        </div>

        <div class="col-md-4">
          <div class="property-card shadow-sm p-2 text-center">
            <img src="images/img_4.jpg" class="img-fluid mb-2" />
            <p>42 Park Street, LA</p>
            <input type="checkbox" name="properties[]" value='{"image":"images/img_4.jpg","address":"42 Park Street, LA"}' /> Select
          </div>
        </div>

        <div class="col-md-4">
          <div class="property-card shadow-sm p-2 text-center">
            <img src="images/img_8.jpg" class="img-fluid mb-2" />
            <p>75 Main Road, NY</p>
            <input type="checkbox" name="properties[]" value='{"image":"images/img_8.jpg","address":"75 Main Road, NY"}' /> Select
          </div>
        </div>

        <div class="col-md-4">
          <div class="property-card shadow-sm p-2 text-center">
            <img src="images/img_4.jpg" class="img-fluid mb-2" />
            <p>42 Park Street, LA</p>
            <input type="checkbox" name="properties[]" value='{"image":"images/img_4.jpg","address":"42 Park Street, LA"}' /> Select
          </div>
        </div>

        <div class="col-md-4">
          <div class="property-card shadow-sm p-2 text-center">
            <img src="images/img_8.jpg" class="img-fluid mb-2" />
            <p>75 Main Road, NY</p>
            <input type="checkbox" name="properties[]" value='{"image":"images/img_8.jpg","address":"75 Main Road, NY"}' /> Select
          </div>
        </div>

        <div class="col-md-4">
          <div class="property-card shadow-sm p-2 text-center">
            <img src="images/img_4.jpg" class="img-fluid mb-2" />
            <p>42 Park Street, LA</p>
            <input type="checkbox" name="properties[]" value='{"image":"images/img_4.jpg","address":"42 Park Street, LA"}' /> Select
          </div>
        </div>

        <div class="col-md-4">
          <div class="property-card shadow-sm p-2 text-center">
            <img src="images/img_8.jpg" class="img-fluid mb-2" />
            <p>75 Main Road, NY</p>
            <input type="checkbox" name="properties[]" value='{"image":"images/img_8.jpg","address":"75 Main Road, NY"}' /> Select
          </div>
        </div>

      </div>
      <div class="text-center mt-4">
        <button type="button" class="btn btn-primary" onclick="openPaymentForm()">Proceed to Payment</button>
      </div>
    </form>
  </div>
</section>


<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-4 rounded-4 shadow">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title fw-bold text-center w-100">PAYMENT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="paymentForm">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required />
          </div>

          <!-- Stripe Elements separate rows -->
          <div class="mb-3">
            <label class="form-label">Card Number</label>
            <div id="card-number" class="form-control"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Expiry Date</label>
            <div id="card-expiry" class="form-control"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">CVC</label>
            <div id="card-cvc" class="form-control"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">ZIP</label>
            <div id="card-zip" class="form-control"></div>
          </div>

          <div class="mb-3 text-end fw-bold">
            Total Amount: ₹<span id="totalAmount">0</span>
          </div>

          <input type="hidden" name="properties" id="selectedProperties" />

          <button id="submitBtn" type="submit" class="btn btn-success w-100">Pay Now</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>

<script>
const stripe = Stripe("pk_test_51SCJjjRrq2LqEckHWaxmLj5Rqm0G2SK4altIdQyZCGMa4VgyALTZPIGTxxV6o1O8isTTgHPWweOnjPjqMWKwodA700f5rOVAKK");
const elements = stripe.elements();
const style = { base: { fontSize: "16px", color: "#32325d", "::placeholder": { color: "#a0a0a0" } } };

const cardNumber = elements.create("cardNumber", { style });
cardNumber.mount("#card-number");

const cardExpiry = elements.create("cardExpiry", { style });
cardExpiry.mount("#card-expiry");

const cardCvc = elements.create("cardCvc", { style });
cardCvc.mount("#card-cvc");

const cardPostal = elements.create("postalCode", { style });
cardPostal.mount("#card-zip");

// Track downloaded images in localStorage
const downloadedImages = JSON.parse(localStorage.getItem("downloadedImages") || "[]");

function openPaymentForm() {
    const checkedBoxes = document.querySelectorAll('input[name="properties[]"]:checked');
    if (checkedBoxes.length === 0) return alert("Select at least one property.");

    const selectedProperties = [];
    let alreadyDownloaded = false;

    checkedBoxes.forEach(cb => {
        const prop = JSON.parse(cb.value);
        selectedProperties.push(prop);
        if (downloadedImages.includes(prop.image)) alreadyDownloaded = true;
    });

    if (alreadyDownloaded) {
        if (!confirm("Some images have already been downloaded. Do you want to pay again and download them?")) {
            return; // stop if user clicks No
        }
    }

    document.getElementById("selectedProperties").value = JSON.stringify(selectedProperties);

    const total = selectedProperties.length * 2; // ₹2 per image
    document.getElementById("totalAmount").textContent = total;

    const paymentModal = new bootstrap.Modal(document.getElementById("paymentModal"));
    paymentModal.show();
}

document.getElementById("paymentForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    const btn = document.getElementById("submitBtn");
    btn.disabled = true;

    const name = e.target.name.value;
    const email = e.target.email.value;
    const properties = e.target.properties.value;
    const selectedImages = JSON.parse(properties);
    const amount = selectedImages.length * 200; // amount in paisa

    try {
        const res = await fetch("create_checkout_session.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, email, amount })
        });
        const data = await res.json();

        if (data.error) { alert(data.error); btn.disabled = false; return; }

        const result = await stripe.confirmCardPayment(data.client_secret, {
            payment_method: {
                card: cardNumber,
                billing_details: { name, email }
            }
        });

        if (result.error) {
            alert(result.error.message);
            btn.disabled = false;
            return;
        }

        if (result.paymentIntent.status === "succeeded") {
            alert("Payment successful!");

            selectedImages.forEach((p, index) => {
                setTimeout(() => {
                    const a = document.createElement("a");
                    a.href = p.image;
                    a.download = p.address.replace(/\s/g, "_") + ".jpg";
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

                    // Mark as downloaded
                    if (!downloadedImages.includes(p.image)) {
                        downloadedImages.push(p.image);
                        localStorage.setItem("downloadedImages", JSON.stringify(downloadedImages));
                    }
                }, index * 500);
            });
        }
    } catch (err) {
        alert("Payment failed. Please try again.");
        console.error(err);
    }

    btn.disabled = false;
});
</script>





</body>
</html>




