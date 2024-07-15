<?php
        
        class UserChickenSandwich {

            private $id;
            private $chicken_id;
            private $user_id;
            private $score;
            private $name;
           
            

            /**
             * Get the value of id
             */ 
            public function getId()
            {
                        return $this->id;
            }

            /**
             * Set the value of id
             *
             * @return  self
             */ 
            public function setId($id)
            {
                        $this->id = $id;

                        return $this;
            }
            
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

        }
                
?>

    
    


    

