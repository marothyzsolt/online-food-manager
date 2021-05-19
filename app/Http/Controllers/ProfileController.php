<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\CourierActivity;
use App\Models\User;
use App\Services\IntervalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct(private IntervalService $intervalService)
    {
    }

    public function show(): Response
    {
        $user = auth()->user();

        switch (auth()->user()->type) {
            case User::TYPE_COURIER:
                return $this->view('courier.profile', compact('user'));
        }

        return $this->view('profile');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->update($request->all());

        $days = $request->get('days');
        $intervals = $this->intervalService->generateInterval(CourierActivity::class, $days);

        $user->activities()->delete();
        $user->activities()->saveMany($intervals);

        return $this->back(true);
    }
}
