<?php

namespace App\Http\Controllers;

use App\Models\Convocation;
use App\Models\ConvocationInvitation;
use App\Models\User;
use App\Notifications\ConvocationInvitationNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Nette\Utils\Paginator;

class ConvocationController extends Controller
{

    /**
     * Get all convocations for the authenticated user
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        // get authenticated user
        $user = auth()->user();

        if ($user->managing()->count() > 0) {
            return
                Convocation::with('invitations')
                    ->with('invitations.user')
                    ->orderBy('datetime', 'desc')
                    ->where('datetime', '>=', now())
                    ->paginate(5);
        } else {
            return $user->convocations()->with('invitations')
                ->with('invitations.user')
                ->orderBy('datetime', 'desc')
                ->where('datetime', '>=', now())->paginate(5);
        }
    }

    /**
     * Search a convocation by title for the authenticated user
     *
     * @param Request $request
     * @return Paginator
     */
    public function search(Request $request): Paginator
    {
        $search = $request->input('search');
        $user = auth()->user();

        if ($user->managing()->count() > 0) {
            return Convocation::where('title', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->where('datetime', '>=', now())->paginate(5)
                ->paginate(5);
        } else {
            return $user->convocations()->where('title', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->where('datetime', '>=', now())->paginate(5)
                ->paginate(5);
        }
    }

    /**
     * Accept a convocation invitation
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function accept(Request $request, $id)
    {
        try {
            /** @var ConvocationInvitation $invitation */
            $invitation = ConvocationInvitation::findOrFail($id);

            $user_authenticated_id = auth()->id();

            // Check if invitation is for the authenticated user
            if (intval($invitation->user_id) !== $user_authenticated_id)
                return response()->json(['message' => 'Unauthorized'], 401);
            $invitation->accept();
            return ['message' => 'Invitation accepted'];
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Invitation not found'], 404);
        }
    }

    /**
     * Decline a convocation invitation
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function decline(Request $request, $id)
    {
        try {
            /** @var ConvocationInvitation $invitation */
            $invitation = ConvocationInvitation::findOrFail($id);

            $user_authenticated_id = auth()->id();

            // Check if invitation is for the authenticated user
            if (intval($invitation->user_id) !== $user_authenticated_id)
                return response()->json(['message' => 'Unauthorized'], 401);

            $invitation->decline();
            return ['message' => 'Invitation declined'];
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Invitation not found'], 404);
        }
    }

    /**
     * Get a convocation by id
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $convocation = Convocation::findOrFail($id);
        $convocation->load('invitations');
        $convocation->load('invitations');
        $convocation->load('invitations.user');

        return $convocation;
    }

    /**
     * Store a new convocation with invitations
     *
     * @return LengthAwarePaginator
     */
    public function store(Request $request)
    {
        $convocation = Convocation::create($request->all());

        $invitations = $request->input('invitations');
        foreach ($invitations as $invitation) {
            try {
                // fetch user by id
                $user = User::find($invitation);

                $convocation->invitations()->create([
                    'user_id' => intval($invitation)
                ]);

                $user->notify(new ConvocationInvitationNotification($convocation->title, $convocation->content));
            } catch (ModelNotFoundException $e) {
                // do nothing
            }
        }

        return $convocation;
    }

    /**
     * Update a convocation with invitations
     *
     * @param Request $request
     * @param $id
     * @return Convocation
     */
    public function update(Request $request, $id)
    {
        /** @var Convocation $convocation */
        $convocation = Convocation::findOrFail($id);
        $convocation->update($request->all());
        $convocation_invitations = $convocation->invitations()->get();

        $invitations = $request->input('invitations');

        // Compare the invitations to delete
        $convocation_invitations->each(function ($invitation) use ($invitations) {
            if (!in_array($invitation->user_id, $invitations)) {
                $invitation->delete();
            }
        });

        // Compare the invitations to add
        foreach ($invitations as $invitation) {
            if (!$convocation_invitations->contains('user_id', $invitation)) {
                try {
                    // fetch user by id
                    $user = User::find($invitation);

                    $convocation->invitations()->create([
                        'user_id' => intval($invitation)
                    ]);

                    $user->notify(new ConvocationInvitationNotification($convocation->title, $convocation->content));
                } catch (ModelNotFoundException $e) {
                    // do nothing
                }
            }
        }

        $convocation->load('invitations');

        return $convocation;
    }

    /**
     * Delete a convocation by id
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $id)
    {
        try {
            $convocation = Convocation::findOrFail($id);
            $convocation->delete();

            return response()->json(['message' => 'Convocation deleted']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Convocation not found'], 404);
        }
    }
}
