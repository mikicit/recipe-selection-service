const registrationForm = document.querySelector('#registration-form');

if (registrationForm) {
    registrationForm.addEventListener('submit', (e) => {
        e.preventDefault();
        


        console.log('test');
    });

    registrationForm.addEventListener('input', (e) => {
        const target = e.target;
        
        if (target.name == 'firstname') {
            if (target.value.length < 2 || target.value.length > 50) {
                target.classList.add('is-invalid');
            } else {
                target.classList.remove('is-invalid');
            }
        }
    });
}