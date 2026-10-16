/**
 * CyberSafe — Main Application JavaScript
 * Global navigation, mobile drawer, toast notification engine, and UI utilities.
 * Pure Vanilla JavaScript — Zero Framework Dependencies.
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Navigation Hamburger Toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function () {
            const isOpen = navMenu.classList.toggle('open');
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            navToggle.innerHTML = isOpen ? '&times;' : '&#9776;';
        });

        // Close mobile drawer when clicking any link
        navMenu.querySelectorAll('.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                navMenu.classList.remove('open');
                navToggle.setAttribute('aria-expanded', 'false');
                navToggle.innerHTML = '&#9776;';
            });
        });
    }

    // 2. Global Escape Key Listener for Modals and Menus
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            // Close open mobile menu
            if (navMenu && navMenu.classList.contains('open')) {
                navMenu.classList.remove('open');
                if (navToggle) {
                    navToggle.setAttribute('aria-expanded', 'false');
                    navToggle.innerHTML = '&#9776;';
                }
            }

            // Close open learn modals
            document.querySelectorAll('.learn-modal.active').forEach(function (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
    });
});

/**
 * Global Toast Notification Generator
 * @param {string} message - Text notification to display
 * @param {string} type - 'success', 'danger', 'info', or 'warning'
 * @param {number} durationMs - Display time before auto-dismissal
 */
function showToast(message, type = 'success', durationMs = 3500) {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type === 'danger' ? 'danger' : 'success'}`;
    toast.setAttribute('role', 'alert');

    const icon = type === 'danger' ? '⚠️' : '✅';
    toast.innerHTML = `
        <span style="font-size: 1.1rem;" aria-hidden="true">${icon}</span>
        <span style="flex: 1;">${message}</span>
        <button type="button" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1.1rem; line-height: 1;" aria-label="Close">&times;</button>
    `;

    // Dismiss on close button
    const closeBtn = toast.querySelector('button');
    closeBtn.addEventListener('click', function () {
        dismissToast(toast);
    });

    container.appendChild(toast);

    // Auto dismiss
    setTimeout(function () {
        dismissToast(toast);
    }, durationMs);
}

function dismissToast(toast) {
    if (!toast || !toast.parentNode) return;
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(30px)';
    toast.style.transition = 'all 0.25s ease';
    setTimeout(function () {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 250);
}
