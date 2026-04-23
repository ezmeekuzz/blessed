<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NewsletterSubscriberModel;
use CodeIgniter\HTTP\ResponseInterface;

class NewsletterController extends BaseController
{
    protected $subscriberModel;

    public function __construct()
    {
        $this->subscriberModel = new NewsletterSubscriberModel();
    }

    /**
     * Subscribe to newsletter
     */
    public function subscribe()
    {
        // Check if AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }

        $email = trim($this->request->getPost('email'));

        // Validate email
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

        // Check if email already exists
        $existing = $this->subscriberModel->where('email', $email)->first();

        if ($existing) {
            if ($existing['status'] === 'active') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'This email is already subscribed.'
                ]);
            } elseif ($existing['status'] === 'unsubscribed') {
                // Reactivate subscription
                $this->subscriberModel->update($existing['subscriber_id'], [
                    'status' => 'active',
                    'unsubscribed_at' => null,
                    'subscribed_at' => date('Y-m-d H:i:s')
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Welcome back! You have been re-subscribed.'
                ]);
            }
        }

        // Save new subscriber
        $data = [
            'email' => $email,
            'status' => 'active',
            'is_verified' => 1,
            'subscribed_at' => date('Y-m-d H:i:s'),
            'ip_address' => $this->request->getIPAddress()
        ];

        if ($this->subscriberModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully subscribed to our newsletter!'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to subscribe. Please try again.'
        ]);
    }
}