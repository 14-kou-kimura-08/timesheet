<?php

namespace App\Http\Controllers;

use App\Company;
use App\Plan;
use App\Timesheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimesheetController extends Controller
{
    /**
     * The timesheet repository instance.
     */
    protected $timesheets;

    /**
     * The company repository instance.
     */
    protected $company;

    /**
     * The plan repository instance.
     */
    protected $plan;

    /**
     * Create a new controller instance.
     *
     * @param Timesheet $timesheets
     * @param Company $company
     * @param Plan $plan
     */
    public function __construct(Timesheet $timesheets, Company $company, Plan $plan)
    {
        $this->timesheets = $timesheets;
        $this->company    = $company;
        $this->plan       = $plan;
    }

    public function index()
    {
        return view('timesheets.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'year'  => 'required|numeric',
            'month' => 'required|numeric',
        ]);

        // 指定された年月の初日を取得
        $firstOfMonth = Carbon::create($validatedData['year'], $validatedData['month'])->firstOfMonth();

        // 指定された年月の最終日を取得
        $lastOfMonth = Carbon::create($validatedData['year'], $validatedData['month'])->lastOfMonth();

        // 指定された年月の初日と最終日をつかってループ処理をする
        // エラーが発生したときに途中で作成されたデータを破棄するためにトランザクションを利用
        DB::transaction(function () use ($firstOfMonth, $lastOfMonth) {
            for ($date = $firstOfMonth; $date <= $lastOfMonth; $date->addDay()) {
                // $dayは何曜日か
                $dayName = $date->isoFormat('dddd');

                // その曜日のplanは何か？
                // 会社のidはログインユーザーが所属しているidを取得したい
                $plans = $this->plan->where(['company_id' => 1, 'day_name' => $dayName])->get();

                // そのplanをOKと言っているひとは誰か
                foreach ($plans as $plan) {
                    // 会社が必要な人数よりも多いかどうかで処理を変える、そうしないとエラーになる
                    if ($plan->users->count() >= $plan->number_of_people) {
                        $users = $plan->users->random($plan->number_of_people);
                    } else {
                        $users = $plan->users->random($plan->users->count());
                    }
                    // データ追加する、もし対象ユーザーがいなくてもループが回らないのでエラーにはならない
                    foreach ($users as $user) {
                        $this->timesheets->create([
                            'plan_id' => $plan->id,
                            'user_id' => $user->id,
                            'date'    => $date->format('Y-m-d'),
                        ]);
                    }
                }
            }
        });

        return redirect('/timesheets')->with('message', $validatedData['year'] . '年' . $validatedData['month'] . '月のタイムシートを作成しました');
    }

    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'year'  => 'required|numeric',
            'month' => 'required|numeric',
        ]);

        // 指定された年月の初日を取得
        $firstOfMonth = Carbon::create($validatedData['year'], $validatedData['month'])->firstOfMonth();

        // 指定された年月の最終日を取得
        $lastOfMonth = Carbon::create($validatedData['year'], $validatedData['month'])->lastOfMonth();

        $deletedCount = $this->timesheets->where('date', '>=' , $firstOfMonth->format('Y-m-d'))
                         ->where('date', '<=' , $lastOfMonth->format('Y-m-d'))
                         ->delete();

        if ($deletedCount > 0) {
            $message = $validatedData['year'] . '年' . $validatedData['month'] . '月のタイムシートを削除しました';
        } else {
            $message = $validatedData['year'] . '年' . $validatedData['month'] . '月のデータはありませんでした。';
        }

        return redirect('/timesheets')->with('message', $message);
    }
}
