<?php

namespace App\Http\Controllers;

use App\Models\LicensedUser;
use App\Models\ManagingUser;
use App\Models\User;
use App\Notifications\MyAccountLoginNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(5);
        $users->load('licensed');
        $users->load('managing');

        return $users;
    }

    public function all()
    {
        return User::all();
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $user->load('licensed');
        $user->load('managing');
        $user->load('invitations');
        $user->load('convocations');

        return $user;
    }

    public function licensed()
    {
        return User::has('licensed')->paginate(5);
    }

    public function managing()
    {
        return User::has('managing')->get();
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->load('licensed');
            $user->load('managing');
            return $user;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function setPicture(Request $request, User $user)
    {
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');

            // check if the file is an image
            if (!in_array($profileImage->getMimeType(), ['image/jpeg', 'image/png']))
                return response()->json(['error' => 'Le fichier doit être une image'], 422);

            $path = $profileImage->store('public/pictures/users/profile_image', 'public');
            if(!$path)
                return response()->json(['error' => 'Erreur lors de l\'enregistrement de l\'image'], 500);

            $user->picture = '/storage/' . $path;
        } else if ($user->picture == null) {
            $sex = $user->sex;
            if ($sex == User::SEX_MALE)
                $user->picture = 'pictures/no-picture-male.jpg';
            else if ($sex == User::SEX_WOMEN)
                $user->picture = 'pictures/no-picture-women.jpg';
        } else if ($request->file('profile_image') && $request->file('profile_image')->getError() != 0)
            return response()->json(['error' => 'Erreur lors de l\'envoi de l\'image'], 422);

        if(!$user->save()) {
            return response()->json(['error' => 'Erreur lors de l\'enregistrement de l\'image'], 500);
        }
        return response()->json(['message' => 'Image enregistrée']);
    }

    public function setRoles(array $roles, User $user)
    {
        /** @var LicensedUser $licensed */
        $licensed = $user->licensed();
        $roles_licensed = $roles['licensed'] ?? null;
        $licensed_empty = $licensed->get()->isEmpty();

        if (!empty($roles_licensed)) {
            // Remove license_number if it's the same
            if (!$licensed_empty && $licensed->first()->license_number == $roles_licensed['license_number'])
                unset($roles_licensed['license_number']);

            $validator = Validator::make($roles_licensed, LicensedUser::$rules);

            // Validate and return errors if is not valid
            if (!empty($roles_licensed) && $validator->fails())
                return $validator->errors();

            // Create if empty
            if ($licensed_empty) {
                $licensed->create($roles_licensed);
            } else {
                // Update is finish if no data to update
                if (!empty($roles_licensed['license_number']))
                    $licensed->update($roles_licensed);
            }
        } else if (!$licensed_empty) {
            $licensed->delete();
        }

        /** @var ManagingUser $managing */
        $managing = $user->managing();
        $managing_empty = $managing->get()->isEmpty();
        $roles_managing = $roles['managing'] ?? null;
        if (!empty($roles_managing)) {
            $validator = Validator::make($roles_managing, ManagingUser::$rules);
            if ($validator->fails())
                return $validator->errors();

            $managing_empty ? $managing->create($roles_managing) : $managing->update($roles_managing);
        } else if (!$managing_empty) {
            $managing->delete();
        }

        $user->save();
        return true;
    }

    public function store(Request $request)
    {
        $all = $request->all();

        $validator = Validator::make($all, User::$rules);

        $all['created_at'] = date('Y-m-d H:i:s');
        $all['updated_at'] = date('Y-m-d H:i:s');

        $password_generated = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz' . strtoupper('abcdefghijklmnopqrstuvwxyz') . '123456789', 5)), 0, 15);


        $all['password'] = bcrypt($password_generated); // password hashed

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        try {
            $user = User::create($all);

            // Set roles
            $all['roles'] = $all['roles'] ?? [];
            $errors = $this->setRoles($all['roles'], $user);
            if (!$errors)
                return response()->json($errors, 422);

            unset($all['roles']);

            // Set picture
            if (!empty($user)) {
                $r = $this->setPicture($request, $user);
                if ($r->getStatusCode() != 200)
                    return $r;
            }

            $user->load('licensed');
            $user->load('managing');

            $user->password_generated = $password_generated;

            // Send email here
             $user->notify(new MyAccountLoginNotification($user->email, $password_generated));

            return $user;
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $all = $request->all();

        if ($user->email == $all['email'])
            unset($all['email']);

        if ($user->phone == $all['phone'])
            unset($all['phone']);

        $rules = User::$rules;
        if (empty($all['email']))
            unset($rules['email']);

        if (empty($all['phone']))
            unset($rules['phone']);

        $validator = Validator::make($all, $rules);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        // Set roles
        $all['roles'] = $all['roles'] ?? [];
        $errors = $this->setRoles($all['roles'], $user);
        if (!$errors)
            return response()->json($errors, 422);

        unset($all['roles']);

        // Update date related fields
        $user->update($all);

        // Set picture
        if (!empty($user)) {
            $r = $this->setPicture($request, $user);
            if ($r->getStatusCode() != 200)
                return $r;
        }

        $user->load('licensed');
        $user->load('managing');

        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $managing = $user->managing();
        $licensed = $user->licensed();

        // get related data and delete
        if (!$managing->get()->isEmpty())
            $managing->delete();

        if (!$licensed->get()->isEmpty())
            $licensed->delete();

        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        return User::where(function ($query) use ($search) {
            $query->where('email', 'like', '%' . $search . '%')
                ->orWhere('firstname', 'like', '%' . $search . '%')
                ->orWhere('lastname', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        })->paginate(5);
    }
}
