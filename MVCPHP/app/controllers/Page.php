<?php


class Page extends Controller
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = $this->model('Post');
    }
    public function index(){
        if(isLoggedIn()){
            redirect('posts');
        }

        $posts = $this->postModel->getPosts();
        $data = [
            'title'=>'welcome',
            'description'=>'Simple social network built on Le Chi Linh MVC PHP freamwork'
        ];
        $this->view('pages/index',$data);
    }
    public function about(){
        $data = [
            'title'=>'About',
            'description'=>'App to share posts with other users'
        ];
        $this->view('pages/about',$data);
    }
}