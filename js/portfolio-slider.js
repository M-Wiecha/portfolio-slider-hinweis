document.addEventListener('DOMContentLoaded', function () {
    var notificationBar = document.getElementById('notification-bar');
    var closeButton = document.getElementById('close-notification');

    // Slider von oben anzeigen
    setTimeout(function () {
        if (notificationBar) {
            notificationBar.classList.add('active');
        }
    }, 1000);

    // Schließen-Button Funktionalität
    if (closeButton) {
        closeButton.addEventListener('click', function () {
            notificationBar.style.top = '-100px';
        });
    }
});