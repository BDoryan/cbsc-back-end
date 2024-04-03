<?php

namespace Tests\Unit;

use App\Models\User;
use App\Notifications\ConvocationInvitationNotification;
use Illuminate\Notifications\Notification;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }


    public function testSendNotificationsToAllUsers()
    {
        $title = "Convocation";
        $message = "Vous êtes invité à une convocation";

        $user = User::where('email', 'contact@doryanbessiere.fr');
        $user->notify(new ConvocationInvitationNotification($title, $message));
    }
}
