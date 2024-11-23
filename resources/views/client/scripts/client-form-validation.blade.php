@push('scripts')
    <script>
        /**@type {boolean} */
        let isValid = true;

        /**
         * Show/hide error message based on input validity.
         *
         * @param {bool} nonValidInput
         * @param {HTMLInputElement} input
         * @param {HTMLSpanElement} errorSpan
         */
        const toggleErrorMessage = (nonValidInput, input, errorSpan) => {
            if (nonValidInput) {
                input.classList.add('error-border');
                if (input.getAttribute('name') === 'phone') {
                    errorSpan.textContent = 'Please enter a valid phone number (8-12 digits).';
                } else {
                    errorSpan.textContent = input.validationMessage;
                }
                isValid = false;
            } else {
                input.classList.remove('error-border');
                errorSpan.textContent = '';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('createClient');
            const formFields = ['first_name', 'last_name', 'email', 'phone', 'address'];

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                isValid = true;

                formFields.forEach(field => {
                    const input = document.getElementById(field);
                    const errorSpan = document.getElementById(`${field}_error`);

                    if (field === 'address' && input.value.length < 1) {
                        return;
                    }

                    if (field === 'phone' && document.getElementById('email').value.trim().length >
                        0) {
                        return;
                    } else if (field === 'phone') {
                        const phonePattern = /^[0-9]{8,12}$/;
                        toggleErrorMessage(!phonePattern.test(input.value), input, errorSpan);
                        return;
                    }

                    if (field === 'email' && document.getElementById('phone').value.trim().length >
                        0) {
                        return;
                    }

                    toggleErrorMessage(!input.checkValidity(), input, errorSpan);
                });

                if (isValid) {
                    form.submit();
                }
            });

            formFields.forEach(field => {
                const input = document.getElementById(field);
                input.addEventListener('input', () => {
                    const errorSpan = document.getElementById(`${field}_error`);
                    if (input.checkValidity()) {
                        if (field === 'email') {
                            document.getElementById('phone').classList.remove('error-border');
                            document.getElementById('phone_error').textContent = '';
                        } else if (field === 'phone') {
                            document.getElementById('email').classList.remove('error-border');
                            document.getElementById('email_error').textContent = '';
                        }
                        input.classList.remove('error-border');
                        errorSpan.textContent = '';
                    }
                });
            });
        });
    </script>
@endpush
