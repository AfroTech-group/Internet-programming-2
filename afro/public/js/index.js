// index.js - JavaScript for Habesha Events Home Page

document.addEventListener('DOMContentLoaded', function() {
    // Event data for home page
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
        }
    ];
    
    // Ticket purchase functionality
    const ticketButtons = document.querySelectorAll('.btn-ticket');
    const ticketModal = document.getElementById('ticket-modal');
    const modalClose = document.getElementById('modal-close');
    const cancelPurchase = document.getElementById('cancel-purchase');
    const confirmPurchase = document.getElementById('confirm-purchase');
    const decreaseTicket = document.getElementById('decrease-ticket');
    const increaseTicket = document.getElementById('increase-ticket');
    const ticketQuantity = document.getElementById('ticket-quantity');
    const modalEventTitle = document.getElementById('modal-event-title');
    const modalEventDate = document.getElementById('modal-event-date');
    const modalEventPrice = document.getElementById('modal-event-price');
    const summaryTickets = document.getElementById('summary-tickets');
    const summaryTotal = document.getElementById('summary-total');
    const successModal = document.getElementById('success-modal');
    const successClose = document.getElementById('success-close');
    const successOk = document.getElementById('success-ok');
    const successEventTitle = document.getElementById('success-event-title');
    const successQuantity = document.getElementById('success-quantity');
    const successTotal = document.getElementById('success-total');
    
    let currentEventId = null;
    let serviceFee = 2.50;
    
    // Ticket button click handlers
    if (ticketButtons.length > 0) {
        ticketButtons.forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-event');
                currentEventId = eventId;
                openTicketModal(eventId);
            });
        });
    }
    
    // Open ticket modal
    function openTicketModal(eventId) {
        const event = eventsData.find(e => e.id === parseInt(eventId));
        if (!event) return;
        
        modalEventTitle.textContent = event.title;
        modalEventDate.textContent = `Date: ${event.date}`;
        modalEventPrice.textContent = `Price: ${event.price === 0 ? 'FREE' : 'ETB ' + event.price.toFixed(2)}`;
        
        // Reset quantity to 1
        if (ticketQuantity) ticketQuantity.value = 1;
        
        // Update summary
        updatePurchaseSummary(event.price);
        
        // Show modal
        if (ticketModal) {
            ticketModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Close ticket modal
    function closeTicketModal() {
        if (ticketModal) {
            ticketModal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }
    
    // Close modal when clicking close button or outside modal
    if (modalClose) {
        modalClose.addEventListener('click', closeTicketModal);
    }
    
    if (cancelPurchase) {
        cancelPurchase.addEventListener('click', closeTicketModal);
    }
    
    // Ticket quantity adjustments
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
    
    // Update purchase summary
    function updatePurchaseSummary(price) {
        if (!ticketQuantity || !summaryTickets || !summaryTotal) return;
        
        const quantity = parseInt(ticketQuantity.value);
        const ticketCost = price * quantity;
        const total = ticketCost + (price === 0 ? 0 : serviceFee);
        
        summaryTickets.textContent = `${quantity} x ETB ${price.toFixed(2)}`;
        summaryTotal.textContent = `ETB ${total.toFixed(2)}`;
    }
    
    // Confirm purchase
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
            
            // Update the UI on all pages
            updateTicketCount(currentEventId, event.tickets);
            
            // Close purchase modal then show a detailed success popup
            closeTicketModal();
            openSuccessModal(event, quantity);
        });
    }

    // Open success confirmation modal with details
    function openSuccessModal(event, quantity) {
        if (!successModal) return;
        // Fill details
        if (successEventTitle) successEventTitle.textContent = event.title;
        if (successQuantity) successQuantity.textContent = quantity;

        const price = event.price || 0;
        const ticketCost = price * quantity;
        const total = ticketCost + (price === 0 ? 0 : serviceFee);
        if (successTotal) successTotal.textContent = `ETB ${total.toFixed(2)}`;

        successModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSuccessModal() {
        if (!successModal) return;
        successModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Wire up success modal controls
    if (successClose) {
        successClose.addEventListener('click', closeSuccessModal);
    }
    if (successOk) {
        successOk.addEventListener('click', closeSuccessModal);
    }
    
    // Update ticket count in the UI
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
    
    // Initialize ticket counts on page load
    function initializeTicketCounts() {
        eventsData.forEach(event => {
            updateTicketCount(event.id, event.tickets);
        });
    }
    
    // Initialize
    initializeTicketCounts();
});