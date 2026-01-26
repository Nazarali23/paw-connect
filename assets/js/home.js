document.addEventListener('DOMContentLoaded', () => {

    const track = document.querySelector('.pet-cards');
    const cards = track.children;
    let width = 0;

    for (let i = 0; i < cards.length / 2; i++) {
        width += cards[i].offsetWidth + 16;
    }

    track.style.setProperty('--loop-width', width + 'px');


    const roleChange = document.getElementById('role-change-text');
    const roleChangeBox = document.querySelector('.role-change');
    const infoForUsers = document.querySelector('.info-for-users');
    const infoForShelters = document.querySelector('.info-for-shelters');
    let a = true;
    roleChangeBox.addEventListener('click', () => {
        if (roleChange.classList.contains('active')) {
            roleChangeBox.style.paddingRight = '25px';
            roleChangeBox.style.backgroundColor = '#b45700';
            roleChange.textContent = 'For Shelters';
            roleChange.classList.remove('active');
            infoForUsers.classList.add('hidden');
            infoForShelters.classList.remove('hidden');

        } else {
            roleChange.textContent = 'For Users';
            roleChangeBox.style.paddingRight = '15px';
            roleChangeBox.style.backgroundColor = '#336604';
            roleChange.classList.add('active');
            infoForShelters.classList.add('hidden');
            infoForUsers.classList.remove('hidden');
        }
    });

});