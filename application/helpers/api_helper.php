<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('api_success')) {
    function api_success($data = null, $message = null, $status_code = 200) {
        $response = ['success' => true];
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        if ($message) {
            $response['message'] = $message;
        }
        
        header('Content-Type: application/json');
        http_response_code($status_code);
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}

if (!function_exists('api_error')) {
    function api_error($message, $status_code = 400, $errors = null) {
        $response = [
            'success' => false,
            'message' => $message
        ];
        
        if ($errors) {
            $response['errors'] = $errors;
        }
        
        header('Content-Type: application/json');
        http_response_code($status_code);
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}

if (!function_exists('format_course_for_api')) {
    function format_course_for_api($course) {
        if (!$course) return null;
        
        return [
            'id' => $course->id,
            'title' => $course->title,
            'slug' => $course->slug,
            'description' => $course->description,
            'thumbnail' => $course->thumbnail,
            'price' => (float)$course->price,
            'is_featured' => (bool)$course->is_featured,
            'is_active' => (bool)$course->is_active,
            'category_id' => $course->category_id,
            'mentor_id' => $course->mentor_id,
            'rating' => (float)$course->rating,
            'total_students' => (int)$course->total_students,
            'created_at' => $course->created_at,
            'updated_at' => $course->updated_at
        ];
    }
}

if (!function_exists('format_user_for_api')) {
    function format_user_for_api($user) {
        if (!$user) return null;
        
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'role' => $user->role,
            'is_teacher' => (bool)$user->is_teacher,
            'is_mentor' => (bool)$user->is_mentor,
            'phone' => $user->phone,
            'bio' => $user->bio,
            'created_at' => $user->created_at
        ];
    }
}

if (!function_exists('format_lesson_for_api')) {
    function format_lesson_for_api($lesson) {
        if (!$lesson) return null;
        
        return [
            'id' => $lesson->id,
            'course_id' => $lesson->course_id,
            'title' => $lesson->title,
            'description' => $lesson->description,
            'video_url' => $lesson->video_url,
            'content' => $lesson->content,
            'duration' => $lesson->duration,
            'sort_order' => (int)$lesson->sort_order,
            'is_free_preview' => (bool)$lesson->is_free_preview,
            'created_at' => $lesson->created_at
        ];
    }
}

if (!function_exists('format_quiz_for_api')) {
    function format_quiz_for_api($quiz) {
        if (!$quiz) return null;
        
        return [
            'id' => $quiz->id,
            'course_id' => $quiz->course_id,
            'title' => $quiz->title,
            'description' => $quiz->description,
            'passing_score' => (int)$quiz->passing_score,
            'time_limit' => (int)$quiz->time_limit,
            'max_attempts' => (int)$quiz->max_attempts,
            'created_at' => $quiz->created_at
        ];
    }
}

if (!function_exists('format_question_for_api')) {
    function format_question_for_api($question, $include_answer = false) {
        if (!$question) return null;
        
        $data = [
            'id' => $question->id,
            'quiz_id' => $question->quiz_id,
            'question' => $question->question,
            'type' => $question->type,
            'points' => (int)$question->points,
            'sort_order' => (int)$question->sort_order
        ];
        
        // Decode options JSON
        if (!empty($question->options)) {
            $data['options'] = json_decode($question->options, true);
        }
        
        if ($include_answer) {
            $data['correct_answer'] = $question->correct_answer;
            $data['explanation'] = $question->explanation;
        }
        
        return $data;
    }
}

if (!function_exists('format_transaction_for_api')) {
    function format_transaction_for_api($transaction) {
        if (!$transaction) return null;
        
        return [
            'id' => $transaction->id,
            'uuid' => $transaction->uuid,
            'user_id' => $transaction->user_id,
            'total_amount' => (float)$transaction->total_amount,
            'discount_amount' => (float)$transaction->discount_amount,
            'final_amount' => (float)$transaction->final_amount,
            'status' => $transaction->status,
            'payment_method' => $transaction->payment_method,
            'payment_proof' => $transaction->payment_proof,
            'coupon_code' => $transaction->coupon_code,
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at
        ];
    }
}

if (!function_exists('format_certificate_for_api')) {
    function format_certificate_for_api($certificate) {
        if (!$certificate) return null;
        
        return [
            'id' => $certificate->id,
            'uuid' => $certificate->uuid,
            'user_id' => $certificate->user_id,
            'course_id' => $certificate->course_id,
            'certificate_number' => $certificate->certificate_number,
            'issued_date' => $certificate->issued_date,
            'created_at' => $certificate->created_at
        ];
    }
}

if (!function_exists('format_mentor_for_api')) {
    function format_mentor_for_api($mentor) {
        if (!$mentor) return null;
        
        return [
            'id' => $mentor->id,
            'name' => $mentor->name,
            'email' => $mentor->email,
            'avatar' => $mentor->avatar,
            'bio' => $mentor->bio,
            'expertise' => $mentor->expertise,
            'rating' => (float)$mentor->rating,
            'total_students' => (int)$mentor->total_students,
            'hourly_rate' => (float)$mentor->hourly_rate,
            'is_available' => (bool)$mentor->is_available
        ];
    }
}
