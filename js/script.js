document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#petitionForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // Empêcher la soumission classique du formulaire

            const name = form.querySelector('input[name="name"]').value.trim();
            const email = form.querySelector('input[name="email"]').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Validation des champs
            if (!name || !email || !emailRegex.test(email)) {
                document.getElementById('message').textContent = 'Nom ou email invalide.';
                return;
            }

            // Soumission classique sans AJAX
            form.submit(); // Soumet le formulaire de manière classique
        });
    }
});
