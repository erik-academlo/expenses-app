<?php

namespace App\Jobs;

use App\Imports\ExpensesImport;
use App\Mail\ExcelUploaded;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ImportExpensesExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $user)
    {
        $this->file = $file;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $import = new ExpensesImport($this->user->id);
        Excel::import($import, $this->file);

        $categoryCounts = $import->categoryCounts;

        Mail::to($this->user->email)->send(new ExcelUploaded($this->user, $categoryCounts));
    }
}
