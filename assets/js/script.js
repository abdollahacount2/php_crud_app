// Auto-hide alert messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alertMessage = document.getElementById('alertMessage');
    
    if (alertMessage) {
        setTimeout(() => {
            alertMessage.style.transition = 'opacity 0.5s ease-out';
            alertMessage.style.opacity = '0';
            
            setTimeout(() => {
                alertMessage.remove();
            }, 500);
        }, 5000);
    }
    
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Form validation
    const forms = document.querySelectorAll('.task-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const title = form.querySelector('#title');
            
            if (title && title.value.trim() === '') {
                e.preventDefault();
                alert('Please enter a task title');
                title.focus();
                return false;
            }
        });
    });
    
    // Add loading state to buttons
    const buttons = document.querySelectorAll('button[type="submit"]');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.form && this.form.checkValidity()) {
                this.disabled = true;
                const originalText = this.textContent;
                this.textContent = 'Processing...';
                
                // Re-enable after 3 seconds as fallback
                setTimeout(() => {
                    this.disabled = false;
                    this.textContent = originalText;
                }, 3000);
            }
        });
    });
});

// Confirm delete with better UX
function confirmDelete(id) {
    const modal = confirm(
        'Are you sure you want to delete this task?\n\n' +
        'This action cannot be undone.'
    );
    
    if (modal) {
        // Show loading indicator
        const btn = event.target;
        btn.disabled = true;
        btn.textContent = 'Deleting...';
        
        window.location.href = `delete.php?id=${id}`;
    }
    
    return false;
}

// Filter tasks function (used in list.php)
function filterTasks() {
    const status = document.getElementById('statusFilter')?.value || 'all';
    const sort = document.getElementById('sortBy')?.value || 'created_at';
    const order = document.getElementById('orderBy')?.value || 'DESC';
    
    // Build URL with parameters
    const url = new URL(window.location.href);
    url.searchParams.set('status', status);
    url.searchParams.set('sort', sort);
    url.searchParams.set('order', order);
    
    // Add loading indicator
    document.body.style.cursor = 'wait';
    
    window.location.href = url.toString();
}

// Character counter for textarea
document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea');
    
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        
        if (maxLength) {
            const counter = document.createElement('div');
            counter.className = 'char-counter';
            counter.style.textAlign = 'right';
            counter.style.fontSize = '0.875rem';
            counter.style.color = '#999';
            counter.style.marginTop = '0.25rem';
            
            textarea.parentNode.appendChild(counter);
            
            const updateCounter = () => {
                const remaining = maxLength - textarea.value.length;
                counter.textContent = `${remaining} characters remaining`;
                
                if (remaining < 50) {
                    counter.style.color = '#dc3545';
                } else {
                    counter.style.color = '#999';
                }
            };
            
            textarea.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
});

// Add animation to cards on scroll
function animateOnScroll() {
    const cards = document.querySelectorAll('.task-card, .stat-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.5s ease-out';
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    cards.forEach(card => observer.observe(card));
}

// Add CSS animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);

// Initialize animations when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', animateOnScroll);
} else {
    animateOnScroll();
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search (if exists)
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) searchInput.focus();
    }
    
    // Escape to close modals or cancel forms
    if (e.key === 'Escape') {
        const cancelBtn = document.getElementById('cancelBtn');
        if (cancelBtn && cancelBtn.style.display !== 'none') {
            cancelBtn.click();
        }
    }
});

// Add tooltips to buttons
document.addEventListener('DOMContentLoaded', function() {
    const buttons = {
        'btn-success': 'Edit this task',
        'btn-danger': 'Delete this task',
        'btn-info': 'View task details'
    };
    
    Object.keys(buttons).forEach(className => {
        document.querySelectorAll(`.${className}`).forEach(btn => {
            if (!btn.hasAttribute('title')) {
                btn.setAttribute('title', buttons[className]);
            }
        });
    });
});