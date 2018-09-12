<?php
/**
 * File app/Helpers.php
 *
 * Ce fichier contient des fonctions globales
 * utiles pour le fonctionnement du projet
 *
 * @author sofianeakbly
 */

namespace App;

use App\Models\Category;
use App\Models\Wcalendar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Helpers
 *
 * @package App
 */
class Helpers
{


    public static $days = [
        'week' => [],
        'we'   => [],
        'out'  => []
    ];

    public function __construct()
    {

    }

    public static function isActive($date = null)
    {
        $user = Auth::user();
        $wc = Wcalendar::where('id_user', '=', $user->id)
            ->where('start', '=', Carbon::parse($date)->toDateString())
            ->orWhere('stop', '=', Carbon::parse($date)->toDateString())->first();
        $color = null;

        if ($wc !== null && ($type = Category::where('id', $wc->id_category)->first()) !== null)
            $color = strtoupper($type->name);
        if (in_array(Carbon::parse($date)->toDateString(), session()->get('out')))
            $color = 'out';

        $half = $wc !== null && (int)$wc->half === 1 ? ' half' : '';

        return $wc !== null || Carbon::now()->toDateString() === Carbon::parse($date)->toDateString() || $color ? ("$color$half" ?? '') . ' active' : '';
    }

    /*public static function getCat($date = null)
    {
        $user = Auth::user();
        if ($date !== null &&
            ($wc = Wcalendar::where('id_user', '=', $user->id)
                ->where('start', '=', Carbon::parse($date)->toDateString())
                ->orWhere('stop', '=', Carbon::parse($date)->toDateString())->first()) !== null &&
            ($type = Category::where('id', $wc->id_category)->first()) !== null)
            $cat = $type->name;
        else
            $cat = null;

        return strtoupper($cat);
    }*/

    public static function getCounter($category, $year, $user = null)
    {
        $user = $user ?? Auth::user();
        $full = DB::table('wcalendars')
            ->where('id_user', $user->getAuthIdentifier())
            ->where('start', '>=', $year . "-01-01")
            ->where('stop', '<', $year + 1 . "-01-01")
            ->where('id_category', Category::where('name', strtoupper($category))->first()->id ?? -1)
            ->get();

        $half = 0;

        foreach ($full as $f)
            $half += $f->half ? 1 : 0;
        return count($full) - ($half / 2);
    }

    public static function getColorByCategory($category)
    {
        $categories = array(
            'F'  => 'dc3545',
            'CP' => '28a745',
            'R'  => 'ffc107',
            'AM' => '00695c',
            'CS' => 'ef6c00',
            'A'  => 'aa66cc',
        );

        return $categories[$category] ?? '';
    }

    public static function getNumberRange($min, $max)
    {
        $arr = [];

        for ($i = $min; $i <= $max; $i++)
            $arr[] = $i;

        return $arr;
    }

}