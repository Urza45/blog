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
            $user->setStatusConnected('0');
            $userManager->save($user);
        }
        
        $this->session->destroy();

        header('Location: /');

    }

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
}