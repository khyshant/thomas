<?php

namespace App\Controller;

use App\Entity\Task;
use App\Handler\TaskHandler;
use App\Security\voter\TaskVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="listing_tasks")
     * @param Request $request
     */
    public function listTask(Request $request)
    {
        $user = $this->getUser();
        if($user->getRoles()[0] == "ADMIN"){
            return $this->render('task/listing.html.twig', ['tasks' => $this->getDoctrine()->getRepository('App:Task')->findAll()]);
        }
        return $this->render('task/listing.html.twig', ['tasks' => $this->getDoctrine()->getRepository('App:Task')->findBY(['user'=>$user->getId()])]);
    }

    /**
     * @Route("task/create", name="task_create")
     * @param Request $request
     * @param TaskHandler $handler
     * @return Response
     */
    public function create(Request $request,TaskHandler $handler): Response
    {
        $user = $this->getUser();
        $task = new Task();
        $task->setUser($user);
        if($handler->handle($request, $task, ["validation_groups" => ["Default", "add"]        ]
        )) {
            return $this->redirectToRoute("task_update",array('id' => $task->getId()));
        }
        return $this->render("task/create.html.twig", [
            "form" => $handler->createView()
        ]);
    }

    /**
     * @Route("task/{id}/update", name="task_update")
     * @param Request $request
     * @param Task $task
     * @param TaskHandler $handler
     * @return Response
     */
    public function update(Request $request, Task $task,TaskHandler $handler): Response
    {
        $this->denyAccessUnlessGranted(TaskVoter::EDIT, $task);
        if($handler->handle($request, $task)) {
            return $this->redirectToRoute("task_update",array('id' => $task->getId()));
        }
        return $this->render("task/update.html.twig", [
            "form" => $handler->createView()
        ]);
    }


    /**
     * @Route("/tasks/{id}/valid", name="task_valid")
     * @param Task $task
     * @return RedirectResponse
     */
    public function valid(Task $task): RedirectResponse
    {
        $task->setDone = true;
        $this->entityManager->flush();
        $this->flash->add('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return new RedirectResponse($this->urlGenerator->generate('listing_tasks'));
    }
}