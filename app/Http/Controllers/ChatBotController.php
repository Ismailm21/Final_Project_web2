<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $message = strtolower(trim($request->input('message')));
        $response = $this->getBotResponse($message);

        return response()->json(['response' => $response]);
    }

    private function getBotResponse(string $message): string
    {
        $timeGreeting = $this->getTimeGreeting();

        return match (true) {
            $message === 'hello', $message === 'hi' => "$timeGreeting! How can I help you?",
            $message === 'bye', $message === 'goodbye' => 'Goodbye! Have a great day! 👋',
            $message === 'help', $message === '?' => 'Here are some things you can try: <br><ul>'
            . '<li>faq</li><li>contact</li></ul>',
            str_contains($message, 'contact') || str_contains($message, 'support') => 'Reach out to us here: <a href="/contact" target="_blank">Contact Support</a>',
            str_contains($message, 'faq') || str_contains($message, needle: 'questions') => 'Visit our FAQ: <a href="/faq" target="_blank">FAQ Page</a>',
            str_contains($message, 'help') => 'You might find these links helpful:<br><ul>'
            . '<li><a href="/about" target="_blank">About Us</a></li>'
            . '<li><a href="/contact" target="_blank">Contact Support</a></li>'
            . '<li><a href="/faq" target="_blank">FAQ</a></li>'
            . '</ul>',
            default => $this->getDefaultResponse(),
        };
    }

    private function getTimeGreeting(): string
    {
        $hour = now()->format('H');
        return match (true) {
            $hour < 12 => 'Good morning',
            $hour < 18 => 'Good afternoon',
            default => 'Good evening',
        };
    }

    private function getDefaultResponse(): string
    {
        return '🤖 Sorry, I didn’t quite understand that. You might find these links helpful:<br><ul>'
            . '<li><a href="/about" target="_blank">About Us</a></li>'
            . '<li><a href="/contact" target="_blank">Contact Support</a></li>'
            . '<li><a href="/faq" target="_blank">FAQ</a></li>'
            . '</ul>';
    }
}
