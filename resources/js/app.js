import "./bootstrap";

// Cart functions
window.updateCartCount = function () {
    fetch("/cart/count")
        .then((response) => response.json())
        .then((data) => {
            const cartCountElement = document.getElementById("cart-count");
            if (cartCountElement) {
                cartCountElement.textContent = data.count;
            }
        })
        .catch((error) => {
            console.error("Error updating cart count:", error);
        });
};

// Update cart count on page load if needed
document.addEventListener("DOMContentLoaded", function () {
    // Additional initialization can go here
});
