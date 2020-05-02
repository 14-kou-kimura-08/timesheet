<?php

namespace App\Http\Controllers;

use App\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    /**
     * The timesheet repository instance.
     */
    protected $timesheets;

    /**
     * Create a new controller instance.
     *
     * @param Timesheet $timesheets
     */
    public function __construct(Timesheet $timesheets)
    {
        $this->timesheets = $timesheets;
    }

    public function index()
    {
        return view('timesheets.index');
    }

    public function store()
    {
        return redirect('/timesheets');
    }
}
