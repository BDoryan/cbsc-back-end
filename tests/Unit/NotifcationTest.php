<?php

namespace Tests\Unit;

use App\Models\User;
use App\Notifications\ConvocationInvitationNotification;
use Tests\TestCase;

class NotifcationTest extends TestCase
{
    public function test_notification() {
        try {
            $title = 'Untitled';
            $message = 'No message';

            // Récupérer l'utilisateur avec l'email spécifié
            $user = User::where('email', 'contact@doryanbessiere.fr')->first();


            $this->assertTrue($user, "User not found");

            // Vérifier si l'utilisateur existe
            if ($user) {
                // Envoyer la notification à cet utilisateur
                $user->notify(new ConvocationInvitationNotification($title, $message));
                $this->assertTrue(true);
                return;
            }
        } catch (\Exception $e) {
            // En cas d'erreur, le test échoue
            $this->assertTrue(false, $e->getMessage());
        }
    }

}
