<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AddressBook;
use AppBundle\Form\AddressBookFormType;
use AppBundle\Repository\AddressBookRepository;
use AppBundle\Service\UploadFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AddressBookController
 * @package AppBundle\Controller
 */
class AddressBookController extends Controller
{
    /**
     * @param AddressBookRepository $addressBookRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * show the list of Items
     */
    public function indexAction()
    {
        $addresses = $this->getDoctrine()->getRepository('AppBundle:AddressBook')->findAll();
        return $this->render('AddressBook/index.html.twig', [
            'addresses' => $addresses
        ]);
    }

    public function createAction(Request $request)
    {
        $addressBook = new AddressBook();
        $form = $this->createForm(AddressBookFormType::class, $addressBook); //create form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Entity manager
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();

            /** upload picture **/
            $upload = new UploadFile();
            $upload->UploadFile($form,$data,$this->getParameter('Uploads_dir'));

            $entityManager->persist($data);
            $entityManager->flush();

            //show successful message and redirect to index
            $this->addFlash('success', 'your address book created successfully');
            return $this->redirectToRoute('index');
        }

        return $this->render('AddressBook/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * show a record
     */
    public function showAction($id)
    {
        $address = $this->getDoctrine()->getRepository('AppBundle:AddressBook')->find($id);
        return $this->render('AddressBook/show.html.twig', [
            'address' => $address
        ]);
    }

    /**
     * @param Request $request
     * @param AddressBook $addressBook
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, AddressBook $addressBook)
    {
        $form = $this->createForm(AddressBookFormType::class, $addressBook);    //create form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();            //Entity manager

            /** upload picture **/
            $upload = new UploadFile();
            $upload->UploadFile($form,$addressBook,$this->getParameter('Uploads_dir'));

            $entityManager->flush();

            //show successful message and redirect to index
            $this->addFlash('update', 'your address book updated successfully');
            return $this->redirectToRoute('index');
        }

        return $this->render('AddressBook/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param AddressBook $addressBook
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Delete An Address from database and pictures folder
     */
    public function deleteAction(AddressBook $addressBook)
    {
        // remove picture form directory
        $picture = $addressBook->getPicture();
        $path = $this->getParameter('Uploads_dir') . '/' . $picture;
        $fs = new Filesystem();
        $fs->remove(array($path));

        //remove record from database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($addressBook);
        $entityManager->flush();

        //show successful message and redirect to index
        $this->addFlash('delete', 'your address book deleted successfully');
        return $this->redirectToRoute('index');
    }

}
