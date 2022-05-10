<?php

namespace App\Controller;
// include 'ChromePhp.php';
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/","/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        $errormsg = 0;
        if ($user = $this->getUser()) {
            if ($user->isBlocked()) {
                $errormsg = 'User blocker par Admin';
            } else if (!$user->IsVerified()) {
                $errormsg = 'Mail pas encour verifier';
            } else {
                // if ($user->isVerified()) {
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    return $this->redirectToRoute('app_user');
                }
                if (in_array('ROLE_ETUDIANT', $user->getRoles())) {
                    return $this->redirectToRoute('app_front');
                }
                if (in_array('ROLE_RECRUTEUR', $user->getRoles())) {
                    return $this->redirectToRoute('listSociete');
                }
                if (in_array('ROLE_ENSIEGNANT', $user->getRoles())) {
                    return $this->redirectToRoute('ensiegnant_home');
                }
                if (in_array('ROLE_UNIVERSITE', $user->getRoles())) {
                    return $this->redirectToRoute('universite_home');
                }
                if (in_array('ROLE_SOCIETE', $user->getRoles())) {
                    return $this->redirectToRoute('listSociete');
                }

                return $this->redirectToRoute('app_front');
                // }
            }
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'errormsg' => $errormsg
        ]);
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
