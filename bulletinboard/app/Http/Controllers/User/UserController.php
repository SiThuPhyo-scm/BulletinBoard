<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Redirect;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * SystemName: BulletinBoard
 * ModuleName: User
 */
class UserController extends Controller
{
    /**
     * Associated with the UserService
     *
     */
    private $userService;

    /**
     * Create a new Controller instance.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    /**
     * User List
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = new User;
        $search->name = $request->name;
        $search->email = $request->email;
        $search->startdate = $request->startdate;
        $search->enddate = $request->enddate;
        $users = $this->userService->getuser($search);
        return view('user.userList', compact('users','search'));
    }

    /**
     * Search User Detail
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = new User;
        $search->name = $request->name;
        $search->email = $request->email;
        $search->startdate = $request->startdate;
        $search->enddate = $request->enddate;
        $users = $this->userService->getuser($search);
        return view('user.userlist', compact('users','search'));
    }

    /**
     * User List with modal
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $this->userService->show($user_id = $request->id);
        return response()->json($user);
    }

    /**
     * Registration New User
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->forget([
            'search',
        ]);
        return view('user.create');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function createConfirm(UserRequest $request)
    {
        $validator = $request->validated();
        $user = $this->userService->createConfirm($request);
        return view('user.createConfirm', compact('user'));
    }

    /**
     * Store User Information
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert_user = $this->userService->store($request);
        return redirect()->intended('user')->with('success', 'User create successfully.');
    }

    /**
     * Show User Profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user_profile = $this->userService->profile($user_id = Auth::user()->id);
        return view('user.profile', compact('user_profile'));
    }

    /**
     * Show the form for Update User
     *
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $users = $this->userService->edit($user_id);
        return view('user.edit', compact('users'));
    }
    /**
     * Update user after a validion
     *
     * @param UpdateUserRequest $request
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function editConfirm(UpdateUserRequest $request, $user_id)
    {
        $validator = $request->validated();
        $user = $this->userService->editConfirm($request);
        return view('user.editConfirm', compact('user', 'user_id'));
    }

    /**
     * Update Profile in database
     *
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $users = $this->userService->update($request);
        return redirect()->intended('user/profile')
            ->withSuccess('Profile update successfully.');
    }

    /**
     * Delete User
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destory(Request $request)
    {
        $user = $this->userService->softDelete($request);
        return redirect()->intended('user')
            ->withSuccess('User delete successfully.');
    }

    /**
     * Show form for Change Password
     *
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function password($user_id)
    {
        return view('user.password', compact('user_id'));
    }

    /**
     * Store Change Password after validation
     *
     * @param PasswordRequest $request
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function changepassword(PasswordRequest $request, $user_id)
    {
        $validator = $request->validated();
        $status = $this->userService->changepassword($request, $user_id);
        if ($status) {
            return redirect()->intended('post')->withSuccess('Password change successfully.');
        } else {
            return redirect()->back()->with('Incorrect', 'The old password you have entered is incorrect. Please try again');
        }
    }
}
