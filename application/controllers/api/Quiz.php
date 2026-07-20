<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Quiz extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Quiz_model');
        $this->load->model('Question_model');
        $this->load->model('Quiz_attempt_model');
        $this->load->model('Course_model');
        $this->load->model('Course_enrollment_model');
    }
    
    /**
     * GET /api/quizzes/:id
     * Get quiz detail with questions
     */
    public function show($id) {
        $quiz = $this->Quiz_model->get_quiz_by_id($id);
        
        if (!$quiz) {
            $this->response_error('Quiz not found', 404);
        }
        
        $data = format_quiz_for_api($quiz);
        
        // Add course info
        $course = $this->Course_model->get_course_by_id($quiz->course_id);
        if ($course) {
            $data['course'] = [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug
            ];
        }
        
        // Check if user already attempted
        if ($this->user_id) {
            $attempts = $this->Quiz_attempt_model->get_user_attempts($this->user_id, $id);
            $data['attempts'] = array_map(function($attempt) {
                return [
                    'id' => $attempt->id,
                    'score' => $attempt->score,
                    'total_points' => $attempt->total_points,
                    'is_passed' => (bool)$attempt->is_passed,
                    'started_at' => $attempt->started_at,
                    'finished_at' => $attempt->finished_at
                ];
            }, $attempts);
        }
        
        $this->response($data);
    }
    
    /**
     * POST /api/quizzes/:id/start
     * Start a quiz attempt
     */
    public function start($id) {
        $this->require_auth();
        
        $quiz = $this->Quiz_model->get_quiz_by_id($id);
        
        if (!$quiz) {
            $this->response_error('Quiz not found', 404);
        }
        
        // Check enrollment
        $enrollment = $this->Course_enrollment_model->get_enrollment($this->user_id, $quiz->course_id);
        if (!$enrollment) {
            $this->response_error('Not enrolled in this course', 403);
        }
        
        // Check attempt limit
        $attempt_count = $this->Quiz_attempt_model->count_user_attempts($this->user_id, $id);
        if ($quiz->max_attempts > 0 && $attempt_count >= $quiz->max_attempts) {
            $this->response_error('Maximum attempts reached', 400);
        }
        
        // Create attempt
        $attempt_data = [
            'quiz_id' => $id,
            'user_id' => $this->user_id,
            'started_at' => date('Y-m-d H:i:s'),
            'status' => 'in_progress'
        ];
        
        $attempt_id = $this->Quiz_attempt_model->create_attempt($attempt_data);
        
        if (!$attempt_id) {
            $this->response_error('Failed to start quiz', 500);
        }
        
        // Get questions (without answers)
        $questions = $this->Question_model->get_questions_by_quiz($id);
        
        $formatted_questions = array_map(function($question) {
            return format_question_for_api($question, false);
        }, $questions);
        
        $this->response([
            'attempt_id' => $attempt_id,
            'quiz' => format_quiz_for_api($quiz),
            'questions' => $formatted_questions
        ], 201, 'Quiz started');
    }
    
    /**
     * POST /api/quizzes/:id/submit
     * Submit quiz answers
     */
    public function submit($id) {
        $this->require_auth();
        
        $input = $this->get_json_input();
        $attempt_id = $input['attempt_id'] ?? 0;
        $answers = $input['answers'] ?? [];
        
        if (empty($attempt_id) || empty($answers)) {
            $this->response_error('Attempt ID and answers are required');
        }
        
        // Verify attempt belongs to user
        $attempt = $this->Quiz_attempt_model->get_attempt_by_id($attempt_id);
        
        if (!$attempt || $attempt->user_id != $this->user_id || $attempt->quiz_id != $id) {
            $this->response_error('Invalid attempt', 400);
        }
        
        if ($attempt->finished_at) {
            $this->response_error('Quiz already submitted', 400);
        }
        
        // Get questions for grading
        $questions = $this->Question_model->get_questions_by_quiz($id);
        $total_points = 0;
        $score = 0;
        $results = [];
        
        foreach ($questions as $question) {
            $total_points += $question->points;
            $user_answer = $answers[$question->id] ?? '';
            $is_correct = false;
            
            if ($question->type === 'multiple_choice' || $question->type === 'true_false') {
                $is_correct = strtolower($user_answer) === strtolower($question->correct_answer);
                if ($is_correct) {
                    $score += $question->points;
                }
            } elseif ($question->type === 'short_answer') {
                // Case-insensitive comparison
                $is_correct = strtolower(trim($user_answer)) === strtolower(trim($question->correct_answer));
                if ($is_correct) {
                    $score += $question->points;
                }
            } else {
                // Essay - needs manual grading
                $is_correct = null;
            }
            
            $results[] = [
                'question_id' => $question->id,
                'user_answer' => $user_answer,
                'is_correct' => $is_correct,
                'points_earned' => $is_correct === true ? $question->points : 0
            ];
        }
        
        $is_passed = $score >= ($quiz->passing_score ?? 70);
        
        // Update attempt
        $this->Quiz_attempt_model->update_attempt($attempt_id, [
            'answers' => json_encode($answers, JSON_UNESCAPED_UNICODE),
            'score' => $score,
            'total_points' => $total_points,
            'is_passed' => $is_passed ? 1 : 0,
            'finished_at' => date('Y-m-d H:i:s'),
            'status' => 'completed'
        ]);
        
        $this->response([
            'attempt_id' => $attempt_id,
            'score' => $score,
            'total_points' => $total_points,
            'percentage' => $total_points > 0 ? round(($score / $total_points) * 100) : 0,
            'is_passed' => $is_passed,
            'results' => $results
        ], 200, 'Quiz submitted');
    }
    
    /**
     * GET /api/quizzes/:id/result/:attempt_id
     * Get quiz attempt result
     */
    public function result($id, $attempt_id) {
        $this->require_auth();
        
        $attempt = $this->Quiz_attempt_model->get_attempt_by_id($attempt_id);
        
        if (!$attempt || $attempt->user_id != $this->user_id || $attempt->quiz_id != $id) {
            $this->response_error('Invalid attempt', 404);
        }
        
        $quiz = $this->Quiz_model->get_quiz_by_id($id);
        
        if (!$quiz) {
            $this->response_error('Quiz not found', 404);
        }
        
        $questions = $this->Question_model->get_questions_by_quiz($id);
        $user_answers = json_decode($attempt->answers, true) ?: [];
        
        $formatted_questions = array_map(function($question) use ($user_answers) {
            $data = format_question_for_api($question, true);
            $data['user_answer'] = $user_answers[$question->id] ?? '';
            return $data;
        }, $questions);
        
        $this->response([
            'quiz' => format_quiz_for_api($quiz),
            'attempt' => [
                'id' => $attempt->id,
                'score' => (int)$attempt->score,
                'total_points' => (int)$attempt->total_points,
                'percentage' => $attempt->total_points > 0 ? round(($attempt->score / $attempt->total_points) * 100) : 0,
                'is_passed' => (bool)$attempt->is_passed,
                'started_at' => $attempt->started_at,
                'finished_at' => $attempt->finished_at
            ],
            'questions' => $formatted_questions
        ]);
    }
}
