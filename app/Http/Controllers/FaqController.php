<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __invoke(): View
    {
        // Linkurile spre articole încă nepublicate (din coada zilnică) nu se afișează, ca să nu ducă la 404.
        $published = Post::query()->published()->pluck('slug')->all();

        $groups = collect(config('faq', []))->map(function ($g) use ($published) {
            $g['items'] = array_map(function ($i) use ($published) {
                [$q, $a, $link] = $i + [2 => null];
                if ($link && str_starts_with($link, '/blog/') && ! in_array(substr($link, 6), $published, true)) {
                    $link = null;
                }

                return ['q' => $q, 'a' => $a, 'link' => $link];
            }, $g['items']);

            return $g;
        })->all();

        return view('pages.faq', ['groups' => $groups]);
    }
}
