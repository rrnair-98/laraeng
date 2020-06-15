<?php


namespace App\Features\Courses\Http\Controllers;


use App\Features\Courses\Models\Course;
use App\Features\Courses\Queries\CourseQuery;
use App\Features\Courses\Transactors\CourseTransactor;
use App\Features\Users\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    private CourseTransactor    $courseTransactor;
    private CourseQuery         $courseQuery;
    public function __construct(CourseTransactor $courseTransactor, CourseQuery $courseQuery)
    {
        $this->courseQuery      = $courseQuery;
        $this->courseTransactor = $courseTransactor;
        $this->middleware('auth');

    }

    public function index() {
        return view('course');
    }


    public function createCourse(Request $request) {
        return $this->courseTransactor->create(Auth::id(), $request->all());
    }


}
