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
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

// Load books
function loadBooks() {
    axios.get("/api/admin/books").then((res) => {
        const tbody = document.querySelector("#booksTable tbody");
        tbody.innerHTML = "";
        res.data.forEach((book) => {
            tbody.innerHTML += `
                        <tr>
                            <td>${book.id}</td>
                            <td>${book.title}</td>
                            <td>${book.author}</td>
                            <td>${book.price}</td>
                            <td>${book.sale_price ?? "-"}</td>
                            <td>${book.description}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="editBook(${
                                    book.id
                                })">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteBook(${
                                    book.id
                                })">Delete</button>
                            </td>
                        </tr>
                    `;
        });
    });
}

loadBooks();

// Create / Update book
document.getElementById("bookForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const id = document.getElementById("book_id").value;
    const data = {
        title: document.getElementById("title").value,
        author: document.getElementById("author").value,
        price: document.getElementById("price").value,
        sale_price: document.getElementById("sale_price").value,
        description: document.getElementById("description").value,
    };

    if (id) {
        axios.put(`/api/admin/books/${id}`, data).then(() => {
            this.reset();
            document.getElementById("book_id").value = "";
            loadBooks();
        });
    } else {
        axios.post("/api/admin/books", data).then(() => {
            this.reset();
            loadBooks();
        });
    }
});

// Edit book
function editBook(id) {
    axios.get(`/api/admin/books/${id}`).then((res) => {
        const book = res.data;
        document.getElementById("book_id").value = book.id;
        document.getElementById("title").value = book.title;
        document.getElementById("author").value = book.author;
        document.getElementById("price").value = book.price;
        document.getElementById("sale_price").value = book.sale_price;
        document.getElementById("description").value = book.description;
    });
}

// Delete book
function deleteBook(id) {
    if (confirm("Are you sure?")) {
        axios.delete(`/api/admin/books/${id}`).then(() => loadBooks());
    }
}
// لما تدوس على أي genre-btn
document.querySelectorAll(".genre-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        const checkbox = this.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked; // عكس حالة الـ checkbox
        this.classList.toggle("genre-active");
        this.classList.toggle("genre-inactive");
    });
});
