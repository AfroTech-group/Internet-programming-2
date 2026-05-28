// Contact Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            menuToggle.innerHTML = navMenu.classList.contains('active') ? 
                '<i class="fas fa-times"></i>' : 
                '<i class="fas fa-bars"></i>';
        });
    }
    
    // Theme toggle
    const themeToggle = document.getElementById('theme-toggle');
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-theme');
            const icon = themeToggle.querySelector('i');
            if (document.body.classList.contains('dark-theme')) {
                icon.className = 'fas fa-sun';
                localStorage.setItem('theme', 'dark');
            } else {
                icon.className = 'fas fa-moon';
                localStorage.setItem('theme', 'light');
            }
        });
        
        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-theme');
            const icon = themeToggle.querySelector('i');
            icon.className = 'fas fa-sun';
        }
    }
    
    // Contact form submission
    const contactForm = document.getElementById('main-contact-form');
    const successModal = document.getElementById('contact-success-modal');
    const closeModalBtn = document.getElementById('close-contact-modal');
    const modalCloseBtn = document.getElementById('contact-modal-close');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                name: document.getElementById('contact-name').value,
                email: document.getElementById('contact-email').value,
                subject: document.getElementById('contact-subject').value,
                message: document.getElementById('contact-message').value,
                purpose: document.getElementById('contact-purpose').value,
                newsletter: document.getElementById('newsletter-optin').checked
            };
            
            // Basic validation
            if (!formData.name || !formData.email || !formData.subject || !formData.message || !formData.purpose) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                alert('Please enter a valid email address.');
                return;
            }
            
            // In a real application, you would send this data to a server
            // For now, we'll simulate a successful submission
            console.log('Form submitted:', formData);
            
            // Show success modal
            if (successModal) {
                successModal.style.display = 'flex';
                
                // Reset form
                contactForm.reset();
                
                // Keep newsletter subscription checked if it was checked
                document.getElementById('newsletter-optin').checked = formData.newsletter;
            }
        });
    }
    
    // Modal close functionality
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            successModal.style.display = 'none';
        });
    }
    
    if (modalCloseBtn) {
        modalCloseBtn.addEventListener('click', function() {
            successModal.style.display = 'none';
        });
    }
    
    // Close modal when clicking outside
    if (successModal) {
        successModal.addEventListener('click', function(e) {
            if (e.target === successModal) {
                successModal.style.display = 'none';
            }
        });
    }
    
    // Form input validation styling
    const formInputs = document.querySelectorAll('#main-contact-form input, #main-contact-form select, #main-contact-form textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '#e0e0e0';
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#e0e0e0';
            }
        });
    });
    
    // Ethiopian-themed animations
    const contactCards = document.querySelectorAll('.contact-card');
    
    contactCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in-up');
    });
    
    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .dark-theme {
            --primary-color: #2ecc71;
            --primary-dark: #27ae60;
            --secondary-color: #3498db;
            --text-color: #f0f0f0;
            --text-light: #b0b0b0;
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --border-color: #333;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .dark-theme .map-placeholder {
            background-color: #2a2a2a;
            color: #b0b0b0;
        }
    `;
    document.head.appendChild(style);
    
    // Ethiopian date formatting helper
    function formatEthiopianDate(date) {
        const ethiopianMonths = [
            'Meskerem', 'Tikimt', 'Hidar', 'Tahesas', 'Tir', 'Yekatit',
            'Megabit', 'Miazia', 'Genbot', 'Sene', 'Hamle', 'Nehase', 'Pagume'
        ];
        
        // Simple conversion (for demo purposes)
        const ethiopianYear = date.getFullYear() - 8;
        const monthIndex = date.getMonth();
        const day = date.getDate();
        
        return `${day} ${ethiopianMonths[monthIndex]} ${ethiopianYear}`;
    }
    
    // Add Ethiopian date to footer
    const footerBottom = document.querySelector('.footer-bottom');
    if (footerBottom) {
        const today = new Date();
        const ethiopianDate = formatEthiopianDate(today);
        const dateSpan = document.createElement('span');
        dateSpan.textContent = ` | Today: ${ethiopianDate}`;
        dateSpan.style.marginLeft = '10px';
        dateSpan.style.fontSize = '0.9em';
        dateSpan.style.color = '#666';
        footerBottom.querySelector('p').appendChild(dateSpan);
    }
    
    // Ethiopian phone number formatting
    const phoneNumber = document.querySelector('.contact-card:nth-child(2) p:first-child');
    if (phoneNumber) {
        const originalText = phoneNumber.textContent;
        // Format as Ethiopian style
        phoneNumber.textContent = originalText.replace('+251 912 345 678', '+251 91 234 5678');
    }
    
    // Add Addis Ababa time display
    const businessHoursCard = document.querySelector('.contact-card:nth-child(4)');
    if (businessHoursCard) {
        const timePara = document.createElement('p');
        const now = new Date();
        const addisTime = now.toLocaleTimeString('en-US', {
            timeZone: 'Africa/Addis_Ababa',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
        timePara.textContent = `Current time in Addis: ${addisTime}`;
        timePara.style.fontSize = '0.9em';
        timePara.style.color = 'var(--primary-color)';
        timePara.style.fontWeight = '500';
        timePara.style.marginTop = '10px';
        businessHoursCard.appendChild(timePara);
    }
});