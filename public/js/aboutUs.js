    /*-------------------
		Blog READMORE
	--------------------- */
    document.getElementById('read-more-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the <a> tag
        
        const fullText = document.getElementById('blog-text'); // Get the full text element
        const shortText = document.getElementById('blog-text-short'); // Get the short text element
        const button = this; // Reference to the current button
        
        // Check the current state
        if (fullText.style.display === 'none' || fullText.style.display === '') {
            // Show the full text
            fullText.style.display = 'block'; // Set display to block to make it visible
            shortText.style.display = 'none'; // Hide the short text
            button.innerHTML = 'READ LESS <span class="arrow_left"></span>'; // Change button text to "READ LESS"
        } else {
            // Hide the full text
            fullText.style.display = 'none'; // Set display to none to hide it
            shortText.style.display = 'block'; // Show the short text
            button.innerHTML = 'READ MORE <span class="arrow_right"></span>';  // Change button text back to "READ MORE"
        }
    });