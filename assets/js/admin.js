document.addEventListener('DOMContentLoaded', () => {

    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveProfileBtn');
    const profileForm = document.getElementById('profileForm');
    const profileInputs = profileForm ? profileForm.querySelectorAll('input, select') : [];

    if (editBtn && saveBtn && profileForm) {
        editBtn.addEventListener('click', (e) => {
            e.preventDefault();
            profileInputs.forEach(input => {
                input.disabled = false;
                input.style.border = "1px solid #e58e26";
            });
            saveBtn.style.display = 'inline-block';
            editBtn.style.display = 'none';
        });

        saveBtn.addEventListener('click', (e) => {
            let valid = true;
            profileInputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value.trim()) {
                    input.style.borderColor = 'red';
                    valid = false;
                } else {
                    input.style.borderColor = '';
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    }

    const menuItems = document.querySelectorAll('.nav-item');

    const sections = {
        'nav-dashboard': document.querySelector('.stats-row'),
        'nav-pets-list': document.querySelector('.pets-section'),
        'nav-requests': document.querySelector('.requests-section'),
        'nav-history': document.querySelector('.history-section'),
        'nav-settings': document.querySelector('.profile-settings'),
    };

    menuItems.forEach(item => {
        item.addEventListener('click', (e) => {
            if (item.id !== 'nav-logout') {
                e.preventDefault();

                menuItems.forEach(nav => nav.classList.remove('active'));
                item.classList.add('active');

                const targetId = item.id;

                for (const [key, section] of Object.entries(sections)) {
                    if (section) {
                        if (key === targetId) {
                            section.classList.remove('hidden');
                        } else {
                            section.classList.add('hidden');
                        }
                    }
                }
            }
        });
    });

    const logoutbutton = document.getElementById('nav-logout');
    if (logoutbutton) {
        logoutbutton.addEventListener('click', (e) => {
            e.preventDefault();
            const logoutanswer = confirm('Are you sure you want to logout?');
            if (logoutanswer) {
                window.location.href = '../includes/logout.php';
            }
        });
    }

    const tabGroups = document.querySelectorAll('.request-tabs');

    tabGroups.forEach(group => {
        const buttons = group.querySelectorAll('.tab-btn');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));

                btn.classList.add('active');

                const targetId = btn.getAttribute('data-target');
                const targetContent = document.getElementById(targetId);
                const parentSection = group.closest('section');

                const contents = parentSection.querySelectorAll('.request-tab-content');
                contents.forEach(content => content.classList.remove('active'));
                if (targetContent) {
                    targetContent.classList.add('active');
                }
            });
        });
    });

});