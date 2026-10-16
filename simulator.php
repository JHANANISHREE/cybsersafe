<?php
/**
 * CyberSafe — Phishing Awareness Simulator
 * Hands-on safe sandbox where students inspect realistic emails, spot red flags,
 * identify legitimate vs malicious messages, and receive immediate debriefs.
 */

$page_title = 'Phishing Simulator — Safe Threat Inspector';
$active_nav = 'simulator';
$page_scripts = ['assets/js/simulator.js'];

require_once __DIR__ . '/includes/header.php';
?>

<div class="container simulator-container">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <span class="badge badge-red" style="margin-bottom: 0.75rem;">Educational Sandbox</span>
        <h1>Phishing Threat Simulator</h1>
        <p class="lead" style="max-width: 720px; margin: 0 auto;">
            Inspect these five realistic email messages. Examine the sender addresses, hover over links to inspect destination URLs, check for urgency tactics, and decide whether each message is <strong>Phishing</strong> or <strong>Legitimate</strong>.
        </p>
        <div style="margin-top: 1rem; font-size: 0.85rem; color: #94a3b8;">
            🛡️ <em>All scenarios use fictional names and addresses for benign educational instruction only.</em>
        </div>
    </div>

    <!-- Simulator Navigation & Score Tracker -->
    <div class="simulator-header">
        <div>
            <strong style="color: var(--text-primary); margin-right: 0.75rem;">Select Scenario:</strong>
            <div class="simulator-scenario-nav" id="scenarioNav">
                <button type="button" class="scenario-pill active" data-index="0">Case 1: IT Reset</button>
                <button type="button" class="scenario-pill" data-index="1">Case 2: Library</button>
                <button type="button" class="scenario-pill" data-index="2">Case 3: Grant</button>
                <button type="button" class="scenario-pill" data-index="3">Case 4: Delivery</button>
                <button type="button" class="scenario-pill" data-index="4">Case 5: SysAdmin</button>
            </div>
        </div>

        <!-- Simulator Score Badge -->
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="font-size: 0.9rem;">
                <span style="color: var(--text-muted);">Accuracy:</span>
                <strong id="simAccuracyText" style="color: var(--accent-cyan); font-size: 1.1rem;">0%</strong>
                <span style="color: var(--text-muted); font-size: 0.8rem;" id="simScoreCount">(0/5)</span>
            </div>
            <button type="button" class="btn btn-outline btn-sm" id="btnResetSimulator" title="Reset all scenarios">Reset All</button>
        </div>
    </div>

    <!-- Mock Email Client Window -->
    <div class="email-client" id="emailClientWindow">
        <!-- Message Metadata -->
        <div class="email-meta">
            <div class="email-row">
                <span class="email-label">From:</span>
                <span class="email-value" id="emailFrom">
                    <!-- Populated via simulator.js -->
                </span>
            </div>
            <div class="email-row">
                <span class="email-label">To:</span>
                <span class="email-value" id="emailTo">student.jhanani@apex-university.edu</span>
            </div>
            <div class="email-row">
                <span class="email-label">Date:</span>
                <span class="email-value" id="emailDate">Today, 09:41 AM</span>
            </div>
            <div class="email-subject" id="emailSubject">
                <!-- Subject populated dynamically -->
            </div>
        </div>

        <!-- Email Body Content -->
        <div class="email-body" id="emailBody">
            <!-- Email Body Content populated dynamically -->
        </div>

        <!-- Email Attachment Container (if any) -->
        <div id="emailAttachmentContainer" style="padding: 0 1.5rem 1.5rem 1.5rem; display: none;">
            <!-- Attachment details populated dynamically -->
        </div>
    </div>

    <!-- Red Flags Discovery Checklist -->
    <div class="card" style="margin-top: 1.75rem;">
        <h4 style="margin-bottom: 0.5rem; color: var(--accent-cyan);">🔎 Identify Warning Signs (Red Flags)</h4>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">
            Before making your final verdict, check any suspicious indicators you noticed in this email:
        </p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 0.75rem;" id="redFlagsChecklist">
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" value="domain" class="flag-check"> Spoofed / Suspicious Sender Domain
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" value="urgency" class="flag-check"> Extreme Urgency or Coercive Threat
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" value="url" class="flag-check"> Misleading Link / Lookalike URL
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" value="credentials" class="flag-check"> Request for Credentials / Financial Data
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" value="attachment" class="flag-check"> Dangerous or Unexpected Attachment
            </label>
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" value="generic" class="flag-check"> Generic Greeting / Impersonal Tone
            </label>
        </div>
    </div>

    <!-- Verdict Action Buttons -->
    <div class="simulator-verdict-box" id="verdictBox">
        <h3>What is your verdict on this message?</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem;">
            Analyze the evidence above and submit your assessment.
        </p>
        <div class="simulator-verdict-buttons">
            <button type="button" class="btn btn-danger btn-lg" id="btnVerdictPhishing">
                <span aria-hidden="true">🚩</span> Flag as Phishing Attack
            </button>
            <button type="button" class="btn btn-success btn-lg" id="btnVerdictLegitimate">
                <span aria-hidden="true">🛡️</span> Verify as Legitimate Email
            </button>
        </div>
    </div>

    <!-- Educational Feedback Debrief -->
    <div class="simulator-feedback" id="simulatorFeedback">
        <div id="feedbackBanner" style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem;">
            <!-- Feedback title injected dynamically -->
        </div>
        <div id="feedbackExplanation" style="line-height: 1.7; font-size: 1rem; color: var(--text-secondary);">
            <!-- Explanation injected dynamically -->
        </div>
        <div id="feedbackKeyTakeaway" class="edu-callout" style="margin-top: 1.5rem;">
            <!-- Key takeaway rule injected dynamically -->
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
            <button type="button" class="btn btn-primary" id="btnNextScenario">Proceed to Next Case &rarr;</button>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
