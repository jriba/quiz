#QUIZ

QUIZ is Vue.js application working with API to recieve and store data. This application is created as task to show my skills and knowledge.
P.S. This was first time I used Vue.js.

##INSTALLATION

-To run this app You need an some web server with php installed and mysql server for database.
-To set up database execute attached sql-dump file, to create necessary database and tables with some example data.
-After that place project directory with all containing files in Your server public folder, except for sql-dump.sql.

-Check if app can connect to DB if not change database connection data in API/classes/database.php
    -DB connection default values
        private $host = 'localhost';
        private $db_name = 'QUIZ';
        private $db_user = 'root';
        private $password = '';

-if You want You can chage API folder to some specific place, but in that case You must change url for request in main.js file so app could acces API index.php file 
    default url -> const url = "http://127.0.0.1/quiz/API/index.php/"

-after all is set up open project in Your browser.
    http://127.0.0.1/quiz/

###USAGE

To start quiz You must provide user_name and slect quiz and click "Start quiz".
If user name is not enered or quiz is not selected You will reciew error message.

After starting quiz You will see all questions and You will nedd to choose qorect answer for question by clicking on it. 
Your selected answer will be marked with check symbol. 
You can change Your choice by clicking on another answer. 
If You redy to submit Your answer press "Next question". 

!!!Remember You can not return to previous question!!!!. 
At the last question You will have button "Save and Show results".
After presing this button You will finish quiz and see Your score. 
If You want to start new quiz press on button "Star new quiz" and You will go back to start menu.
