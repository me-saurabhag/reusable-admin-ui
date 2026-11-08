<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HeaderDemoController extends Controller
{
    public function index(): View
    {
        // Illustrative server-side values. Replace these with values from your
        // application services/repositories in a real application.
        return view('admin-ui-demo', [
            'headerData' => [
                'profile' => [
                    'name' => 'Admin User',
                    'role' => 'Administrator',
                    'initials' => 'AU',
                    'avatar' => null,
                ],
                'cards' => [
                    'wallet_balance' => [
                        'value' => '₹1,250.50',
                    ],
                    'otp_credit' => [
                        'value' => '250 Credits',
                    ],
                ],
            ],
        ]);
    }
}
