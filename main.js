const url = "http://127.0.0.1/quiz/API/index.php/"

var app = new Vue({
      el:"#app",
      data:{
            Wellcome:"Welcome to Quize!",
            Info:'Please enter user name!',
            Quizes:"",
            user_name:"",
            quiz_select:'-1',
            show_Quiz_Question:1,
            quiz_attempt_id:"",
            selected_answer:"",
            error_message:"",
            correct_answers_given:0,

            quiz:{},
            answer:{},
            show_menu:true,
            show_quiz:false,
            show_result:false,
            show_error_message:false,
            lastQuetion:false,
            
            errors:{
                  user_name_error:"Please enter Username!",
                  quiz_select_error:"Plese select quiz!", 
                  answer_not_saved:"Some thing went wrong!"
            }
      }, 

      methods:{
            startQuiz(){
                  if(this.user_name!=''){
                        if(this.quiz_select == '-1'){
                              this.show_error_message = true;
                              this.error_message = this.errors.quiz_select_error
                        }else{
                              this.show_menu = false,
                              this.show_quiz = true,
                              axios.get(url+"quizes/getQuizQuestions?ID="+this.quiz_select).then(response => (this.quiz = JSON.parse(response.data)))
                              var milliseconds = (new Date).getTime();
                              this.quiz_attempt_id = this.user_name+milliseconds; 
                        }
                  }else{
                        this.error_message = this.errors.user_name_error
                        this.show_error_message = true;
                  }
            },
            userNameChanges(){
                  if(this.user_name!=''){
                        this.show_error_message = false;
                  }else{
                        this.error_message = this.errors.user_name_error
                        this.show_error_message = true;
                  }
            },
            nextQuestion(){
                  if(this.selected_answer != ""){
                        var data = this.answer;
                        axios
                              .post(url+"quizes/saveAnswer", data)
                              .then(response => (
                                    this.correct_answers_given + response.data
                              ))
                        if(this.show_Quiz_Question <= this.quiz.question_count){
                              this.selected_answer = "";
                              this.show_Quiz_Question++;
                              if(this.show_Quiz_Question == this.quiz.question_count){
                                    this.lastQuetion = true;  
                              }
                        }else{
                              this.show_Quiz_Question++;
                              this.selected_answer = "";
                              this.lastQuetion = true;   
                        }
                  }
            },

            getResults(){
                  if(this.selected_answer != ""){
                        this.lastQuetion = false;
                        this.show_menu=false;
                        this.show_quiz=false;
                        this.show_result=true;
                        var data = this.answer;
                        var res = this;
                        axios
                        .post(url+"quizes/saveAnswer", data)
                        .then(function(){
                                    axios.get(url+"quizes/getAnswerCount?resp_id="+res.quiz_attempt_id+"&user="+res.user_name+"&quiz_id="+res.quiz_select).then(
                                          response => (res.correct_answers_given = response.data)
                                    )
                              }
                        )  
                  }             
            },
            selectAnswer(answer){
                  this.selected_answer = answer
                  this.answer = {
                        user:this.user_name,
                        quiz_id:this.quiz.quiz_id,
                        question:this.show_Quiz_Question,
                        Answer:answer,
                        attempt_id:this.quiz_attempt_id
                  }
            },

            startNewQuiz(){                
                  this.user_name="";
                  this.quiz_select='-1';
                  this.show_Quiz_Question=1;
                  this.quiz_attempt_id="";
                  this.selected_answer="";
                  this.error_message="";
                  this.correct_answers_given=0;
                  this.quiz={};
                  this.answer={};
                  this.lastQuetion=false;      
                  this.show_menu=true;
                  this.show_quiz=false;
                  this.show_result=false;                  
            }
            
      },
      mounted () {
            axios.get(url+"quizes/getQuizes").then(response => (this.Quizes = response.data))
      }
})