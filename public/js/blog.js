'use strict';

(function ($) {

    /*-------------------
        Blog READMORE
    --------------------- */
    document.querySelectorAll('.read-more-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action of the <a> tag
            
            const blogPost = this.closest('.blog__item'); // Get the closest blog item container
            const fullText = blogPost.querySelector('.blog-text'); // Get the full text element
            const shortText = blogPost.querySelector('.blog-text-short'); // Get the short text element
            
            // Check the current state
            if (fullText.style.display === 'none' || fullText.style.display === '') {
                // Show the full text
                fullText.style.display = 'block'; // Set display to block to make it visible
                shortText.style.display = 'none'; // Hide the short text
                this.innerHTML = 'READ LESS <span class="arrow_left"></span>'; // Change button text to "READ LESS"
            } else {
                // Hide the full text
                fullText.style.display = 'none'; // Set display to none to hide it
                shortText.style.display = 'block'; // Show the short text
                this.innerHTML = 'READ MORE <span class="arrow_right"></span>';  // Change button text back to "READ MORE"
            }
        });
    });
    
})(jQuery);