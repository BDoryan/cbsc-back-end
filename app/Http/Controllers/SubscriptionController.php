<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ConvocationInvitationNotification;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // notification subscription
    public function subscribe(Request $request)
    {
        /** Subscription */
        $request->user()->updatePushSubscription(
            $request->endpoint,
            $request->publicKey,
            $request->authToken,
            'aesgcm'
        );
    }

    // notification unsubscription
    public function unsubscribe(Request $request)
    {
        /** Unsubscription */
        $request->user()->deletePushSubscription($request->endpoint);
    }

    // send notification to all users
    public function sendNotification(Request $request)
    {
        $title = $request->title ?? 'Untitled';
        $message = $request->message ?? 'No message';
        $users = User::all();
        echo '<pre>';
        foreach ($users as $user) {
            if($user->email != 'contact@doryanbessiere.fr') continue;
            $user->notify(new ConvocationInvitationNotification($title, $message));
        }
    }
}
