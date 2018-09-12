<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Category;
use App\Models\Wcalendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExportController extends Controller
{

    public function index($year)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('Sofiane Akbly')
            ->setLastModifiedBy('Sofiane Akbly')
            ->setTitle('Liste des congés pris au cours de l\'année choisie')
            ->setSubject('Congés')
            ->setDescription('A Simple Excel Spreadsheet generated using PhpSpreadsheet.')
            ->setKeywords('Microsoft office 2013 php PhpSpreadsheet')
            ->setCategory('Test file');

        try {
            $spreadsheet->getActiveSheet()->setTitle('Simple');
            $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);

            $this->setDays($spreadsheet, $year);
            $this->setTotals($spreadsheet, $year);

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="repos.' . Carbon::now()->timestamp . '.' . Carbon::now()->year . '.xlsx"');
            $writer->save("php://output");
        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
        }
    }

    public function setDays(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet, $year)
    {
        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');

        $days = [];
        $user = Auth::user();

        for ($i = Carbon::parse($year . '/01/01'); $i < Carbon::parse(($year + 1) . '/01/01'); $i->addDay())
            $days[] = Carbon::parse($i->toDateString());

        $last = $days[0];
        $index = 1;

        foreach ($days as $i => $day) {
            try {

                if (($wc = Wcalendar::where('id_user', '=', $user->id)
                        ->where('start', '=', Carbon::parse($day)->toDateString())
                        ->orWhere('stop', '=', Carbon::parse($day)->toDateString())->first()) !== null &&
                    ($cat = $type = Category::where('id', $wc->id_category)->first()) !== null) {

                    $spreadsheet->getActiveSheet()->setCellValue('A' . $index, $day->toDateString());
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $index, $type->name);
                    $spreadsheet->getActiveSheet()->getStyle('B' . $index)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(Helpers::getColorByCategory($type->name));
                    $spreadsheet->getActiveSheet()->getStyle('B' . $index)->getFont()->getColor()->setARGB('FFFFFF');
                    $spreadsheet->getActiveSheet()->getStyle('A' . $index)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $spreadsheet->getActiveSheet()->getStyle('B' . $index)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

                    $index++;

                }
            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            }
        }
    }

    public function setTotals(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet, $year)
    {
        $categories = Category::all();

        try {
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Totaux');
            foreach ($categories as $index => $category) {
                $nb = Helpers::getCounter($category->name, $year);
                $spreadsheet->getActiveSheet()->setCellValue('D' . ($index + 2), ucfirst($category->label));
                $spreadsheet->getActiveSheet()->setCellValue('E' . ($index + 2), $nb);
            }

        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
        }
    }

    public function getRoute()
    {
    }
}
