// post-event.js - JavaScript for Habesha Events Post Event Page

document.addEventListener('DOMContentLoaded', function() {
    // Only run if on post-event page
    if (document.getElementById('post-event-form')) {
        // DOM Elements
        const form = document.getElementById('post-event-form');
        const steps = document.querySelectorAll('.form-step');
        const nextButtons = document.querySelectorAll('.btn-next');
        const prevButtons = document.querySelectorAll('.btn-prev');
        const progressFill = document.getElementById('progress-fill');
        const progressSteps = document.querySelectorAll('.progress-step');
        const charCount = document.getElementById('char-count');
        const descriptionTextarea = document.getElementById('event-description');
    const ticketTypeRadios = document.querySelectorAll('input[name="ticket_type"]');
        const paidTicketOptions = document.getElementById('paid-ticket-options');
        const freeTicketOptions = document.getElementById('free-ticket-options');
        const earlyBirdCheck = document.getElementById('early-bird-check');
        const earlyBirdDetails = document.getElementById('early-bird-details');
        const imageUploadArea = document.getElementById('image-upload-area');
        const imageInput = document.getElementById('event-image');
        const imagePreview = document.getElementById('image-preview');
        const summaryTitle = document.getElementById('summary-title');
        const summaryDate = document.getElementById('summary-date');
        const summaryLocation = document.getElementById('summary-location');
        const summaryTicketType = document.getElementById('summary-ticket-type');
        const submitButton = document.getElementById('submit-event');
        const successModal = document.getElementById('success-modal');
        const successModalClose = document.getElementById('success-modal-close');
        const closeSuccessModal = document.getElementById('close-success-modal');
        
        // State
        let currentStep = 1;
        const totalSteps = 5;
        let uploadedImage = null;
        
    // Initialize
    // Disable browser's native validation so optional URL/social fields don't block our custom submit flow
    if (form) form.noValidate = true;
    updateProgress();
    updateSummary();

        // Fetch CSRF token from server and populate hidden field
        (function fetchCsrf() {
            const csrfInput = document.getElementById('csrf-token');
            if (!csrfInput) return;
            fetch('post-event.php?action=token', { credentials: 'same-origin' })
                .then(r => r.json())
                .then(data => {
                    if (data && data.token) csrfInput.value = data.token;
                })
                .catch(() => {
                    // silent fail; form submission will fail with CSRF if token missing
                });
        })();
        
        // Event Listeners
        
        // Character count for description
        if (descriptionTextarea && charCount) {
            descriptionTextarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
        }
        
        
        // Ticket type toggle
        ticketTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'paid') {
                    if (paidTicketOptions) paidTicketOptions.style.display = 'block';
                    if (freeTicketOptions) freeTicketOptions.style.display = 'none';
                } else {
                    if (paidTicketOptions) paidTicketOptions.style.display = 'none';
                    if (freeTicketOptions) freeTicketOptions.style.display = 'block';
                }
                updateSummary();
            });
        });
        
        // Early bird toggle
        if (earlyBirdCheck && earlyBirdDetails) {
            earlyBirdCheck.addEventListener('change', function() {
                earlyBirdDetails.style.display = this.checked ? 'block' : 'none';
            });
        }
        
        // Image upload
        if (imageUploadArea && imageInput) {
            imageUploadArea.addEventListener('click', function() {
                imageInput.click();
            });
            
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 5 * 1024 * 1024) { // 5MB limit
                        showNotification('File size must be less than 5MB', 'error');
                        return;
                    }
                    
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        showNotification('Please upload a valid image file (JPG, PNG, GIF)', 'error');
                        return;
                    }
                    
                    uploadedImage = file;
                    displayImagePreview(file);
                }
            });
            
            // Drag and drop
            imageUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--accent-color)';
                this.style.backgroundColor = 'rgba(0, 184, 148, 0.1)';
            });
            
            imageUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = '#ddd';
                this.style.backgroundColor = '';
            });
            
            imageUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#ddd';
                this.style.backgroundColor = '';
                
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    if (file.size > 5 * 1024 * 1024) {
                        showNotification('File size must be less than 5MB', 'error');
                        return;
                    }
                    
                    uploadedImage = file;
                    displayImagePreview(file);
                    imageInput.files = e.dataTransfer.files;
                }
            });
        }
        
        // Form step navigation
        nextButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const nextStepId = this.getAttribute('data-next');
                goToStep(nextStepId);
            });
        });
        
        prevButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const prevStepId = this.getAttribute('data-prev');
                goToStep(prevStepId);
            });
        });
        
        // Form submission
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Validate all required fields
                if (!validateForm()) return;

                // Build FormData
                const fd = new FormData(form);

                // Ensure image included
                if (imageInput && imageInput.files && imageInput.files.length > 0) {
                    fd.set('event_image', imageInput.files[0]);
                }

                // Send to server
                submitButton.disabled = true;
                submitButton.textContent = 'Submitting...';

                try {
                    const res = await fetch('post-event.php', {
                        method: 'POST',
                        credentials: 'same-origin',
                        body: fd
                    });
                    const data = await res.json();
                    if (data && data.success) {
                        if (successModal) {
                            successModal.classList.add('active');
                            document.body.style.overflow = 'hidden';
                        }
                    } else {
                        showNotification((data && data.message) ? data.message : 'Submission failed', 'error');
                    }
                } catch (err) {
                    showNotification('Network error sending form', 'error');
                } finally {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Submit Event';
                }
            });
        }
        
        // Success modal close
        if (successModalClose) {
            successModalClose.addEventListener('click', function() {
                if (successModal) {
                    successModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        }
        
        if (closeSuccessModal) {
            closeSuccessModal.addEventListener('click', function() {
                if (successModal) {
                    successModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        }
        
        if (successModal) {
            successModal.addEventListener('click', function(e) {
                if (e.target === successModal) {
                    successModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        }
        
        // Update summary when form fields change
        const summaryFields = [
            'event-title', 'event-date', 'event-time', 
            'event-location'
        ];
        
        summaryFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                if (field.type === 'radio') {
                    // For radio buttons, add event listener to all with the same name
                    document.querySelectorAll(`input[name="${fieldName}"]`).forEach(radio => {
                        radio.addEventListener('change', updateSummary);
                    });
                } else {
                    field.addEventListener('input', updateSummary);
                    field.addEventListener('change', updateSummary);
                }
            }
        });
        
        // Functions
        function goToStep(stepId) {
            // Validate current step before proceeding
            if (stepId !== 'step-1' && !validateCurrentStep()) {
                return;
            }
            
            // Hide all steps
            steps.forEach(step => {
                step.classList.remove('active');
            });
            
            // Show target step
            const targetStep = document.getElementById(stepId);
            if (targetStep) {
                targetStep.classList.add('active');
                
                // Update current step
                currentStep = parseInt(stepId.split('-')[1]);
                updateProgress();
                
                // Update summary when reaching step 5
                if (currentStep === 5) {
                    updateSummary();
                }
                
                // Scroll to top of form
                targetStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        function updateProgress() {
            // Update progress bar
            const progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
            if (progressFill) {
                progressFill.style.width = `${progressPercentage}%`;
            }
            
            // Update step indicators
            progressSteps.forEach((step, index) => {
                if (index + 1 <= currentStep) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });
        }
        
        function displayImagePreview(file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.innerHTML = `
                    <img src="${e.target.result}" alt="Event preview">
                    <button class="remove-image" id="remove-image">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                imagePreview.style.display = 'block';
                
                // Add remove image functionality
                const removeButton = document.getElementById('remove-image');
                if (removeButton) {
                    removeButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        uploadedImage = null;
                        imagePreview.innerHTML = '';
                        imagePreview.style.display = 'none';
                        imageInput.value = '';
                    });
                }
            };
            
            reader.readAsDataURL(file);
        }
        
        function updateSummary() {
            // Event title
            const titleField = document.getElementById('event-title');
            if (titleField && summaryTitle) {
                summaryTitle.textContent = titleField.value || '-';
            }
            
            // Date and time
            const dateField = document.getElementById('event-date');
            const timeField = document.getElementById('event-time');
            if (dateField && timeField && summaryDate) {
                const date = dateField.value;
                const time = timeField.value;
                
                if (date && time) {
                    const formattedDate = new Date(date).toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    summaryDate.textContent = `${formattedDate} at ${formatTime(time)}`;
                } else if (date) {
                    const formattedDate = new Date(date).toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    summaryDate.textContent = formattedDate;
                } else {
                    summaryDate.textContent = '-';
                }
            }
            
            // Location
            const locationField = document.getElementById('event-location');
            if (locationField && summaryLocation) {
                summaryLocation.textContent = locationField.value || '-';
            }
            
            // Ticket type
            const selectedTicketType = document.querySelector('input[name="ticket_type"]:checked');
            if (selectedTicketType && summaryTicketType) {
                if (selectedTicketType.value === 'free') {
                    summaryTicketType.textContent = 'Free Event';
                } else {
                    const priceField = document.getElementById('ticket-price');
                    if (priceField && priceField.value) {
                        summaryTicketType.textContent = `Paid: ETB ${parseFloat(priceField.value).toFixed(2)} per ticket`;
                    } else {
                        summaryTicketType.textContent = 'Paid Event';
                    }
                }
            }
        }
        
        function formatTime(timeString) {
            if (!timeString) return '';
            
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const formattedHour = hour % 12 || 12;
            
            return `${formattedHour}:${minutes} ${ampm}`;
        }
        
        function validateCurrentStep() {
            const currentStepElement = document.querySelector('.form-step.active');
            const requiredFields = currentStepElement.querySelectorAll('[required]');
            
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    highlightError(field);
                } else {
                    removeErrorHighlight(field);
                    
                    // Additional validation for specific fields
                    if (field.id === 'event-description' && field.value.length < 150) {
                        isValid = false;
                        highlightError(field, 'Description must be at least 150 characters');
                    }
                    
                    if (field.type === 'email' && !isValidEmail(field.value)) {
                        isValid = false;
                        highlightError(field, 'Please enter a valid email address');
                    }
                    
                    if (field.id === 'ticket-quantity-form') {
                        const value = parseInt(field.value);
                        if (isNaN(value) || value < 1 || value > 10000) {
                            isValid = false;
                            highlightError(field, 'Please enter a valid number of tickets (1-10000)');
                        }
                    }
                    
                    if (field.id === 'organizer-phone') {
                        // Simple Ethiopian phone validation
                        const phoneRegex = /^(\+251|0)[79]\d{8}$/;
                        if (!phoneRegex.test(field.value.replace(/\s/g, ''))) {
                            isValid = false;
                            highlightError(field, 'Please enter a valid Ethiopian phone number');
                        }
                    }
                }
            });
            
            if (!isValid) {
                // Scroll to first error
                const firstError = currentStepElement.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                // Show error notification
                showNotification('Please fill in all required fields correctly', 'error');
            }
            
            return isValid;
        }
        
        function validateForm() {
            // Check all steps
            for (let i = 1; i <= totalSteps; i++) {
                const stepElement = document.getElementById(`step-${i}`);
                if (stepElement) {
                    const requiredFields = stepElement.querySelectorAll('[required]');
                    
                    for (const field of requiredFields) {
                        if (!field.value.trim()) {
                            // Go to step with error
                            goToStep(`step-${i}`);
                            highlightError(field);
                            return false;
                        }
                        
                        // Additional validation
                        if (field.id === 'event-description' && field.value.length < 150) {
                            goToStep(`step-${i}`);
                            highlightError(field, 'Description must be at least 150 characters');
                            return false;
                        }
                        
                        if (field.id === 'organizer-phone') {
                            const phoneRegex = /^(\+251|0)[79]\d{8}$/;
                            if (!phoneRegex.test(field.value.replace(/\s/g, ''))) {
                                goToStep(`step-${i}`);
                                highlightError(field, 'Please enter a valid Ethiopian phone number');
                                return false;
                            }
                        }
                    }
                }
            }
            
            // Special validation for step 5 (terms agreement)
            const termsCheckbox = document.getElementById('agree-terms');
            if (termsCheckbox && !termsCheckbox.checked) {
                goToStep('step-5');
                highlightError(termsCheckbox, 'You must agree to the terms and conditions');
                return false;
            }
            
            // Check if image is uploaded
            if (!uploadedImage) {
                goToStep('step-4');
                showNotification('Please upload an event image', 'error');
                return false;
            }
            
            return true;
        }
        
        function highlightError(field, message = 'This field is required') {
            const formGroup = field.closest('.form-group');
            if (formGroup) {
                formGroup.classList.add('error');
                
                // Remove any existing error message
                const existingError = formGroup.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
                
                // Add error message
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                errorMessage.textContent = message;
                errorMessage.style.color = '#E17055';
                errorMessage.style.fontSize = '0.9rem';
                errorMessage.style.marginTop = '5px';
                
                formGroup.appendChild(errorMessage);
                
                // Highlight field
                field.style.borderColor = '#E17055';
            }
        }
        
        function removeErrorHighlight(field) {
            const formGroup = field.closest('.form-group');
            if (formGroup) {
                formGroup.classList.remove('error');
                
                // Remove error message
                const errorMessage = formGroup.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
                
                // Reset field border
                field.style.borderColor = '';
            }
        }
    }
});