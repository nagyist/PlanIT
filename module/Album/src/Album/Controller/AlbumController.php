<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Album\Entity\User;
use Album\Entity\Album;

use Album\Form\AlbumForm;

class AlbumController extends AbstractActionController
{

    /**
    * @var EntityManager
    */
    protected $entityManager;

    /**
    * Sets the EntityManager
    *
    * @param EntityManager $em
    * @access protected
    * @return PostController
    */
    protected function setEntityManager(\Doctrine\ORM\EntityManager $em)
    {
        $this->entityManager = $em;
        return $this;
    }

    /**
    * Returns the EntityManager
    *
    * Fetches the EntityManager from ServiceLocator if it has not been initiated
    * and then returns it
    *
    * @access protected
    * @return EntityManager
    */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        }
        return $this->entityManager;
    }

    public function indexAction()
    {
        $albums =  $this->getEntityManager()->getRepository('Album\Entity\Album')->findAll();

        return new ViewModel(array(
            'albums' => $albums
        ));
    }

    public function addAction()
    {
        $em = $this->getEntityManager();

        $album = new Album();

        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $form->bind($album);

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());

            if ($form->isValid())
            {
                $em->persist($album);
                $em->flush();
            }
        }

        return array(
            'form' => $form
            );
    }

    public function editAction()
    {
        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'index'
            ));
        }

        $album = $em->find('Album\Entity\Album', $id);

        $form = new AlbumForm();
        $form->get('submit')->setValue('Edit');

        $form->bind($album);

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());

            if ($form->isValid())
            {
                $em->persist($album);
                $em->flush();
            }
        }

        return array(
            'id' => $id,
            'form' => $form
            );
    }

    public function deleteAction()
    {
        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $album = $em->find('Album\Entity\Album', $id);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $em->remove($album);
                $em->flush();
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return array(
            'id'    => $id,
            'album' => $album
        );
    }
}