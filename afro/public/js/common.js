// common.js - Shared JavaScript for Habesha Events Website

document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // 1. COMMON FUNCTIONALITY (All Pages)
    // ============================================
    
    // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }
    
    // Close mobile menu when clicking on a link
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navMenu.classList.remove('active');
        });
    });
    
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
    
    // Newsletter form submission (present on all pages)
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    newsletterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            // In a real app, you would send this to a server
            showNotification(`Thank you for subscribing with ${email}!`, 'success');
            this.reset();
        });
    });
    
    // Show notification
    window.showNotification = function(message, type) {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notification-message');
        
        if (notification && notificationMessage) {
            notificationMessage.textContent = message;
            
            // Set color based on type
            if (type === 'error') {
                notification.style.backgroundColor = '#E17055';
            } else if (type === 'success') {
                notification.style.backgroundColor = '#00B894';
            } else {
                notification.style.backgroundColor = 'var(--accent-color)';
            }
            
            notification.classList.add('active');
            
            // Hide after 5 seconds
            setTimeout(() => {
                notification.classList.remove('active');
            }, 5000);
        } else {
            // Fallback to alert if notification element doesn't exist
            alert(message);
        }
    };
    
    // Email validation helper
    window.isValidEmail = function(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    };
    
    // Close modals when clicking outside
    const allModals = document.querySelectorAll('.modal');
    allModals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    });
});