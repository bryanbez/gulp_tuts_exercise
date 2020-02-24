document.addEventListener('DOMContentLoaded', function(e) {

    let testimonialContactForm = document.getElementById('testimonial_contact_form');

    testimonialContactForm.addEventListener('submit', (e) => {

        e.preventDefault();

        resetInputMessages();

        let data = {

            name: testimonialContactForm.querySelector('[name="name"]').value,
            email: testimonialContactForm.querySelector('[name="email"]').value,
            message: testimonialContactForm.querySelector('[name="message"]').value,
            nonce: testimonialContactForm.querySelector('[name="nonce"]').value

        };


        if (!data.name) {

            testimonialContactForm.querySelector('[data-error="nameError"]').classList.add('show');
            return;

        }

        if (!validateEmail(data.email)) {

            testimonialContactForm.querySelector('[data-error="emailError"]').classList.add('show');
            return;

        }

        if (!data.message) {

            testimonialContactForm.querySelector('[data-error="messageError"]').classList.add('show');
            return;

        }

        // ajax http post

        let url = testimonialContactForm.dataset.url;
        let params = new URLSearchParams(new FormData(testimonialContactForm));

        testimonialContactForm.querySelector('.js-form-during-submission').classList.add('show');

        fetch(url, {

                method: "POST",
                body: params

            }).then(res => res.json())
            .catch(error => {
                resetInputMessages();
                testimonialContactForm.querySelector('.js-form-error').classList.add('show');
            }).then(response => {
                resetInputMessages();

                console.log(response.status);

                if (response.status == 404) {

                    testimonialContactForm.querySelector('.js-form-error').classList.add('show');
                    return;

                }

                testimonialContactForm.querySelector('.js-form-success').classList.add('show');
                testimonialContactForm.reset();

            });



    });


});

function resetInputMessages() {

    document.querySelectorAll('.field-msg').forEach(function(field) {

        field.classList.remove('show');

    });
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}