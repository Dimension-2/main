document.addEventListener('DOMContentLoaded', function() {
    // --- Scroll to Top Button Functionality ---
    const scrollToTopBtn = document.getElementById('scrollToTopBtn');

    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) { // Show button after scrolling down 300px
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });

    // Scroll to top when button is clicked
    if (scrollToTopBtn) {
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // Smooth scroll effect
            });
        });
    }

    // --- Industry Carousel Functionality ---
    const industryCarousel = document.querySelector('.industry-carousel');
    const prevBtn = document.querySelector('.carousel-btn.prev-btn');
    const nextBtn = document.querySelector('.carousel-btn.next-btn');
    const scrollbarThumb = document.querySelector('.scrollbar-thumb');

    let scrollPosition = 0;
    const cardWidth = 220; // 200px card width + 20px margin-right
    const visibleCards = 4; // Adjust based on how many cards are visible at once

    // Function to update scrollbar thumb position and width
    function updateScrollbar() {
        if (!industryCarousel) return;

        const scrollWidth = industryCarousel.scrollWidth;
        const clientWidth = industryCarousel.clientWidth;

        if (scrollWidth <= clientWidth) {
            // No need for scrollbar if content fits
            scrollbarThumb.style.width = '0%';
            return;
        }

        const scrollPercentage = (industryCarousel.scrollLeft / (scrollWidth - clientWidth)) * 100;
        const thumbWidthPercentage = (clientWidth / scrollWidth) * 100;

        scrollbarThumb.style.width = `${thumbWidthPercentage}%`;
        scrollbarThumb.style.left = `${scrollPercentage}%`;
    }

    // Event listener for next button
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (industryCarousel) {
                industryCarousel.scrollBy({
                    left: cardWidth * visibleCards, // Scroll by the width of visible cards
                    behavior: 'smooth'
                });
            }
        });
    }

    // Event listener for previous button
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            if (industryCarousel) {
                industryCarousel.scrollBy({
                    left: -cardWidth * visibleCards, // Scroll back by the width of visible cards
                    behavior: 'smooth'
                });
            }
        });
    }

    // Update scrollbar when carousel is scrolled
    if (industryCarousel) {
        industryCarousel.addEventListener('scroll', updateScrollbar);
        // Initial update
        updateScrollbar();
        // Update on window resize as well
        window.addEventListener('resize', updateScrollbar);
    }

    console.log('Script loaded: DOM is ready and interactive elements are active!');
});