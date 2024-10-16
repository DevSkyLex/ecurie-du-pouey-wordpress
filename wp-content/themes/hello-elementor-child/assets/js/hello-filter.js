document.addEventListener('DOMContentLoaded', function () {
    // Get all filter inputs
    const raceFilters = document.querySelectorAll('.race-filter');
    const ageFilters = document.querySelectorAll('.age-filter');
    const sexFilters = document.querySelectorAll('.sex-filter');
    const hairFilters = document.querySelectorAll('.hair-filter');
    const lowerPrice = document.getElementById('lower');
    const upperPrice = document.getElementById('upper');
    const resultFilters = document.querySelectorAll('.result-filter');

    const  lowerSlider = document.querySelector('#lower');
    const  upperSlider = document.querySelector('#upper');

    // Get all horse cards
    const horseCards = document.querySelectorAll('.font-family-card');

    // Add event listeners to all filters
    const allCheckboxFilters = [
        ...raceFilters,
        ...ageFilters,
        ...sexFilters,
        ...hairFilters,
        ...resultFilters
    ];

    allCheckboxFilters.forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });

    // Add event listeners for price range
    if (lowerPrice && upperPrice) {
        lowerPrice.addEventListener('input', applyFilters);
        upperPrice.addEventListener('input', applyFilters);
    }

    function applyFilters() {
        // Get selected values for each filter type
        const selectedRaces = getSelectedValues(raceFilters);
        const selectedAges = getSelectedValues(ageFilters);
        const selectedSexes = getSelectedValues(sexFilters);
        const selectedColors = getSelectedValues(hairFilters);
        const selectedResults = getSelectedValues(resultFilters);

        // Get price range values if they exist
        const minPrice = lowerPrice ? parseFloat(lowerPrice.value) : null;
        const maxPrice = upperPrice ? parseFloat(upperPrice.value) : null;

        // Loop through each horse card
        horseCards.forEach(card => {
            let shouldShow = true;

            // Check race filter
            if (selectedRaces.length > 0) {
                const cardRace = card.dataset.race;
                if (!selectedRaces.includes(cardRace)) {
                    shouldShow = false;
                }
            }

            // Check age filter
            if (shouldShow && selectedAges.length > 0) {
                const cardAge = card.dataset.age;
                if (!selectedAges.includes(cardAge)) {
                    shouldShow = false;
                }
            }

            // Check sex filter
            if (shouldShow && selectedSexes.length > 0) {
                const cardSex = card.dataset.sex;
                if (!selectedSexes.includes(cardSex)) {
                    shouldShow = false;
                }
            }

            // Check hair color filter
            if (shouldShow && selectedColors.length > 0) {
                const cardColor = card.dataset.color;
                if (!selectedColors.includes(cardColor)) {
                    shouldShow = false;
                }
            }

            // Check price filter
            if (shouldShow && minPrice !== null && maxPrice !== null) {
                const cardPrice = parseFloat(card.dataset.price);
                if (cardPrice < minPrice || cardPrice > maxPrice) {
                    shouldShow = false;
                }
            }

            // Check results filter
            if (shouldShow && selectedResults.length > 0) {
                const cardResult = card.dataset.result;
                if (!selectedResults.includes(cardResult)) {
                    shouldShow = false;
                }
            }

            // Show or hide the card
            card.style.display = shouldShow ? 'block' : 'none';
        });
    }

    adaptHeaderHeight()

    if(lowerSlider &&  upperSlider) {
        showPricesOnRange(lowerSlider, upperSlider)
    }

});

function adaptHeaderHeight() {
    // Get the header element (adjust selector if needed)
    var header = document.querySelector('header'); // Change selector if your theme uses a different class or ID for the header
    console.log('adapt header')
    console.log(header)
    // Get the height of the header
    var headerHeight = header.offsetHeight;

    // Apply the height to your template (or log it for testing)
    console.log('Header height:', headerHeight);

    // Optionally, you can adjust the margin or padding of other elements based on the header height
    var mainCustomContent = document.querySelector('.main-custom-content'); // Change selector to match your main content area
    if (mainCustomContent) {
        mainCustomContent.style.marginTop = headerHeight + 'px';
    }
}
function showPricesOnRange(lowerSlider, upperSlider) {

    document.querySelector('#two').value=upperSlider.value;
    document.querySelector('#one').value=lowerSlider.value;

    let lowerVal = parseInt(lowerSlider.value);
    let upperVal = parseInt(upperSlider.value);

    upperSlider.oninput = function () {
        lowerVal = parseInt(lowerSlider.value);
        upperVal = parseInt(upperSlider.value);

        if (upperVal < lowerVal + 4) {
            lowerSlider.value = upperVal - 4;
            if (lowerVal === lowerSlider.min) {
                upperSlider.value = 4;
            }
        }
        document.querySelector('#two').value=this.value
    };

    lowerSlider.oninput = function () {
        lowerVal = parseInt(lowerSlider.value);
        upperVal = parseInt(upperSlider.value);
        if (lowerVal > upperVal - 4) {
            upperSlider.value = lowerVal + 4;
            if (upperVal === upperSlider.max) {
                lowerSlider.value = parseInt(upperSlider.max) - 4;
            }
        }
        document.querySelector('#one').value=this.value
    };
}

function getSelectedValues(filterElements) {
    return Array.from(filterElements)
        .filter(filter => filter.checked)
        .map(filter => filter.value);
}