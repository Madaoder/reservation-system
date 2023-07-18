<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $courses = Course::query()
            ->with('teacher')
            ->where('start_time', '>=', now())
            ->paginate(10);

        return view('home', ['courses' => $courses]);
    }

    public function search(Request $request)
    {
        $name = $request->query('name');
        $courses = Course::query()
            ->with('teacher')
            ->where('name', 'like', '%' . $name . '%')
            ->orWhereHas('teacher', function (Builder $query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->where('start_time', '>=', now())
            ->paginate(10);

        return view('home', ['courses' => $courses]);
    }

    public function comment(Request $request, $id)
    {
        Comment::query()
            ->create([
                'message' => $request->input('message'),
                'student_id' => auth()->id(),
                'course_id' => $id,
            ]);
    }

    public function reserve($id)
    {
        $existReservation = Reservation::query()
            ->where([
                ['student_id', '=', auth()->id()],
                ['course_id', '=', $id]
            ])->first();

        if ($existReservation) {
            return redirect('/')->withErrors('Has been reserved');
        }

        $user = auth()->user();

        if ($user->points <= 0) {
            return redirect('/')->withErrors('points not empty');
        }

        $user->points--;

        DB::transaction(function () use ($id, $user) {
            Reservation::query()
                ->create([
                    'student_id' => auth()->id(),
                    'course_id' => $id,
                ]);

            $user->save();
        });

        return redirect('/')->with('success', 'Reserve success');
    }

    public function cancel($id)
    {
        $user = auth()->user();
        $reservation = Reservation::query()
            ->where([
                ['student_id', '=', auth()->id()],
                ['course_id', '=', $id]
            ])
            ->first();

        if (Carbon::now()->diffInSeconds($reservation->created_at) <= 3 * 24 * 60 * 60) {
            $user->points++;
            session('success', 'point has been return');
        } else {
            session('bad', 'point will not return');
        }

        DB::transaction(function () use ($reservation, $user) {
            $reservation->delete();

            $user->save();
        });

        return redirect('/student/myCourse');
    }

    public function check()
    {
        $courses = Course::query()
            ->with('teacher')
            ->whereExists(function (QueryBuilder $query) {
                $query->select(DB::raw(1))
                    ->from('reservations')
                    ->where('reservations.student_id', '=', auth()->id())
                    ->whereColumn('reservations.course_id', 'courses.id');
            })
            ->paginate(10);

        return view('student.myCourse', ['courses' => $courses]);
    }

    public function commentIndex(Course $course)
    {
        return view('student.commentForm', ['course' => $course]);
    }
}
