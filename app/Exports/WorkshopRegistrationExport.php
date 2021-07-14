<?php

namespace App\Exports;

use App\WorkshopRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkshopRegistrationExport implements FromView
{
    private $workshopId;
    public function __construct($workshop)
    {
        $this->workshopId = $workshop;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return WorkshopRegistration::where('workshop_id', $this->workshopId)->get();
    // }
    public function view(): View
    {
        return view('workshop.exportLayout', [
            'invoices' => WorkshopRegistration::where('workshop_id', $this->workshopId)->get()
        ]);
    }
}
