<?php
namespace App\Controllers;
use Core\Controller;
use Core\Router;
use App\Models\Users;
use App\Models\Login;

class UserController extends Controller {

  public function __construct($controller, $action) {
    parent::__construct($controller, $action);
    $this->load_model('Users');
    $this->view->setLayout('default');
  }

  public function loginAction() {
    echo '<script type="text/javascript">var bodyMode = localStorage.getItem("body-mode") localStorage.clear() localStorage.setItem("body-mode", bodyMode) localStorage.setItem("sidebar-active", "sidebar-no"); </script>'; //clear localstorage

    $loginModel = new Login();
    if($this->request->isPost()) {
      // form validation
      // $this->request->csrfCheck(); csrf underconstruction
      $loginModel->assign($this->request->get());
      $loginModel->validator();
      if($loginModel->validationPassed()){
        $user = $this->UsersModel->findByUsername($_POST['username']);
        if($user && password_verify($this->request->get('password'), $user->password)) {
          $remember = $loginModel->getRememberMeChecked();
          $user->login($remember);
          Router::redirect('');
        }  else {
          $loginModel->addErrorMessage('username','There is an error with your username or password');
        }
      }
    }
    $this->view->login = $loginModel;
    $this->view->displayErrors = $loginModel->getErrorMessages();
    $this->view->render('user/login');
  }

  public function logoutAction() {
    if(Users::currentUser()) {
      Users::currentUser()->logout();
    }
    Router::redirect('user/login');
  }

  public function registerAction() {
    $newUser = new Users();
    if($this->request->isPost()) {
      // $this->request->csrfCheck(); csrf underconstruction
      $newUser->assign($this->request->get());
      $newUser->setConfirm($this->request->get('confirm'));
      if($newUser->save()){
        Router::redirect('user/login');
      }
    }
    $this->view->newUser = $newUser;
    $this->view->displayErrors = $newUser->getErrorMessages();
    $this->view->render('user/register');
  }
}
