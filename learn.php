<?php
/**
 * CyberSafe — Learning Center
 * 6 Modular Cybersecurity Chapters with realistic examples, warning signs,
 * prevention tips, and interactive "Mark as Completed" tracking.
 */

$page_title = 'Learning Center — Cybersecurity Awareness';
$active_nav = 'learn';
$page_scripts = ['assets/js/learn.js'];

require_once __DIR__ . '/includes/header.php';

// Definition of the 6 educational topics
$topics = [
    [
        'slug' => 'phishing',
        'title' => 'Phishing Attacks & Email Spoofing',
        'category' => 'Social Exploits',
        'badge_class' => 'badge-red',
        'icon' => '🎣',
        'read_time' => '5 min read',
        'summary' => 'Deceptive communications masquerading as trustworthy entities to harvest confidential student credentials and financial details.',
        'explanation' => 'Phishing is a cyber attack where threat actors impersonate legitimate institutions—such as college IT departments, academic portals, banks, or online services—to deceive victims into exposing private data like passwords, OTPs, or credit card numbers. Unlike attacks that exploit software bugs, phishing exploits human cognitive vulnerabilities such as curiosity, panic, fear of authority, and urgency.',
        'types' => [
            'Spear Phishing' => 'Targeted attacks customized with specific details about an individual student or staff member.',
            'Whaling' => 'High-profile phishing directed at college deans, department heads, or corporate executives.',
            'Clone Phishing' => 'Replicating a genuine email previously received, replacing safe attachments or links with malicious ones.',
            'Smishing & Vishing' => 'Phishing conducted via SMS text messages or voice/phone calls impersonating bank or tech support.'
        ],
        'example' => 'A student receives an email appearing to come from "admin@univ-portal-support.com" with the subject line "URGENT: Semester Exam Registration Access Suspended Due To Incomplete Verification". The message warns that unless the student logs into a provided link within 2 hours, they will be barred from examinations. The link points to a lookalike domain "univ-portal-login.net/auth".',
        'warning_signs' => [
            'Artificial Urgency: Demands immediate action with threats of account suspension or penalties.',
            'Lookalike Domain Names: The sender address slightly misspells the genuine organization domain (typosquatting).',
            'Generic Greetings: Addressing you as "Dear Student" or "Dear Customer" instead of your actual registered name.',
            'Mismatched URLs: The hyperlink text displayed in the message does not match the actual destination URL when hovered over.',
            'Unexpected Attachments: Files with suspicious extensions like .exe, .scr, or macro-enabled documents (.docm, .xlsm).'
        ],
        'prevention_tips' => [
            'Inspect the Sender: Always inspect the complete sender email address, not just the display name.',
            'Hover Before Clicking: Check the true hyperlink preview in the bottom corner of your browser before clicking.',
            'Navigate Independently: Open a fresh browser tab and manually type the official college URL rather than clicking email links.',
            'Never Transmit Passwords: Legitimate administrators will never ask you to send passwords or OTPs over email.'
        ]
    ],
    [
        'slug' => 'malware',
        'title' => 'Malware & Ransomware Defense',
        'category' => 'System Security',
        'badge_class' => 'badge-amber',
        'icon' => '🦠',
        'read_time' => '6 min read',
        'summary' => 'Hostile software designed to infiltrate systems, extract source code, record keystrokes, and lock personal project files for ransom.',
        'explanation' => 'Malware (short for "malicious software") refers to any code created to damage, exploit, or disable computers, servers, and networks. Ransomware is a particularly destructive form of malware that uses strong encryption to lock a user’s documents, college assignments, and source code, demanding cryptocurrency payments to unlock them.',
        'types' => [
            'Trojans' => 'Malware disguised as legitimate useful software, like pirated IDEs, video games, or PDF utilities.',
            'Keyloggers' => 'Stealthy spyware that secretly logs every keystroke you type, recording login credentials and API tokens.',
            'Ransomware' => 'Programs that encrypt files with AES/RSA encryption algorithms and display an extortion ransom note.',
            'Rootkits & Botnets' => 'Tools that grant stealth administrator access and enslave devices into coordinated DDoS botnets.'
        ],
        'example' => 'While searching for a costly engineering simulation tool or textbook PDF, a student downloads a zip file from an unofficial forum labeled "Tool_Setup_Crack.zip". Upon running the enclosed "setup.exe", an invisible background process installs a keylogger and begins encrypting the student\'s Documents folder.',
        'warning_signs' => [
            'Sluggish System Performance: Unexpectedly high CPU or RAM consumption when idle.',
            'Unsolicited Pop-ups & Redirects: Browser search engine changes without permission or displays aggressive advertisements.',
            'Disabled Security Controls: Antivirus software or Windows Defender is mysteriously deactivated.',
            'File Extension Alterations: Document extensions suddenly appending unfamiliar extensions like .locked or .crypt.'
        ],
        'prevention_tips' => [
            'Download Exclusively from Official Repositories: Avoid third-party torrents, warez sites, and cracked software archives.',
            'Maintain the 3-2-1 Backup Strategy: Keep 3 copies of your important project work across 2 different media, with 1 copy stored offsite/cloud.',
            'Keep Systems Updated: Apply operating system and software security patches promptly to close known vulnerabilities.',
            'Use Standard Accounts: Avoid operating with full Administrator privileges on your daily development machine.'
        ]
    ],
    [
        'slug' => 'passwords',
        'title' => 'Password Hygiene & Passkeys',
        'category' => 'Access Control',
        'badge_class' => 'badge-green',
        'icon' => '🔑',
        'read_time' => '5 min read',
        'summary' => 'Understanding password entropy, defeating brute-force and credential stuffing attacks, and adopting modern password managers.',
        'explanation' => 'Passwords remain the foundational authentication factor on the internet. However, users frequently reuse weak, predictable passwords across multiple platforms. When one obscure forum is breached, attackers use automated botnets to try those stolen credentials against email accounts, GitHub, and university portals in automated attacks known as Credential Stuffing.',
        'types' => [
            'Brute Force Attacks' => 'Systematic guessing of every possible character combination until the correct password is discovered.',
            'Dictionary Attacks' => 'Testing precompiled lists of popular passwords, common phrases, and leaked breach databases.',
            'Credential Stuffing' => 'Injecting large batches of stolen username/password pairs into website login endpoints.',
            'Passkeys (FIDO/WebAuthn)' => 'Cryptographic public/private key pairs that replace passwords entirely with biometric confirmation.'
        ],
        'example' => 'A student uses the password "College2024!" for their gaming forum account. Two months later, that forum is hacked, and its database leaked online. An automated bot sprays that email and password combination across GitHub, accessing the student\'s private repositories containing hardcoded API keys.',
        'warning_signs' => [
            'Notifications of Logins from Unfamiliar Locations: Alerts stating your account was accessed from an unrecognized country or device.',
            'Repeated Password Reset Emails: Receiving unexpected password reset codes you did not trigger.',
            'Reusing Old Passwords: Using identical or slightly modified variants of passwords across academic and personal services.'
        ],
        'prevention_tips' => [
            'Use Long Passphrases: A four-word random passphrase like "correct-horse-battery-staple" is far harder to crack than "P@ssw0rd1".',
            'Adopt a Password Manager: Use tools like Bitwarden or KeePass to generate unique 16+ character passwords for every single site.',
            'Eliminate Password Reuse: Never reuse college or work passwords on entertainment or social media platforms.',
            'Check HaveIBeenPwned: Periodically check if your student email appears in documented public data breaches.'
        ]
    ],
    [
        'slug' => 'social-eng',
        'title' => 'Social Engineering & Psychological Traps',
        'category' => 'Human Factors',
        'badge_class' => 'badge-cyan',
        'icon' => '🎭',
        'read_time' => '6 min read',
        'summary' => 'Techniques used by adversaries to exploit human trust, politeness, fear, and curiosity to bypass digital defenses.',
        'explanation' => 'Social engineering relies on human psychology rather than software exploits. Attackers recognize that it is often far easier to trick a human being into granting access than it is to compromise a firewall. By adopting deceptive personas, attackers convince victims that breaking standard security protocols is acceptable or urgent.',
        'types' => [
            'Pretexting' => 'Creating an elaborate fictitious scenario (pretext) to convince the target to divulge confidential information.',
            'Baiting' => 'Leaving a malicious USB drive labeled "Confidential Exam Answers" in a campus hallway for a curious student to plug in.',
            'Tailgating' => 'Following an authorized person closely through an access-controlled building door without badging in.',
            'Quid Pro Quo' => 'Promising a service or benefit (such as free premium software) in exchange for login credentials.'
        ],
        'example' => 'A caller rings the campus computer lab claiming to be from the university network support team. They state they are troubleshooting an emergency server outage and request the student lab assistant to share the lab administrator password "just for 10 minutes to reboot the router."',
        'warning_signs' => [
            'Appeals to Authority: Threatening disciplinary action if you do not comply immediately.',
            'Requests to Bypass Established Channels: Asking you to share sensitive information over WhatsApp or personal phone instead of official helpdesks.',
            'Too-Good-To-Be-True Offers: Unsolicited internships, free conference tickets, or software licenses requiring your college login.',
            'Reluctance to Provide Callback Verification: Getting aggressive or evasive when asked for verifiable employee credentials.'
        ],
        'prevention_tips' => [
            'Verify Through Independent Channels: Always call back the official, publicly listed departmental phone number.',
            'Never Plug In Unknown USB Drives: Unsolicited flash drives can execute malicious payloads via BadUSB hardware emulation.',
            'Maintain Professional Skepticism: Politeness should never override information security guidelines.',
            'Report Suspicious Inquiries: Notify campus IT administrators whenever someone requests credential disclosures.'
        ]
    ],
    [
        'slug' => 'safe-browsing',
        'title' => 'Safe Browsing & Public Wi-Fi Risks',
        'category' => 'Network Defense',
        'badge_class' => 'badge-amber',
        'icon' => '📡',
        'read_time' => '5 min read',
        'summary' => 'Understanding Man-in-the-Middle (MitM) attacks, rogue access points, SSL/TLS certificates, and defensive hygiene in cafes and airports.',
        'explanation' => 'Public Wi-Fi networks in coffee shops, libraries, and airports are frequently unencrypted and unmonitored. When you connect to open networks without proper defenses, anyone within radio range can potentially intercept, inspect, or tamper with the unencrypted network packets your device transmits.',
        'types' => [
            'Man-in-the-Middle (MitM)' => 'An attacker positions themselves between your device and the router, intercepting transmitted traffic.',
            'Evil Twin Hotspots' => 'A fraudulent Wi-Fi access point configured with an identical name (SSID) to a legitimate coffee shop or campus network.',
            'Packet Sniffing' => 'Using tools like Wireshark on unencrypted networks to capture cleartext passwords and browsing histories.',
            'SSL Stripping' => 'Downgrading secure HTTPS connections to plaintext HTTP so credentials travel unencrypted.'
        ],
        'example' => 'At a student cafe, an attacker launches an open Wi-Fi hotspot named "Cafe_Free_WiFi". A student connects and logs into their university project repository over an unencrypted connection. The attacker intercepts the session cookies and hijacks the student’s active session.',
        'warning_signs' => [
            'Multiple Networks with Identical Names: Seeing two identical Wi-Fi names where one has no password required.',
            'SSL Certificate Warnings: The browser displays alarming warnings such as "Your connection is not private" or "Invalid Certificate".',
            'Unexpected Captive Portal Prompts: Wi-Fi login pages requesting social media or email account passwords to grant internet access.'
        ],
        'prevention_tips' => [
            'Verify HTTPS Everywhere: Always check for HTTPS and a valid security certificate in your browser address bar.',
            'Utilize a Trusted VPN: A Virtual Private Network encrypts your device\'s traffic from end to end on untrusted public networks.',
            'Turn Off Auto-Connect: Disable "Auto-connect to open Wi-Fi networks" in your laptop and phone settings.',
            'Avoid Sensitive Transactions: Do not perform online banking or change critical passwords while connected to public Wi-Fi.'
        ]
    ],
    [
        'slug' => 'mfa',
        'title' => 'Multi-Factor Authentication (MFA)',
        'category' => 'Authentication',
        'badge_class' => 'badge-green',
        'icon' => '🛡️',
        'read_time' => '5 min read',
        'summary' => 'Why passwords alone are insufficient, exploring factors of authentication, and ranking Authenticator apps versus SMS OTPs.',
        'explanation' => 'Multi-Factor Authentication (MFA) requires users to provide two or more distinct verification factors before gaining access to an account. Even if an attacker steals your password via a phishing email or data breach, they cannot breach your account without possessing your second authentication factor.',
        'types' => [
            'Something You Know' => 'Knowledge factors: Passwords, PINs, or answers to security questions.',
            'Something You Have' => 'Possession factors: A smartphone with an authenticator app (TOTP), SMS OTP, or hardware FIDO2 key.',
            'Something You Are' => 'Inherence factors: Biometrics such as fingerprint recognition or facial scanning.'
        ],
        'example' => 'A student falls for a phishing email and enters their university username and password into a fake site. However, because their university account has Time-based One-Time Password (TOTP) MFA enabled, the hacker cannot log in because they do not have access to the 6-digit code rotating every 30 seconds on the student\'s authenticator app.',
        'warning_signs' => [
            'Receiving Unprompted MFA Prompts: Receiving an authentication prompt or SMS OTP when you did not attempt to log in.',
            'MFA Fatigue Attacks: Attackers sending dozens of push notifications in the middle of the night hoping you will tap "Approve" to stop the notifications.'
        ],
        'prevention_tips' => [
            'Enable MFA on All Accounts: Prioritize email, GitHub, college portals, and banking services.',
            'Prefer Authenticator Apps Over SMS: SMS messages are susceptible to SIM swapping and interception; use Google Authenticator, Microsoft Authenticator, or Aegis.',
            'Never Approve Unexpected Prompts: If you receive a push notification you did not initiate, decline it and change your password immediately.',
            'Save Emergency Backup Codes: Store one-time recovery codes securely in an encrypted vault or safe physical location.'
        ]
    ]
];

// Check completed topics for the current user
$completedSlugs = [];
$currentUser = getCurrentUser();

if (isDbConnected() && !empty($currentUser['numeric_id'])) {
    try {
        $db = getDb();
        $stmt = $db->prepare("SELECT topic_slug FROM learning_progress WHERE user_id = ?");
        $stmt->execute([$currentUser['numeric_id']]);
        $completedSlugs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        $completedSlugs = [];
    }
}
?>

<div class="container">
    <!-- Header Summary -->
    <div style="margin-bottom: 2.5rem; text-align: center;">
        <span class="badge badge-cyan" style="margin-bottom: 0.75rem;">Curriculum</span>
        <h1>Cybersecurity Knowledge Center</h1>
        <p class="lead" style="max-width: 720px; margin: 0 auto;">
            Master these six foundational domains. Each module includes theoretical fundamentals, realistic scenario examples, key warning signs, and defensive prevention protocols.
        </p>

        <!-- Dynamic Learning Progress Bar -->
        <div style="max-width: 500px; margin: 1.75rem auto 0 auto;">
            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--text-muted);">
                <span>Your Completion Progress</span>
                <span id="progressCounterText">0 of 6 Completed</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" id="learnProgressBar" style="width: 0%;"></div>
            </div>
        </div>
    </div>

    <!-- Topics Grid -->
    <div class="topics-grid">
        <?php foreach ($topics as $index => $t): ?>
            <?php $isDone = in_array($t['slug'], $completedSlugs); ?>
            <article class="card topic-card <?= $isDone ? 'completed' : '' ?>" id="topic-<?= sanitize($t['slug']) ?>" data-slug="<?= sanitize($t['slug']) ?>">
                <div>
                    <div class="card-header">
                        <div class="card-icon" style="font-size: 1.6rem;" aria-hidden="true">
                            <?= $t['icon'] ?>
                        </div>
                        <span class="badge <?= $t['badge_class'] ?>"><?= sanitize($t['category']) ?></span>
                    </div>

                    <div class="topic-meta">
                        <span>Module #<?= $index + 1 ?></span> &bull;
                        <span><?= sanitize($t['read_time']) ?></span>
                    </div>

                    <h3><?= sanitize($t['title']) ?></h3>
                    <p><?= sanitize($t['summary']) ?></p>
                </div>

                <!-- Action Footer -->
                <div class="topic-actions">
                    <button type="button" class="btn btn-outline btn-sm btn-open-modal" data-target="modal-<?= sanitize($t['slug']) ?>">
                        Read Full Guide &rarr;
                    </button>
                    <button type="button" class="btn btn-sm btn-toggle-complete <?= $isDone ? 'btn-success' : 'btn-outline' ?>" data-slug="<?= sanitize($t['slug']) ?>">
                        <?= $isDone ? '✓ Completed' : 'Mark as Done' ?>
                    </button>
                </div>
            </article>

            <!-- Detailed Educational Modal for each topic -->
            <div class="learn-modal" id="modal-<?= sanitize($t['slug']) ?>" role="dialog" aria-modal="true" aria-labelledby="title-<?= sanitize($t['slug']) ?>">
                <div class="learn-modal-content">
                    <button type="button" class="learn-modal-close" aria-label="Close dialog">&times;</button>
                    
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                        <span style="font-size: 2rem;"><?= $t['icon'] ?></span>
                        <div>
                            <span class="badge <?= $t['badge_class'] ?>"><?= sanitize($t['category']) ?></span>
                            <h2 id="title-<?= sanitize($t['slug']) ?>" style="margin-top: 0.25rem;"><?= sanitize($t['title']) ?></h2>
                        </div>
                    </div>

                    <!-- 1. Explanation -->
                    <h4 style="color: var(--accent-cyan); margin-top: 1.5rem;">1. Technical Overview</h4>
                    <p><?= sanitize($t['explanation']) ?></p>

                    <!-- Attack Classifications -->
                    <div style="margin: 1.25rem 0;">
                        <?php foreach ($t['types'] as $typeName => $typeDesc): ?>
                            <div style="margin-bottom: 0.75rem; padding-left: 0.75rem; border-left: 2px solid var(--border-accent);">
                                <strong style="color: var(--text-primary);"><?= sanitize($typeName) ?>:</strong>
                                <span style="color: var(--text-secondary);"><?= sanitize($typeDesc) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- 2. Realistic Scenario -->
                    <div class="edu-callout">
                        <h5>📌 Realistic Campus Scenario:</h5>
                        <p style="margin-bottom: 0;"><?= sanitize($t['example']) ?></p>
                    </div>

                    <!-- 3. Warning Signs Checklist -->
                    <h4 style="color: var(--accent-amber); margin-top: 1.5rem;">⚠️ Key Warning Signs &amp; Red Flags</h4>
                    <ul style="padding-left: 1.25rem; margin-bottom: 1.25rem;">
                        <?php foreach ($t['warning_signs'] as $sign): ?>
                            <li style="margin-bottom: 0.4rem; color: var(--text-secondary);"><?= sanitize($sign) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- 4. Prevention Protocol -->
                    <h4 style="color: var(--accent-green); margin-top: 1.5rem;">🛡️ Defensive Prevention Tips</h4>
                    <ul style="padding-left: 1.25rem; margin-bottom: 1.75rem;">
                        <?php foreach ($t['prevention_tips'] as $tip): ?>
                            <li style="margin-bottom: 0.4rem; color: var(--text-secondary);"><?= sanitize($tip) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 1.25rem;">
                        <button type="button" class="btn btn-outline btn-close-modal">Close</button>
                        <button type="button" class="btn btn-sm btn-toggle-complete <?= $isDone ? 'btn-success' : 'btn-outline' ?>" data-slug="<?= sanitize($t['slug']) ?>">
                            <?= $isDone ? '✓ Completed' : 'Mark as Done' ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
