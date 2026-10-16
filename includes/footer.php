    </main>
    <!-- Main Content Area Ends -->

    <!-- Toast Container for Dynamic Notifications -->
    <div class="toast-container" id="toastContainer" aria-live="polite" aria-atomic="true"></div>

    <!-- Semantic Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand & Mission -->
                <div class="footer-brand">
                    <div class="nav-brand" style="margin-bottom: 0.75rem;">
                        <div class="brand-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: currentColor;">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18l7 3.11v4.71c0 4.54-3.14 8.78-7 9.87-3.86-1.09-7-5.33-7-9.87V6.29l7-3.11z"/>
                            </svg>
                        </div>
                        <div class="brand-text">Cyber<span>Safe</span></div>
                    </div>
                    <p>
                        An interactive educational platform empowering students to understand cyber threats, detect sophisticated phishing indicators, and develop healthy digital defense habits.
                    </p>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.75rem;">
                        ⚠️ <strong>Educational Sandbox:</strong> All phishing examples and domains are strictly fictional and intended exclusively for benign defensive instruction.
                    </p>
                </div>

                <!-- Fast Navigation -->
                <div class="footer-links">
                    <h4>Learning Modules</h4>
                    <ul>
                        <li><a href="learn.php#topic-phishing">Phishing Attacks</a></li>
                        <li><a href="learn.php#topic-malware">Malware & Ransomware</a></li>
                        <li><a href="learn.php#topic-passwords">Password Hygiene</a></li>
                        <li><a href="learn.php#topic-social-eng">Social Engineering</a></li>
                        <li><a href="learn.php#topic-wifi">Public Wi-Fi Safety</a></li>
                        <li><a href="learn.php#topic-mfa">Multi-Factor Auth (MFA)</a></li>
                    </ul>
                </div>

                <!-- Practical Tools & Student Resources -->
                <div class="footer-links">
                    <h4>Interactive Tools</h4>
                    <ul>
                        <li><a href="simulator.php">Phishing Simulator</a></li>
                        <li><a href="quiz.php">15-Question Cyber Quiz</a></li>
                        <li><a href="dashboard.php">Student Dashboard</a></li>
                        <li><a href="feedback.php">Submit Feedback</a></li>
                        <li><a href="login.php">Student Account / Guest</a></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom Bar -->
            <div class="footer-bottom">
                <div>
                    &copy; <?= date('Y') ?> CyberSafe Project. College Web Programming &amp; Cybersecurity Portal.
                </div>
                <div>
                    Built with <strong>HTML5 &bull; CSS3 &bull; Vanilla JS &bull; PHP &bull; MySQL</strong>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global JavaScript Application Logic -->
    <script src="assets/js/main.js"></script>
    <?php if (!empty($page_scripts) && is_array($page_scripts)): ?>
        <?php foreach ($page_scripts as $script): ?>
            <script src="<?= sanitize($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
