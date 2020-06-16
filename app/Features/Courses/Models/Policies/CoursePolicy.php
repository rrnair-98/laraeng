<?php


namespace App\Features\Courses\Models\Policies;

use App\Features\Users\Models\User;
use App\Features\Courses\Models\Course;

class CoursePolicy {
    public function update(User $user, Course $course) {
        return $user->id === $course->created_by || $user->isAdmin() || $user->isOps();
    }

    public function create(User $user) {
        return $user->isTeacher() || $user->isAdmin() || $user->isOps();
    }

    public function delete(User $user, Course $course) {
        return $course->isOwner($user->id) || $user->isAdmin() || $user->isOps();
    }
}
