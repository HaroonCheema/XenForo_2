<?php

namespace FS\CallWhatsApp\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Thread extends XFCP_Thread {

    /**
     * Handle AJAX: log action and redirect
     */
    public function actionPushLog(ParameterBag $params) {

        $visitor = \XF::visitor();
        if (!$visitor->canShowCallWhatsup()) {
            return $this->noPermission();
        }
        $this->assertPostOnly();

        $threadId = $this->filter('thread_id', 'uint');
        $actionType = $this->filter('action_type', 'str'); // "call" | "whatsapp"

        /** @var \XF\Entity\Thread $thread */
        $thread = $this->assertViewableThread($threadId);
        $lastPost = $thread->LastPost;

        if (!$lastPost) {
            return $this->jsonError('No last post found.');
        }

        // Get phone number
        $phoneNumber = $this->getPhoneNumberFromMessage($lastPost->message);

        if (!$phoneNumber) {

            return $this->jsonError('Phone number not found.');
        }

        if(\xf::options()->toggle_logging){
            
            // Gender from prefix
            $gender = $this->getGenderFromThread($thread);

            // Create log entry
            $this->createCallLog($thread, $lastPost->post_id, $phoneNumber, $gender, $actionType);

            // Update counters
            $this->updateCounter($thread->thread_id, $actionType);

        }
        // Redirect URL
        $redirectUrl = $this->getRedirectUrl($actionType, $phoneNumber);

        $redirectMessage = $actionType === 'call' ? \XF::phrase('fs_opening_call')->render() : \XF::phrase('fs_opening_whatsapp')->render();

        // Return JSON in XenForo View format
        $results = [
            'success' => true,
            'redirectUrl' => $redirectUrl,
            'message' => $redirectMessage
        ];

        $view = $this->view();
        $view->setJsonParam('results', $results);
        return $view;
    }

    /**
     * Extract phone number from post message
     */
    protected function getPhoneNumberFromMessage(string $message): ?string {
        // Match numbers with optional +, allow spaces/dashes inside
        preg_match('/(\+?\d[\d\s\-]{6,20}\d)/', $message, $matches);
        $rawNumber = $matches[0] ?? '';

        if (!$rawNumber) {
            return null;
        }

        // Remove spaces and dashes
        $normalized = preg_replace('/[\s\-]/', '', $rawNumber);

        // Ensure starts with +
        if (strpos($normalized, '+') !== 0) {
            // Prepend default country code +39
            $normalized = '+39' . $normalized;
        }

        return $normalized;
    }

    /**
     * Determine gender based on thread prefix
     */
    protected function getGenderFromThread(\XF\Entity\Thread $thread): string {

        $prefixMap = [
            'ESCORT' => 'ES',
            'TRANS' => 'TX'
        ];

        return $prefixMap[$thread->prefix_id] ?? 'ES';
    }

    /**
     * Create a log entry
     */
    protected function createCallLog(\XF\Entity\Thread $thread, int $postId, string $phoneNumber, string $gender, string $actionType): void {
        $visitor = \XF::visitor();

        /** @var \FS\CallWhatsApp\Entity\CallWhatsAppLog $log */
        $log = $this->em()->create('FS\CallWhatsApp:CallWhatsAppLog');
        $log->bulkSet([
            'thread_id' => $thread->thread_id,
            'post_id' => $postId,
            'phone_number' => $phoneNumber,
            'gender' => $gender,
            'city' => $thread->Forum->Node->title,
            'action_type' => $actionType,
            'user_id' => $visitor->user_id ?? 0,
            'username' => $visitor->username ?: 'Guest',
            'ip_address' => $this->request->getIp(),
            'timestamp' => time(),
        ]);
        $log->save();
    }

    /**
     * Update counters for a thread
     */
    protected function updateCounter(int $threadId, string $actionType): void {
        /** @var \FS\CallWhatsApp\Entity\CallWhatsAppCounter $counter */
        $counter = $this->finder('FS\CallWhatsApp:CallWhatsAppCounter')
                ->where('thread_id', $threadId)
                ->fetchOne();

        if (!$counter) {
            $counter = $this->em()->create('FS\CallWhatsApp:CallWhatsAppCounter');
            $counter->thread_id = $threadId;
        }

        if ($actionType === 'call') {
            $counter->call_count++;
        } elseif ($actionType === 'whatsapp') {
            $counter->whatsapp_count++;
        }

        $counter->save();
    }

    /**
     * Build redirect URL for call/whatsapp
     */
    protected function getRedirectUrl(string $actionType, string $phoneNumber): string {
        if ($actionType === 'call') {
            return 'tel:' . $phoneNumber;
        }

        // Normalize WhatsApp number: keep + at start, digits only afterwards
        $cleanNumber = preg_replace('/[^\d]/', '', $phoneNumber); // digits only
        if (strpos($phoneNumber, '+') === 0) {
            $cleanNumber = '+' . $cleanNumber;
        }

        
        // Define phrase (can be pulled from phrases system later)
        $message = \XF::phrase('fs_whatsapp_default_message')->render();

       
//        return "https://wa.me/{$cleanNumber}?text={$message}";
//        return "https://wa.me/{$cleanNumber}?text={$message}";
        return "https://api.whatsapp.com/send/?phone={$cleanNumber}&text={$message}";
    }

    /**
     * Helper for consistent JSON error
     */
    protected function jsonError(string $message): View {
        $view = $this->view();
        $view->setJsonParam('error', $message);
        return $view;
    }
}
