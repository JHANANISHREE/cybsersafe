/**
 * CyberSafe — Interactive Cyber Quiz Engine
 * 15 Multiple-Choice Questions covering the 6 educational domains.
 * Features single-question stepper, instant feedback, scoring math,
 * detailed review breakdown, and duplicate-submission prevention.
 */

document.addEventListener('DOMContentLoaded', function () {
    const questions = [
        {
            id: 1,
            category: 'Phishing Attacks',
            badgeClass: 'badge-red',
            question: 'You receive an urgent email claiming to be from your university IT team asking you to update your password. Which of the following is the most reliable indicator of a phishing email?',
            options: [
                'The email contains the official university logo at the top',
                'The sender display name says "University IT Helpdesk"',
                'The actual sender email domain is "it-support@univ-portal-update.org" instead of "@university.edu"',
                'The email was sent early in the morning'
            ],
            correctIndex: 2,
            explanation: 'Attackers can easily copy logos and fake friendly display names. The actual sender email domain (the part after @) reveals the true origin server.'
        },
        {
            id: 2,
            category: 'Phishing Attacks',
            badgeClass: 'badge-red',
            question: 'What is the recommended defensive action before clicking any hyperlink received in an unsolicited email?',
            options: [
                'Click the link quickly to see if the website loads safely',
                'Forward the email to all classmates to see if they got it',
                'Hover your cursor over the link to verify that the displayed text matches the actual destination URL preview',
                'Reply to the email asking the sender if the link is safe'
            ],
            correctIndex: 2,
            explanation: 'Hyperlink anchor text can display a legitimate address (like university.edu) while the underlying href attribute routes your browser to a malicious server. Hovering reveals the true destination.'
        },
        {
            id: 3,
            category: 'Phishing Attacks',
            badgeClass: 'badge-red',
            question: 'What distinguishes a "Spear Phishing" attack from traditional generic phishing?',
            options: [
                'It physically targets campus data center hardware',
                'It is customized with specific details about an individual or organization using gathered intelligence',
                'It only targets mobile devices via SMS text messaging',
                'It is completely random and blast-emailed to millions of addresses simultaneously'
            ],
            correctIndex: 1,
            explanation: 'Spear phishing utilizes researched facts (such as your college name, advisor, or active courses) to create highly convincing, tailored messages that are much harder to spot.'
        },
        {
            id: 4,
            category: 'Malware & Ransomware',
            badgeClass: 'badge-amber',
            question: 'Which type of malware disguises itself as legitimate, useful software (such as a pirated game, PDF utility, or cracked IDE) while concealing malicious payloads?',
            options: [
                'Trojan Horse',
                'Network Worm',
                'Distributed Denial of Service (DDoS) Script',
                'Macro Virus'
            ],
            correctIndex: 0,
            explanation: 'Named after the ancient Greek myth, a Trojan Horse tricks the user into installing it by pretending to be legitimate software, while secretly executing malicious code in the background.'
        },
        {
            id: 5,
            category: 'Malware & Ransomware',
            badgeClass: 'badge-amber',
            question: 'What is the primary mechanism and objective of a Ransomware attack?',
            options: [
                'Deleting temporary browser cache files to slow down computer performance',
                'Cryptographically encrypting user files and demanding payment (usually cryptocurrency) for the decryption key',
                'Overclocking your graphics processor until the hardware fails',
                'Sending spam promotional emails to your email contacts'
            ],
            correctIndex: 1,
            explanation: 'Ransomware uses strong mathematical encryption (like AES-256 and RSA) to lock victim files, extorting victims to pay a ransom in exchange for the private decryption key.'
        },
        {
            id: 6,
            category: 'Malware & Ransomware',
            badgeClass: 'badge-amber',
            question: 'How does spyware known as a "Keylogger" pose a grave security risk to developers and students?',
            options: [
                'It secretly records every keystroke typed, capturing usernames, passwords, API tokens, and confidential code',
                'It physically jams mechanical laptop switches',
                'It changes your default keyboard language randomly',
                'It drains the laptop battery by 5%'
            ],
            correctIndex: 0,
            explanation: 'Keyloggers capture sensitive strings directly from input buffers, intercepting credentials before they are even transmitted across the network.'
        },
        {
            id: 7,
            category: 'Password Security',
            badgeClass: 'badge-green',
            question: 'According to modern NIST security guidelines, which of the following passwords has the highest mathematical entropy and resistance against brute-force cracking?',
            options: [
                'P@ss1',
                'Summer2024!',
                'correct-horse-battery-staple',
                'Admin#123'
            ],
            correctIndex: 2,
            explanation: 'Length is the dominant factor in password entropy. A four-word passphrase with 28 characters requires trillions of combinations to brute-force compared to short complex passwords.'
        },
        {
            id: 8,
            category: 'Password Security',
            badgeClass: 'badge-green',
            question: 'What is "Credential Stuffing"?',
            options: [
                'Storing all your passwords in a plaintext text document on your Desktop',
                'An automated attack where leaked username/password combinations from one breached service are tested across many other websites',
                'Using sticky notes to write down computer passwords',
                'Forgetting your security questions during account recovery'
            ],
            correctIndex: 1,
            explanation: 'Because users frequently reuse passwords across multiple sites, attackers use automated botnets to "stuff" leaked breach credentials into thousands of other login endpoints.'
        },
        {
            id: 9,
            category: 'Social Engineering',
            badgeClass: 'badge-cyan',
            question: 'An attacker calls an employee pretending to be an urgent IT technician needing access to reboot a crashed server during an executive presentation. Which technique is this?',
            options: [
                'Pretexting',
                'SQL Injection',
                'Cross-Site Scripting (XSS)',
                'Buffer Overflow'
            ],
            correctIndex: 0,
            explanation: 'Pretexting is the act of creating an invented scenario (pretext) to persuade a targeted victim to release information or perform an action they would not otherwise do.'
        },
        {
            id: 10,
            category: 'Social Engineering',
            badgeClass: 'badge-cyan',
            question: 'You find an unlabeled, brand-new USB flash drive left on a library desk on campus. What is the safest cybersecurity action to take?',
            options: [
                'Plug it into your primary laptop to check if there are personal photos to find the owner',
                'Plug it in only using a private incognito browser window',
                'Hand it over to campus security/lost-and-found without plugging it into any computer',
                'Format the drive immediately on your college computer lab machine'
            ],
            correctIndex: 2,
            explanation: 'This is a classic "Baiting" attack. Malicious USB drives can contain BadUSB microcontrollers that emulate a keyboard to execute malicious payloads within seconds of insertion.'
        },
        {
            id: 11,
            category: 'Social Engineering',
            badgeClass: 'badge-cyan',
            question: 'What is "Tailgating" (also known as piggybacking) in cybersecurity defense?',
            options: [
                'Driving too close to another vehicle in the campus parking lot',
                'An unauthorized person following closely behind an authorized employee through a secure badge-controlled door without badging in',
                'Streaming video over campus Wi-Fi',
                'Monitoring network packets using packet sniffers'
            ],
            correctIndex: 1,
            explanation: 'Tailgating exploits social courtesy (holding doors open for others) to bypass physical access controls and security perimeters.'
        },
        {
            id: 12,
            category: 'Safe Browsing & Wi-Fi',
            badgeClass: 'badge-amber',
            question: 'What is the primary risk of connecting to an unencrypted public Wi-Fi network in a cafe without a VPN?',
            options: [
                'Other devices nearby will run out of internet bandwidth',
                'Attackers on the same local network can perform Man-in-the-Middle (MitM) packet sniffing and session hijacking',
                'Your laptop screen will shut down automatically',
                'Your operating system license will expire'
            ],
            correctIndex: 1,
            explanation: 'On unencrypted public Wi-Fi networks, data packets travel over the air in cleartext, enabling nearby adversaries to capture unencrypted traffic and active session cookies.'
        },
        {
            id: 13,
            category: 'Safe Browsing & Wi-Fi',
            badgeClass: 'badge-amber',
            question: 'Does a padlock icon and "HTTPS" in your browser address bar guarantee that a website is legitimate and safe from phishing?',
            options: [
                'Yes, HTTPS means the website is certified by the government to be 100% legitimate',
                'Yes, cybercriminals cannot obtain SSL/TLS certificates',
                'No, HTTPS only encrypts data in transit; malicious phishing sites can and frequently do acquire valid HTTPS certificates',
                'No, HTTPS means the connection is unencrypted'
            ],
            correctIndex: 2,
            explanation: 'HTTPS only guarantees encryption between your browser and the web server. It does not certify the identity or intentions of the website owner. Many phishing sites use free SSL certificates.'
        },
        {
            id: 14,
            category: 'Multi-Factor Auth',
            badgeClass: 'badge-green',
            question: 'What are the three fundamental authentication factor categories defined in security architecture?',
            options: [
                'Something you know, something you have, and something you are',
                'Username, password, and recovery email',
                'IP address, browser type, and operating system',
                'Laptop, tablet, and mobile phone'
            ],
            correctIndex: 0,
            explanation: 'Multi-Factor Authentication requires at least two factors from distinct categories: Knowledge (passwords/PINs), Possession (tokens/smartphones), and Inherence (biometrics like fingerprints).'
        },
        {
            id: 15,
            category: 'Multi-Factor Auth',
            badgeClass: 'badge-green',
            question: 'Why are Time-based One-Time Password (TOTP) authenticator apps (like Google Authenticator) considered more secure than SMS OTPs?',
            options: [
                'Authenticator apps work even when the phone battery is at 0%',
                'SMS text messages are susceptible to SIM swapping, telecommunication routing attacks, and interception',
                'SMS OTPs charge the user for every message received',
                'Authenticator apps never require a smartphone device'
            ],
            correctIndex: 1,
            explanation: 'SMS relies on mobile carrier infrastructure and is vulnerable to SIM swapping, SS7 attacks, and cellular interception. TOTP codes are generated cryptographically offline on your device.'
        }
    ];

    let currentQuestionIndex = 0;
    let userAnswers = []; // stores selected index for each question
    let isQuestionAnswered = false;
    let quizSubmitted = false;

    // DOM Elements
    const quizCounterText = document.getElementById('quizCounterText');
    const quizScoreRunningText = document.getElementById('quizScoreRunningText');
    const quizProgressBar = document.getElementById('quizProgressBar');
    const questionCategory = document.getElementById('questionCategory');
    const questionText = document.getElementById('questionText');
    const optionsContainer = document.getElementById('optionsContainer');
    const quizExplanationBox = document.getElementById('quizExplanationBox');
    const explanationVerdict = document.getElementById('explanationVerdict');
    const explanationText = document.getElementById('explanationText');
    const btnNextQuestion = document.getElementById('btnNextQuestion');
    const btnRestartEarly = document.getElementById('btnRestartEarly');

    // Results Screen DOM Elements
    const quizActiveArea = document.getElementById('quizActiveArea');
    const quizResultsScreen = document.getElementById('quizResultsScreen');
    const finalScoreNumber = document.getElementById('finalScoreNumber');
    const finalPercentage = document.getElementById('finalPercentage');
    const scoreCircle = document.getElementById('scoreCircle');
    const performanceBadge = document.getElementById('performanceBadge');
    const performanceFeedbackText = document.getElementById('performanceFeedbackText');
    const detailedReviewContainer = document.getElementById('detailedReviewContainer');
    const btnRetakeQuiz = document.getElementById('btnRetakeQuiz');

    // Initialize Quiz
    initQuiz();

    function initQuiz() {
        currentQuestionIndex = 0;
        userAnswers = new Array(questions.length).fill(null);
        isQuestionAnswered = false;
        quizSubmitted = false;

        quizActiveArea.style.display = 'block';
        quizResultsScreen.style.display = 'none';

        renderQuestion(currentQuestionIndex);
    }

    // 1. Next Question Button
    btnNextQuestion.addEventListener('click', function () {
        if (!isQuestionAnswered) return;

        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            renderQuestion(currentQuestionIndex);
        } else {
            // Finish Quiz
            finishQuiz();
        }
    });

    // 2. Early Restart Button
    btnRestartEarly.addEventListener('click', function () {
        if (confirm('Are you sure you want to restart the quiz from Question 1?')) {
            initQuiz();
            showToast('Quiz restarted.', 'info');
        }
    });

    // 3. Retake Quiz from Results Screen
    btnRetakeQuiz.addEventListener('click', function () {
        initQuiz();
    });

    /**
     * Render a single question
     */
    function renderQuestion(index) {
        const q = questions[index];
        if (!q) return;

        isQuestionAnswered = (userAnswers[index] !== null);

        // Update progress counter & progress bar
        const questionNum = index + 1;
        const total = questions.length;
        const percent = Math.round((questionNum / total) * 100);

        quizCounterText.textContent = `Question ${questionNum} of ${total}`;
        quizProgressBar.style.width = `${percent}%`;
        quizProgressBar.setAttribute('aria-valuenow', questionNum);

        // Calculate running score
        let runningScore = 0;
        userAnswers.forEach((ans, qIdx) => {
            if (ans !== null && ans === questions[qIdx].correctIndex) {
                runningScore++;
            }
        });
        quizScoreRunningText.textContent = `Current Score: ${runningScore}`;

        // Category & Question text
        questionCategory.textContent = q.category;
        questionCategory.className = `badge ${q.badgeClass}`;
        questionText.textContent = q.question;

        // Render Options (A, B, C, D)
        optionsContainer.innerHTML = '';
        const prefixes = ['A', 'B', 'C', 'D'];

        q.options.forEach((optText, optIdx) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'quiz-option';
            btn.setAttribute('data-index', optIdx);

            btn.innerHTML = `
                <span class="option-prefix">${prefixes[optIdx]}</span>
                <span>${optText}</span>
            `;

            // If already answered
            if (userAnswers[index] !== null) {
                btn.disabled = true;
                if (optIdx === q.correctIndex) {
                    btn.classList.add('correct');
                } else if (optIdx === userAnswers[index]) {
                    btn.classList.add('incorrect');
                }
            } else {
                btn.addEventListener('click', function () {
                    selectAnswer(optIdx);
                });
            }

            optionsContainer.appendChild(btn);
        });

        // Explanation Box
        if (isQuestionAnswered) {
            showExplanation(q, userAnswers[index]);
            btnNextQuestion.disabled = false;
        } else {
            quizExplanationBox.classList.remove('active');
            btnNextQuestion.disabled = true;
        }

        // Change button label on last question
        if (index === questions.length - 1) {
            btnNextQuestion.textContent = 'Submit Quiz & View Results';
        } else {
            btnNextQuestion.textContent = 'Next Question →';
        }
    }

    /**
     * Handle user option selection
     */
    function selectAnswer(selectedIndex) {
        if (isQuestionAnswered) return;

        isQuestionAnswered = true;
        userAnswers[currentQuestionIndex] = selectedIndex;

        const q = questions[currentQuestionIndex];
        const isCorrect = (selectedIndex === q.correctIndex);

        // Highlight options in DOM
        const optionButtons = optionsContainer.querySelectorAll('.quiz-option');
        optionButtons.forEach((btn, idx) => {
            btn.disabled = true;
            if (idx === q.correctIndex) {
                btn.classList.add('correct');
            } else if (idx === selectedIndex) {
                btn.classList.add('incorrect');
            }
        });

        // Update running score display
        let runningScore = 0;
        userAnswers.forEach((ans, qIdx) => {
            if (ans !== null && ans === questions[qIdx].correctIndex) {
                runningScore++;
            }
        });
        quizScoreRunningText.textContent = `Current Score: ${runningScore}`;

        // Show immediate explanation
        showExplanation(q, selectedIndex);

        // Enable next button
        btnNextQuestion.disabled = false;

        // Feedback toast
        if (isCorrect) {
            showToast('Correct! Great job.', 'success', 2000);
        } else {
            showToast('Incorrect. See explanation below.', 'danger', 2500);
        }
    }

    /**
     * Display explanation box
     */
    function showExplanation(q, selectedIndex) {
        const isCorrect = (selectedIndex === q.correctIndex);
        quizExplanationBox.classList.add('active');

        if (isCorrect) {
            quizExplanationBox.style.borderLeftColor = 'var(--accent-green)';
            explanationVerdict.style.color = 'var(--accent-green)';
            explanationVerdict.innerHTML = '✅ Correct Answer!';
        } else {
            quizExplanationBox.style.borderLeftColor = 'var(--accent-red)';
            explanationVerdict.style.color = 'var(--accent-red)';
            explanationVerdict.innerHTML = '❌ Incorrect. Correct Option: ' + ['A', 'B', 'C', 'D'][q.correctIndex];
        }

        explanationText.textContent = q.explanation;
    }

    /**
     * Complete Quiz, Calculate Final Score & Display Results
     */
    function finishQuiz() {
        if (quizSubmitted) return; // Prevent double submission
        quizSubmitted = true;

        let finalScore = 0;
        const totalQuestions = questions.length;

        userAnswers.forEach((ans, idx) => {
            if (ans === questions[idx].correctIndex) {
                finalScore++;
            }
        });

        const percentage = Math.round((finalScore / totalQuestions) * 100);

        // Switch to Results Screen
        quizActiveArea.style.display = 'none';
        quizResultsScreen.style.display = 'block';

        finalScoreNumber.textContent = `${finalScore}/${totalQuestions}`;
        finalPercentage.textContent = `${percentage}%`;

        // Style score dial and determine tier
        scoreCircle.className = 'score-circle';
        if (percentage >= 80) {
            scoreCircle.classList.add('passed');
            performanceBadge.style.color = 'var(--accent-green)';
            performanceBadge.textContent = '🛡️ Master Cyber Defender (Distinction)';
            performanceFeedbackText.textContent = 'Exceptional performance! You demonstrated thorough understanding of email inspection, ransomware defenses, entropy, and authentication factors.';
        } else if (percentage >= 60) {
            scoreCircle.classList.add('passed');
            performanceBadge.style.color = 'var(--accent-cyan)';
            performanceBadge.textContent = '🔒 Security Practitioner (Passed)';
            performanceFeedbackText.textContent = 'Good work! You have solid awareness of primary attack vectors. Review the missed questions below to solidify your knowledge.';
        } else {
            scoreCircle.classList.add('failed');
            performanceBadge.style.color = 'var(--accent-red)';
            performanceBadge.textContent = '⚠️ Trainee Defender (Review Recommended)';
            performanceFeedbackText.textContent = 'You have grasped some fundamentals, but several critical attack vectors were missed. Please review the detailed explanations below and retake the quiz.';
        }

        // Render detailed 15-question review list
        renderDetailedReview();

        // Send score to backend API
        sendScoreToBackend(finalScore, totalQuestions, percentage);

        // Scroll to top of results
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /**
     * Render the detailed question-by-question review
     */
    function renderDetailedReview() {
        detailedReviewContainer.innerHTML = '';
        const prefixes = ['A', 'B', 'C', 'D'];

        questions.forEach((q, idx) => {
            const userAns = userAnswers[idx];
            const isCorrect = (userAns === q.correctIndex);

            const item = document.createElement('div');
            item.className = `review-item ${isCorrect ? 'right' : 'wrong'}`;

            const userSelectedText = userAns !== null ? `${prefixes[userAns]}) ${q.options[userAns]}` : 'No answer';
            const correctText = `${prefixes[q.correctIndex]}) ${q.options[q.correctIndex]}`;

            item.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <strong style="color: var(--text-primary);">Question ${idx + 1}: ${q.category}</strong>
                    <span class="badge ${isCorrect ? 'badge-green' : 'badge-red'}">${isCorrect ? '✓ Correct' : '✗ Missed'}</span>
                </div>
                <p style="margin-bottom: 0.75rem; color: #e2e8f0; font-weight: 500;">${q.question}</p>
                <div style="font-size: 0.9rem; margin-bottom: 0.4rem;">
                    <span style="color: var(--text-muted);">Your Answer:</span>
                    <strong style="color: ${isCorrect ? 'var(--accent-green)' : 'var(--accent-red)'};">${userSelectedText}</strong>
                </div>
                ${!isCorrect ? `
                    <div style="font-size: 0.9rem; margin-bottom: 0.5rem;">
                        <span style="color: var(--text-muted);">Correct Answer:</span>
                        <strong style="color: var(--accent-green);">${correctText}</strong>
                    </div>
                ` : ''}
                <div style="font-size: 0.85rem; color: var(--text-secondary); background: rgba(0,0,0,0.2); padding: 0.65rem 0.85rem; border-radius: 6px; margin-top: 0.5rem;">
                    <strong>Explanation:</strong> ${q.explanation}
                </div>
            `;

            detailedReviewContainer.appendChild(item);
        });
    }

    /**
     * Send quiz score to backend API
     */
    function sendScoreToBackend(score, total, percentage) {
        fetch('api/submit_quiz.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                score: score,
                total_questions: total,
                percentage: percentage
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Quiz score saved to your student profile!', 'success');
            }
        })
        .catch(err => {
            console.log('Quiz saved locally (Standalone mode)');
        });
    }
});
