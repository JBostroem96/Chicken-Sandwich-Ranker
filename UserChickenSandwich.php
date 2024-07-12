<?php
        
        class UserChickenSandwich {

            private $chicken_id;
            private $user_id;
            private $rated;
            private $score;
            private $name;
           
            
            /**
             * Get the value of chicken
             */ 
            public function getChicken_id()
            {
                        return $this->chicken_id;
            }

            /**
             * Set the value of chicken
             *
             * @return  self
             */ 
            public function setChicken_id($chicken_id)
            {
                        $this->chicken_id = $chicken_id;

                        return $this;
            }

            /**
             * Get the value of user
             */ 
            public function getUser_id()
            {
                        return $this->user_id;
            }

            /**
             * Set the value of user
             *
             * @return  self
             */ 
            public function setUser_id($user_id)
            {
                        $this->user_id = $user_id;

                        return $this;
            }

            /**
             * Get the value of rated
             */ 
            public function getRated()
            {
                        return $this->rated;
            }

            /**
             * Set the value of rated
             *
             * @return  self
             */ 
            public function setRated($rated)
            {
                        $this->rated = $rated;

                        return $this;
            }

            /**
             * Get the value of name
             */ 
            public function getName()
            {
                        return $this->name;
            }

            /**
             * Set the value of name
             *
             * @return  self
             */ 
            public function setName($name)
            {
                        $this->name = $name;

                        return $this;
            }

            /**
             * Get the value of score
             */ 
            public function getScore()
            {
                        return $this->score;
            }

            /**
             * Set the value of score
             *
             * @return  self
             */ 
            public function setScore($score)
            {
                        $this->score = $score;

                        return $this;
            }

            //This function's purpose is to display the chicken sandwich
            public function display($chicken_sandwich) {
                    
                    echo "<div class='score'>" 
                        . "<div class='styling'><form action='user_chicken_sandwich_service.php' method='POST'>
                        <p class='text-white fw-bold'>Your rating for {$chicken_sandwich->getName()}:"; 
                        
                    if (isset($_POST['edit_entry'])) {
                                
                        if ($_POST['chicken_id'] == $chicken_sandwich->getId()) {
                                    
                            echo "<input type='numeric' name='score' pattern='[1-9]|10'>";
                            echo "<button class='button' type='submit' id='edit_score'
                                name='edit_score' value='{$_POST['chicken_id']}'>RATE ME!</button><p>Only 1-10 is allowed, one rating per account</p>";
                        }
                                
                    } else {

                        echo "{$chicken_sandwich->getScore()}<br>";

                        echo "<input type='hidden' name='chicken_id' value='{$chicken_sandwich->getChicken_id()}'>
                            <button class='button' type='submit' id='delete_entry'
                            name='delete_entry' value='{$chicken_sandwich->getScore()}'>DELETE</button>"
                            . "<button class='button' type='submit' id='edit_entry'
                            name='edit_entry'>EDIT</button></form></div></div>";
                    }   
            }

        }
                
?>

    
    


    

