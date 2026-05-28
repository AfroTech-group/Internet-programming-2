// Support Page JavaScript - Habesha Events

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
    
    // FAQ functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    const categoryTabs = document.querySelectorAll('.category-tab');
    
    // FAQ accordion
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Close other answers in the same category
            const parentCategory = this.closest('.faq-category');
            const allQuestionsInCategory = parentCategory.querySelectorAll('.faq-question');
            
            allQuestionsInCategory.forEach(q => {
                if (q !== this) {
                    q.classList.remove('active');
                    q.nextElementSibling.classList.remove('active');
                }
            });
            
            // Toggle current answer
            this.classList.toggle('active');
            answer.classList.toggle('active');
            
            if (answer.classList.contains('active')) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
            } else {
                answer.style.maxHeight = '0';
            }
        });
    });
    
    // Category tabs
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update active tab
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Show selected category
            const allCategories = document.querySelectorAll('.faq-category');
            allCategories.forEach(cat => {
                cat.classList.remove('active');
                if (cat.id === `${category}-faq`) {
                    cat.classList.add('active');
                }
            });
            
            // Close all FAQ answers when switching categories
            const allAnswers = document.querySelectorAll('.faq-answer');
            const allQuestions = document.querySelectorAll('.faq-question');
            allAnswers.forEach(answer => {
                answer.classList.remove('active');
                answer.style.maxHeight = '0';
            });
            allQuestions.forEach(question => question.classList.remove('active'));
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('support-search-input');
    const searchBtn = document.getElementById('search-btn');
    
    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            performSearch();
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
    }
    
    function performSearch() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        
        if (!searchTerm) {
            alert('Please enter a search term');
            return;
        }
        
        // Search through FAQ questions and answers
        const allQuestions = document.querySelectorAll('.faq-question');
        const allAnswers = document.querySelectorAll('.faq-answer');
        let foundResults = false;
        
        // Reset all highlights
        allQuestions.forEach(q => q.classList.remove('highlight'));
        allAnswers.forEach(a => a.classList.remove('highlight'));
        
        // Search and highlight
        allQuestions.forEach((question, index) => {
            const questionText = question.textContent.toLowerCase();
            const answerText = allAnswers[index].textContent.toLowerCase();
            
            if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                // Show the category
                const category = question.closest('.faq-category');
                const categoryId = category.id.replace('-faq', '');
                
                // Activate the correct tab
                const tabToActivate = document.querySelector(`[data-category="${categoryId}"]`);
                if (tabToActivate) {
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    tabToActivate.classList.add('active');
                    
                    // Show the category
                    const allCategories = document.querySelectorAll('.faq-category');
                    allCategories.forEach(cat => cat.classList.remove('active'));
                    category.classList.add('active');
                }
                
                // Highlight the question
                question.classList.add('highlight');
                question.scrollIntoView({ behavior: 'smooth', block: 'center' });
                foundResults = true;
            }
        });
        
        if (!foundResults) {
            alert('No results found for: ' + searchTerm);
        }
    }
    
    // Support contact form
    const supportForm = document.getElementById('support-contact-form');
    const fileUploadInput = document.getElementById('file-upload-input');
    const fileList = document.getElementById('file-list');
    
    if (supportForm) {
        supportForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                name: document.getElementById('support-name').value,
                email: document.getElementById('support-email').value,
                phone: document.getElementById('support-phone').value,
                category: document.getElementById('support-category').value,
                subject: document.getElementById('support-subject').value,
                message: document.getElementById('support-message').value,
                files: Array.from(fileUploadInput.files).map(file => file.name)
            };
            
            // Basic validation
            if (!formData.name || !formData.email || !formData.category || !formData.subject || !formData.message) {
                alert('Please fill in all required fields marked with *');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(formData.email)) {
                alert('Please enter a valid email address.');
                return;
            }
            
            // Phone validation (if provided)
            if (formData.phone && !/^\+251\d{9}$/.test(formData.phone.replace(/\s/g, ''))) {
                alert('Please enter a valid Ethiopian phone number starting with +251');
                return;
            }
            
            // Simulate form submission
            console.log('Support form submitted:', formData);
            
            // Show success message
            alert('Thank you for contacting Habesha Events support! We will respond within 24 hours.');
            
            // Reset form
            supportForm.reset();
            fileList.innerHTML = '';
        });
    }
    
    // File upload handling
    if (fileUploadInput && fileList) {
        fileUploadInput.addEventListener('change', function() {
            fileList.innerHTML = '';
            const files = Array.from(this.files);
            
            if (files.length > 3) {
                alert('Maximum 3 files allowed');
                this.value = '';
                return;
            }
            
            files.forEach((file, index) => {
                if (file.size > 10 * 1024 * 1024) { // 10MB limit
                    alert(`File "${file.name}" exceeds 10MB limit`);
                    return;
                }
                
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <span>${index + 1}. ${file.name} (${formatFileSize(file.size)})</span>
                    <button type="button" class="remove-file" data-index="${index}">&times;</button>
                `;
                fileList.appendChild(fileItem);
            });
            
            // Add remove file functionality
            document.querySelectorAll('.remove-file').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    removeFile(index);
                });
            });
        });
    }
    
    function removeFile(index) {
        const dt = new DataTransfer();
        const files = Array.from(fileUploadInput.files);
        
        files.forEach((file, i) => {
            if (i !== index) {
                dt.items.add(file);
            }
        });
        
        fileUploadInput.files = dt.files;
        fileUploadInput.dispatchEvent(new Event('change'));
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Live chat functionality
    const chatIcon = document.getElementById('chat-icon');
    const chatWidget = document.getElementById('chat-widget');
    const chatToggle = document.getElementById('chat-toggle');
    const chatInput = document.getElementById('chat-input');
    const sendMessageBtn = document.getElementById('send-message');
    const chatMessages = document.getElementById('chat-messages');
    
    if (chatIcon && chatWidget) {
        chatIcon.addEventListener('click', function() {
            chatWidget.classList.add('active');
            this.style.display = 'none';
        });
        
        chatToggle.addEventListener('click', function() {
            chatWidget.classList.remove('active');
            chatIcon.style.display = 'flex';
        });
    }
    
    if (sendMessageBtn && chatInput) {
        sendMessageBtn.addEventListener('click', sendChatMessage);
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendChatMessage();
            }
        });
    }
    
    function sendChatMessage() {
        const message = chatInput.value.trim();
        if (!message) return;
        
        // Add user message
        addChatMessage(message, 'user');
        chatInput.value = '';
        
        // Simulate bot response after delay
        setTimeout(() => {
            const botResponse = getBotResponse(message);
            addChatMessage(botResponse, 'bot');
        }, 1000);
    }
    
    function addChatMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}`;
        
        const now = new Date();
        const timeString = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        messageDiv.innerHTML = `
            <div class="message-content">
                <p>${text}</p>
            </div>
            <div class="message-time">${timeString}</div>
        `;
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    function getBotResponse(userMessage) {
        const message = userMessage.toLowerCase();
        
        // Ethiopian greeting responses
        if (message.includes('selam') || message.includes('salam')) {
            return 'Selam! Amesegenalehu! How can I help you today?';
        }
        
        if (message.includes('ticket') || message.includes('tickets')) {
            return 'For ticket purchases, please visit our Events page. You can pay using mobile banking, credit card, or other local payment methods.';
        }
        
        if (message.includes('event') && message.includes('post')) {
            return 'To post an event, click on "Post Event" in the navigation menu. You can create listings in Amharic or English.';
        }
        
        if (message.includes('refund')) {
            return 'Refund policies are set by event organizers. Please check the specific event page for refund details. For urgent refund requests, contact support@habeshaevents.com';
        }
        
        if (message.includes('choke') || message.includes('music fest')) {
            return 'Choke Music Fest is one of Ethiopia\'s largest music festivals. Tickets are available on our platform. Visit the Events page for details.';
        }
        
        if (message.includes('shega')) {
            return 'Shega Events organizes various cultural and entertainment events across Ethiopia. Check their upcoming events on our platform.';
        }
        
        if (message.includes('ethiopian') || message.includes('habesha')) {
            return 'Habesha Events features Ethiopian cultural events, music festivals, traditional ceremonies, and more from across Ethiopia.';
        }
        
        // Default responses
        const responses = [
            'I understand. Can you provide more details about your issue?',
            'Our support team can help with that. Would you like me to connect you?',
            'For detailed assistance, please email support@habeshaevents.com or call +251 91 234 5678',
            'Thank you for your question. Let me find the best solution for you.',
            'I recommend checking our FAQ section for quick answers to common questions.'
        ];
        
        return responses[Math.floor(Math.random() * responses.length)];
    }
    
    // Newsletter subscription
    const newsletterForm = document.getElementById('footer-newsletter');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            if (!email) {
                alert('Please enter your email address');
                return;
            }
            
            // Simulate subscription
            console.log('Newsletter subscription:', email);
            alert('Thank you for subscribing to Habesha Events newsletter! You will receive updates on upcoming Ethiopian events.');
            this.reset();
        });
    }
    
    // Ethiopian-themed animations and features
    function addEthiopianFeatures() {
        // Add Ethiopian flag colors to loading animation
        const style = document.createElement('style');
        style.textContent = `
            .highlight {
                background-color: rgba(46, 204, 113, 0.2);
                border-left: 4px solid var(--primary-color);
            }
            
            .file-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 12px;
                background: #f0f0f0;
                border-radius: 4px;
                margin-bottom: 5px;
                font-size: 14px;
            }
            
            .remove-file {
                background: none;
                border: none;
                color: #e74c3c;
                font-size: 20px;
                cursor: pointer;
                line-height: 1;
            }
            
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
            
            .chat-icon.new-message {
                animation: pulse 2s infinite;
                background: linear-gradient(135deg, #2ecc71, #3498db);
            }
            
            /* Ethiopian flag colors for special elements */
            .ethiopian-theme {
                background: linear-gradient(to right, #da121a 33%, #fcdd09 33%, #fcdd09 66%, #078930 66%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-weight: bold;
            }
        `;
        document.head.appendChild(style);
        
        // Add Ethiopian date to page
        const today = new Date();
        const ethiopianDate = convertToEthiopianDate(today);
        
        const dateDisplay = document.createElement('div');
        dateDisplay.className = 'ethiopian-date';
        dateDisplay.style.cssText = `
            text-align: center;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 5px;
            margin: 20px auto;
            max-width: 300px;
            font-size: 14px;
            color: #666;
        `;
       
        
        
        
        // Add animation to option cards
        const optionCards = document.querySelectorAll('.option-card');
        optionCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in-up');
        });
    }
    
    function convertToEthiopianDate(gregorianDate) {
        // Simple conversion for demo purposes
        const ethiopianMonths = [
            'Meskerem', 'Tikimt', 'Hidar', 'Tahesas', 'Tir', 'Yekatit',
            'Megabit', 'Miazia', 'Genbot', 'Sene', 'Hamle', 'Nehase', 'Pagume'
        ];
        
        const date = gregorianDate.getDate();
        const month = gregorianDate.getMonth();
        let year = gregorianDate.getFullYear() - 8;
        
        // Adjust for Ethiopian New Year (September 11/12)
        if (month < 8 || (month === 8 && date < 11)) {
            year--;
        }
        
        const ethiopianMonth = ethiopianMonths[month];
        return `${date} ${ethiopianMonth} ${year}`;
    }
    
    // Initialize Ethiopian features
    addEthiopianFeatures();
    
    // Add Ethiopian business hours with timezone
    function updateEthiopianTime() {
        const ethiopianTimeElement = document.querySelector('.ethiopian-time');
        if (!ethiopianTimeElement) {
            const timeDiv = document.createElement('div');
            timeDiv.className = 'ethiopian-time';
            timeDiv.style.cssText = `
                text-align: center;
                padding: 10px;
                margin: 10px 0;
                font-size: 14px;
                color: var(--text-light);
            `;
            
            const contactInfo = document.querySelector('.contact-info');
            if (contactInfo) {
                contactInfo.appendChild(timeDiv);
            }
        }
        
        const now = new Date();
        const ethiopianTime = now.toLocaleTimeString('en-US', {
            timeZone: 'Africa/Addis_Ababa',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
        
        const element = document.querySelector('.ethiopian-time');
        if (element) {
            element.textContent = `Current time in Addis Ababa: ${ethiopianTime} EAT`;
        }
    }
    
    // Update time every minute
    updateEthiopianTime();
    setInterval(updateEthiopianTime, 60000);
});