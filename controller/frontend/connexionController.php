<?php
declare(strict_types=1);

namespace Controller\Frontend;

use \Lib\Controller;
use \Lib\Request;
use \Lib\Utilities;

/**
 * ConnexionController
 */
class ConnexionController extends Controller
{    
    /**
     * signin
     *
     * @param  mixed $request
     * @return void
     */
    public function signin(Request $request) {
    
        $userManager = $this->manager->getManagerOf('User');

        // Verification of the existence of nickname in request'params
        if (isset($request->getParams()['pseudo'])) {

            // Verification of the existence of nickname in database and retrieval of corresponding user information.
            $user = $userManager->getUniqueByPseudo($request->getParams()['pseudo']);

            // If user exist
            if ($user) {
                // Password verification
                if (Utilities::verify_password($request->getParams()['password'], $user->getSalt(), $user->getPassword()))
                {
                    // Activated user 
                    if ($user->getActivatedUser() == '0') {
                        $this->response = ['type' => 'danger' , 'message' => 'Vous n\'avez pas activé votre compte.'];
                    } else {
                        // Connected user
                        if ($user->getStatusConnected() == '1') {
                            $this->response = ['type' => 'danger' , 'message' => 'Vous êtes déjà connecté.'];
                        } else { // All is ok :)
                            $this->response = ['type' => 'success' , 'message' => 'Connexion réussie'];
                    
                            $this->session->setAttribute('name', $user->getName() . ' ' .$user->getFirstname());
                            $this->session->setAttribute('connected', '1');
                            $this->session->setAttribute('admin', $user->getTypeUser_idTypeUSer());
                            $this->session->setAttribute('idUser', $user->getId());
                            $user->setStatusConnected('1');

                            $userManager->save($user);
                        
                            header('Location: /');
                        }
                    }
                } else {
                    $this->response = ['type' => 'danger' , 'message' => 'Connexion échouée'];
                }
            } else {
                $this->response = ['type' => 'danger' , 'message' => 'Pseudo incorrect'];
            }
        }

        return ['frontend/register.html.twig', [
            'Response' => $this->response,
            'Page' => '/signin'
            ]
        ];
    }
    
    /**
     * signout
     *
     * @param  mixed $request
     * @return void
     */
    public function signout(Request $request) {
        
        if ($this->session->existsAttribute('idUser')) 
        {
            $userManager = $this->manager->getManagerOf('User');

            $user = $userManager->getUnique((int) $this->session->getAttribute('idUser'));
            var_dump($user);
            $user->setStatusConnected('0');
            $userManager->save($user);
        }
        
        $this->session->destroy();

        header('Location: /');

    }
    
    /**
     * activation
     *
     * @param  mixed $request
     * @return void
     */
    public function activation(Request $request)
    {
        $userManager = $this->manager->getManagerOf('User');
        
        // Verification of the existence of nickname in database and retrieval of corresponding user information.
        $user = $userManager->getUniqueByPseudo($request->getParams()['p']);

        if ($user) {
            if ($user->getActivatedUser() == 1) {
                $this->response = [ 'type' => 'success', 'message' => 'Votre activation a déjà été effectuée.'];
            } else {
                if ($request->getParams()['v'] === $user->getValidationKey()) {
                    $user->setActivatedUser(1);
                    $userManager->save($user);
                    $this->response = [ 'type' => 'success', 'message' => 'Votre activation a bien été effectuée. Vous pouvez vous connecter.'];
                }
            }
        } else {
            $this->response = [ 'type' => 'danger', 'message' => 'Le pseudo recherché n\'est pas enregistré en base de données.'];
        }

        return ['frontend/index.html.twig', [
            'Response' => $this->response,
            'Page' => '/'
            ]
        ];
    }
    
    /**
     * account
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function account(Request $request, $vars)
    {
        if ($this->session->existsAttribute('connected')) 
        {
            $user = $this->manager->getManagerOf('User')->getUnique((int) $vars['id_user']);
            $level = $this->manager->getManagerOf('TypeUser')->getLabel((int) $user->getTypeUser_idTypeUSer());
            //var_dump($user);
            //var_dump($level);
            return ['frontend/user.html.twig', [
                'Response' => $this->response,
                'User' => $user,
                'level' => $level
                ]
            ];
        }
        return ['error/forbidden.html.twig', [] ];
    }
    
    /**
     * ask
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function ask(Request $request, $vars)
    {
        if ($this->session->existsAttribute('connected')) 
        {
            $this->response = $this->manager->getManagerOf('USer')->askPromotion((int) $vars['id_user']);
            $user = $this->manager->getManagerOf('User')->getUnique((int) $vars['id_user']);
            $level = $this->manager->getManagerOf('TypeUser')->getLabel((int) $user->getTypeUser_idTypeUSer());

            return ['frontend/user.html.twig', [
                'Response' => $this->response,
                'User' => $user,
                'level' => $level
                ]
            ];

        }
        return ['error/forbidden.html.twig', [] ];
    }

    public function modify(Request $request, $vars)
    {
        if ($this->session->existsAttribute('connected')) 
        {
            $user = $this->manager->getManagerOf('User')->getUnique((int) $vars['id_user']);

            $user->setName($request->getParams()['name']);
            $user->setFirstName($request->getParams()['firstName']);
            $user->setEmail($request->getParams()['email']);
            $user->setPhone($request->getParams()['phone']);
            $user->setPortable($request->getParams()['portable']);

            if ($this->manager->getManagerOf('User')->save($user) == 1) {
                $this->response = [ 'type'=> 'success', 'message' => 'Modification(s) enregistrée(s).'];
            } else {
                $this->response = [ 'type'=> 'danger', 'message' => 'Une erreur est survenue. Pas de modification effectuée.'];
            }
            
            $level = $this->manager->getManagerOf('TypeUser')->getLabel((int) $user->getTypeUser_idTypeUSer());

            return ['frontend/user.html.twig', [
                'Response' => $this->response,
                'User' => $user,
                'level' => $level
                ]
            ];
        }
    }

    public function password(Request $request, $vars)
    {
        if ($this->session->existsAttribute('connected')) 
        {
            $user = $this->manager->getManagerOf('User')->getUnique((int) $vars['id_user']);

            // Password verification
            if (!Utilities::verify_password($request->getParams()['passwordOld'], $user->getSalt(), $user->getPassword()))
            {
                $this->response = [ 'type'=> 'danger', 'message' => 'L\'ancien mot de passe n\'est pas correct.'];
            } elseif ( $request->getParams()['passwordFirst'] <> $request->getParams()['confirmedPassword']) {
                $this->response = [ 'type'=> 'danger', 'message' => 'Confirmation de mot de passe erronée.'];
            } else {
                $user->setSalt(Utilities::Salt());
                $user->setPassword(Utilities::password_encode($request->getParams()['passwordFirst'], $user->getSalt()));
                if ($this->manager->getManagerOf('User')->save($user) == 1) {
                    $this->response = [ 'type'=> 'success', 'message' => 'Mot de passe modifié.'];
                } else {
                    $this->response = [ 'type'=> 'danger', 'message' => 'Une erreur est survenue. Mot de passe non modifié.'];
                }
            }

            $level = $this->manager->getManagerOf('TypeUser')->getLabel((int) $user->getTypeUser_idTypeUSer());

            return ['frontend/user.html.twig', [
                'Response' => $this->response,
                'User' => $user,
                'level' => $level
                ]
            ];
        }
    }
}