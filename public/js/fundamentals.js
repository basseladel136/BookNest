document.addEventListener("DOMContentLoaded", function () {
    console.log("fundamentals.js loaded");

    /* =======================
       1) فلترة الكتب محليًا (بدون Ajax)
       ======================= */
    const searchInput = document.getElementById("bookSearch");
    const bookItems = document.querySelectorAll(".book-item");
    const noResults = document.getElementById("no-results");

    if (searchInput && bookItems.length > 0) {
        searchInput.addEventListener("input", function () {
            const query = this.value.trim().toLowerCase();
            let anyVisible = false;

            bookItems.forEach((item) => {
                const titleEl = item.querySelector(".card-title");
                const authorEl = item.querySelector(".card-text");

                const title = titleEl ? titleEl.textContent.toLowerCase() : "";
                const author = authorEl
                    ? authorEl.textContent.toLowerCase()
                    : "";

                if (title.includes(query) || author.includes(query)) {
                    item.style.display = "";
                    anyVisible = true;
                } else {
                    item.style.display = "none";
                }
            });

            if (noResults) {
                noResults.style.display = anyVisible ? "none" : "";
            }
        });
    }

    /* =======================
       2) Live search بالـ Ajax
       ======================= */
    const liveSearchInput = document.getElementById("bookSearch");
    const booksContainer = document.getElementById("books-container");

    if (liveSearchInput && booksContainer) {
        let timer = null;

        liveSearchInput.addEventListener("keyup", function (e) {
            const q = e.target.value;

            clearTimeout(timer);

            timer = setTimeout(function () {
                fetch("/books/live-search?q=" + encodeURIComponent(q))
                    .then((res) => res.text())
                    .then((html) => {
                        booksContainer.innerHTML = html;
                    })
                    .catch((err) => console.error("Live search error:", err));
            }, 300);
        });
    }

    /* =======================
       3) إظهار/إخفاء الباسورد (الأيقونات بـ .toggle-password)
       ======================= */
    document.querySelectorAll(".toggle-password").forEach(function (el) {
        el.addEventListener("click", function (e) {
            e.preventDefault();

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

    // دالة togglePassword التقليدية (لو بتستخدمها في صفحة معينة)
    window.togglePassword = function () {
        const pw = document.getElementById("password");
        const icon = document.getElementById("toggleIcon");

        if (!pw || !icon) return;

        if (pw.type === "password") {
            pw.type = "text";
            icon.className = "bi bi-eye-slash";
        } else {
            pw.type = "password";
            icon.className = "bi bi-eye";
        }
    };

    /* =======================
       4) تعديل الكمية في الكارت
       ======================= */
    document.querySelectorAll(".quantity-form").forEach((form) => {
        const quantityInput = form.querySelector(".quantity-input");
        const minusBtn = form.querySelector(".minus-btn");
        const plusBtn = form.querySelector(".plus-btn");

        if (!quantityInput || !minusBtn || !plusBtn) return;

        minusBtn.addEventListener("click", () => {
            let currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                form.submit();
            }
        });

        plusBtn.addEventListener("click", () => {
            let currentValue = parseInt(quantityInput.value) || 1;
            quantityInput.value = currentValue + 1;
            form.submit();
        });
    });

    /* =======================
       5) تغيير نص زر الدفع حسب طريقة الدفع
       ======================= */
    const paymentMethodInputs = document.querySelectorAll(
        'input[name="payment_method"]'
    );
    const payButton = document.getElementById("pay-button");

    if (paymentMethodInputs.length > 0 && payButton) {
        paymentMethodInputs.forEach((radio) => {
            radio.addEventListener("change", (e) => {
                const selectedValue = e.target.value;

                if (selectedValue === "paypal") {
                    payButton.textContent = "Pay with PayPal";
                } else if (selectedValue === "cod") {
                    payButton.textContent = "Place Order";
                }
            });
        });

        payButton.addEventListener("click", function () {
            alert("Order placed successfully!");
        });
    } else {
        // ده طبيعي لو انت مش في صفحة الدفع، بس مش هنوقف السكربت
        console.log("Payment controls not found on this page (OK).");
    }
});
