<?php

namespace App\Controller;

use App\Entity\Note;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    /**
     * @Route("/notes", name="notes_page")
     */
    public function notesPage() {
        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findBy(array(), array('date' => 'DESC'));
        return $this->render('note/index.html.twig', [
            'notes' => $notes
        ]);
    }

    /**
     * @Route("/note/add", name="add_note_page")
     */
    public function addNotePage() {
        return $this->render('note/add.html.twig');
    }

    /**
     * @Route("/note/add_action", methods={"POST"}, name="add_note_action")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function addNote(Request $request)
    {
        $noteTitle = $request->get('note_title');
        $noteText = $request->get('note_text');

        $em = $this->getDoctrine()->getManager();

        $note = new Note();
        $note->setTitle($noteTitle);
        $note->setText($noteText);
        $note->setDate(new DateTime());

        $em->persist($note);

        $em->flush();

        return $this->redirectToRoute('notes_page');
        //return new Response('Saved new product with id ' . $note->getId());
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
