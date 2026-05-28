// events.js - JavaScript for Habesha Events Events Page

document.addEventListener('DOMContentLoaded', function() {
    // Event data for events page (Ethiopian events)
    const eventsData = [
        {
            id: 1,
            title: "Choke Music Festival",
            date: "June 15, 2024 | 6:00 PM",
            location: "Addis Ababa Stadium, Addis Ababa",
            category: "music",
            price: 0,
            tickets: 150,
            description: "Experience the best of Ethiopian music with top artists from across the country in a day-long celebration of rhythm and culture.",
            image: "https://images.unsplash.com/photo-1575467672413-8b10b5b5e8c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 2,
            title: "Ethiopian Entrepreneurship Summit",
            date: "July 22, 2024 | 9:00 AM",
            location: "Skylight Hotel, Addis Ababa",
            category: "business",
            price: 49.99,
            tickets: 75,
            description: "Join leading entrepreneurs and investors for networking, workshops, and discussions on business opportunities in Ethiopia.",
            image: "https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 3,
            title: "Contemporary Ethiopian Art Exhibition",
            date: "August 5, 2024 | 10:00 AM",
            location: "National Museum, Addis Ababa",
            category: "art",
            price: 25.00,
            tickets: 42,
            description: "Showcasing groundbreaking works from emerging and established Ethiopian artists exploring identity, tradition, and modernity.",
            image: "https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 4,
            title: "Shega Food Festival",
            date: "June 30, 2024 | 12:00 PM",
            location: "Sheger Park, Addis Ababa",
            category: "food",
            price: 35.00,
            tickets: 120,
            description: "Taste authentic Ethiopian dishes from across the country, with cooking demonstrations, cultural performances, and food competitions.",
            image: "https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 5,
            title: "Tech Innovation Ethiopia Conference",
            date: "September 12, 2024 | 8:00 AM",
            location: "Ethiopian Innovation Hub, Addis Ababa",
            category: "tech",
            price: 89.99,
            tickets: 200,
            description: "Explore the latest technological innovations from Ethiopia's booming tech scene with industry leaders and startups.",
            image: "https://images.unsplash.com/photo-1535223289827-42f1e9919769?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 6,
            title: "Ethiopian Dance Workshop",
            date: "July 8, 2024 | 2:00 PM",
            location: "Cultural Center, Addis Ababa",
            category: "music",
            price: 0,
            tickets: 50,
            description: "Learn traditional Ethiopian dance moves from professional instructors in this interactive workshop for all skill levels.",
            image: "https://images.unsplash.com/photo-1547153760-18fc86324498?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 7,
            title: "Investment in Ethiopia Forum",
            date: "October 5, 2024 | 10:00 AM",
            location: "Hilton Hotel, Addis Ababa",
            category: "business",
            price: 149.99,
            tickets: 80,
            description: "Connect with investors and learn about opportunities in Ethiopia's growing markets across various sectors.",
            image: "https://images.unsplash.com/photo-1556761175-b413da4baf72?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 8,
            title: "Ethiopian Literature Festival",
            date: "August 25, 2024 | 11:00 AM",
            location: "Addis Ababa University Library",
            category: "education",
            price: 15.00,
            tickets: 90,
            description: "Celebrate Ethiopian authors and storytelling with book readings, author talks, and writing workshops.",
            image: "https://images.unsplash.com/photo-1544716278-e513176f20b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 9,
            title: "Timket Festival Celebration",
            date: "January 19, 2024 | 1:00 PM",
            location: "Jan Meda, Addis Ababa",
            category: "community",
            price: 0,
            tickets: 500,
            description: "Join the vibrant celebration of Timket (Epiphany) with traditional ceremonies, music, and cultural performances.",
            image: "https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 10,
            title: "Ethiopian Fashion Week",
            date: "November 10, 2024 | 7:00 PM",
            location: "Sheraton Hotel, Addis Ababa",
            category: "art",
            price: 75.00,
            tickets: 150,
            description: "Experience the latest collections from Ethiopia's top fashion designers on the runway with afterparty networking.",
            image: "https://images.unsplash.com/photo-1539109136881-3be0616acf4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 11,
            title: "Startup Pitch Ethiopia",
            date: "July 18, 2024 | 6:00 PM",
            location: "Blue Moon, Addis Ababa",
            category: "business",
            price: 25.00,
            tickets: 60,
            description: "Watch Ethiopian startups pitch their ideas to investors and network with the country's entrepreneurial community.",
            image: "https://images.unsplash.com/photo-1559136555-9303baea8ebd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        },
        {
            id: 12,
            title: "Ethiopian Film Screening Night",
            date: "August 14, 2024 | 8:00 PM",
            location: "Cinema Ethiopia, Addis Ababa",
            category: "art",
            price: 12.00,
            tickets: 75,
            description: "Screening of award-winning Ethiopian films followed by Q&A with directors and filmmakers.",
            image: "https://images.unsplash.com/photo-1489599809516-9827b6d1cf13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80"
        }
    ];
    
    // DOM Elements
    const eventsContainer = document.getElementById('events-container');
    const eventsCount = document.getElementById('events-count');
    const loadMoreBtn = document.getElementById('load-more');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const priceFilter = document.getElementById('price-filter');
    const dateFilter = document.getElementById('date-filter');
    const sortFilter = document.getElementById('sort-filter');
    const categoryCards = document.querySelectorAll('.category-card');
    const eventsSearchInput = document.querySelector('.events-search input');
    const eventsSearchButton = document.querySelector('.events-search .btn-search');
    
    // State
    let currentEvents = [...eventsData];
    let displayedEvents = 6;
    let activeCategory = 'all';
    let activePriceFilter = 'all';
    let activeDateFilter = 'all';
    let activeSort = 'date';
    
    // Initialize
    renderEvents();
    updateEventsCount();
    
    // Event Listeners
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMoreEvents);
    }
    
    // Category filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update category
            activeCategory = this.getAttribute('data-category');
            
            // Apply filters
            applyFilters();
        });
    });
    
    // Category cards
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            
            // Update filter buttons
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-category') === category) {
                    btn.classList.add('active');
                }
            });
            
            // Update category
            activeCategory = category;
            
            // Apply filters
            applyFilters();
            
            // Scroll to events
            document.querySelector('.all-events').scrollIntoView({ behavior: 'smooth' });
        });
    });
    
    // Price filter
    if (priceFilter) {
        priceFilter.addEventListener('change', function() {
            activePriceFilter = this.value;
            applyFilters();
        });
    }
    
    // Date filter
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            activeDateFilter = this.value;
            applyFilters();
        });
    }
    
    // Sort filter
    if (sortFilter) {
        sortFilter.addEventListener('change', function() {
            activeSort = this.value;
            applyFilters();
        });
    }
    
    // Search functionality
    if (eventsSearchButton) {
        eventsSearchButton.addEventListener('click', performSearch);
    }
    
    if (eventsSearchInput) {
        eventsSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
    
    // Functions
    function renderEvents() {
        if (!eventsContainer) return;
        
        eventsContainer.innerHTML = '';
        
        const eventsToShow = currentEvents.slice(0, displayedEvents);
        
        eventsToShow.forEach(event => {
            const eventCard = createEventCard(event);
            eventsContainer.appendChild(eventCard);
        });
        
        // Update load more button visibility
        if (loadMoreBtn) {
            if (displayedEvents >= currentEvents.length) {
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.style.display = 'block';
            }
        }
        
        // Initialize ticket buttons for new events
        initializeTicketButtons();
    }
    
    function createEventCard(event) {
        const card = document.createElement('div');
        card.className = 'event-card';
        card.setAttribute('data-category', event.category);
        card.setAttribute('data-price', event.price);
        
        // Format date for data attribute
        const eventDate = new Date(event.date.split(' | ')[0]);
        card.setAttribute('data-date', eventDate.toISOString().split('T')[0]);
        
        card.innerHTML = `
            <div class="event-image">
                <img src="${event.image}" alt="${event.title}">
                <span class="event-category">${getCategoryLabel(event.category)}</span>
                <span class="event-price ${event.price === 0 ? 'free' : ''}">
                    ${event.price === 0 ? 'Free' : 'ETB ' + event.price.toFixed(2)}
                </span>
            </div>
            <div class="event-info">
                <h3>${event.title}</h3>
                <p class="event-date"><i class="far fa-calendar"></i> ${event.date}</p>
                <p class="event-location"><i class="fas fa-map-marker-alt"></i> ${event.location}</p>
                <p class="event-description">${event.description}</p>
                <div class="event-footer">
                    <div class="tickets-available">
                        <i class="fas fa-ticket-alt"></i>
                        <span class="ticket-count">${event.tickets}</span> tickets left
                    </div>
                    <button class="btn btn-ticket" data-event="${event.id}">
                        ${event.price === 0 ? 'Register Free' : 'Get Ticket'}
                    </button>
                </div>
            </div>
        `;
        
        return card;
    }
    
    function getCategoryLabel(category) {
        const labels = {
            'music': 'Music',
            'business': 'Business',
            'art': 'Art & Culture',
            'sports': 'Sports',
            'food': 'Food & Drink',
            'tech': 'Technology',
            'education': 'Education',
            'community': 'Community'
        };
        
        return labels[category] || category;
    }
    
    function loadMoreEvents() {
        displayedEvents += 6;
        renderEvents();
        updateEventsCount();
    }
    
    function updateEventsCount() {
        if (eventsCount) {
            const visibleCount = Math.min(displayedEvents, currentEvents.length);
            eventsCount.textContent = visibleCount;
        }
    }
    
    function applyFilters() {
        let filteredEvents = [...eventsData];
        
        // Apply category filter
        if (activeCategory !== 'all') {
            filteredEvents = filteredEvents.filter(event => event.category === activeCategory);
        }
        
        // Apply price filter
        if (activePriceFilter !== 'all') {
            if (activePriceFilter === 'free') {
                filteredEvents = filteredEvents.filter(event => event.price === 0);
            } else if (activePriceFilter === '0-50') {
                filteredEvents = filteredEvents.filter(event => event.price > 0 && event.price <= 50);
            } else if (activePriceFilter === '50-100') {
                filteredEvents = filteredEvents.filter(event => event.price > 50 && event.price <= 100);
            } else if (activePriceFilter === '100+') {
                filteredEvents = filteredEvents.filter(event => event.price > 100);
            }
        }
        
        // Apply date filter
        if (activeDateFilter !== 'all') {
            const today = new Date();
            const nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 7);
            const nextMonth = new Date();
            nextMonth.setMonth(today.getMonth() + 1);
            
            filteredEvents = filteredEvents.filter(event => {
                const eventDate = new Date(event.date.split(' | ')[0]);
                
                switch (activeDateFilter) {
                    case 'today':
                        return eventDate.toDateString() === today.toDateString();
                    case 'week':
                        return eventDate >= today && eventDate <= nextWeek;
                    case 'month':
                        return eventDate >= today && eventDate <= nextMonth;
                    case 'upcoming':
                        return eventDate >= today;
                    default:
                        return true;
                }
            });
        }
        
        // Apply sorting
        switch (activeSort) {
            case 'date':
                filteredEvents.sort((a, b) => {
                    const dateA = new Date(a.date.split(' | ')[0]);
                    const dateB = new Date(b.date.split(' | ')[0]);
                    return dateA - dateB;
                });
                break;
            case 'price-low':
                filteredEvents.sort((a, b) => a.price - b.price);
                break;
            case 'price-high':
                filteredEvents.sort((a, b) => b.price - a.price);
                break;
            case 'popular':
                // Sort by tickets available (fewer tickets = more popular)
                filteredEvents.sort((a, b) => a.tickets - b.tickets);
                break;
        }
        
        // Update state
        currentEvents = filteredEvents;
        displayedEvents = 6;
        
        // Re-render
        renderEvents();
        updateEventsCount();
    }
    
    function performSearch() {
        if (!eventsSearchInput) return;
        
        const searchTerm = eventsSearchInput.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            // If search is empty, reset to all events
            currentEvents = [...eventsData];
        } else {
            // Filter events by search term
            currentEvents = eventsData.filter(event => {
                return event.title.toLowerCase().includes(searchTerm) ||
                       event.description.toLowerCase().includes(searchTerm) ||
                       event.location.toLowerCase().includes(searchTerm) ||
                       event.category.toLowerCase().includes(searchTerm);
            });
        }
        
        // Reset displayed events count
        displayedEvents = 6;
        
        // Re-render
        renderEvents();
        updateEventsCount();
        
        // Scroll to results
        document.querySelector('.all-events').scrollIntoView({ behavior: 'smooth' });
    }
    
    function initializeTicketButtons() {
        const ticketButtons = document.querySelectorAll('.btn-ticket');
        
        ticketButtons.forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-event');
                openTicketModal(eventId);
            });
        });
    }
    
    // Ticket purchase functionality (similar to index.js but using eventsData)
    let currentEventId = null;
    let serviceFee = 2.50;
    
    function openTicketModal(eventId) {
        const event = eventsData.find(e => e.id === parseInt(eventId));
        if (!event) return;
        
        const modalEventTitle = document.getElementById('modal-event-title');
        const modalEventDate = document.getElementById('modal-event-date');
        const modalEventPrice = document.getElementById('modal-event-price');
        const summaryTickets = document.getElementById('summary-tickets');
        const summaryTotal = document.getElementById('summary-total');
        const ticketQuantity = document.getElementById('ticket-quantity');
        const ticketModal = document.getElementById('ticket-modal');
        
        if (modalEventTitle) modalEventTitle.textContent = event.title;
        if (modalEventDate) modalEventDate.textContent = `Date: ${event.date}`;
        if (modalEventPrice) modalEventPrice.textContent = `Price: ${event.price === 0 ? 'FREE' : 'ETB ' + event.price.toFixed(2)}`;
        
        // Reset quantity to 1
        if (ticketQuantity) ticketQuantity.value = 1;
        
        // Update summary
        updatePurchaseSummary(event.price);
        
        // Show modal
        if (ticketModal) {
            ticketModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        currentEventId = eventId;
    }
    
    function updatePurchaseSummary(price) {
        const ticketQuantity = document.getElementById('ticket-quantity');
        const summaryTickets = document.getElementById('summary-tickets');
        const summaryTotal = document.getElementById('summary-total');
        
        if (!ticketQuantity || !summaryTickets || !summaryTotal) return;
        
        const quantity = parseInt(ticketQuantity.value);
        const ticketCost = price * quantity;
        const total = ticketCost + (price === 0 ? 0 : serviceFee);
        
        summaryTickets.textContent = `${quantity} x ETB ${price.toFixed(2)}`;
        summaryTotal.textContent = `ETB ${total.toFixed(2)}`;
    }
    
    // Initialize events page
    initializeTicketButtons();
    
    // Add event listeners for ticket modal
    const modalClose = document.getElementById('modal-close');
    const cancelPurchase = document.getElementById('cancel-purchase');
    const confirmPurchase = document.getElementById('confirm-purchase');
    const decreaseTicket = document.getElementById('decrease-ticket');
    const increaseTicket = document.getElementById('increase-ticket');
    const ticketQuantity = document.getElementById('ticket-quantity');
    
    if (modalClose) {
        modalClose.addEventListener('click', function() {
            const ticketModal = document.getElementById('ticket-modal');
            if (ticketModal) {
                ticketModal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }
    
    if (cancelPurchase) {
        cancelPurchase.addEventListener('click', function() {
            const ticketModal = document.getElementById('ticket-modal');
            if (ticketModal) {
                ticketModal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }
    
    if (decreaseTicket) {
        decreaseTicket.addEventListener('click', function() {
            if (parseInt(ticketQuantity.value) > 1) {
                ticketQuantity.value = parseInt(ticketQuantity.value) - 1;
                const event = eventsData.find(e => e.id === parseInt(currentEventId));
                if (event) updatePurchaseSummary(event.price);
            }
        });
    }
    
    if (increaseTicket) {
        increaseTicket.addEventListener('click', function() {
            if (parseInt(ticketQuantity.value) < 10) {
                ticketQuantity.value = parseInt(ticketQuantity.value) + 1;
                const event = eventsData.find(e => e.id === parseInt(currentEventId));
                if (event) updatePurchaseSummary(event.price);
            }
        });
    }
    
    if (ticketQuantity) {
        ticketQuantity.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) value = 1;
            if (value > 10) value = 10;
            this.value = value;
            const event = eventsData.find(e => e.id === parseInt(currentEventId));
            if (event) updatePurchaseSummary(event.price);
        });
    }
    
    if (confirmPurchase) {
        confirmPurchase.addEventListener('click', function() {
            if (!currentEventId) return;
            
            const event = eventsData.find(e => e.id === parseInt(currentEventId));
            if (!event) return;
            
            const quantity = parseInt(ticketQuantity.value);
            
            // Check if enough tickets are available
            if (quantity > event.tickets) {
                showNotification(`Sorry, only ${event.tickets} tickets available for this event.`, 'error');
                return;
            }
            
            // Update available tickets
            event.tickets -= quantity;
            
            // Update the UI
            updateTicketCount(currentEventId, event.tickets);
            
            // Show success message
            showNotification(`Successfully purchased ${quantity} ticket(s) for ${event.title}!`, 'success');
            
            // Close modal
            const ticketModal = document.getElementById('ticket-modal');
            if (ticketModal) {
                ticketModal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }
    
    function updateTicketCount(eventId, newCount) {
        const ticketElements = document.querySelectorAll(`.btn-ticket[data-event="${eventId}"]`);
        ticketElements.forEach(button => {
            const ticketInfo = button.closest('.event-footer').querySelector('.ticket-count');
            if (ticketInfo) ticketInfo.textContent = newCount;
            
            // If no tickets left, disable the button
            if (newCount === 0) {
                button.textContent = 'Sold Out';
                button.disabled = true;
                button.classList.remove('btn-ticket');
                button.classList.add('btn-disabled');
            }
        });
    }
});