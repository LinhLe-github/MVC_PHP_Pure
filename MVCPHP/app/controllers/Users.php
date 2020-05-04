<?php


class Users extends Controller
{
    /**
     * @var mixed
     */
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    public function register(){
        //check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //process form
            //sanitize post data
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'name'=>trim($_POST['name']),
                'email'=>trim($_POST['email']),
                'password'=>trim($_POST['password']),
                'confirm_password'=>trim($_POST['confirm_password']),
                'name_err'=>'',
                'email_err'=>'',
                'password_err'=>'',
                'confirm_password_err'=>''
            ];
            //validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';

            }else{
                //check email
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email already taken';

                }

            }
            //validate name
            if(empty($data['name'])){
                $data['name_err'] = 'Please enter name';
            }

            //validate password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter pass word';

            }elseif (strlen($data['password']) < 6){
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            //validate con firm password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            }else{
                if($data['password']!= $data['confirm_password']){
                    $data['confirm_password_err'] = 'Password not match';
                }
            }

            //make sure errors are empty
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                //validated

                //hash password
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                if($this->userModel->register($data)){
                  flash('Register_success','You are resgisted and can login');
                    redirect('users/login');
                }else{
                    die('Some thing went wrong!');
                }
            }else{
                // load view with error
                $this->view('users/register',$data);
            }

        }else{
            $data = [
              'name'=>'',
              'email'=>'',
              'password'=>'',
                'confirm_password'=>'',
                'name_err'=>'',
                'email_err'=>'',
                'password_err'=>'',
                'confirm_password_err'=>''
            ];

            //load view
            $this->view('users/register',$data);
        }
    }

    public function login(){
        //check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //process form
            $data = [
                'email'=>trim($_POST['email']),
                'password'=>trim($_POST['password']),
                'email_err'=>'',
                'password_err'=>''
            ];
            //validate email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }
            //validate password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }

            //check for user/email
            if($this->userModel->findUserByEmail($data['email'])){
                //email found
            }else{
                $data['email_err'] = 'Not Found Email';
                $this->view('users/login',$data);
            }

            //make sure errors empty
            if(empty($data['email_err']) && empty($data['password_err'])){
                $loggedInUser =  $this->userModel->login($data['email'],$data['password']);
                if($loggedInUser){
                    //create session
                    $this->createUserSession($loggedInUser);


                }else{
                    $data['password_err'] = 'Password incorrect';
                    $this->view('users/login',$data);
                }

            }else{
                $this->view('users/login',$data);
            }


        }else{
            $data = [

                'email'=>'',
                'password'=>'',

                'email_err'=>'',
                'password_err'=>''

            ];

            //load view
            $this->view('users/login',$data);
        }
    }
    public function createUserSession($user){
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;

        redirect('posts');

    }
    public function logout(){
        //huy session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }


}