<?php

declare(strict_types=1);

use App\Models\RouletteLink;
use App\Models\RouletteScore;

/**
 * @var RouletteLink $link
 * @var null|RouletteScore $score
 */
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page A</title></head>
<body>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('roulette.createNewLink') }}">
    @csrf
    <button type="submit">Generate new</button>
</form>

<br>

<a href="{{ route('roulette.history', [$link->getSlug()]) }}">History</a>

<br>

@if(!$link->isActive())
    <p>Your link is expired. Generate new</p>
@else
    <form method="POST" action="{{ route('roulette.span', [$link->getSlug()]) }}">
        @csrf
        <button type="submit">I'm feeling lucky</button>
    </form>
@endif

@isset($score)
    <table>
        <thead>
        <tr>
            <th scope="col">Score</th>
            <th scope="col">Is won</th>
            <th scope="col">Reward</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>{{ $score->getScore() }}</th>
            <td>@if($score->isWon()) {{ "Yes" }} @else {{ "No" }} @endif</td>
            <td>{{ $score->getReward() }}</td>
        </tr>
        </tbody>
    </table>
@endisset

</body>
</html>
