/**
 * CyberSafe — Phishing Awareness Simulator JavaScript
 * Manages 5 realistic educational scenarios, hotspot hover inspections,
 * red-flag validation, verdict adjudication, and accuracy scoring.
 */

document.addEventListener('DOMContentLoaded', function () {
    const scenarios = [
        {
            id: 'scenario_0',
            title: 'Case 1: IT Reset',
            type: 'phishing',
            from: 'Apex IT HelpDesk &lt;admin-support@apex-univ-portal-verify.net&gt;',
            subject: 'CRITICAL ACTION REQUIRED: Your University Portal Access Expires in 2 Hours',
            date: 'Today, 08:15 AM',
            body: `
                <p>Dear Student,</p>
                <p>Our central directory security systems detected multiple unauthorized login attempts on your institutional account. Your portal access and exam registration privilege have been flagged for <strong>immediate termination</strong>.</p>
                <p>To avoid permanent cancellation, you must confirm your student credentials and password within <strong>120 minutes</strong> via our security server:</p>
                <p style="margin: 1.5rem 0;">
                    <a href="javascript:void(0)" class="interactive-hotspot" data-tooltip="Real destination: http://apex-univ-portal-verify.net/auth/login.php (External spoofed domain!)">
                        https://apex-university.edu/login-security-verification
                        <span class="tooltip">Destination: http://apex-univ-portal-verify.net/login.php (Spoofed Domain!)</span>
                    </a>
                </p>
                <p style="color: #ef4444; font-weight: 600;">Failure to comply before 10:15 AM will lock all campus library and examination portal services.</p>
                <p>Apex University Information Systems Service</p>
            `,
            attachment: null,
            clues: [
                'Lookalike Sender Domain: The sender address ends in @apex-univ-portal-verify.net instead of official @apex-university.edu.',
                'Artificial Urgency: 120-minute countdown designed to induce panic and bypass logical thinking.',
                'Disguised Hyperlink: The text reads apex-university.edu, but the actual target URL leads to an external phishing landing page.'
            ],
            takeaway: 'Rule #1: University IT administrators will never issue 2-hour emergency ultimatums threatening to erase your exam records over email. When in doubt, navigate independently to the known official campus portal.'
        },
        {
            id: 'scenario_1',
            title: 'Case 2: Library',
            type: 'legitimate',
            from: 'Apex University Library &lt;library-services@apex-university.edu&gt;',
            subject: 'Notice: Borrowed Library Book Due on Friday (CS204 Database Systems)',
            date: 'Yesterday, 02:40 PM',
            body: `
                <p>Dear Jhanani Shree V,</p>
                <p>This is a standard informational courtesy reminder that your borrowed textbook has an upcoming due date:</p>
                <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 8px; margin: 1rem 0; border: 1px solid var(--border-color);">
                    <strong>Title:</strong> Database System Concepts (7th Edition)<br>
                    <strong>Barcode:</strong> <code>APX-LIB-88412</code><br>
                    <strong>Due Date:</strong> Friday, October 16th, by 5:00 PM
                </div>
                <p>If you wish to renew your lending period, you can log in to your library account via the central university portal or visit the ground-floor circulation desk during operating hours.</p>
                <p>No action is required if you have already returned this volume.</p>
                <p>Best regards,<br>Apex Central Library Circulation Desk</p>
            `,
            attachment: null,
            clues: [
                'Authentic Domain: Originates from the genuine verified university domain (@apex-university.edu).',
                'Personalized Information: Refers to the student by full name with exact book title and library barcode.',
                'No Suspicious Action Requested: No external links, no emergency passwords, and no coercion.'
            ],
            takeaway: 'Rule #2: Legitimate service notifications provide specific, verifiable context (like item barcodes and standard deadlines) without demanding immediate password submissions.'
        },
        {
            id: 'scenario_2',
            title: 'Case 3: Grant',
            type: 'phishing',
            from: 'Dean Research Fellowship Committee &lt;academic-scholarship-grants@gmail-grants.org&gt;',
            subject: 'CONGRATULATIONS: You have been selected for the $5,000 Academic Excellence Fellowship',
            date: 'Today, 11:05 AM',
            body: `
                <p>Attention Selected Student,</p>
                <p>We are delighted to notify you that based on your academic standing in Computer Science, you have been awarded an unrestricted <strong>$5,000 Research Fellowship Grant</strong> funded by our external alumni endowment foundation.</p>
                <p>To prepare your electronic wire transfer, please open the attached official acceptance document, enable document macros to auto-verify your system, and fill out your direct bank account and national tax identity details.</p>
                <p>Please return the completed form today to ensure processing in this financial cycle.</p>
                <p>Fellowship Selection Office</p>
            `,
            attachment: {
                name: 'Fellowship_Grant_Application_Form.pdf.exe',
                size: '2.4 MB',
                icon: '📄'
            },
            clues: [
                'Dangerous Double Extension: The attachment Fellowship_Grant_Application_Form.pdf.exe is an executable program (.exe) masquerading as a PDF document.',
                'Suspicious Third-Party Domain: Uses a free lookalike domain (@gmail-grants.org) instead of institutional accreditation.',
                'Request for Macros & Banking Data: Urges users to enable macros (common malware distribution vector) and transmit financial secrets.',
                'Generic Greeting: Impersonal "Attention Selected Student" greeting.'
            ],
            takeaway: 'Rule #3: Never execute files with hidden or double extensions (.pdf.exe, .docx.scr). Operating systems often hide known extensions, allowing trojans to disguise themselves as documents.'
        },
        {
            id: 'scenario_3',
            title: 'Case 4: Delivery',
            type: 'phishing',
            from: 'Apex Express Logistics &lt;tracking-delivery@fast-courier-updates.top&gt;',
            subject: 'Delivery Alert: Package #EXP-99214 pending unpaid customs fee ($2.85)',
            date: 'Today, 06:22 AM',
            body: `
                <p>Hello Customer,</p>
                <p>Our courier driver attempted delivery of your registered parcel this morning, but could not proceed due to an unpaid regulatory clearance fee of <strong>$2.85</strong>.</p>
                <p>To confirm your delivery window and authorize payment, click the secure payment gateway link below within 24 hours:</p>
                <p style="margin: 1.5rem 0;">
                    <a href="javascript:void(0)" class="interactive-hotspot" data-tooltip="Real destination: http://pay-customs-fast.top/card-entry (Card skimmer)">
                        https://fast-courier-updates.top/pay-fee?id=EXP-99214
                        <span class="tooltip">Destination: http://pay-customs-fast.top/card-entry (Fake Gateway!)</span>
                    </a>
                </p>
                <p>Unclaimed parcels will be returned to origin warehouse and destroyed.</p>
            `,
            attachment: null,
            clues: [
                'Micro-Payment Trap: Requesting a trivial $2.85 fee is a classic tactic to get victims to enter their credit card numbers and CVVs into a fraudulent form.',
                'Suspicious Top-Level Domain: Legitimate shipping companies do not operate out of random .top or .biz domains.',
                'Impersonal Customer Salutation: Addressed to "Hello Customer" without tracking order specifics.'
            ],
            takeaway: 'Rule #4: Smishing and delivery scams use low-dollar charges as bait. The attackers are not after $2.85; they want your 16-digit card number, expiration date, and CVV code.'
        },
        {
            id: 'scenario_4',
            title: 'Case 5: SysAdmin',
            type: 'legitimate',
            from: 'Campus Systems Engineering &lt;sysadmin@apex-university.edu&gt;',
            subject: 'Advisory: Campus Network & Server Maintenance (Sunday 02:00 - 05:00 AM)',
            date: 'Yesterday, 04:15 PM',
            body: `
                <p>Greetings Engineering Students &amp; Faculty,</p>
                <p>The Department of Computer Science and Campus Infrastructure will be performing routine switch firmware updates and core server maintenance this coming <strong>Sunday between 02:00 AM and 05:00 AM IST</strong>.</p>
                <p>During this scheduled maintenance window:</p>
                <ul style="padding-left: 1.25rem; margin-bottom: 1rem;">
                    <li>Internal campus git repositories and virtual lab access will be temporarily intermittent.</li>
                    <li>Residential hall Wi-Fi internet access will continue functioning normally.</li>
                    <li>No stored user data or course files will be affected.</li>
                </ul>
                <p>If you experience connectivity issues after 05:30 AM Sunday, please notify the Lab Helpdesk at <strong>Extension 4022</strong> (Room CS-102).</p>
                <p>Regards,<br>Campus Systems Operations Team</p>
            `,
            attachment: null,
            clues: [
                'Genuine Sender Address: Uses authentic sysadmin@apex-university.edu domain.',
                'Off-Peak Maintenance: Routine work scheduled during non-business overnight hours (Sunday 2 AM - 5 AM).',
                'No Links or Credentials: Does not ask anyone to verify accounts, click links, or input passwords.',
                'Verifiable Support Contacts: Lists real internal physical office (Room CS-102) and telephone extension.'
            ],
            takeaway: 'Rule #5: Routine maintenance notices notify you of scheduled downtime ahead of time. They will never ask you to authenticate or share passwords.'
        }
    ];

    let currentScenarioIndex = 0;
    const resolvedScenarios = {}; // maps scenario_index => { isCorrect: bool, verdict: string }

    // DOM Elements
    const emailFrom = document.getElementById('emailFrom');
    const emailSubject = document.getElementById('emailSubject');
    const emailDate = document.getElementById('emailDate');
    const emailBody = document.getElementById('emailBody');
    const emailAttachmentContainer = document.getElementById('emailAttachmentContainer');
    const scenarioNav = document.getElementById('scenarioNav');
    const simAccuracyText = document.getElementById('simAccuracyText');
    const simScoreCount = document.getElementById('simScoreCount');
    const btnVerdictPhishing = document.getElementById('btnVerdictPhishing');
    const btnVerdictLegitimate = document.getElementById('btnVerdictLegitimate');
    const simulatorFeedback = document.getElementById('simulatorFeedback');
    const feedbackBanner = document.getElementById('feedbackBanner');
    const feedbackExplanation = document.getElementById('feedbackExplanation');
    const feedbackKeyTakeaway = document.getElementById('feedbackKeyTakeaway');
    const btnNextScenario = document.getElementById('btnNextScenario');
    const btnResetSimulator = document.getElementById('btnResetSimulator');

    // Load initial scenario
    renderScenario(currentScenarioIndex);

    // 1. Scenario Tab Switching
    scenarioNav.querySelectorAll('.scenario-pill').forEach(function (pill) {
        pill.addEventListener('click', function () {
            const index = parseInt(pill.getAttribute('data-index'), 10);
            if (!isNaN(index)) {
                currentScenarioIndex = index;
                renderScenario(currentScenarioIndex);
            }
        });
    });

    // 2. Verdict Submissions
    btnVerdictPhishing.addEventListener('click', function () {
        submitVerdict('phishing');
    });

    btnVerdictLegitimate.addEventListener('click', function () {
        submitVerdict('legitimate');
    });

    // 3. Next Scenario Button
    btnNextScenario.addEventListener('click', function () {
        currentScenarioIndex = (currentScenarioIndex + 1) % scenarios.length;
        renderScenario(currentScenarioIndex);
    });

    // 4. Reset Button
    btnResetSimulator.addEventListener('click', function () {
        for (let key in resolvedScenarios) delete resolvedScenarios[key];
        currentScenarioIndex = 0;
        updateScoreDisplay();
        renderScenario(0);
        showToast('Simulator progress reset.', 'info');
    });

    /**
     * Render the active scenario content
     */
    function renderScenario(index) {
        const scenario = scenarios[index];
        if (!scenario) return;

        // Update Nav Pills
        scenarioNav.querySelectorAll('.scenario-pill').forEach(function (pill, pIdx) {
            pill.classList.remove('active');
            if (pIdx === index) {
                pill.classList.add('active');
            }
        });

        // Populate email metadata
        emailFrom.innerHTML = scenario.from;
        emailSubject.textContent = scenario.subject;
        emailDate.textContent = scenario.date;
        emailBody.innerHTML = scenario.body;

        // Attachment
        if (scenario.attachment) {
            emailAttachmentContainer.style.display = 'block';
            emailAttachmentContainer.innerHTML = `
                <div class="email-attachment">
                    <span style="font-size: 1.5rem;" aria-hidden="true">${scenario.attachment.icon}</span>
                    <div>
                        <strong style="color: var(--text-primary);">${scenario.attachment.name}</strong>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Size: ${scenario.attachment.size} &bull; Security Status: Unverified</div>
                    </div>
                </div>
            `;
        } else {
            emailAttachmentContainer.style.display = 'none';
            emailAttachmentContainer.innerHTML = '';
        }

        // Reset Red Flag Checkboxes
        document.querySelectorAll('.flag-check').forEach(function (chk) {
            chk.checked = false;
        });

        // If this scenario has already been evaluated, show previous result
        if (resolvedScenarios[index]) {
            showEvaluationDebrief(scenario, resolvedScenarios[index].isCorrect, resolvedScenarios[index].verdict);
        } else {
            simulatorFeedback.style.display = 'none';
            btnVerdictPhishing.disabled = false;
            btnVerdictLegitimate.disabled = false;
        }

        // Scroll smoothly to simulator header
        const simContainer = document.getElementById('emailClientWindow');
        if (simContainer) {
            simContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    /**
     * Evaluate the user verdict
     */
    function submitVerdict(userVerdict) {
        const scenario = scenarios[currentScenarioIndex];
        if (!scenario) return;

        const isCorrect = (userVerdict === scenario.type);
        resolvedScenarios[currentScenarioIndex] = {
            isCorrect: isCorrect,
            verdict: userVerdict
        };

        // Update nav pill color
        const activePill = scenarioNav.querySelector(`.scenario-pill[data-index="${currentScenarioIndex}"]`);
        if (activePill) {
            if (isCorrect) {
                activePill.classList.remove('resolved-phish');
                activePill.classList.add('resolved-safe');
            } else {
                activePill.classList.remove('resolved-safe');
                activePill.classList.add('resolved-phish');
            }
        }

        // Update score calculations
        updateScoreDisplay();

        // Show debrief
        showEvaluationDebrief(scenario, isCorrect, userVerdict);

        // Send attempt to server API
        sendAttemptToBackend(scenario.id, userVerdict, isCorrect);

        // Feedback toast
        if (isCorrect) {
            showToast('Correct Assessment! Well done.', 'success');
        } else {
            showToast('Warning: Incorrect Assessment! Check debrief below.', 'danger');
        }
    }

    /**
     * Display comprehensive educational debrief
     */
    function showEvaluationDebrief(scenario, isCorrect, userVerdict) {
        simulatorFeedback.style.display = 'block';
        simulatorFeedback.className = `simulator-feedback ${isCorrect ? 'correct' : 'incorrect'}`;

        if (isCorrect) {
            feedbackBanner.innerHTML = `
                <span style="color: var(--accent-green); font-size: 1.5rem;">✅</span>
                <span style="color: var(--accent-green);">CORRECT ASSESSMENT!</span>
            `;
        } else {
            feedbackBanner.innerHTML = `
                <span style="color: var(--accent-red); font-size: 1.5rem;">⚠️</span>
                <span style="color: var(--accent-red);">INCORRECT ASSESSMENT!</span>
            `;
        }

        let verdictDesc = '';
        if (scenario.type === 'phishing') {
            verdictDesc = `<p>This email was indeed a <strong>Phishing Attack</strong>. You classified it as <em>${userVerdict}</em>.</p>`;
        } else {
            verdictDesc = `<p>This message was actually <strong>Legitimate</strong>. You classified it as <em>${userVerdict}</em>.</p>`;
        }

        let cluesHtml = '<strong>Critical Warning Signs / Evidence:</strong><ul style="padding-left: 1.25rem; margin-top: 0.5rem;">';
        scenario.clues.forEach(function (clue) {
            cluesHtml += `<li style="margin-bottom: 0.4rem;">${clue}</li>`;
        });
        cluesHtml += '</ul>';

        feedbackExplanation.innerHTML = verdictDesc + cluesHtml;
        feedbackKeyTakeaway.innerHTML = `<h5>🛡️ Defensive Takeaway:</h5><p style="margin: 0;">${scenario.takeaway}</p>`;

        btnVerdictPhishing.disabled = true;
        btnVerdictLegitimate.disabled = true;

        simulatorFeedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Update score display in header
     */
    function updateScoreDisplay() {
        const resolvedKeys = Object.keys(resolvedScenarios);
        const totalSolved = resolvedKeys.length;
        let correctCount = 0;

        resolvedKeys.forEach(function (k) {
            if (resolvedScenarios[k].isCorrect) correctCount++;
        });

        const accuracy = totalSolved > 0 ? Math.round((correctCount / totalSolved) * 100) : 0;

        simAccuracyText.textContent = `${accuracy}%`;
        simScoreCount.textContent = `(${correctCount}/${totalSolved})`;
    }

    /**
     * Record simulation in backend
     */
    function sendAttemptToBackend(scenarioId, userVerdict, isCorrect) {
        fetch('api/record_simulation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                scenario_id: scenarioId,
                user_verdict: userVerdict,
                is_correct: isCorrect ? 1 : 0
            })
        })
        .then(response => response.json())
        .catch(err => {
            console.log('Simulator recorded locally (Standalone mode)');
        });
    }
});
