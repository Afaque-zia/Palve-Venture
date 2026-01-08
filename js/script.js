/**
 * Palve Ventures - Main JavaScript
 * Handles form submissions, animations, and user interactions
 */

$(document).ready(function () {

    // Smooth scroll for navigation links
    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        const target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 1000);

            // Close mobile menu if open
            if ($('.navbar-collapse').hasClass('show')) {
                $('.navbar-toggler').click();
            }
        }
    });

    // Navbar scroll effect
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('shadow-lg');
        } else {
            $('.navbar').removeClass('shadow-lg');
        }

        // Show/hide scroll to top button
        if ($(this).scrollTop() > 300) {
            $('#scrollTopBtn').fadeIn();
        } else {
            $('#scrollTopBtn').fadeOut();
        }
    });

    // Active nav link on scroll
    $(window).on('scroll', function () {
        let scrollPos = $(document).scrollTop() + 100;

        $('.nav-link').each(function () {
            let currLink = $(this);
            let refElement = $(currLink.attr('href'));

            if (refElement.length && refElement.position().top <= scrollPos &&
                refElement.position().top + refElement.height() > scrollPos) {
                $('.nav-link').removeClass('active');
                currLink.addClass('active');
            }
        });
    });

    // Scroll to top button
    $('body').append('<button id="scrollTopBtn" title="Go to top"><i class="bi bi-arrow-up"></i></button>');

    $('#scrollTopBtn').on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 600);
    });

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                event.preventDefault();
                handleFormSubmit(form);
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Handle form submissions
    function handleFormSubmit(form) {
        const formId = form.id;
        const formData = new FormData(form);

        // Show loading state
        const submitBtn = $(form).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Sending...');

        // AJAX request to PHP handler
        $.ajax({
            url: 'php/form-handler.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showAlert('success', response.message || 'Form submitted successfully! We will contact you soon.');
                    form.reset();
                    form.classList.remove('was-validated');
                } else {
                    showAlert('danger', response.message || 'Something went wrong. Please try again.');
                }
            },
            error: function () {
                showAlert('warning', 'Unable to send message. Please email us directly at info@palveventures.com or call us.');
            },
            complete: function () {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    }

    // Show alert message
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show alert-floating" role="alert">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}-fill me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        $('body').append(alertHtml);

        setTimeout(function () {
            $('.alert-floating').fadeOut(function () {
                $(this).remove();
            });
        }, 5000);
    }

    // Animate elements on scroll
    function animateOnScroll() {
        $('.service-card, .property-card, .process-card, .verification-step').each(function () {
            const elementTop = $(this).offset().top;
            const elementBottom = elementTop + $(this).outerHeight();
            const viewportTop = $(window).scrollTop();
            const viewportBottom = viewportTop + $(window).height();

            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('fade-in-up');
            }
        });
    }

    $(window).on('scroll', animateOnScroll);
    animateOnScroll(); // Initial check

    // Property card click tracking
    $('.property-card').on('click', function () {
        const propertyName = $(this).find('h5').text();
        console.log('Property clicked:', propertyName);
        // You can add analytics tracking here
    });

    // Phone number formatting
    $('input[type="tel"]').on('input', function () {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 10) {
            value = value.substr(0, 10);
        }
        $(this).val(value);
    });

    // Add loading skeleton for property images (optional enhancement)
    $('.property-image').each(function () {
        $(this).addClass('skeleton-loading');
        setTimeout(() => {
            $(this).removeClass('skeleton-loading');
        }, 500);
    });

    // Category button tracking
    $('.category-btn').on('click', function (e) {
        const category = $(this).find('span').text();
        console.log('Category selected:', category);
    });

    // Modal enhancements
    $('#propertyModal').on('show.bs.modal', function (e) {
        // You can load dynamic property data here
    });

    // Newsletter subscription (if added later)
    $(document).on('submit', '#newsletterForm', function (e) {
        e.preventDefault();
        const email = $(this).find('input[type="email"]').val();
        showAlert('success', 'Thank you for subscribing! Check your email for updates.');
        this.reset();
    });

    // Lazy loading for SVGs (optional optimization)
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('svg').forEach(svg => {
        observer.observe(svg);
    });

    // Console welcome message
    console.log('%c Palve Ventures ', 'background: #3B82F6; color: white; font-size: 20px; padding: 10px;');
    console.log('%c Trusted Property Consultants ', 'font-size: 14px; color: #6B7280;');

    // Preload critical images (if any real images are added)
    function preloadImages(urls) {
        urls.forEach(url => {
            const img = new Image();
            img.src = url;
        });
    }

    // Add keyboard navigation for accessibility
    $('.property-card, .service-card').attr('tabindex', '0');

    $('.property-card, .service-card').on('keypress', function (e) {
        if (e.which === 13) { // Enter key
            $(this).click();
        }
    });

    // Dynamic year in footer
    const currentYear = new Date().getFullYear();
    $('footer p:contains("2026")').html(function (_, html) {
        return html.replace('2026', currentYear);
    });

    // Form field focus effects
    $('.form-control, .form-select').on('focus', function () {
        $(this).parent().addClass('focused');
    }).on('blur', function () {
        $(this).parent().removeClass('focused');
    });

    // Initialize tooltips (if Bootstrap tooltips are used)
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Performance optimization: Debounce scroll events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    const debouncedScroll = debounce(() => {
        animateOnScroll();
    }, 100);

    $(window).on('scroll', debouncedScroll);

});

// Service Worker Registration (for PWA - optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        // navigator.serviceWorker.register('/sw.js'); // Uncomment if you add a service worker
    });
}

// Google Analytics (add your tracking ID)
// window.dataLayer = window.dataLayer || [];
// function gtag(){dataLayer.push(arguments);}
// gtag('js', new Date());
// gtag('config', 'YOUR-GA-TRACKING-ID');