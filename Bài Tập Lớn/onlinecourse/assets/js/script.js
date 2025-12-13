console.log('OnlineCourse app loaded');

// Moving navigation indicator bar
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const indicator = document.querySelector('.nav-indicator');
    
    if (!indicator) return;
    
    // Function to update indicator position
    function updateIndicator(link) {
        const linkRect = link.getBoundingClientRect();
        const navRect = link.closest('.navbar-nav').getBoundingClientRect();
        
        const left = linkRect.left - navRect.left;
        const width = linkRect.width;
        
        indicator.style.left = left + 'px';
        indicator.style.width = width + 'px';
    }
    
    // Set initial position to active link
    const activeLink = document.querySelector('.nav-link.active');
    if (activeLink) {
        updateIndicator(activeLink);
    }
    
    // Add click event listeners to navigation links
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Update indicator position
            updateIndicator(this);
            
            // Smooth scroll to target section
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            
            if (targetSection) {
                const headerHeight = document.querySelector('.header-main').offsetHeight;
                const targetPosition = targetSection.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            } else {
                // If section doesn't exist, navigate to the page
                window.location.href = this.getAttribute('href');
            }
        });
    });
    
    // Update indicator on window resize
    window.addEventListener('resize', function() {
        const currentActive = document.querySelector('.nav-link.active');
        if (currentActive) {
            updateIndicator(currentActive);
        }
    });
    
    // Update active navigation on scroll
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('section[id]');
        const headerHeight = document.querySelector('.header-main').offsetHeight;
        const scrollPosition = window.scrollY + headerHeight + 100;
        
        let currentSection = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                currentSection = section.getAttribute('id');
            }
        });
        
        if (currentSection) {
            const targetLink = document.querySelector(`.nav-link[href="#${currentSection}"]`);
            if (targetLink && !targetLink.classList.contains('active')) {
                navLinks.forEach(l => l.classList.remove('active'));
                targetLink.classList.add('active');
                updateIndicator(targetLink);
            }
        }
    });
});
