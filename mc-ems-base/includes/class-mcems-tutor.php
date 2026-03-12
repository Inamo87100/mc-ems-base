<?php
if (!defined('ABSPATH')) exit;

class MCEMS_Tutor {

    public static function course_post_type(): string {
        if (post_type_exists('courses')) return 'courses';
        if (post_type_exists('tutor_course')) return 'tutor_course';
        return '';
    }

    public static function get_courses(): array {
        $pt = self::course_post_type();
        if (!$pt) return [];

        $ids = get_posts([
            'post_type'      => $pt,
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'fields'         => 'ids',
        ]);

        $out = [];
        foreach ($ids as $id) {
            $out[(int)$id] = get_the_title($id);
        }
        return $out;
    }

    public static function course_title(int $course_id): string {
        if ($course_id <= 0) return '';
        return (string) get_the_title($course_id);
    }

    /**
     * Check whether a user has a valid (active) Tutor LMS enrollment for a course.
     * Admins and instructors are always considered enrolled.
     */
    public static function is_user_enrolled(int $user_id, int $course_id): bool {
        if ($user_id <= 0 || $course_id <= 0) return false;

        // Bypass: admins and instructors do not need an enrollment
        if (user_can($user_id, 'manage_options')) return true;
        if (user_can($user_id, 'tutor_instructor') || user_can($user_id, 'tutor_instructor_manager')) return true;

        // Primary check: Tutor LMS API
        if (function_exists('tutor_utils') && method_exists(tutor_utils(), 'is_enrolled')) {
            return (bool) tutor_utils()->is_enrolled($course_id, $user_id);
        }

        // Fallback: query the tutor_enrolled post type directly
        $enrolled = get_posts([
            'post_type'      => 'tutor_enrolled',
            'post_status'    => 'completed',
            'post_parent'    => $course_id,
            'author'         => $user_id,
            'posts_per_page' => 1,
            'fields'         => 'ids',
        ]);

        return !empty($enrolled);
    }
}
