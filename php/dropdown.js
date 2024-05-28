document.addEventListener('DOMContentLoaded', function() {
    const dropdownIcon = document.getElementById('dropdown-icon');
    const dropdownMenu = document.getElementById('dropdown-menu');

    dropdownIcon.addEventListener('click', function() {
        dropdownMenu.classList.toggle('active');
    });

    document.addEventListener('click', function(event) {
        if (!dropdownIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('active');
        }
    });
});

    document.getElementById("paymentForm").addEventListener("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        fetch("upload.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                openPopup();
            } else {
                alert("Failed to upload proof of payment.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred. Please try again later.");
        });
    });

    function openPopup() {
        document.getElementById("popup").style.display = "block";
    }

    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }

