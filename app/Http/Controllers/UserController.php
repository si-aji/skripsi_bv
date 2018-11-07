<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Bestmomo\LaravelEmailConfirmation\Notifications\ConfirmEmail;
use Illuminate\Console\DetectsApplicationNamespace;




//Use RegisterContoller
use App\Http\Controllers\Auth\RegisterController;

class UserController extends Controller
{
    use DetectsApplicationNamespace;

    /**
     * Data for Json Format (all)
     */
    public function userJson(){
        $list = User::where([
            ['id', '!=', \Auth::user()->id]
        ]);
        return datatables()
                ->of($list)
                ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('staff.profile.index');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorProfile(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:191',
            'username' => 'required|string|min:5|max:191|unique:users,username,'.$data['id'],
            'email' => 'nullable|email|min:5|max:191|unique:users,email,'.$data['id'],
        ]);
    }
    protected function validatorProfilePassword(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
    /**
     * Notify user with email
     *
     * @param  Model $user
     * @return void
     */
    protected function notifyUser($user)
    {
        $class = $this->getAppNamespace() . 'Notifications\ConfirmEmail';

        if (!class_exists($class)) {
            $class = ConfirmEmail::class;
        }

        $user->notify(new $class);
    }
    public function profileUpdate(Request $request, $id){
        $this->validatorProfile($request->all())->validate();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;

        if($request->email != ""){
            if($request->email != $user->email){
                //Ganti email
                $user->email = $request->email;
                $user->email_verified_at = null;
                //Notify user if user insert an email in form
                $sentmail = (new RegisterController)->resend($request);
            }
        } else {
            $user->email = $request->email;
        }

        if($request->password != ""){
            //Password validation
            $this->validatorProfilePassword($request->all())->validate();
            $user->password = Hash::make($request->password);
        }

        $message = [
            'status' => 'success',
            'message' => $user->name.' successfully updated!',
            'response' => $user->save(),
        ];
        return response()->json($message);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.karyawan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return (new RegisterController)->register($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:191',
            'username' => 'required|string|min:5|max:191|unique:users,username,'.$data['id'],
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validatorUpdate($request->all())->validate();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $message = [
            'status' => 'success',
            'message' => $user->name.' successfully updated!',
            'response' => $user->save(),
        ];
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if($request->permintaan == "hapus"){
            $user->status = "Tidak Aktif";
        } else {
            if($request->permintaan == "reset"){
                $user->password = Hash::make("bakulvisor");
            } else {
                if($request->permintaan == "upgrade"){
                    $user->level = "Admin";
                } else if($request->permintaan == "downgrade"){
                    $user->level = "Karyawan";
                } else {
                    $user->status = "Aktif";
                }
            }
        }

        $message = [
            'status' => 'success',
            'message' => $user->name.' successfully updated!',
            'response' => $user->save(),
        ];
        return response()->json($message);
    }
}
