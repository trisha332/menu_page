





// menu
document.addEventListener('DOMContentLoaded', function() {
    const menuLinks = document.querySelectorAll('.menu ul li a');
    const sections = document.querySelectorAll('section');

    menuLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            
            // Hide all sections
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Show the clicked section
            const targetId = this.getAttribute('href').substring(1);
            document.getElementById(targetId).classList.add('active');
        });
    });
});