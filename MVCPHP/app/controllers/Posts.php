<?php


class Posts extends Controller
{
    //kiểm tra có tồn tại session với user id hay không mới cho vào trang post
    public function __construct()
    {
        if(!isLoggedIn()){
            redirect('users/login');
        }
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index(){
       $posts = $this->postModel->getPosts();
        $data = [

            'posts'=>$posts
        ];

        $this->view('posts/index',$data);
    }

    public function add(){
        // check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //sanitize data post
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data = [
                'title'=>trim($_POST['title']),
                'body'=>trim($_POST['body']),
                'user_id'=> $_SESSION['user_id'],
                'title_err'=>'',
                'body_err'=>''

            ];
            if(empty($data['title'])){
                $data['title_err'] = 'Please enter title';

            }
            if(empty($data['body'])){
                $data['body_err'] = 'Please enter body';

            }
            if(empty($data['title_err']) && empty($data['body_err'])){
                    if($this->postModel->addPost($data)){
                        flash('Post_added','Post Added');
                        redirect('posts');
                    }else{
                        die('Something went Wrong');
                    }
            }else{
                //load view
                $this->view('posts/add',$data);
            }
        }else{
            $data = [
                'title'=>'',
                'body'=>'',
                'title_err'=>'',
                'body_err'=>''

            ];

            $this->view('posts/add',$data);
        }


    }

    public function show($id){
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);
       $data = [
           'post'=>$post,
           'user'=>$user
       ];


        $this->view('posts/show',$data);
    }

    public function edit($id){

        // check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //sanitize data post
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

            $data = [
                'title'=>trim($_POST['title']),
                'body'=>trim($_POST['body']),
                'user_id'=> $_SESSION['user_id'],
                'title_err'=>'',
                'body_err'=>''

            ];
            if(empty($data['title'])){
                $data['title_err'] = 'Please enter title';

            }
            if(empty($data['body'])){
                $data['body_err'] = 'Please enter body';

            }
            if(empty($data['title_err']) && empty($data['body_err'])){
                if($this->postModel->addPost($data)){
                    flash('Post_added','Post Added');
                    redirect('posts');
                }else{
                    die('Something went Wrong');
                }
            }else{
                //load view
                $this->view('posts/add',$data);
            }
        }else{
            $data = [
                'title'=>'',
                'body'=>'',
                'title_err'=>'',
                'body_err'=>''

            ];

            $this->view('posts/edit',$data);
        }




    }
}