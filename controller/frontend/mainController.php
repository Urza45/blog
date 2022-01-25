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
    public function index(Request $request) {

        $postManager = $this->manager->getManagerOf('Post');
        $userManager = $this->manager->getManagerOf('User');

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending'))
        {
            $email = new MyMail;
            $this->response = $email->sendEmailToAdmin($request->getParams());
        }

        return ['frontend/index.html.twig', [
                'LastPostList' => $postManager->getListPost(5),
                'Response' => $this->response,
                'Page' => $request->getUrl()
            ]
        ];
    }

    public function list(Request $request) {

        $postManager = $this->manager->getManagerOf('Post');

        return ['frontend/list.html.twig', [
                'LastPostList' => $postManager->getListPost(),
                'Response' => $this->response,
                'Page' => $request->getUrl()
            ]
        ];
    }

    public function post(Request $request, $vars) {

        if (isset($request->getParams()['action'])) {

        }
        
        $postManager = $this->manager->getManagerOf('Post');
        $commentsManager = $this->manager->getManagerOf('Comments');
        $Params = new Comments();
        $Params->setDisabled('0');
        $Params->setPost_idPost($vars['id_post']);
        $Params->setUser_idUser($this->session->getAttribute('idUser'));
        $Params->setDate(date('Y/m/d'));

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

    public function register(Request $request) {

        $userManager = $this->manager->getManagerOf('User');

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'registration'))
        {
            // Check password matching
            if ($request->getParams()['passwordFirst'] === $request->getParams()['confirmedPassword'] ) {
                // Verification of the existence of nickname 
                $user = $userManager->getUniqueByPseudo($request->getParams()['pseudo']);

                if ($user) {
                    $this->response = ['type' => 'danger' , 'message' => 'Le pseudo est déjà pris'];
                } else {
                    $user = new User();
                    $user->setName($request->getParams()['lastname']);
                    $user->setFirstName($request->getParams()['firstname']);
                    $user->setEmail($request->getParams()['email']);
                    $user->setPseudo($request->getParams()['pseudo']);
                    $user->setSalt(Utilities::Salt());
                    $user->setPassword(Utilities::password_encode($request->getParams()['passwordFirst'],$user->getSalt()));
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

    public function contact(Request $request) {

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending'))
        {
            $email = new \Lib\MyMail;
            $this->response = $email->sendEmailToAdmin($request->getParams());
        }

        return ['frontend/index.html.twig', [
            'Params' => $request->getParams(),
            'Response' => $this->response
            ]
        ];
    }
}