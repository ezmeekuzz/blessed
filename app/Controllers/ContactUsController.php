<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ContactMessagesModel;
use CodeIgniter\HTTP\ResponseInterface;

class ContactUsController extends BaseController
{
    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactMessagesModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Contact Us - The Blessed Manifest',
            'activeMenu' => 'contact'
        ];

        return view('pages/contact-us', $data);
    }

    /**
     * Submit contact form
     */
    public function submit()
    {
        // Check if AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }

        $name = trim($this->request->getPost('name'));
        $email = trim($this->request->getPost('email'));
        $reason = trim($this->request->getPost('reason'));
        $message = trim($this->request->getPost('message'));

        // Validate inputs
        if (empty($name)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please enter your name.'
            ]);
        }

        if (strlen($name) < 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Name must be at least 2 characters.'
            ]);
        }

        if (empty($email)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please enter your email address.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ]);
        }

        if (empty($reason) || $reason === 'Select a reason') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please select a reason for contacting us.'
            ]);
        }

        if (empty($message)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please enter your message.'
            ]);
        }

        if (strlen($message) < 10) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Message must be at least 10 characters.'
            ]);
        }

        // Save to database
        $data = [
            'name' => $name,
            'email' => $email,
            'subject' => $reason,
            'message' => $message,
            'ip_address' => $this->request->getIPAddress(),
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->contactModel->insert($data)) {
            // Send email to admin
            $this->sendAdminEmail($name, $email, $reason, $message);
            
            // Send auto-reply to user
            $this->sendUserAutoReply($name, $email);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Thank you for contacting us! We will get back to you within 24-48 hours.'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to send message. Please try again later.'
        ]);
    }

    /**
     * Send email to admin
     */
    private function sendAdminEmail($name, $email, $reason, $message)
    {
        $siteName = 'The Blessed Manifest';
        $siteUrl = base_url();
        $currentDateTime = date('F j, Y \a\t g:i A');
        
        $emailContent = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>New Contact Form Submission - ' . $siteName . '</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                    background-color: #f6f8fc;
                    margin: 0;
                    padding: 20px;
                    line-height: 1.6;
                }
                
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    background: #ffffff;
                    border-radius: 24px;
                    overflow: hidden;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                }
                
                .email-header {
                    background: #3D204E;
                    padding: 32px 32px;
                    text-align: center;
                }
                
                .logo {
                    font-size: 28px;
                    font-weight: 700;
                    color: #ffffff;
                    margin-bottom: 16px;
                    display: inline-block;
                }
                
                .email-header h1 {
                    color: #ffffff;
                    font-size: 24px;
                    font-weight: 700;
                    margin-bottom: 8px;
                }
                
                .email-header p {
                    color: rgba(255, 255, 255, 0.85);
                    font-size: 14px;
                    margin: 0;
                }
                
                .accent-line {
                    width: 60px;
                    height: 3px;
                    background: #B48B5A;
                    margin: 20px auto 0 auto;
                    border-radius: 4px;
                }
                
                .email-body {
                    padding: 32px;
                    background: #ffffff;
                }
                
                .alert-badge {
                    background: #3D204E;
                    color: #ffffff;
                    padding: 6px 16px;
                    border-radius: 50px;
                    display: inline-block;
                    font-size: 12px;
                    font-weight: 600;
                    margin-bottom: 24px;
                }
                
                .section-title {
                    font-size: 18px;
                    font-weight: 700;
                    color: #3D204E;
                    margin: 24px 0 16px;
                    padding-bottom: 8px;
                    border-bottom: 2px solid #e9ecef;
                }
                
                .user-card {
                    background: #f8f9fa;
                    border-radius: 16px;
                    padding: 20px;
                    margin: 16px 0;
                    border: 1px solid #e9ecef;
                }
                
                .user-row {
                    display: flex;
                    padding: 10px 0;
                    border-bottom: 1px solid #e9ecef;
                }
                
                .user-row:last-child {
                    border-bottom: none;
                }
                
                .user-label {
                    font-weight: 600;
                    color: #3D204E;
                    width: 120px;
                    font-size: 13px;
                }
                
                .user-value {
                    color: #1a2e4b;
                    flex: 1;
                    font-size: 13px;
                }
                
                .message-box {
                    background: #f8f9fa;
                    border-radius: 16px;
                    padding: 20px;
                    margin: 16px 0;
                    border-left: 4px solid #3D204E;
                }
                
                .message-box p {
                    margin: 8px 0;
                    font-size: 14px;
                    color: #1a2e4b;
                    line-height: 1.6;
                }
                
                .action-buttons {
                    margin: 24px 0;
                    text-align: center;
                }
                
                .btn-primary {
                    display: inline-block;
                    background: #3D204E;
                    color: #ffffff;
                    text-decoration: none;
                    padding: 10px 24px;
                    border-radius: 12px;
                    font-weight: 600;
                    font-size: 13px;
                    margin: 0 6px;
                }
                
                .btn-secondary {
                    display: inline-block;
                    background: transparent;
                    color: #3D204E;
                    text-decoration: none;
                    padding: 10px 24px;
                    border-radius: 12px;
                    font-weight: 600;
                    font-size: 13px;
                    margin: 0 6px;
                    border: 1px solid #3D204E;
                }
                
                .info-note {
                    background: #f8f9fa;
                    border-radius: 16px;
                    padding: 16px;
                    margin: 24px 0;
                    border-left: 3px solid #B48B5A;
                }
                
                .info-note p {
                    margin: 6px 0;
                    font-size: 12px;
                    color: #495057;
                    line-height: 1.5;
                }
                
                .email-footer {
                    background: #f8f9fa;
                    padding: 24px;
                    text-align: center;
                    border-top: 1px solid #e9ecef;
                }
                
                .email-footer p {
                    color: #6c757d;
                    font-size: 11px;
                    margin: 6px 0;
                }
                
                .email-footer a {
                    color: #3D204E;
                    text-decoration: none;
                }
                
                @media (max-width: 600px) {
                    .email-body {
                        padding: 24px 20px;
                    }
                    
                    .user-row {
                        flex-direction: column;
                    }
                    
                    .user-label {
                        width: 100%;
                        margin-bottom: 4px;
                    }
                    
                    .action-buttons a {
                        display: block;
                        margin: 10px 0;
                    }
                    
                    .btn-primary, .btn-secondary {
                        display: block;
                        width: 100%;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <div class="logo">✝️ ' . $siteName . '</div>
                    <h1>New Contact Form Submission</h1>
                    <p>Someone has reached out through the website</p>
                    <div class="accent-line"></div>
                </div>
                
                <div class="email-body">
                    <div style="text-align: center;">
                        <div class="alert-badge">
                            📬 NEW MESSAGE RECEIVED
                        </div>
                    </div>
                    
                    <div class="section-title">
                        📋 Sender Information
                    </div>
                    
                    <div class="user-card">
                        <div class="user-row">
                            <div class="user-label">Name:</div>
                            <div class="user-value"><strong>' . htmlspecialchars($name) . '</strong></div>
                        </div>
                        <div class="user-row">
                            <div class="user-label">Email:</div>
                            <div class="user-value">
                                <a href="mailto:' . htmlspecialchars($email) . '" style="color: #3D204E; text-decoration: none;">' . htmlspecialchars($email) . '</a>
                            </div>
                        </div>
                        <div class="user-row">
                            <div class="user-label">Subject:</div>
                            <div class="user-value">' . htmlspecialchars($reason) . '</div>
                        </div>
                        <div class="user-row">
                            <div class="user-label">Submitted:</div>
                            <div class="user-value">' . $currentDateTime . '</div>
                        </div>
                    </div>
                    
                    <div class="section-title">
                        💬 Message Content
                    </div>
                    
                    <div class="message-box">
                        <p><strong>Message:</strong></p>
                        <p>' . nl2br(htmlspecialchars($message)) . '</p>
                    </div>
                    
                    <div class="section-title">
                        ⚡ Quick Actions
                    </div>
                    
                    <div class="action-buttons">
                        <a href="mailto:' . htmlspecialchars($email) . '" class="btn-primary">Reply to Sender</a>
                        <a href="' . $siteUrl . '/admin/contact-messages" class="btn-secondary">View All Messages</a>
                    </div>
                    
                    <div class="info-note">
                        <p><strong>📌 Important Notes:</strong></p>
                        <p>• This message has been saved to the database</p>
                        <p>• An auto-reply has been sent to the sender</p>
                        <p>• Please respond within 24-48 hours</p>
                        <p>• Mark as "read" in admin panel after reviewing</p>
                    </div>
                </div>
                
                <div class="email-footer">
                    <p>© ' . date('Y') . ' ' . $siteName . '. All rights reserved.</p>
                    <p>This is an automated notification from your website contact form.</p>
                    <p><a href="' . $siteUrl . '/admin/dashboard">Go to Admin Dashboard →</a></p>
                </div>
            </div>
        </body>
        </html>';
        
        $emailService = \Config\Services::email();
        $emailService->setTo('rustomcodilan@gmail.com');
        $emailService->setSubject('📬 New Contact Message from ' . $name . ' - ' . $siteName);
        $emailService->setMessage($emailContent);
        $emailService->setMailType('html');
        $emailService->send();
    }

    /**
     * Send auto-reply to user
     */
    private function sendUserAutoReply($name, $email)
    {
        $siteName = 'The Blessed Manifest';
        $siteUrl = base_url();
        
        $emailContent = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Thank You for Contacting ' . $siteName . '</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                    background-color: #f6f8fc;
                    margin: 0;
                    padding: 20px;
                    line-height: 1.6;
                }
                
                .email-container {
                    max-width: 600px;
                    margin: 0 auto;
                    background: #ffffff;
                    border-radius: 24px;
                    overflow: hidden;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                }
                
                .email-header {
                    background: #3D204E;
                    padding: 40px 32px;
                    text-align: center;
                }
                
                .logo {
                    font-size: 28px;
                    font-weight: 700;
                    color: #ffffff;
                    margin-bottom: 16px;
                    display: inline-block;
                }
                
                .email-header h1 {
                    color: #ffffff;
                    font-size: 26px;
                    font-weight: 700;
                    margin: 0 0 8px 0;
                }
                
                .email-header .tagline {
                    color: rgba(255, 255, 255, 0.85);
                    font-size: 15px;
                    margin: 0;
                }
                
                .accent-line {
                    width: 60px;
                    height: 3px;
                    background: #B48B5A;
                    margin: 20px auto 0 auto;
                    border-radius: 4px;
                }
                
                .email-body {
                    padding: 40px 32px;
                    background: #ffffff;
                }
                
                .greeting {
                    font-size: 24px;
                    font-weight: 700;
                    color: #3D204E;
                    margin-bottom: 20px;
                }
                
                .message {
                    color: #1a2e4b;
                    font-size: 16px;
                    margin-bottom: 20px;
                    line-height: 1.6;
                }
                
                .highlight {
                    color: #3D204E;
                    font-weight: 600;
                }
                
                .info-box {
                    background: #fff8e7;
                    border-left: 3px solid #B48B5A;
                    padding: 16px 20px;
                    border-radius: 12px;
                    margin: 24px 0;
                }
                
                .info-box p {
                    font-size: 13px;
                    color: #856404;
                    margin: 0;
                    line-height: 1.5;
                }
                
                .features-grid {
                    display: block;
                    margin: 32px 0;
                }
                
                .feature-card {
                    background: #f8f9fa;
                    border-radius: 16px;
                    padding: 16px;
                    margin-bottom: 12px;
                    text-align: center;
                    border: 1px solid #e9ecef;
                }
                
                .feature-icon {
                    font-size: 28px;
                    margin-bottom: 8px;
                    display: inline-block;
                }
                
                .feature-title {
                    font-weight: 700;
                    color: #3D204E;
                    font-size: 14px;
                    margin-bottom: 4px;
                }
                
                .feature-desc {
                    font-size: 12px;
                    color: #6c757d;
                    line-height: 1.4;
                }
                
                .email-footer {
                    background: #f8f9fa;
                    padding: 32px;
                    text-align: center;
                    border-top: 1px solid #e9ecef;
                }
                
                .email-footer p {
                    color: #6c757d;
                    font-size: 12px;
                    margin: 8px 0;
                    line-height: 1.5;
                }
                
                .email-footer a {
                    color: #3D204E;
                    text-decoration: none;
                }
                
                .social-links {
                    margin-top: 16px;
                    padding-top: 16px;
                    border-top: 1px solid #e9ecef;
                }
                
                .social-links a {
                    margin: 0 8px;
                    color: #6c757d;
                    text-decoration: none;
                    font-size: 12px;
                }
                
                @media (max-width: 600px) {
                    .email-body {
                        padding: 24px 20px;
                    }
                    
                    .greeting {
                        font-size: 22px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <div class="logo">✝️ ' . $siteName . '</div>
                    <h1>Thank You for Reaching Out! 🙏</h1>
                    <p class="tagline">We value your message and will respond soon</p>
                    <div class="accent-line"></div>
                </div>
                
                <div class="email-body">
                    <div class="greeting">
                        Dear ' . htmlspecialchars($name) . ',
                    </div>
                    
                    <div class="message">
                        Thank you for contacting <span class="highlight">' . $siteName . '</span>. We have received your message and truly appreciate you reaching out to us.
                    </div>
                    
                    <div class="message">
                        Our team will review your inquiry and get back to you within <strong>24-48 hours</strong>. We are committed to providing you with the support and guidance you need.
                    </div>
                    
                    <div class="info-box">
                        <p>📌 <strong>What to expect next:</strong> One of our team members will personally respond to your message via email. In the meantime, feel free to explore our website for inspiration and resources.</p>
                    </div>
                    
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon">📖</div>
                            <div class="feature-title">Daily Devotionals</div>
                            <div class="feature-desc">Find hope and encouragement each day</div>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🎨</div>
                            <div class="feature-title">Custom Designs</div>
                            <div class="feature-desc">Bring your faith to life with personalized products</div>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🙏</div>
                            <div class="feature-title">Prayer Support</div>
                            <div class="feature-desc">We\'re here to pray with you</div>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">✨</div>
                            <div class="feature-title">Inspiration</div>
                            <div class="feature-desc">Stay motivated with faith-centered content</div>
                        </div>
                    </div>
                    
                    <div class="message">
                        May God bless you abundantly,
                    </div>
                    
                    <div class="message" style="margin-bottom: 0;">
                        <strong>The Blessed Manifest Team</strong>
                    </div>
                </div>
                
                <div class="email-footer">
                    <p>© ' . date('Y') . ' ' . $siteName . '. All rights reserved.</p>
                    <p>Empowering you to bring your faith and vision to life</p>
                    <p>
                        <a href="' . $siteUrl . '">Visit Website</a> &nbsp;|&nbsp;
                        <a href="' . $siteUrl . '/blogs">Read Our Blog</a> &nbsp;|&nbsp;
                        <a href="' . $siteUrl . '/shop">Shop Products</a>
                    </p>
                    <div class="social-links">
                        <a href="#">📷 Instagram</a>
                        <a href="#">📘 Facebook</a>
                        <a href="#">✝️ Ministry</a>
                    </div>
                </div>
            </div>
        </body>
        </html>';
        
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Thank You for Contacting ' . $siteName . ' - We\'ll Be in Touch Soon');
        $emailService->setMessage($emailContent);
        $emailService->setMailType('html');
        $emailService->send();
    }
}