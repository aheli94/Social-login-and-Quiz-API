<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model
{
    public function insert_quiz($quizData)
    {
        $this->db->insert('quiz', $quizData);
        return $this->db->insert_id();
    }

    public function extract_quiz($set) {
        //return $this->db->get_where('quiz', ['question_set'=>'Set 1'])->result();
        //return $this->db->get('quiz')->where('question_set','Set 1');
        $this->db->where('question_set', $set);
        $query = $this->db->get('quiz');
        $result=$query->result();

        return $result;
    }

    public function extract_set(){
        $this->db->select('question_set');
        $query = $this->db->get('quiz');
        $result = $query->result();
        return $result;
    }
}
?>