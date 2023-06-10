<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \Exception('logout() should never be reached');
    }

    #[Route('/newUser', name: 'NewUser')]
    public function newUser(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        //$user = new User();
        //$user->setUsername('admin');
        //$plaintextPassword= 1234;
        //$user->setRoles(['ROLE_ADMIN']);
        //$hashedPassword =$passwordHasher->hashPassword(
        //    $user,
        //    $plaintextPassword
        //);
        //$user->setPassword($hashedPassword);
        //$userRepository->save($user, true);
        //return new Response('admin created');

        $user = new User();
        $user->setUsername('user');
        $plaintextPassword = 1234;
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $userRepository->save($user, true);
        return new Response('User Created');
    }

    #[Route('/delU', name: 'no')]
    public function delU(UserRepository $userRepository,)
    {
        //$id = 9;
        //$users = $userRepository->find($id);
        //$userRepository->remove($users,true);
        $users = $userRepository->findAll();
        //dd($users);


        return new Response('deleted');
    }
}
