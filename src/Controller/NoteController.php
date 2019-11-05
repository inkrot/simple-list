<?php

namespace App\Controller;

use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    /**
     * @Route("/notes", name="notes_page")
     */
    public function index() {
        return $this->render('note/index.html.twig');
    }

    /**
     * @Route("/help", name="help_page")
     */
    public function help() {
        return $this->render('note/help.html.twig');
    }

    /**
     * @Route("/note/{id<\d+>}", methods={"GET"}, name="get_note")
     */
    public function getNote($id)
    {
        $note = $this->getDoctrine()
            ->getRepository(Note::class)
            ->find($id);

        /*if (! $note) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }*/

        return $this->json($note);
    }

    /**
     * @Route("/note", methods={"POST"}, name="add_note")
     * @param Request $request
     * @return Response
     */
    public function addNote(Request $request)
    {
        return new Response(dump($request));
        $em = $this->getDoctrine()->getManager();

        $note = new Note();
        $note->setTitle('a');

        $em->persist($note);

        $em->flush();

        return new Response('Saved new product with id ' . $note->getId());
    }
}
