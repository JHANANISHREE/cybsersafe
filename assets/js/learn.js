/**
 * CyberSafe — Learning Center JavaScript
 * Handles educational detail modals, dynamic progress calculation,
 * and asynchronous "Mark as Completed" toggles.
 */

document.addEventListener('DOMContentLoaded', function () {
    const STORAGE_KEY = 'cybersafe_completed_topics';
    const totalTopics = 6;

    // Load local storage fallback state
    let completedSet = new Set();
    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
            JSON.parse(stored).forEach(slug => completedSet.add(slug));
        }
    } catch (e) {
        // Fallback gracefully
    }

    // Sync cards that already have 'completed' class from server PHP
    document.querySelectorAll('.topic-card.completed').forEach(function (card) {
        const slug = card.getAttribute('data-slug');
        if (slug) completedSet.add(slug);
    });

    // Apply initial progress bar state
    updateProgressDisplay();

    // 1. Modal Open / Close Handlers
    document.querySelectorAll('.btn-open-modal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = btn.getAttribute('data-target');
            const modal = document.getElementById(targetId);
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent background scroll
            }
        });
    });

    document.querySelectorAll('.learn-modal-close, .btn-close-modal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const modal = btn.closest('.learn-modal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close modal when clicking outside the modal content box
    document.querySelectorAll('.learn-modal').forEach(function (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // 2. Mark as Completed Toggle Handlers
    document.querySelectorAll('.btn-toggle-complete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const slug = btn.getAttribute('data-slug');
            if (!slug) return;

            const isCurrentlyDone = completedSet.has(slug);
            const newStatus = !isCurrentlyDone;

            if (newStatus) {
                completedSet.add(slug);
            } else {
                completedSet.delete(slug);
            }

            // Save to localStorage
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(Array.from(completedSet)));
            } catch (e) {}

            // Update DOM Elements for this topic
            syncTopicDom(slug, newStatus);
            updateProgressDisplay();

            // Send AJAX update to backend API
            sendProgressToBackend(slug, newStatus ? 'completed' : 'pending');

            // Feedback Toast
            if (newStatus) {
                showToast(`Module marked as completed!`, 'success');
            } else {
                showToast(`Module progress reset to uncompleted.`, 'info');
            }
        });
    });

    /**
     * Synchronize DOM elements for a given topic
     */
    function syncTopicDom(slug, isDone) {
        const card = document.getElementById(`topic-${slug}`);
        if (card) {
            if (isDone) {
                card.classList.add('completed');
            } else {
                card.classList.remove('completed');
            }
        }

        // Update all buttons for this slug (both on card and in modal)
        document.querySelectorAll(`.btn-toggle-complete[data-slug="${slug}"]`).forEach(function (button) {
            if (isDone) {
                button.className = 'btn btn-sm btn-toggle-complete btn-success';
                button.textContent = '✓ Completed';
            } else {
                button.className = 'btn btn-sm btn-toggle-complete btn-outline';
                button.textContent = 'Mark as Done';
            }
        });
    }

    /**
     * Update progress counter and progress bar width
     */
    function updateProgressDisplay() {
        const count = completedSet.size;
        const percent = Math.min(100, Math.round((count / totalTopics) * 100));

        const counterText = document.getElementById('progressCounterText');
        const progressBar = document.getElementById('learnProgressBar');

        if (counterText) {
            counterText.textContent = `${count} of ${totalTopics} Completed`;
        }

        if (progressBar) {
            progressBar.style.width = `${percent}%`;
            progressBar.setAttribute('aria-valuenow', percent);
        }

        // Apply completed styling to any cards matching the set
        completedSet.forEach(function (slug) {
            syncTopicDom(slug, true);
        });
    }

    /**
     * Send asynchronous progress update to PHP backend
     */
    function sendProgressToBackend(slug, status) {
        fetch('api/update_progress.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                slug: slug,
                status: status
            })
        })
        .then(response => response.json())
        .catch(err => {
            // Silently fallback to local storage
            console.log('Progress stored locally (Standalone mode)');
        });
    }
});
