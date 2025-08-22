// Back to Top Button
let backToTopButton = document.getElementById('btn-back-to-top');

// Show/hide the button when scrolling
window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        backToTopButton.style.display = "flex";
    } else {
        backToTopButton.style.display = "none";
    }
}

// Scroll to top when the button is clicked
backToTopButton.addEventListener('click', function() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
});

// Form validation
(function() {
    'use strict';
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation');
    
    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
})();

// Add smooth scrolling to all links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80, // Adjust for fixed header
                behavior: 'smooth'
            });
        }
    });
});

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Initialize popovers
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
});

// Add animation to elements when they come into view
const animateOnScroll = function() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;
        
        if (elementPosition < screenPosition) {
            element.classList.add('animated');
        }
    });
};

// Run animation check on load and scroll
window.addEventListener('load', animateOnScroll);
window.addEventListener('scroll', animateOnScroll);

// Handle contact form submission
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(contactForm);
        const submitButton = contactForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        
        // Disable button and show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sending...';
        
        // Simulate form submission (replace with actual AJAX call)
        setTimeout(() => {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success mt-3';
            alertDiv.role = 'alert';
            alertDiv.innerHTML = 'Your message has been sent successfully! We will get back to you soon.';
            
            // Insert alert before the form
            contactForm.parentNode.insertBefore(alertDiv, contactForm);
            
            // Reset form
            contactForm.reset();
            contactForm.classList.remove('was-validated');
            
            // Reset button state
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
            
            // Scroll to the alert
            alertDiv.scrollIntoView({ behavior: 'smooth' });
            
            // Remove alert after 5 seconds
            setTimeout(() => {
                alertDiv.style.opacity = '0';
                setTimeout(() => {
                    alertDiv.remove();
                }, 300);
            }, 5000);
        }, 1500);
    });
}

// Handle result form submission
const resultForm = document.getElementById('resultForm');
if (resultForm) {
    resultForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(resultForm);
        const submitButton = resultForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        
        // Disable button and show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Searching...';
        
        // Here you would typically make an AJAX call to your server
        // For now, we'll simulate a delay and then submit the form
        setTimeout(() => {
            // Submit the form normally (remove this in favor of AJAX in production)
            resultForm.submit();
            
            // Reset button state (this won't be reached if the form redirects)
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        }, 1000);
    });
}

// Handle class change to load subjects (if applicable)
const classSelect = document.getElementById('class_id');
const subjectSelect = document.getElementById('subject_id');

if (classSelect && subjectSelect) {
    classSelect.addEventListener('change', function() {
        const classId = this.value;
        
        if (!classId) {
            subjectSelect.innerHTML = '<option value="">Select a class first</option>';
            return;
        }
        
        // Show loading state
        subjectSelect.disabled = true;
        const originalHTML = subjectSelect.innerHTML;
        subjectSelect.innerHTML = '<option value="">Loading subjects...</option>';
        
        // Simulate API call to get subjects for the selected class
        // In a real application, you would make an AJAX request here
        // Example: fetch(`/api/classes/${classId}/subjects`)
        
        setTimeout(() => {
            // This is a mock response - replace with actual API call
            const mockSubjects = [
                { id: 1, name: 'Mathematics' },
                { id: 2, name: 'Science' },
                { id: 3, name: 'English' },
                { id: 4, name: 'Social Studies' },
                { id: 5, name: 'Nepali' }
            ];
            
            // Populate subjects
            let options = '<option value="">Select Subject</option>';
            mockSubjects.forEach(subject => {
                options += `<option value="${subject.id}">${subject.name}</option>`;
            });
            
            subjectSelect.innerHTML = options;
            subjectSelect.disabled = false;
            
        }, 500);
    });
}

// Add animation to elements with data-animate attribute
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('[data-animate]');
    
    animatedElements.forEach(element => {
        const animationClass = element.getAttribute('data-animate');
        element.classList.add('invisible');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('invisible');
                    entry.target.classList.add('visible', animationClass);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        observer.observe(element);
    });
});

// Handle print button click
document.querySelectorAll('.print-btn').forEach(button => {
    button.addEventListener('click', function() {
        window.print();
    });
});

// Handle form reset
document.querySelectorAll('.form-reset').forEach(button => {
    button.addEventListener('click', function() {
        const form = this.closest('form');
        if (form) {
            form.reset();
            form.classList.remove('was-validated');
        }
    });
});

// Add active class to current nav link
const currentLocation = location.href;
const navLinks = document.querySelectorAll('.nav-link');
const navLength = navLinks.length;

for (let i = 0; i < navLength; i++) {
    if (navLinks[i].href === currentLocation) {
        navLinks[i].classList.add('active');
        navLinks[i].setAttribute('aria-current', 'page');
    }
}

// Handle dropdown menus on mobile
document.querySelectorAll('.dropdown > a').forEach(link => {
    link.addEventListener('click', function(e) {
        if (window.innerWidth < 992) { // For mobile
            e.preventDefault();
            const parent = this.parentElement;
            const isOpen = this.getAttribute('aria-expanded') === 'true';
            
            // Close all other open dropdowns
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                if (dropdown !== parent) {
                    const button = dropdown.querySelector('a[data-bs-toggle]');
                    if (button) {
                        const dropdownInstance = bootstrap.Dropdown.getInstance(button) || new bootstrap.Dropdown(button);
                        dropdownInstance.hide();
                    }
                }
            });
            
            // Toggle current dropdown
            if (!isOpen) {
                const dropdownInstance = new bootstrap.Dropdown(this);
                dropdownInstance.toggle();
            }
        }
    });
});

// Close mobile menu when clicking outside
document.addEventListener('click', function(e) {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && !navbarToggler.contains(e.target) && 
        navbarCollapse && !navbarCollapse.contains(e.target) && 
        navbarCollapse.classList.contains('show')) {
        
        const bsCollapse = new bootstrap.Collapse(navbarCollapse, { toggle: false });
        bsCollapse.hide();
    }
});
