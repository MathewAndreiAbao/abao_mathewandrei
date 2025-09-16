document.addEventListener('DOMContentLoaded', function() {
    // Select all elements with the Bootstrap alert class
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;

            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });
});