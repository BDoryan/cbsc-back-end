<?php

namespace App\Http\Controllers;

use App\Models\Convocation;
use App\Models\ConvocationInvitation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Nette\Utils\Paginator;

class ConvocationController extends Controller
{

    public function index(): LengthAwarePaginator
    {
        // get authenticated user
        $user = auth()->user();

        if($user->managing()->count() > 0) {
            return Convocation::with('invitations')->with('invitations.user')->orderBy('created_at', 'desc')->paginate(5);
        } else {
            return $user->convocations()->with('invitations')->with('invitations.user')->orderBy('created_at', 'desc')->paginate(5);
        }
    }

    public function myConvocations()
    {
        // Get user authenticated
        $user = auth()->user();
        return $user->convocations()->paginate(25);
    }

    public function accept(Request $request, $id) {
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

    public function decline(Request $request, $id) {
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

    public function search(Request $request): Paginator
    {
        $search = $request->input('search');
        return Convocation::where('title', 'like', '%' . $search . '%')->paginator(25);
    }

    public function show($id)
    {
        $convocation = Convocation::findOrFail($id);
        $convocation->load('invitations');
        $convocation->load('invitations');
        $convocation->load('invitations.user');

        return $convocation;
    }

    public function store(Request $request)
    {
        $convocation = Convocation::create($request->all());

        $invitations = $request->input('invitations');
        foreach ($invitations as $invitation) {
            $convocation->invitations()->create([
                'user_id' => intval($invitation)
            ]);
        }

        return $convocation;
    }

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
                $convocation->invitations()->create([
                    'user_id' => intval($invitation)
                ]);
            }
        }

        $convocation->load('invitations');

        return $convocation;
    }

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
