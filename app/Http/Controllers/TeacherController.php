<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        $courses = $teacher->courses()
            ->where('start_time', '>=', now())
            ->get();

        return view('dashboard', ['courses' => $courses]);
    }

    public function create(Request $request)
    {
        $dateTime = Carbon::parse($request->input('start_date') . ' ' . $request->input('start_time'))->format('Y-m-d H:i:s');

        if (Carbon::now()->gte($dateTime)) {
            return redirect('/teacher/create')->withErrors('you sould set time after today');
        }

        Course::query()
            ->create([
                'name' => $request->input('name'),
                'teacher_id' => auth()->id(),
                'start_time' => $dateTime,
            ]);

        return redirect('/teacher/create')->with('success', 'Course has been create');
    }
}
