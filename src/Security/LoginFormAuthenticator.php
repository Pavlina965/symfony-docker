<?php

namespace App\Security;

use App\entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    private UserRepository $userRepository;
    private RouterInterface $router;
    private Security $security;


    public function __construct(UserRepository $userRepository, RouterInterface $router, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->security = $security;
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');
        return new Passport
        (
            new UserBadge($username, function ($userIdentifier) {
                $user = $this->userRepository->findOneBy(['username' => $userIdentifier]);
                if (!$user) {
                    throw new UserNotFoundException();
                }

                return $user;
            }),
            new PasswordCredentials($password)
        );
        //new CustomCredentials(function ($credentials, User $user){
        //    //dd($credentials, $user);
        //    //return $credentials==='tada';
        //}, $password)
        // TODO: Implement authenticate() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($target = $this->getTargetPath($request->getSession(), $firewallName)) {

        }
        $user = $this->security->getUser()->getUserIdentifier();
        //dd($user);
        if ($user === 'admin') {
            return new RedirectResponse(
                $this->router->generate('admin')
            );
        } else {
            return new RedirectResponse(
                $this->router->generate('app_index')
            );
        }
        // TODO: Implement onAuthenticationSuccess() method.
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('app_login');
    }
}
