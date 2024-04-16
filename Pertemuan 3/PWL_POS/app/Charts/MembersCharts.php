<?php

namespace App\Charts;

use App\Models\LevelModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MembersCharts
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\lineChart
    {
        $levelMember = LevelModel::where('level_nama', 'Member')->first();
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        
        $dataRaw = DB::select(
        "SELECT count(user_id) as count, DATE_FORMAT(u.created_at, '%W %d %M') as day 
        FROM m_user as u 
        WHERE u.level_id =".$levelMember->level_id." and  u.created_at >=".$start."
        GROUP by day"
        );

        //parse array to collection
        $dataRaw = collect($dataRaw);
        //to hold processed data
        $processedData = collect();

        for ($i=0; $i < ((Int) Carbon::now()->format('d')); $i++) { 
            $comparisonDate =  Carbon::now()->subDays($i)->format('l d F');

            $existDate = $dataRaw->where('day', $comparisonDate);

            if($existDate->isEmpty()){
                $processedData->prepend([
                    'count' => 0,
                    'day' => $comparisonDate
                ]);
            }else{
                $processedData->prepend([
                    'count' => $existDate->first()->count,
                    'day' => $existDate->first()->day
                ]);
            }
        }

        //Number of registrants
        $data =$processedData->pluck('count')->toArray();

        //Date
        $date = $processedData->pluck('day')->toArray();
        
        // dd($data->pluck('count'), $data->pluck('day'));

        return $this->chart->lineChart()
            ->setTitle('Registrasi User')
            ->setSubtitle(' Perkembangan Registrasi User Bulan '.Carbon::now()->format('F'))
            ->addData('Jumlah User Register', $data)
            ->setXAxis($date)
            ->setColors(['#9C88FF'])
            ->setMarkers(['#4E31E4'], 8);
    }
}
