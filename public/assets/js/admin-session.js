/**
 * Admin Session Management
 * Handles admin authentication and session refresh
 */

class AdminSessionManager {
    constructor() {
        this.sessionCheckInterval = null;
        this.sessionTimeout = 30 * 60 * 1000; // 30 minutes
        this.lastActivity = Date.now();
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.startSessionCheck();
        this.checkSessionOnPageLoad();
    }

    setupEventListeners() {
        // Track user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, () => {
                this.lastActivity = Date.now();
            });
        });

        // Check session before form submission
        document.addEventListener('submit', (e) => {
            if (!this.isSessionValid()) {
                e.preventDefault();
                this.handleSessionExpired();
            }
        });

        // Check session before navigation
        document.addEventListener('click', (e) => {
            if (e.target.tagName === 'A' && e.target.href && !e.target.href.includes('logout')) {
                if (!this.isSessionValid()) {
                    e.preventDefault();
                    this.handleSessionExpired();
                }
            }
        });
    }

    startSessionCheck() {
        // Check session every 5 minutes
        this.sessionCheckInterval = setInterval(() => {
            this.checkSession();
        }, 5 * 60 * 1000);
    }

    async checkSession() {
        try {
            const response = await fetch('/admin/check-auth', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                this.handleSessionExpired();
                return false;
            }

            const data = await response.json();
            if (!data.authenticated) {
                this.handleSessionExpired();
                return false;
            }

            return true;
        } catch (error) {
            console.error('Session check failed:', error);
            this.handleSessionExpired();
            return false;
        }
    }

    async checkSessionOnPageLoad() {
        const isValid = await this.checkSession();
        if (!isValid) {
            this.handleSessionExpired();
        }
    }

    isSessionValid() {
        const timeSinceLastActivity = Date.now() - this.lastActivity;
        return timeSinceLastActivity < this.sessionTimeout;
    }

    async refreshSession() {
        try {
            const response = await fetch('/admin/refresh-session', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success) {
                    this.lastActivity = Date.now();
                    return true;
                }
            }

            return false;
        } catch (error) {
            console.error('Session refresh failed:', error);
            return false;
        }
    }

    handleSessionExpired() {
        // Show session expired modal
        this.showSessionExpiredModal();
        
        // Redirect to login after a delay
        setTimeout(() => {
            window.location.href = '/admin/login';
        }, 3000);
    }

    showSessionExpiredModal() {
        // Create modal if it doesn't exist
        if (!document.getElementById('session-expired-modal')) {
            const modal = document.createElement('div');
            modal.id = 'session-expired-modal';
            modal.className = 'modal fade show';
            modal.style.display = 'block';
            modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle"></i> Session Expired
                            </h5>
                        </div>
                        <div class="modal-body">
                            <p>Your session has expired due to inactivity. You will be redirected to the login page.</p>
                            <p>If you want to continue working, please log in again.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="window.location.href='/admin/login'">
                                Login Now
                            </button>
                        </div>
                    </div>
                </div>
            `;

            // Add backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.id = 'session-expired-backdrop';

            document.body.appendChild(backdrop);
            document.body.appendChild(modal);
        }
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
               document.querySelector('input[name="_token"]')?.value;
    }

    destroy() {
        if (this.sessionCheckInterval) {
            clearInterval(this.sessionCheckInterval);
        }
    }
}

// Initialize session manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.adminSessionManager = new AdminSessionManager();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AdminSessionManager;
}
