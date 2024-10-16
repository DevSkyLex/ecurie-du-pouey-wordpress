document.addEventListener('DOMContentLoaded', function () {
    console.log("JS from frontend child theme is on")
    const checkboxes = document.querySelectorAll('.race-filter');
    const horseCards = document.querySelectorAll('.card-wrapper');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const selectedRaces = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            horseCards.forEach(card => {
                const horseRace = card.getAttribute('data-race');
                if (selectedRaces.length === 0 || selectedRaces.includes(horseRace)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
