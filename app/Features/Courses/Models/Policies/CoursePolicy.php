<?php


namespace App\Courses\Models\Policies;

use App\Features\Users\Models\User;
use App\Courses\Models\Course;

class CoursePolicy {
    public function update(User $user, Course $course) {
        return $user->id === $course->created_by || $user->isAdmin();
    }

    public function create(User $user) {
        return $user->isTeacher() || $user->isAdmin();
    }

    public function delete(User $user) {
        return $user->isTeacher() || $user->isAdmin();
    }
}
