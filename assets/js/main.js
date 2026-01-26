document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    hamburger.addEventListener('click', (e) => {
        e.stopPropagation();
        navLinks.classList.toggle('active');
    });
    document.addEventListener('click', (e) => {
        if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
            navLinks.classList.remove('active');
        }
    });


    const petfiltermenu = document.querySelector('.filter-menu');
    const petfilters = document.querySelector('.filters');
    petfiltermenu.addEventListener('click', (e) => {
        e.stopPropagation();
        petfilters.classList.toggle('active');
    })

    document.addEventListener('click', (e) => {
        if (!petfilters.contains(e.target)) {
            petfilters.classList.remove('active');
        }
    });


    const cards = document.querySelectorAll('.pet-card');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const pageIndicator = document.getElementById('pageIndicator');

    const itemsPerPage = 12;
    let currentPage = 1;

    const totalPages = Math.ceil(cards.length / itemsPerPage);

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        cards.forEach((card, index) => {
            if (index >= start && index < end) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        if (pageIndicator) {
            pageIndicator.textContent = `Page ${page} of ${totalPages}`;
        }

        if (prevBtn) prevBtn.disabled = (page === 1);
        if (nextBtn) nextBtn.disabled = (page === totalPages);
    }

    if (cards.length > 0 && prevBtn && nextBtn) {
        showPage(currentPage);

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
                document.querySelector('.pets-section').scrollIntoView({ behavior: 'smooth' });
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
                document.querySelector('.pets-section').scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
})