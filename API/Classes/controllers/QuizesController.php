<?php
    class QuizesController{
        /**
         * Get all active quizes
         *
         * @param $request
         * @return [array] $res - all active quizes 
         */
        public function getQuizes($request){
            $db = new database;
            $query = "SELECT * FROM QUIZ WHERE QUIZ_STATUS = '1'";
            $res = $db->getData($query);
            return $res;
        }

        /**
         * Get selected quiz questions and answers for each question
         *
         * @param $request
         * @return void
         */
        public function getQuizQuestions($request){
            $db = new database;
            $inputs = $request->parameters;
            $query = "
            SELECT QZ.ID, QZ.QUIZ_NAME, QQ.QUIZ_QUESTION_ID, QQ.QUIZ_QUESTIONS, QA.QUIZ_ANSWER_ID, QA.QUIZ_ANSWER 
            FROM QUIZ QZ
            INNER JOIN QUIZ_QUESTION QQ ON QZ.ID = QQ.QUIZ_ID
            INNER JOIN QUIZ_ANSWERS QA ON QZ.ID = QA.QUIZ_ID AND QQ.QUIZ_QUESTION_ID = QA.QUIZ_QUESTION_ID 
            WHERE QZ.ID = '".$inputs['ID']."'";

            $res = $db->getData($query);
            $result = array();
            if(!empty($res)){
                $result = array(
                    "quiz_name" => $res[0]['QUIZ_NAME'],
                    "quiz_id" => $res[0]['ID'],
                    
                    "questions" =>array(),
                    "answers" =>array()
                );
                foreach($res as $key => $row){
                    if(array_key_exists($row['QUIZ_QUESTION_ID'], $result['questions'])){
                        $result['answers'][$row['QUIZ_QUESTION_ID']][]=array(
                            "answer" => $row['QUIZ_ANSWER'],
                            "answer_id" => $row['QUIZ_ANSWER_ID']                        
                        );
                    }else{
                        $result['questions'][ $row['QUIZ_QUESTION_ID']]= array(
                            "question_id" => $row['QUIZ_QUESTION_ID'],
                            "question" => $row['QUIZ_QUESTIONS']
                        );
                        $result['answers'][$row['QUIZ_QUESTION_ID']][]= array(
                            "answer" => $row['QUIZ_ANSWER'],
                            "answer_id" => $row['QUIZ_ANSWER_ID']                        
                        );
                    }
                }
            }else{
                $result['quiz_name'] = "Sorr! No data found!";
            }
            $result["question_count"] = count($result['questions']);
            return json_encode($result);
        }

        /**
         * Saving selected answer
         *
         * @param $request->paprameters[
         *      attempt_id,
         *      user,
         *      quiz_id,
         *      question,
         *      Answer,
         * ]
         * @return void
         */
        public function saveAnswer($request){
            $db = new database;
            $inputs = $request->parameters;
            $res = array();
            $corectAnswer = 0;
            if(!empty($inputs)){
                // checking if provided answer is corect
                $corectAnswer = $this->checkSavedAnsewer($inputs);
                $query = "INSERT INTO quiz_responses 
                    (QUIZ_RESPONSE_ID, QUIZ_RESPONSE_USER, QUIZ_ID, QUIZ_QUESTOON_ID, QUIZ_GIVEN_ANSWER_ID, QUIZ_ANSWER_CORRECT)
                VALUES
                    ('".$inputs['attempt_id']."', '".$inputs['user']."','".$inputs['quiz_id']."','".$inputs['question']."','".$inputs['Answer']."', '".$corectAnswer."')
                ";
                $res = $db->insertData($query);
            }else{
                $res = "No data provided!";
            }

            if($res){
                return $corectAnswer;
            }else{
                return "Some thing went wrong!";
            }

            return $res;
        }

        /**
         * Get corect answer count for specific attempt 
         *
         * @param  $request
         * @return void
         */
        public function getAnswerCount($request){
            $db = new database;
            $inputs=$request->parameters;
            $query = "SELECT sum(QUIZ_ANSWER_CORRECT) as COUNT from quiz_responses WHERE QUIZ_RESPONSE_ID = '".$inputs['resp_id']."'";
            $result = $db->getData($query);
            $count = $result[0]['COUNT'];

            $res = $this->finishRequest($inputs, $count);
            return $count;
        }

        private function finishRequest($inputs, $count){
            $db = new database;            
            $query = "INSERT INTO quiz_results (ATTEMPT_ID, QUIZ_ID, USER, CORRECT_ANSWERS) VALUES ('".$inputs['resp_id']."', '".$inputs['quiz_id']."', '".$inputs['user']."', '".$count."')";
            $res = $db->insertData($query);
            return $res;
        }

        /**
         * Checking if answer is correct for question and returns value.
         *
         * @param $inputs
         * @return void
         */
        private function checkSavedAnsewer($inputs){
            $db = new database;
            $query = "SELECT QUIZ_CORECT_ANSWER FROM QUIZ_ANSWERS 
                WHERE   
                    QUIZ_ID = '".$inputs['quiz_id']."' 
                    AND QUIZ_QUESTION_ID = '".$inputs['question']."'
                    AND QUIZ_ANSWER_ID = '".$inputs['Answer']."'
                ";
            $result = $db->getData($query);
            return $result[0]['QUIZ_CORECT_ANSWER'];
        }
    }
?>