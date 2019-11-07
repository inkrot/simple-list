<?php

namespace App\Controller;

use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/note/add", name="add_note_page")
     */
    public function addPage() {
        return $this->render('note/add.html.twig');
    }

    /**
     * @Route("/note/add_action", methods={"POST"}, name="add_note_action")
     * @param Request $request
     * @return Response
     */
    public function addNote(Request $request)
    {
        dump($request);
        return new Response('Saved new product with id');
        $em = $this->getDoctrine()->getManager();

        $note = new Note();
        $note->setTitle('a');

        $em->persist($note);

        $em->flush();

        return new Response('Saved new product with id ' . $note->getId());
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
}
