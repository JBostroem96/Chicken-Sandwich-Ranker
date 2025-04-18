<?php 
         
       
    class User {

            private $id;
            private $username;
            private $password;
            private $access_privileges;
            private $date_created;
            private $image;
            
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
             * Get the value of username
             */ 
            public function getUsername()
            {
                        return $this->username;
            }

            /**
             * Set the value of username
             *
             * @return  self
             */ 
            public function setUsername($username)
            {
                        $this->username = $username;

                        return $this;
            }

            /**
             * Get the value of password
             */ 
            public function getPassword()
            {
                        return $this->password;
            }

            /**
             * Set the value of password
             *
             * @return  self
             */ 
            public function setPassword($password)
            {
                        $this->password = $password;

                        return $this;
            }

            /**
             * Get the value of access_privileges
             */ 
            public function getAccessPrivileges()
            {
                        return $this->access_privileges;
            }

            /**
             * Set the value of access_privileges
             *
             * @return  self
             */ 
            public function setAccessPrivileges($access_privileges)
            {
                        $this->access_privileges = $access_privileges;

                        return $this;
            }

            /**
             * Get the value of date_created
             */ 
            public function getDateCreated()
            {
                        return $this->date_created;
            }

            /**
             * Set the value of date_created
             *
             * @return  self
             */ 
            public function setDateCreated($date_created)
            {
                        $this->date_created = $date_created;

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
        }

    
    


    

