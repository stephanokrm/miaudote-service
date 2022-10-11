<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var ImageService
     */
    private ImageService $imageService;

    /**
     * @param  ImageService  $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @param  StoreUserRequest  $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $avatar = $this->imageService->upload($request->file('avatar'));

        $user = new User();
        $user->fill($request->all());
        $user->setAttribute('avatar', $avatar);
        $user->setAttribute('password', Hash::make($request->input('password')));
        $user->save();

        return new UserResource($user);
    }

    /**
     * @param  User  $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $user->fill($request->all());

        if ($request->hasFile('avatar')) {
            $avatar = $this->imageService->upload($request->file('avatar'));

            $user->setAttribute('avatar', $avatar);
        }

        $user->save();

        if ($user->wasChanged('avatar')) {
            $this->imageService->delete($user->getOriginal('avatar'));
        }

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * @param  Request  $request
     * @return UserResource
     */
    public function me(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
