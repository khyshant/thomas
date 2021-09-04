<?php

namespace App\Controller;

use App\Entity\User;
use App\Handler\UserHandler;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="listing_users")
     */
    public function listUsers()
    {
        return $this->render('user/listing.html.twig', ['users' => $this->getDoctrine()->getRepository('App:User')->findAll()]);
    }


    /**
     * @Route("user/create", name="user_create")
     * @param Request $request
     * @param UserHandler $handler
     * @return Response
     */
    public function create(Request $request,UserHandler $handler,UserRepository $repository): Response
    {
        $email = $request->request->get('user')['email'];
        $userKnown = $repository->findOneBy(['email'=>$email]);
        if($userKnown ){
            return $this->redirectToRoute("user_update",array('id' => $userKnown->getId()));
        }
        $user = new User();
        if($handler->handle($request, $user, ["validation_groups" => ["Default", "add"]])) {
            return $this->redirectToRoute("user_update",array('id' => $user->getId()));
        }
        return $this->render("user/create.html.twig", [
            "form" => $handler->createView()
        ]);
    }

    /**
     * @Route("user/{id}/update", name="user_update")
     * @param Request $request
     * @param User $user
     * @param UserHandler $handler
     * @return Response
     */
    public function update(Request $request, User $user,UserHandler $handler): Response
    {
        //$this->denyAccessUnlessGranted(UserVoter::EDIT, $user);
        if($handler->handle($request, $user)) {
            return $this->redirectToRoute("user_update",array('id' => $user->getId()));
        }
        return $this->render("user/update.html.twig", [
            "form" => $handler->createView()
        ]);
    }
}