// features.js - JavaScript for Habesha Events Features Page

document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const searchInput = document.getElementById('features-search-input');
    const searchButton = document.getElementById('search-button');
    const filterToggle = document.querySelector('.filter-toggle');
    const filterPanel = document.getElementById('filter-panel');
    const priceOptions = document.querySelectorAll('.price-option');
    const dateOptions = document.querySelectorAll('.date-option');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const filterCategory = document.getElementById('filter-category');
    const filterLocation = document.getElementById('filter-location');
    const resetFiltersButton = document.getElementById('reset-filters');
    const applyFiltersButton = document.getElementById('apply-filters');
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    const quickLinks = document.querySelectorAll('.quick-link');
    const searchResultsModal = document.getElementById('search-results-modal');
    const resultsModalClose = document.getElementById('results-modal-close');
    const closeResultsButton = document.getElementById('close-results');
    const searchResultsContainer = document.getElementById('search-results-container');
    const resultsCount = document.getElementById('results-count');
    
    // Sample search results data for Ethiopian events
    const sampleSearchResults = [
        {
            id: 1,
            title: "Choke Music Festival",
            category: "music",
            price: 0,
            date: "June 15, 2024",
            location: "Addis Ababa",
            description: "Experience the best of Ethiopian music with top artists from across the country in a day-long celebration of rhythm and culture."
        },
        {
            id: 2,
            title: "Ethiopian Entrepreneurship Summit",
            category: "business",
            price: 49.99,
            date: "July 22, 2024",
            location: "Addis Ababa",
            description: "Join leading entrepreneurs and investors for networking, workshops, and discussions on business opportunities in Ethiopia."
        },
        {
            id: 3,
            title: "Contemporary Ethiopian Art Exhibition",
            category: "art",
            price: 25.00,
            date: "August 5, 2024",
            location: "Addis Ababa",
            description: "Showcasing groundbreaking works from emerging and established Ethiopian artists exploring identity, tradition, and modernity."
        },
        {
            id: 4,
            title: "Shega Food Festival",
            category: "food",
            price: 35.00,
            date: "June 30, 2024",
            location: "Addis Ababa",
            description: "Taste authentic Ethiopian dishes from across the country with cooking demonstrations and cultural performances."
        },
        {
            id: 5,
            title: "Timket Festival Celebration",
            category: "community",
            price: 0,
            date: "January 19, 2024",
            location: "Addis Ababa",
            description: "Join the vibrant celebration of Timket (Epiphany) with traditional ceremonies, music, and cultural performances."
        },
        {
            id: 6,
            title: "Ethiopian Fashion Week",
            category: "art",
            price: 75.00,
            date: "November 10, 2024",
            location: "Addis Ababa",
            description: "Experience the latest collections from Ethiopia's top fashion designers on the runway with afterparty networking."
        }
    ];
    
    // Filter state
    let activeFilters = {
        minPrice: null,
        maxPrice: null,
        dateFilter: 'all',
        category: '',
        location: ''
    };
    
    // Initialize
    setupEventListeners();
    
    // Functions
    function setupEventListeners() {
        // Search functionality
        if (searchButton) {
            searchButton.addEventListener('click', performSearch);
        }
        
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
        }
        
        // Filter panel toggle
        if (filterToggle && filterPanel) {
            filterToggle.addEventListener('click', function() {
                filterPanel.classList.toggle('active');
            });
        }
        
        // Price filter options
        priceOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all price options
                priceOptions.forEach(opt => opt.classList.remove('active'));
                
                // Add active class to clicked option
                this.classList.add('active');
                
                // Update price inputs based on selection
                const priceValue = this.getAttribute('data-price');
                if (priceValue === 'free') {
                    if (minPriceInput) minPriceInput.value = 0;
                    if (maxPriceInput) maxPriceInput.value = 0;
                } else if (priceValue === '0-50') {
                    if (minPriceInput) minPriceInput.value = 0;
                    if (maxPriceInput) maxPriceInput.value = 50;
                } else if (priceValue === '50-100') {
                    if (minPriceInput) minPriceInput.value = 50;
                    if (maxPriceInput) maxPriceInput.value = 100;
                }
            });
        });
        
        // Date filter options
        dateOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all date options
                dateOptions.forEach(opt => opt.classList.remove('active'));
                
                // Add active class to clicked option
                this.classList.add('active');
            });
        });
        
        // Reset filters
        if (resetFiltersButton) {
            resetFiltersButton.addEventListener('click', resetFilters);
        }
        
        // Apply filters
        if (applyFiltersButton) {
            applyFiltersButton.addEventListener('click', function() {
                applyFilters();
                if (filterPanel) filterPanel.classList.remove('active');
            });
        }
        
        // Tab functionality
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                switchTab(tabId);
            });
        });
        
        // Quick links - scroll to sections
        quickLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // If it's an internal link (starts with #), scroll to section
                if (href.startsWith('#')) {
                    e.preventDefault();
                    const targetId = href.substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });
        
        // Search results modal close
        if (resultsModalClose) {
            resultsModalClose.addEventListener('click', function() {
                if (searchResultsModal) {
                    searchResultsModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        }
        
        if (closeResultsButton) {
            closeResultsButton.addEventListener('click', function() {
                if (searchResultsModal) {
                    searchResultsModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        }
        
        if (searchResultsModal) {
            searchResultsModal.addEventListener('click', function(e) {
                if (e.target === searchResultsModal) {
                    searchResultsModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        }
    }
    
    function performSearch() {
        if (!searchInput) return;
        
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            showNotification('Please enter a search term', 'error');
            return;
        }
        
        // Filter sample results based on search term
        const filteredResults = sampleSearchResults.filter(event => {
            return event.title.toLowerCase().includes(searchTerm) ||
                   event.description.toLowerCase().includes(searchTerm) ||
                   event.category.toLowerCase().includes(searchTerm) ||
                   event.location.toLowerCase().includes(searchTerm);
        });
        
        // Display results in modal
        displaySearchResults(filteredResults);
        
        // Show modal
        if (searchResultsModal) {
            searchResultsModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function displaySearchResults(results) {
        if (!searchResultsContainer || !resultsCount) return;
        
        // Update results count
        resultsCount.textContent = results.length;
        
        // Clear previous results
        searchResultsContainer.innerHTML = '';
        
        // Display results
        if (results.length === 0) {
            searchResultsContainer.innerHTML = `
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h4>No events found in Ethiopia</h4>
                    <p>Try adjusting your search terms or filters</p>
                </div>
            `;
        } else {
            results.forEach(event => {
                const resultItem = document.createElement('div');
                resultItem.className = 'search-result-item';
                resultItem.innerHTML = `
                    <h4>${event.title}</h4>
                    <p><i class="far fa-calendar"></i> ${event.date} | <i class="fas fa-map-marker-alt"></i> ${event.location}</p>
                    <p>${event.description}</p>
                    <div class="result-footer">
                        <span class="result-category">${event.category}</span>
                        <span class="result-price">${event.price === 0 ? 'Free' : 'ETB ' + event.price.toFixed(2)}</span>
                    </div>
                `;
                searchResultsContainer.appendChild(resultItem);
            });
        }
    }
    
    function resetFilters() {
        // Reset price inputs
        if (minPriceInput) minPriceInput.value = '';
        if (maxPriceInput) maxPriceInput.value = '';
        
        // Reset price options
        priceOptions.forEach(opt => opt.classList.remove('active'));
        
        // Reset date options
        dateOptions.forEach(opt => opt.classList.remove('active'));
        dateOptions[0].classList.add('active'); // "All Dates" is first
        
        // Reset category and location
        if (filterCategory) filterCategory.value = '';
        if (filterLocation) filterLocation.value = '';
        
        // Reset filter state
        activeFilters = {
            minPrice: null,
            maxPrice: null,
            dateFilter: 'all',
            category: '',
            location: ''
        };
        
        showNotification('Filters have been reset', 'success');
    }
    
    function applyFilters() {
        // Get filter values
        if (minPriceInput && minPriceInput.value) {
            activeFilters.minPrice = parseFloat(minPriceInput.value);
        }
        if (maxPriceInput && maxPriceInput.value) {
            activeFilters.maxPrice = parseFloat(maxPriceInput.value);
        }
        
        // Get active date filter
        const activeDateOption = document.querySelector('.date-option.active');
        if (activeDateOption) {
            activeFilters.dateFilter = activeDateOption.getAttribute('data-date');
        }
        
        if (filterCategory) {
            activeFilters.category = filterCategory.value;
        }
        
        if (filterLocation) {
            activeFilters.location = filterLocation.value;
        }
        
        showNotification('Filters applied successfully', 'success');
    }
    
    function switchTab(tabId) {
        // Remove active class from all tabs
        tabButtons.forEach(button => button.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked tab button
        const activeButton = document.querySelector(`.tab-btn[data-tab="${tabId}"]`);
        if (activeButton) activeButton.classList.add('active');
        
        // Show corresponding tab content
        const activeContent = document.getElementById(`${tabId}-tab`);
        if (activeContent) activeContent.classList.add('active');
    }
});