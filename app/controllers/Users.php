<?php

    class Users extends Controller {

        public function __construct() {

            $this->userModel = $this->model('User');


        }

        public function register() {
            
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process the form



                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init Data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' =>  trim($_POST['email']),
                    'password' =>  trim($_POST['password']),
                    'confirm_password' =>  trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validating Name
                if(empty($data['name'])) {
                    $data['name_err'] = 'Please enter name';
                }

                // Validating Email
                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter email';
                } else {
                    // Check if the given email exist
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_err'] = 'Email is already taken';
                    }
                }

                // Validating Password
                if(empty($data['password'])) {
                    $data['password_err'] = 'Please enter password';
                } elseif (strlen($data['password'] < 6)) {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }

                // Validating Confirm Password
                if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm password';
                } else {
                    if($data['password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Password do not match';
                    }
                }


                // Make sure errors are empty
                if( empty($data['email_err']) && 
                    empty($data['name_err']) && 
                    empty($data['password_err']) && 
                    empty($data['confirm_password_err'])) {

                        // Hash Password
                        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);


                        // Register User
                        if($this->userModel->register($data)) {
                           redirect('users/login');
                        } else {
                            die('Something went wrong');
                        }


                } else {

                    // Load view with errors
                    $this->view('users/register', $data);

                }




            } else {

                // Init data 
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Load View
                $this->view('users/register', $data);
            }

        }


        public function login() {
            
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process the form

                
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init Data
                $data = [
                    'email' =>  trim($_POST['email']),
                    'password' =>  trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];


                // Validating Email
                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter email';
                }

                // Validating Password
                if(empty($data['password'])) {
                    $data['password_err'] = 'Please enter password';
                } 


                // Make sure errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])) {
                        die('Success');
                } else {
                    // Load view with errors
                    $this->view('users/login', $data);

                }



            } else {

                // Init data 
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];

                // Load View
                $this->view('users/login', $data);
            }

        }

    }


?>