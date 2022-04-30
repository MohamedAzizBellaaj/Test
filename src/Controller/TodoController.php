<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{

    #[Route('/todo', name:'app_todo')]
function indexAction(SessionInterface $session): Response
    {
    if (!$session->has('todo')) {
        $todo = [
            "Sunday" => "Rest up",
        ];
        $session->set('todo', $todo);
        $this->addFlash(
            'welcome',
            'Welcome to your todo page'
        );
    }
    return $this->render('todo/listToDo.html.twig', [
    ]);
}
#[Route('/todo/add/{key}/{value}', name:'add_todo')]
function addToDo(SessionInterface $session, $key, $value): Response
    {
    if (!$session->has('todo')) {
        $this->addFlash(
            'error',
            'The list is not yet initialized'
        );
        return $this->render('todo/listToDo.html.twig', []);
    }
    if (isset($session->get('todo')[$key])) {
        $todo = $session->get('todo');
        $todo[$key] = $value;
        $session->set('todo', $todo);
        $this->addFlash(
            'success',
            'Item updated successfully!'
        );
    } else {
        $todo = $session->get('todo');
        $todo[$key] = $value;
        $session->set('todo', $todo);
        $this->addFlash(
            'success',
            'Item added successfully!'
        );
    }

    return $this->render('todo/listToDo.html.twig', []);
}
#[Route('/todo/remove/{key}/', name:'remove_todo')]
function removeTodo(SessionInterface $session, $key)
    {
    if (!$session->has('todo')) {
        $this->addFlash(
            'error',
            'The list is not yet initialized'
        );
        return $this->render('todo/listToDo.html.twig', []);
    }
    if (isset($session->get('todo')[$key])) {
        $todo = $session->get('todo');
        unset($todo[$key]);
        $session->set('todo', $todo);
        $this->addFlash(
            'success',
            'Item deleted successfully!'
        );
    } else {
        $this->addFlash(
            'error',
            "This item doesn't exist"
        );
    }
    return $this->render('todo/listToDo.html.twig', []);
}
#[Route('/todo/reset/', name:'reset_todo')]
function reset(SessionInterface $session)
    {
    if (!$session->has('todo')) {
        $this->addFlash(
            'error',
            'The list is not yet initialized'
        );
        return $this->render('todo/listToDo.html.twig', []);
    }$session->remove('todo');
    $this->addFlash(
        'success',
        'List reset successfully!'
    );
    return $this->render('todo/listToDo.html.twig', []);
}
}