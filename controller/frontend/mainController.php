<?php
declare(strict_types=1);

namespace Controller\Frontend;

use \Lib\Controller;
use \Lib\Request;
use \Lib\Utilities;
use \Lib\MyMail;
use \Model\Comments;
use \Model\User;

class MainController extends Controller
{

    
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {

        $postManager = $this->manager->getManagerOf('Post');

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending')) {
            $this->response = [ 'type' => 'danger', 'message' => 'Captcha erroné'];
            if ($request->getParams()['captcha'] == $this->session->getAttribute('captcha')) {
                $email = new MyMail;
                $this->response = $email->sendEmailToAdmin($request->getParams());
            }
        }

        return ['frontend/index.html.twig', [
                'LastPostList' => $postManager->getListPost(5),
                'Response' => $this->response,
                'Page' => $request->getUrl(),
            ]
        ];
    }
    
    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {

        $postManager = $this->manager->getManagerOf('Post');

        return ['frontend/list.html.twig', [
                'LastPostList' => $postManager->getListPost(),
                'Response' => $this->response,
                'Page' => $request->getUrl()
            ]
        ];
    }
    
    /**
     * post
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function post(Request $request, $vars)
    {

        $Params = null;

        if ($this->session->existsAttribute('idUser')) {
            $Params = new Comments();
            $Params->setDisabled('0');
            $Params->setPost_idPost($vars['id_post']);
            $Params->setUser_idUser($this->session->getAttribute('idUser'));
            $Params->setDate(date('Y/m/d'));
        }

        $postManager = $this->manager->getManagerOf('Post');
        $commentsManager = $this->manager->getManagerOf('Comments');
        
        return ['frontend/post.html.twig', [
            'post' => $postManager->getUniquePost((int) $vars['id_post']),
            'action' => '/addcomment',
            'comments' => $commentsManager->getListFromPost((int) $vars['id_post']),
            'vars' => $vars,  
            'Params' => $Params,
            'Response' => $this->response,
            'Page' => $request->getUrl()
            ]
        ];
    }
    
    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function register(Request $request)
    {

        $userManager = $this->manager->getManagerOf('User');

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'registration')) {
            // Check password matching
            if ($request->getParams()['passwordFirst'] === $request->getParams()['confirmedPassword'] ) {
                // Verification of the existence of nickname 
                if ($userManager->ifExistPseudo($request->getParams()['pseudo'])) {
                    $this->response = ['type' => 'danger' , 'message' => 'Le pseudo est déjà pris'];
                } else {
                    $user = new User();
                    $user->setName($request->getParams()['lastname']);
                    $user->setFirstName($request->getParams()['firstname']);
                    $user->setEmail($request->getParams()['email']);
                    $user->setPseudo($request->getParams()['pseudo']);
                    $user->setSalt(Utilities::Salt());
                    $user->setPassword(Utilities::password_encode($request->getParams()['passwordFirst'], $user->getSalt()));
                    $user->setValidationKey(Utilities::RandomToken());
                    $user->setDateCreate(date('Y/m/d'));
                    $tab = [
                        'phone' => '',
                        'portable' => '',
                        'statusConnected' => 0,
                        'activeUser' => 1,
                        'activatedUser' => 0,
                        'TypeUser_idTypeUSer' => 1,
                    ];
                    $user->hydrate($tab);
                    $userManager->save($user);
                    $email = new MyMail;
                    $this->response = $email->sendActivationEmail($user);
                }
            } else {
                $this->response = ['type' => 'danger' , 'message' => 'Les mots de passe ne correspondent pas'];
            }
            
        }
        
        return ['frontend/register.html.twig', [
            'Params' => $request->getParams(),
            'Response' => $this->response,
            'Page' => '/signin'
            ]
        ];
    }
    
    /**
     * contact
     *
     * @param  mixed $request
     * @return void
     */
    public function contact(Request $request)
    {

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending')) {
            $email = new \Lib\MyMail;
            $this->response = $email->sendEmailToAdmin($request->getParams());
        }

        return ['frontend/index.html.twig', [
            'Params' => $request->getParams(),
            'Response' => $this->response
            ]
        ];
    }
    
    /**
     * captcha
     *
     * @return void
     */
    public function captcha()
    {
        return Utilities::captcha($this->session);
    }
    
    /**
     * picture
     *
     * @param  mixed $request
     * @return void
     */
    public function picture(Request $request)
    {
        if (isset($request->getParams()['name']) && isset($request->getParams()['type']) 
            && (in_array(strtoupper($request->getParams()['type']), ['PDF', 'JPG', 'JPEG', 'PNG']))
        ) {
            return Utilities::ViewPicture($request->getParams()['name'], $request->getParams()['type']);
        }
        return ['error/404.html.twig', [] ];
    }
    
    /**
     * error403
     *
     * @return void
     */
    public function error403()
    {
        return ['error/403.html.twig', [] ];
    }
}
