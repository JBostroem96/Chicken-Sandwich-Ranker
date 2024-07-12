

<?php
    /**
    * This class' purpose is to represent a chicken sandwich object */        
        class ChickenSandwich {

            private $id;
            private $name;
            private $average;
            private $image;
            private $logo;
            private $score;
            private $entries;
            private $source;
           
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
             * Get the value of average
             */ 
            public function getAverage()
            {
                        return $this->average;
            }

            /**
             * Set the value of average
             *
             * @return  self
             */ 
            public function setAverage($average)
            {
                        $this->average = $average;

                        return $this;
            }

            /**
             * Get the value of image
             */ 
            public function getImage()
            {
                        return $this->image;
            }

            /**
             * Set the value of image
             *
             * @return  self
             */ 
            public function setImage($image)
            {
                        $this->image = $image;

                        return $this;
            }

            /**
             * Get the value of logo
             */ 
            public function getLogo()
            {
                        return $this->logo;
            }

            /**
             * Set the value of logo
             *
             * @return  self
             */ 
            public function setLogo($logo)
            {
                        $this->logo = $logo;

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


            /**
             * Get the value of source
             */ 
            public function getSource()
            {
                        return $this->source;
            }

            /**
             * Set the value of source
             *
             * @return  self
             */ 
            public function setSource($source)
            {
                        $this->source = $source;

                        return $this;
            }

            /**
             * Get the value of entries
             */ 
            public function getEntries()
            {
                        return $this->entries;
            }

            /**
             * Set the value of entries
             *
             * @return  self
             */ 
            public function setEntries($entries)
            {
                        $this->entries = $entries;

                        return $this;
            }

            /**
             * Get the value of rank
             */ 
            public function getRank()
            {
                        return $this->rank;
            }

            /**
             * Set the value of rank
             *
             * @return  self
             */ 
            public function setRank($rank)
            {
                        $this->rank = $rank;

                        return $this;
            }
            
        }            
?>


    
    


    

