<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Branch;
use App\Models\DailyReport;

class GenerateDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-daily-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $branches = Branch::all();

        foreach ($branches as $branch) {

            DailyReport::firstOrCreate(
                [
                    'branch_id' => $branch->id,
                    'report_date' => $today,
                ],
                [
                    'total_before_tax' => 0,
                    'tax' => 0,
                    'total_after_tax' => 0,
                    'net_sales' => 0,
                ]
            );
        }

        $this->info('Daily reports checked/generated successfully.');
    }
}
