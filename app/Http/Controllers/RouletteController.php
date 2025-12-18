<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\RouletteLink;
use App\Models\User;
use App\Services\RouletteLinkService;
use App\Services\RouletteScoreService;
use App\Services\RouletteService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RouletteController extends Controller
{
    public function index(Request $request, RouletteLink $rouletteLink): Renderable
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->getId() !== $rouletteLink->getUserId()) {
            abort(403);
        }

        return view('roulette.index', ['link' => $rouletteLink]);
    }

    public function createNewLink(Request $request, RouletteLinkService $rouletteLinkService): Response
    {
        /** @var User $user */
        $user = $request->user();

        $rouletteLinkService->cancelUserActiveLink($user);
        $link = $rouletteLinkService->create($user);

        return redirect()->to(route('roulette.index', [$link->getSlug()]));
    }

    public function span(Request $request, RouletteLink $rouletteLink, RouletteService $roulette): Renderable
    {
        $score = $roulette->span($rouletteLink);
        return view('roulette.index', ['link' => $rouletteLink, 'score' => $score]);
    }

    public function history(Request $request, RouletteLink $rouletteLink, RouletteScoreService $rouletteScoreService): Renderable
    {
        $attemptsList = $rouletteScoreService->getHistory($rouletteLink);
        return view('roulette.history', ['link' => $rouletteLink, 'attemptsList' => $attemptsList]);
    }
}
