<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Pages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('page_model');
    }

    public function quiz()
    {
        $data['title'] = "Quiz";

        // $this->load->view('header', $data);
        $this->load->view('pages/quiz', $data);
        // $this->load->view('footer', $data);
    }

    public function fetchQuiz($set) {
        // $set = $this->uri->sagement();
        $this->load->model('page_model');
        $data['data'] = $this->page_model->extract_quiz($set);
       
        $arr = array();
        $final_array = array();
        foreach($data['data'] as $quiz ) {
            $arr['id'] = $quiz->id;
            $arr['questions'] = $quiz->questions;
            //echo $quiz->option1.'<br>';
            //$values = $quiz->option1.','.$quiz->option2.','.$quiz->option3.','.$quiz->option4;
            $arr['options'] =  array($quiz->option1,$quiz->option2, $quiz->option3,$quiz->option4);
            $arr['answer'] = $quiz->answer;
            $final_array[] = $arr;
        }

        $questionJSON = json_encode($final_array);
        echo $questionJSON;

        // echo "<pre>";
        // print_r($final_array);
        // echo "</pre>";

        // exit;

    }

    public function fetchSet(){
        $this->load->model('page_model');
        $data['data'] = $this->page_model->extract_set();

        $set_array = array();
        foreach($data['data'] as $set ) {
            //echo $set->question_set.'<br>';
            if(!in_array($set->question_set, $set_array)){
                $set_array[]=$set->question_set;
            }
        }

        // echo "<pre>";
        // print_r($set_array);
        // exit;
        $setJSON = json_encode($set_array);
        echo $setJSON;
    }

    public function quizSubmit()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('question_set', 'Question set', 'trim|required');
        $this->form_validation->set_rules('questions', 'Questions', 'trim|required');
        $this->form_validation->set_rules('option1', 'Option1', 'trim|required');
        $this->form_validation->set_rules('option2', 'Option2', 'trim|required');
        $this->form_validation->set_rules('option3', 'Option3', 'trim|required');
        $this->form_validation->set_rules('option4', 'Option4', 'trim|required');
        $this->form_validation->set_rules('answer', 'Answer', 'trim|required');

        if ($this->form_validation->run() == false) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
        }
        else {
            $quizData = array(
                'questions' => $this->input->post('questions', true),
                'option1' => $this->input->post('option1', true),
                'option2' => $this->input->post('option2', true),
                'option3' => $this->input->post('option3', true),
                'option4' => $this->input->post('option4', true),
                'answer' => $this->input->post('answer', true),
                'question_set' => $this->input->post('question_set', true),
                'created_at' => date('Y-m-d H:i:s')
            );

            $id = $this->page_model->insert_quiz($quizData);

            $response = array(
                'status' => 'success',
                'message' => "<h3>Quiz created successfully.</h3>"
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
?>