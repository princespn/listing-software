<?php 
 
class UsersController extends AppController 
		{
	var $name = 'Users';
	var $components = array('Acl', 'Auth', 'Session','Email');
	public $helpers = array('Form', 'Html', 'Js', 'Time','Ajax','Javascript');
	
	function beforeFilter() 
				{    
		parent::beforeFilter();		
		$this->Auth->allow(array('login','logout','index','edit','view','groups'));
		$this->Auth->userModel = 'User';  
       //$this->Auth->allow('*');  
   		$this->Session->activate();		
				}
		 
			function login() {
				$this->layout = 'administrator';
				if (!empty($this->data))
				 {
					if ($this->Auth->login($this->data)) 
							{
						 $this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')));
						$this->redirect(array('controller' => 'projects', 'action' => 'index'));
						
							} 
					else 
							{
						$this->Session->setFlash('Your username or password was incorrect.');
							}
					} 
					else
					{
						
							$this->Session->setFlash('Please Enter username and password.');
					}
								}

		function logout()
				{
			$this->layout = 'administrator';
			$this->Session->destroy();
    		//$this->redirect($this->facebook->getLogoutUrl($params));
			$this->Session->setFlash('You have succesfully logged out');
			$this->redirect($this->Auth->logout());
      		}

   function add() {
		
		if (!empty($this->data))
				 {
			 	if ((!empty($this->data['User']['new_password'])) && (!empty($this->data['User']['confirm_password'])))
							{
								
								if($this->data['User']['new_password'] != $this->data['User']['confirm_password']) 
								{
								$this->Session->setFlash(__('Your passwords do not match.', true));
								}
								else
								{
								$newpass = $this->Auth->password($this->data['User']['new_password']);
								
								$this->data['User']['password'] = $newpass;
									$this->User->create($this->data);
									if ($this->User->save($this->data))
									{
									$this->Session->setFlash(__('The user has been Create successfully.', true));
									$this->redirect(array('action' => 'index'));
									} 
									else
									{
									$this->Session->setFlash(__('The user could not be saved. Please try again.', true));
									}
								}												
						}			
						else
						{
						$this->Session->setFlash(__('ERROR!! Please check the fields and try again.', true));
						}	
			}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}
							
						
		function index() {
				$this->User->recursive = 1;
				$this->paginate = array('limit' => 1000,'totallimit' => 2000,'order'=>'User.created  desc');
				$this->set('users', $this->paginate());
				}
			
	function view($id = null) {
						if (!$id) {
							$this->Session->setFlash(__('Invalid user', true));
							$this->redirect(array('action' => 'index'));
						}
						$this->set('user', $this->User->read(null, $id));
					}
	function edit($id = null) 
	{
			if (!$id && empty($this->data))
			 {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data))
				 {
			 $user = $this->Session->read('User.username');
			  $someone = $this->User->findById($this->User->id);
					if (!empty($this->data['User']['new_password']))
							{
								if($this->data['User']['new_password'] != $this->data['User']['confirm_password']) 
								{
								$this->Session->setFlash(__('Your passwords do not match.', true));
								}
								else
								{
								$newpass = $this->Auth->password($this->data['User']['new_password']);
								
								$this->data['User']['password'] = $newpass;
								//print_r($this->User->save($this->data)); die();
									if ($this->User->save($this->data))
									{
									$this->Session->setFlash(__('The user has been updated successfully.', true));
									$this->redirect(array('action' => 'index'));
									} 
									else
									{
									$this->Session->setFlash(__('ERROR!! Please check the fields and try again.', true));
									}
								}												
				}			
			else
			{
				if ($this->User->save($this->data))
				{
				$this->Session->setFlash(__('The user has been updated successfully.', true));
				$this->redirect(array('action' => 'index'));
				} 
				else
				{
				$this->Session->setFlash(__('ERROR!! Please check the fields and try again.', true));
				}	
			}
	}
			if (empty($this->data))
			{
			$this->data = $this->User->read(null, $id);
			}
			$groups = $this->User->Group->find('list');
			$this->set(compact('groups'));
}
	
	function forgatepw ($id = null)
		{
		// $id = $this->User->findByUsername($this->data['User']['username']); 
			if (!$id && empty($this->data))
			 {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('controller' => 'projects', 'action' => 'index'));
			}
			if (!empty($this->data))
				 {
					 $dbuser = $this->User->findByUsername($this->data['User']['username']);
					 if(!empty($dbuser) && ($dbuser['User']['password'] == $this->Auth->password($this->data['User']['old_password'])))
			 					//if (!empty($this->data['User']['old_password']))
						{
								if($this->data['User']['new_password'] != $this->data['User']['confirm_password']) 
								{
								$this->Session->setFlash(__('Your passwords do not match.', true));
								}
								else
								{
								$newpass = $this->Auth->password($this->data['User']['new_password']);
								$this->data['User']['password'] = $newpass;
									if ($this->User->save($this->data))
									{
									$this->Session->setFlash(__('The user has been updated successfully.', true));
									$this->redirect(array('controller' => 'projects', 'action' => 'index'));
									} 
									else
									{
									$this->Session->setFlash(__('ERROR!! Please check the fields and try again.', true));
									}
								}												
						}			
					else
					{
							if ($this->User->save($this->data))
							{
							$this->Session->setFlash(__('The user has been updated successfully.', true));
							$this->redirect(array('controller' => 'projects', 'action' => 'index'));
							} 
							else
							{
							$this->Session->setFlash(__('ERROR!! Please fill correct old Password and try again.', true));
							}	
					}
		}
			if (empty($this->data))
			{
			$this->data = $this->User->read(null, $id);
			}
			$groups = $this->User->Group->find('list');
			$teams = $this->User->Team->find('list');
			$this->set(compact('teams'));
			$this->set(compact('groups'));
}

	function delete($id = null) {
					if (!$id) {
						$this->Session->setFlash(__('Invalid id for user', true));
						$this->redirect(array('action'=>'index'));
					}
					if ($this->User->delete($id)) {
						$this->Session->setFlash(__('The user was deleted successfully!', true));
						$this->redirect(array('action'=>'index'));
					}
					$this->Session->setFlash(__('ERROR!! The user could not be deleted!', true));
					$this->redirect(array('action' => 'index'));
				}
				
				/* function initDB() {
            $group =& $this->User->Group;

            //Allow admins to everything
            $group->id = 1;
            $this->Acl->allow($group, 'controllers');

            //allow managers to Projects edit and user add
            $group->id = 2;
            $this->Acl->allow($group, 'controllers');
            $this->Acl->deny($group, 'controllers/Users/edit');
            $this->Acl->deny($group, 'controllers/Projects/add');
            $this->Acl->deny($group, 'controllers/Projects/view');
           
            //allow users to only view
            $group->id = 3;
            $this->Acl->deny($group, 'controllers');
            $this->Acl->allow($group, 'controllers/Projects/view');
            
             
            //we add an exit to avoid an ugly "missing views" error message
            echo "all done";
            exit;
		}	
		 
*/
		
		}
