<?php

declare(strict_types=1);

use App\Models\RouletteLink;
use App\Models\RouletteScore;
use Illuminate\Support\Enumerable;

/**
 * @var RouletteLink $link
 * @var Enumerable $attemptsList
 */
?>

    <!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>History</title></head>
<body>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
        @endforeach
    </ul>
@endif

<a href="{{ route('roulette.index', [$link->getSlug()]) }}">To page A</a>

<pre>
    @dump($attemptsList->toArray())
</pre>

<table>
    <thead>
    <tr>
        <th scope="col">Score</th>
        <th scope="col">Is won</th>
        <th scope="col">Reward</th>
    </tr>
    </thead>
    <tbody>
    @foreach($attemptsList as $attempt)
            <?php /** @var RouletteScore $attempt */ ?>
        <tr>
            <th>{{ $attempt->getScore() }}</th>
            <td>@if($attempt->isWon())
                    {{ "Yes" }}
                @else
                    {{ "No" }}
                @endif</td>
            <td>{{ $attempt->getReward() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

