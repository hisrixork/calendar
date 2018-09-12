<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Category;
use App\Models\Wcalendar;
use App\Models\Worktime;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class WcalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        (new Calendar())->getOutDays();
        $user = Auth::user();
        $year = $_GET['year'] ?? Carbon::now()->year;
        $data = array(
            "hours"      => array(1, 2, 3, 4, 5, 6),
            "date"       => Carbon::now('Europe/Paris'),
            "categories" => Category::all(),
            "calendar"   => (new Calendar())->show(),
            "navi"       => (new Calendar())->navigation(),
            "counts"     => array(
                'f'  => Helpers::getCounter('f', $year, $user),
                'cp' => Helpers::getCounter('cp', $year, $user),
                'r'  => Helpers::getCounter('r', $year, $user),
                'am' => Helpers::getCounter('am', $year, $user),
                'cs' => Helpers::getCounter('cs', $year, $user),
                'a'  => Helpers::getCounter('a', $year, $user),
            ),
            "days"       => Helpers::getNumberRange(1, 31),
            "months"     => Helpers::getNumberRange(1, 12),
            "years"      => Helpers::getNumberRange(2015, 2030),
        );

        return view('pages.wcalendar.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function store(Request $request)
    {

        Wcalendar::unguard();

        $response = new JsonResponse();
        try {
            $data = json_decode(base64_decode($request->get('data')));
        } catch (JsonEncodingException $e) {
            $data = json_decode(json_encode([]));
        }

        $user = Auth::user();
        $start = Carbon::parse($data->start, 'Europe/Paris') ?? Carbon::now('Europe/Paris');
        $stop = Carbon::parse($data->stop, 'Europe/Paris') ?? Carbon::now('Europe/Paris');
        $category = $data->category ?? -1;
        $half = $data->half ?? 0;

        for ($i = $start; $i <= $stop; $i++) {

            if (!in_array($i->toDateString(), session()->get('we')) && !in_array($i->toDateString(), session()->get('out'))) {

                if (($wc = Wcalendar::where('start', $i)->where('id_user', $user->id)->first()) === null)
                    $wc = new Wcalendar([
                        'start'       => $i,
                        'stop'        => $stop,
                        'half'        => $data->half ?? 0,
                        'id_category' => $data->category ?? -1,
                        'id_user'     => $user->id ?? -1
                    ]);
                else {
                    $wc->setAttribute('start', $start);
                    $wc->setAttribute('stop', $stop);
                    $wc->setAttribute('half', $half);
                    $wc->setAttribute('id_category', $category);
                }
                $wc->save();
            }

            $i = $i->addDay();

        }


        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Worktime $worktime
     * @return \Illuminate\Http\Response
     */
    public function destroyAllInvalid()
    {
        Wcalendar::where('id_category', '-1')->delete();
        return response()->json();
    }


    public function goto($month, $year)
    {
        return redirect(route('wcalendar.index', ['month' => $month, 'year' => $year]));

    }
}
