<?php
App::uses('AppController', 'Controller');
/**
 * Agents Controller
 *
 * @property Agent $Agent
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AgentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('Agent', 'Contact');
	public $components = array('Paginator', 'Session');
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Agent->recursive = 0;
		$this->set('agents', $this->Paginator->paginate());
		$contacts = $this->Contact->find('list');
		$this->set('contacts', $contacts);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Agent->exists($id)) {
			throw new NotFoundException(__('Invalid agent'));
		}
		$options = array('conditions' => array('Agent.' . $this->Agent->primaryKey => $id));
		$this->set('agent', $this->Agent->find('first', $options));
		$contacts = $this->Contact->find('list');
		$this->set('contacts', $contacts);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Agent->create();
			if ($this->Agent->save($this->request->data)) {
				if($this->request->data['Agent']['new_default_contact']){
					$this->Contact->create();
					$this->Contact->save(array(
						'agent_id' => $this->Agent->id,
						'name' => $this->request->data['Agent']['new_default_contact']
					));
					$this->Agent->saveField('default_contact_id', $this->Contact->id);
				}
				$this->Session->setFlash(__('The agent has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The agent could not be saved. Please, try again.'));
			}
		}
		$contacts = $this->Contact->find('list');
		$this->set('contacts', $contacts);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Agent->exists($id)) {
			throw new NotFoundException(__('Invalid agent'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Agent->save($this->request->data)) {
				$this->Session->setFlash(__('The agent has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The agent could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Agent.' . $this->Agent->primaryKey => $id));
			$this->request->data = $this->Agent->find('first', $options);
			$contacts = $this->Contact->find('list');
			$this->set('contacts', $contacts);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Agent->id = $id;
		if (!$this->Agent->exists()) {
			throw new NotFoundException(__('Invalid agent'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Agent->delete()) {
			$this->Session->setFlash(__('The agent has been deleted.'));
		} else {
			$this->Session->setFlash(__('The agent could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
