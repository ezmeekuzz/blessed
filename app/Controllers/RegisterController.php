<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class RegisterController extends BaseController
{
    public function index()
    {
        if (session()->has('user_user_id') && session()->get('user_usertype') == 'Regular User') {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'The Blessed Manifest',
            'activeMenu' => 'register'
        ];
        
        return view('pages/register', $data);
    }

    public function insert()
    {
        $usersModel = new UsersModel();
        $firstname   = $this->request->getPost('firstname');
        $lastname    = $this->request->getPost('lastname');
        $emailaddress = $this->request->getPost('emailaddress');
        $password    = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirmpassword');
        
        // Validate password match
        if ($password !== $confirmPassword) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Passwords do not match.'
            ]);
        }
        
        // Validate password strength
        if (strlen($password) < 8) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Password must be at least 8 characters long.'
            ]);
        }

        // Check if email exists
        $userList = $usersModel->where('emailaddress', $emailaddress)->first();
        if ($userList) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email is already registered. Please use a different email or login.'
            ]);
        }
        
        // Generate verification token
        $verificationToken = bin2hex(random_bytes(32));
        $tokenExpiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $currentDateTime = date('Y-m-d H:i:s');
        
        $data = [
            'firstname'         => $firstname,
            'lastname'          => $lastname,
            'emailaddress'      => $emailaddress,
            'password'          => $password,
            'encryptpass'       => password_hash($password, PASSWORD_BCRYPT),
            'usertype'          => 'Regular User',
            'email_verified'    => 0,
            'verification_token' => $verificationToken,
            'token_expiry'      => $tokenExpiry,
            'status'            => 'pending',
            'created_at'        => $currentDateTime,
            'updated_at'        => $currentDateTime
        ];

        $userId = $usersModel->insert($data);

        if ($userId) {
            $verificationLink = base_url('verify-email?token=' . $verificationToken . '&email=' . urlencode($emailaddress));
            
            // Send verification email
            $emailContent = $this->getVerificationEmailTemplate($firstname, $lastname, $verificationLink);
            
            $emailService = \Config\Services::email();
            $emailService->setTo($emailaddress);
            $emailService->setSubject('Verify Your Email Address - Welcome to The Blessed Manifest!');
            $emailService->setMessage($emailContent);
            $emailService->setMailType('html');
            
            $emailSent = $emailService->send();
            
            if (!$emailSent) {
                log_message('error', 'Failed to send verification email to: ' . $emailaddress);
            }
            
            // Send admin notification
            $this->sendAdminNotification($firstname, $lastname, $emailaddress);
            
            $response = [
                'success' => true,
                'message' => 'Registration successful! Please check your email to verify your account.',
                'redirect' => '/verification-sent'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to register. Please try again.'
            ];
        }

        return $this->response->setJSON($response);
    }
    
    /**
     * Verify email with token
     */
    public function verifyEmail()
    {
        $usersModel = new UsersModel();
        $token = $this->request->getGet('token');
        $email = $this->request->getGet('email');

        // Find user with this token
        $user = $usersModel->where('verification_token', $token)->first();
        
        if (!$user) {
            $data = [
                'title' => 'Verification Failed - The Blessed Manifest',
                'message' => 'Invalid verification link. The link may have been tampered with or already used.',
                'type' => 'error',
                'activeMenu' => 'home'
            ];
            return view('pages/verification_status', $data);
        }
        
        // Check if already verified
        if ($user['email_verified'] == 1) {
            $data = [
                'title' => 'Already Verified - The Blessed Manifest',
                'message' => 'Your email has already been verified. You can now log in to your account.',
                'type' => 'success',
                'activeMenu' => 'home'
            ];
            return view('pages/verification_status', $data);
        }
        
        // Check if token has expired
        if (strtotime($user['token_expiry']) < time()) {
            $data = [
                'title' => 'Verification Link Expired - The Blessed Manifest',
                'message' => 'Your verification link has expired. Please request a new verification email below.',
                'type' => 'expired',
                'email' => $user['emailaddress'],
                'activeMenu' => 'home'
            ];
            return view('pages/verification_status', $data);
        }
        
        // Verify the email
        $usersModel->update($user['user_id'], [
            'email_verified' => 1,
            'verification_token' => null,
            'token_expiry' => null,
            'status' => 1
        ]);
        
        $data = [
            'title' => 'Email Verified Successfully! - The Blessed Manifest',
            'message' => 'Your email has been verified. You can now log in to your account and start exploring The Blessed Manifest.',
            'type' => 'success',
            'activeMenu' => 'home'
        ];
        
        return view('pages/verification_status', $data);
    }
    
    /**
     * Resend verification email
     */
    public function resendVerification()
    {
        $usersModel = new UsersModel();
        $email = $this->request->getPost('email');
        
        if (!$email) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email address is required.'
            ]);
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ]);
        }
        
        $user = $usersModel->where('emailaddress', $email)->first();
        
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No account found with this email address.'
            ]);
        }
        
        if ($user['email_verified'] == 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'This email is already verified. Please log in to your account.'
            ]);
        }
        
        // Generate new verification token
        $verificationToken = bin2hex(random_bytes(32));
        $tokenExpiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $usersModel->update($user['user_id'], [
            'verification_token' => $verificationToken,
            'token_expiry' => $tokenExpiry,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        $verificationLink = base_url('verify-email?token=' . $verificationToken . '&email=' . urlencode($email));
        $emailContent = $this->getVerificationEmailTemplate($user['firstname'], $user['lastname'], $verificationLink);
        
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Resend: Verify Your Email Address - The Blessed Manifest');
        $emailService->setMessage($emailContent);
        $emailService->setMailType('html');
        
        if ($emailService->send()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Verification email has been resent. Please check your inbox.'
            ]);
        } else {
            log_message('error', 'Failed to resend verification email to: ' . $email);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to send verification email. Please try again later.'
            ]);
        }
    }
    
    /**
     * Verification sent page
     */
    public function verificationSent()
    {
        $data = [
            'title' => 'Verification Email Sent - The Blessed Manifest',
            'message' => 'Please check your email inbox and click the verification link to complete your registration.',
            'type' => 'success',
            'activeMenu' => 'home'
        ];
        return view('pages/verification_status', $data);
    }
    
    /**
     * Get verification email template
     */
    private function getVerificationEmailTemplate($firstname, $lastname, $verificationLink)
    {
        $siteName = 'The Blessed Manifest';
        $siteUrl = base_url();
        
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Verify Your Email - ' . $siteName . '</title>
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
                    padding: 0;
                    line-height: 1.6;
                }
                
                .email-wrapper {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                
                .email-container {
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
                
                .button-container {
                    text-align: center;
                    margin: 32px 0;
                }
                
                .verify-button {
                    display: inline-block;
                    background: #3D204E;
                    color: #ffffff;
                    text-decoration: none;
                    padding: 14px 32px;
                    border-radius: 12px;
                    font-weight: 600;
                    font-size: 16px;
                    text-align: center;
                }
                
                .verify-button:hover {
                    background: #5a2d73;
                }
                
                .link-box {
                    background: #f8f9fa;
                    border: 1px solid #e9ecef;
                    border-radius: 12px;
                    padding: 16px;
                    margin: 24px 0;
                    word-break: break-all;
                }
                
                .link-box p {
                    font-size: 12px;
                    color: #6c757d;
                    margin-bottom: 8px;
                    font-weight: 600;
                }
                
                .link-box a {
                    color: #3D204E;
                    text-decoration: none;
                    font-size: 12px;
                    word-break: break-all;
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
                    .email-wrapper {
                        padding: 10px;
                    }
                    
                    .email-body {
                        padding: 24px 20px;
                    }
                    
                    .email-header {
                        padding: 32px 24px;
                    }
                    
                    .greeting {
                        font-size: 22px;
                    }
                    
                    .verify-button {
                        display: block;
                        width: 100%;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-wrapper">
                <div class="email-container">
                    <div class="email-header">
                        <div class="logo">✝️ ' . $siteName . '</div>
                        <h1>Verify Your Email Address</h1>
                        <p class="tagline">Your journey of faith and manifestation begins here</p>
                        <div class="accent-line"></div>
                    </div>
                    
                    <div class="email-body">
                        <div class="greeting">
                            Hello ' . htmlspecialchars($firstname) . '! 🙏
                        </div>
                        
                        <div class="message">
                            Thanks for joining <span class="highlight">' . $siteName . '</span>! We\'re excited to have you in our faith-filled community.
                        </div>
                        
                        <div class="message">
                            To get started and unlock all the features, please verify your email address by clicking the button below:
                        </div>
                        
                        <div class="button-container">
                            <a href="' . $verificationLink . '" class="verify-button">
                                ✓ Verify Email Address
                            </a>
                        </div>
                        
                        <div class="link-box">
                            <p>🔗 Or copy and paste this link into your browser:</p>
                            <a href="' . $verificationLink . '">' . $verificationLink . '</a>
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
                                <div class="feature-title">Prayer Community</div>
                                <div class="feature-desc">Connect with others in faith</div>
                            </div>
                            <div class="feature-card">
                                <div class="feature-icon">✨</div>
                                <div class="feature-title">Inspiration</div>
                                <div class="feature-desc">Stay motivated with faith-centered content</div>
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <p>⏰ <strong>Note:</strong> This verification link will expire in <strong>24 hours</strong>. If you didn\'t create an account with ' . $siteName . ', please ignore this email.</p>
                        </div>
                    </div>
                    
                    <div class="email-footer">
                        <p>© ' . date('Y') . ' ' . $siteName . '. All rights reserved.</p>
                        <p>Empowering you to bring your faith and vision to life</p>
                        <p>
                            <a href="' . $siteUrl . '/privacy-policy">Privacy Policy</a> &nbsp;|&nbsp;
                            <a href="' . $siteUrl . '/terms-and-conditions">Terms of Service</a> &nbsp;|&nbsp;
                            <a href="' . $siteUrl . '/contact">Contact Support</a>
                        </p>
                        <div class="social-links">
                            <a href="#">📷 Instagram</a>
                            <a href="#">📘 Facebook</a>
                            <a href="#">✝️ Ministry</a>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
    }
    
    /**
     * Send admin notification for new registration
     */
    private function sendAdminNotification($firstname, $lastname, $email)
    {
        $currentDateTime = date('F j, Y \a\t g:i A');
        $siteName = 'The Blessed Manifest';
        $siteUrl = base_url();
        
        $content = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>New User Registration - ' . $siteName . '</title>
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
                
                .email-body {
                    padding: 32px;
                    background: #ffffff;
                }
                
                .alert-badge {
                    background: #B48B5A;
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
                
                .status-badge {
                    display: inline-block;
                    background: #fff3e0;
                    color: #fd7e14;
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 11px;
                    font-weight: 600;
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
                    <h1>🎉 New User Registration</h1>
                    <p>A new member has joined the ' . $siteName . ' community</p>
                </div>
                
                <div class="email-body">
                    <div style="text-align: center;">
                        <div class="alert-badge">
                            ✨ PENDING VERIFICATION
                        </div>
                    </div>
                    
                    <div class="section-title">
                        📋 User Information
                    </div>
                    
                    <div class="user-card">
                        <div class="user-row">
                            <div class="user-label">Full Name:</div>
                            <div class="user-value"><strong>' . htmlspecialchars($firstname) . ' ' . htmlspecialchars($lastname) . '</strong></div>
                        </div>
                        <div class="user-row">
                            <div class="user-label">Email Address:</div>
                            <div class="user-value">
                                <a href="mailto:' . htmlspecialchars($email) . '" style="color: #3D204E; text-decoration: none;">' . htmlspecialchars($email) . '</a>
                            </div>
                        </div>
                        <div class="user-row">
                            <div class="user-label">Registration Date:</div>
                            <div class="user-value">' . $currentDateTime . '</div>
                        </div>
                        <div class="user-row">
                            <div class="user-label">Account Status:</div>
                            <div class="user-value">
                                <span class="status-badge">⏳ Pending Email Verification</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-title">
                        ⚡ Quick Actions
                    </div>
                    
                    <div class="action-buttons">
                        <a href="mailto:' . htmlspecialchars($email) . '" class="btn-primary">Reply to User</a>
                        <a href="' . $siteUrl . '/admin/dashboard" class="btn-secondary">Go to Admin Panel</a>
                    </div>
                    
                    <div class="info-note">
                        <p><strong>📌 Important Notes:</strong></p>
                        <p>• This user has not yet verified their email address</p>
                        <p>• A verification link has been sent to the user\'s email</p>
                        <p>• Once verified, their status will automatically update to "Active"</p>
                    </div>
                </div>
                
                <div class="email-footer">
                    <p>© ' . date('Y') . ' ' . $siteName . '. All rights reserved.</p>
                    <p>This is an automated notification from your website registration system.</p>
                </div>
            </div>
        </body>
        </html>';
        
        $emailService = \Config\Services::email();
        $emailService->setTo('rustomcodilan@gmail.com');
        $emailService->setSubject('🔔 New User Registration - ' . $firstname . ' ' . $lastname);
        $emailService->setMessage($content);
        $emailService->setMailType('html');
        $emailService->send();
    }
}