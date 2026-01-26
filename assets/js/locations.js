document.addEventListener('DOMContentLoaded', () => {
    const countrySelect = document.getElementById('country');
    const citySelect = document.getElementById('city');

    let allCountriesData = [];

    if (countrySelect && citySelect) {
        countrySelect.innerHTML = '<option value="">Loading countries...</option>';
        citySelect.disabled = true;
        fetch('https://countriesnow.space/api/v0.1/countries')
            .then(response => response.json())
            .then(data => {
                allCountriesData = data.data;
                countrySelect.innerHTML = '<option value="">Select Country</option>';
                allCountriesData.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.country;
                    option.textContent = item.country;
                    countrySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('API Hatası:', error);
                countrySelect.innerHTML = '<option value="">Error loading data</option>';
            });

        countrySelect.addEventListener('change', () => {
            const selectedCountryName = countrySelect.value;
            citySelect.innerHTML = '<option value="">Select City</option>';

            if (selectedCountryName) {
                const countryData = allCountriesData.find(item => item.country === selectedCountryName);
                if (countryData) {
                    citySelect.disabled = false;
                    countryData.cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        citySelect.appendChild(option);
                    });
                }
            } else {
                citySelect.disabled = true;
            }
        });
    }
});