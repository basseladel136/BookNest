document.addEventListener("DOMContentLoaded", function () {
    // البحث في الكتب (جزءك القديم)
    const searchInput = document.getElementById("bookSearch");
    const bookItems = document.querySelectorAll(".book-item");
    const noResults = document.getElementById("no-results");

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const query = this.value.trim().toLowerCase();
            let anyVisible = false;

            bookItems.forEach((item) => {
                const title = item
                    .querySelector(".card-title")
                    .textContent.toLowerCase();
                const author = item
                    .querySelector(".card-text")
                    .textContent.toLowerCase();

                if (title.includes(query) || author.includes(query)) {
                    item.style.display = "";
                    anyVisible = true;
                } else {
                    item.style.display = "none";
                }
            });

            noResults.style.display = anyVisible ? "none" : "";
        });
    }

    // إظهار/إخفاء الباسورد
    document.querySelectorAll(".toggle-password").forEach(function (el) {
        el.addEventListener("click", function (e) {
            e.preventDefault(); // علشان ما يبوظش أي حاجة في الفورم

            const selector = this.getAttribute("toggle");
            const input = document.querySelector(selector);

            if (input) {
                if (input.type === "password") {
                    input.type = "text";
                    this.classList.remove("fa-eye");
                    this.classList.add("fa-eye-slash");
                } else {
                    input.type = "password";
                    this.classList.remove("fa-eye-slash");
                    this.classList.add("fa-eye");
                }
            }
        });
    });

    // دالة إظهار/إخفاء الباسورد
    function togglePassword() {
        var pw = document.getElementById("password");
        var icon = document.getElementById("toggleIcon");
        if (pw.type === "password") {
            pw.type = "text";
            icon.className = "bi bi-eye-slash";
        } else {
            pw.type = "password";
            icon.className = "bi bi-eye";
        }
    }

    // تعديل الكمية في الكارت
    document.querySelectorAll(".quantity-form").forEach((form) => {
        const quantityInput = form.querySelector(".quantity-input");
        const minusBtn = form.querySelector(".minus-btn");
        const plusBtn = form.querySelector(".plus-btn");

        minusBtn.addEventListener("click", () => {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                form.submit();
            }
        });

        plusBtn.addEventListener("click", () => {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
            form.submit();
        });
    });

    // تغيير نص زر الدفع بناءً على طريقة الدفع المختارة
    const paymentMethodInputs = document.querySelectorAll(
        'input[name="payment_method"]'
    );
    const visaCardDetails = document.getElementById("visa_card_details");
    const payButton = document.getElementById("pay-button");

    console.log(paymentMethodInputs);
    console.log(visaCardDetails);
    console.log(payButton);

    if (paymentMethodInputs.length > 0 && visaCardDetails && payButton) {
        paymentMethodInputs.forEach((radio) => {
            radio.addEventListener("change", (e) => {
                const selectedValue = e.target.value;
                console.log(selectedValue);

                if (selectedValue === "visa_card") {
                    visaCardDetails.style.display = "block";
                    payButton.textContent = "Pay with Visa";
                } else {
                    visaCardDetails.style.display = "none";
                    if (selectedValue === "paypal") {
                        payButton.textContent = "Pay with PayPal";
                    } else if (selectedValue === "cod") {
                        payButton.textContent = "Place Order";
                    }
                }
            });
        });
    } else {
        console.log("One or more elements not found");
    }
});
