((window, document) => {
    'use strict';

    /**
     * Utility Functions
     */
    
    function debounce(func, delay) {
        let timeoutID ;

        return (...args) => {
            clearTimeout(timeoutID);
            timeoutID = setTimeout(() => {
                clearTimeout(timeoutID);
                func(...args);
            }, delay); 
        }
    }

    function isEmpty(obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }
    
        return true;
    }

    function deleteEmptyErrors(obj) {
        for (let prop in obj) {
            if (obj[prop].length === 0) {
                delete obj[prop];
            }
        }
    }


    /**
     * Validation Functions
     */

    function firstnameValidation(value, fields) {
        if (value.length < 2) {
            return 'Firstname must not be shorter than 2 characters.';
        }

        if (value.length > 50) {
            return 'Firstname must not be longer than 50 characters.';
        }

        if (!(value.match(/^[a-zA-Z]*$/))) {
            return 'Only letters allowed.';
        }

        return '';
    }

    function lastnameValidation(value, fields) {
        if (value.length < 2) {
            return 'Lastname must not be shorter than 2 characters.';
        }

        if (value.length > 50) {
            return 'Lastname must not be longer than 50 characters.';
        }

        if (!(value.match(/^[a-zA-Z]*$/))) {
            return 'Only letters allowed.';
        }

        return '';
    }

    function emailValidation(value, fields) {
        if (!(value.match(/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/))) {
            return 'Invalid email format.';
        }

        return '';
    }

    function passwordValidation(value, fields) {
        if (value.length < 8) {
            return 'Password must not be shorter than 8 characters.';
        }

        return '';
    }

    function passwordRepeatValidation(value, fields) {
        if (value !== fields['password'].elem.value) {
            return 'Passwords must match.';
        }

        return '';
    }

    function isEmailExists(email) {
        const url = window.location.href + '/checkemail';
        const xhr = new XMLHttpRequest();

        xhr.open('POST', url);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`email=${encodeURIComponent(email)}`);
        
        var result = false;

        xhr.addEventListener('load', function(e) {
            if (xhr.status !== 200) {
                result = false; // If there was some kind of error on the server, then skip the real-time check.
            }

            if (xhr.response) {
                result = true;
            }

            result = 'dfsa';
        }, false);

        xhr.addEventListener('error', function(e) {
            result = false;
        }, false);

        return result;
    }

    /**
     * Templates
     */

    function inputErrorTemplate($text) {
        return `<p class="input-error">${$text}</p>`;
    }

    function formErrorTemplate(text) {
        return `<div class="mb-m">
                    <p class="alert alert--error">${text}</p>
                </div>`;
    }


    /**
     * Setters
     */

    function setInputError(field, text) {
        field.insertAdjacentHTML('afterend', inputErrorTemplate(text));
        field.classList.add('is-invalid');
    }

    function unsetInputError(field) {
        const parent = field.parentNode;
        const errorMsg = parent.querySelector('.input-error');
        field.classList.remove('is-invalid');

        if (errorMsg) errorMsg.remove();
    }

    function setFormError(form, text) {
        form.insertAdjacentHTML('afterbegin', formErrorTemplate(text));
    }

    function unsetFormError(form) {
        const error = form.querySelector('.alert--error').parentNode;
        if (error) error.remove();
    }

    function unsetFormErrors(form) {
        const errorMessages = form.querySelectorAll('.input-error');
        const inputErrors = form.querySelectorAll('.is-invalid');

        for (let i = 0; i < errorMessages.length; i++) {
            errorMessages[i].remove();
        }

        for (let i = 0; i < inputErrors.length; i++) {
            inputErrors[i].classList.remove('is-invalid');
        }
    }
    

    /**
     * Forms
     */

    /**
     * login Form
     * 
     * Processing of the login form. Validation of fields when printing does not make sense in this case.
     */

    const loginForm = document.getElementById('login-form');

    if (loginForm) {
        loginForm.setAttribute('novalidate', 'true'); // if js is enabled, disable standard browser validation

        const email = document.getElementById('email');
        const password = document.getElementById('password');

        function submitHandler(e) {
            e.preventDefault();
            let formError = '';

            unsetFormError(loginForm);

            formError = (() => {
                let errorMessage = 'Enter the correct password and email.';

                if (emailValidation(email.value).length !== 0) {
                    return errorMessage;
                }

                if (password.value.length == 0) {
                    return errorMessage;
                }

                return '';
            })();

            if (formError.length !== 0) {
                setFormError(loginForm, formError);
            } else {
                this.submit();
            }
        }

        loginForm.addEventListener('submit', submitHandler, false);
    }


    /**
     * Registration Form
     * 
     * Processing of the registration form. Including validation during printing.
     */

    const registrationForm = document.getElementById('registration-form');

    if (registrationForm) {
        registrationForm.setAttribute('novalidate', 'true'); // if js is enabled, disable standard browser validation

        const inputs = {
            'firstname': {
                'callback': firstnameValidation,
                'elem': registrationForm.querySelector('#firstname'),
                'isValid': false
            },
            'lastname': {
                'callback': lastnameValidation,
                'elem': registrationForm.querySelector('#lastname'),
                'isValid': false
            },
            'email': {
                'callback': emailValidation,
                'elem': registrationForm.querySelector('#email'),
                'isValid': false
            },
            'password': {
                'callback': passwordValidation,
                'elem': registrationForm.querySelector('#password'),
                'isValid': false
            },
            'password-repeat': {
                'callback': passwordRepeatValidation,
                'elem': registrationForm.querySelector('#password-repeat'),
                'isValid': false
            }
        }

        // On submit
        function submitHandler(e) {
            e.preventDefault();
            let validationErrors = {};

            unsetFormErrors(registrationForm);

            // Validate
            for (let prop in inputs) {
                validationErrors[prop] = inputs[prop].callback(inputs[prop].elem.value, inputs);
            }

            // Removing Empty Errors
            deleteEmptyErrors(validationErrors);

            if (isEmpty(validationErrors)) {
                this.submit();
            } else {
                for (let prop in validationErrors) {
                    setInputError(inputs[prop].elem, validationErrors[prop]);
                }
            }
        }

        // On keyup
        function inputHandler(e) {
            const target = e.target;
            const message = inputs[target.id].callback(target.value, inputs);
            unsetInputError(target);

            if (message.length !== 0) {
                setInputError(target, message);
                inputs[target.id].isValid = false;
            } else {
                unsetInputError(target);
                inputs[target.id].isValid = true;
            }
        }

        // On blur
        function blurHandler(e) {
            const target = e.target;

            if (inputs[target.id].isValid) {
                const url = window.location.href + '/checkemail';
                const xhr = new XMLHttpRequest();

                xhr.open('POST', url);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send(`email=${encodeURIComponent(target.value)}`);

                xhr.addEventListener('load', function(e) {
                    unsetInputError(target);
                    if (xhr.response === 'true') {
                        setInputError(target, 'A user with this Email already exists.');
                    }
                }, false);

                xhr.addEventListener('error', function(e) {
                    unsetInputError(target);
                }, false);
            }
        }

        const debouncedInputHandler = debounce(inputHandler, 100);

        // Event Binding
        for (let prop in inputs) {
            inputs[prop].elem.addEventListener('input', debouncedInputHandler, false);
        }

        inputs['email'].elem.addEventListener('blur', blurHandler, false);
        registrationForm.addEventListener('submit', submitHandler, false);
    }


    /**
     * Review Form
     * 
     * Processing of the review form. Validation of fields when printing does not make sense in this case.
     */

    const formReview = document.getElementById('form-review');

    if (formReview) {
        formReview.setAttribute('novalidate', 'true'); // if js is enabled, disable standard browser validation
        
        const description = document.getElementById('form-comment-review');
        const rating = document.getElementsByName('rating');

        // On submit
        function submitHandler(e) {
            e.preventDefault();
            let validationErrors = {};

            unsetFormErrors(formReview);

            // Description Validate
            validationErrors.description = (() => {
                if (description.value.length < 2) {
                    return 'Review must not be shorter than 2 characters.';
                }
    
                if (description.value.length > 500) {
                    return 'Review must not be longer than 500 characters.';
                }

                return '';
            })();

            // Rating Validate
            validationErrors.rating = (() => {
                let checkedRadio = null;

                for (let i = 0; i < rating.length; i++) {
                    if (rating[i].checked) {
                        checkedRadio = rating[i];
                        break;
                    }
                }

                if (!checkedRadio) {
                    return 'Please select a rating.';
                }

                if (checkedRadio.value > 5 || checkedRadio.value < 1) {
                    return 'Rating must be between 1 and 5.';
                }

                return '';
            })();

            // Setting styles and creating elements
            if (validationErrors.description.length !== 0) {
                setInputError(description, validationErrors.description);
            }

            if (validationErrors.rating.length !== 0) {
                let parentNode = rating[0].parentNode.parentNode;
                parentNode.insertAdjacentHTML('afterend', inputErrorTemplate(validationErrors.rating));
            }

            // Removing Empty Errors
            deleteEmptyErrors(validationErrors);

            // If no
            if (isEmpty(validationErrors)) {
                this.submit();
            }
        }

        formReview.addEventListener('submit', submitHandler, false);
    }


    /**
     * Add Recipe Form
     * 
     * Processing of the add recipe form. Validation of fields when printing does not make sense in this case.
     */

    const addRecipeForm = document.getElementById('add-recipe-form');

    if (addRecipeForm) {    
        addRecipeForm.setAttribute('novalidate', 'true'); // if js is enabled, disable standard browser validation

        const title = document.getElementById('form-title');
        const description = document.getElementById('form-description');
        const ingredients = document.getElementsByName('ingredients[]');
        const categories = document.getElementsByName('categories[]');
        const imagesInput = document.getElementById('form-images');

        function submitHandler(e) {
            e.preventDefault();
            const images = imagesInput.files;
            let validationErrors = {};

            unsetFormErrors(addRecipeForm);

            // Title Validate
            validationErrors.title = (() => {
                if (title.value.length < 2) {
                    return 'Title must not be shorter than 2 characters.';
                }
    
                if (title.value.length > 500) {
                    return 'Title must not be longer than 500 characters.';
                }

                return '';
            })();

            // Description Validate
            validationErrors.description = (() => {
                if (description.value.length < 2) {
                    return 'Description must not be shorter than 2 characters.';
                }
    
                if (description.value.length > 10000) {
                    return 'Description must not be longer than 10 000 characters.';
                }

                return '';
            })();

            // Ingredients Validate
            validationErrors.ingredients = (() => {
                for (let i = 0; i < ingredients.length; i++) {
                    if (ingredients[i].checked) {
                        return '';
                    };
                 
                }

                return 'Please select at least one ingredient.';
            })();

            // Categories Validate
            validationErrors.categories = (() => {
                for (let i = 0; i < categories.length; i++) {
                    if (categories[i].checked) {
                        return '';
                    };
                 
                }
                
                return 'Please select at least one category.';
            })();

            // Images Validate
            validationErrors.images = (() => {
                if (images.length === 0) {
                    return 'Images are required.';
                }

                for (let i = 0; i < images.length; i++) {
                    if (images.item(i).type !== 'image/jpeg') {
                        return 'Unsupported image format. Only JPEG.';
                    }
                }

                for (let i = 0; i < images.length; i++) {
                    if (images.item(i).size > 5242880) {
                        return 'The image must not be larger than 5 megabytes.';
                    }
                }

                return '';
            })();

            // Setting styles and creating elements
            if (validationErrors.title.length !== 0) {
                setInputError(title, validationErrors.title);
            }

            if (validationErrors.description.length !== 0) {
                setInputError(description, validationErrors.description);
            }

            if (validationErrors.ingredients.length !== 0) {
                const parentNode = ingredients[0].parentNode.parentNode;
                parentNode.insertAdjacentHTML('afterend', inputErrorTemplate(validationErrors.ingredients));
            }

            if (validationErrors.categories.length !== 0) {
                const parentNode = categories[0].parentNode.parentNode;
                parentNode.insertAdjacentHTML('afterend', inputErrorTemplate(validationErrors.categories));
            }

            if (validationErrors.images.length !== 0) {
                setInputError(imagesInput, validationErrors.images);
            }

            // Removing Empty Errors
            deleteEmptyErrors(validationErrors);

            // If no
            if (isEmpty(validationErrors)) {
                this.submit();
            }
        }

        addRecipeForm.addEventListener('submit', submitHandler, false);
    }


})(window, document);