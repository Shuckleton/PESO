// Get the button
let mybutton = document.getElementById("backToTopBtn");

// When the user clicks on the button, scroll to the top of the document smoothly
mybutton.onclick = function() {
    // Scroll to the top of the document
    window.scrollTo({
        top: 0,
        behavior: 'smooth'  // Add smooth scrolling behavior
    });
};
