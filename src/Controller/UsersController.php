<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Connect;
use Cake\ORM\TableRegistry;
use Cake\View\Helper\FormHelper;
use Cake\Event\Event;
use Cake\Auth\ControllerAuthorize;
use Cake\Routing\Router;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $user = $this->Users->get($this->Auth->user('id'));
        $this->set('user', $user);

    }

    /**
     *
     */
    public function all()
    {

        $users = $this->paginate($this->Users->find()->where(['role ' => $this->Auth->user('role')]));
        $this->saveLog($this->Auth->user('id'), 4);
        $this->set('user_id', $this->Auth->user('id'));
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($this->Users->get($id,  [ 'contain' => [] ])->role != $this->Auth->user('role')) {
            $this->Flash->error(__('Vous ne pouvez pas accéder à ce profil car vos rôles ne correspondent pas.'));
            $this->redirect('/users/all');
        }
        $this->set('can_modify', $id == $this->Auth->user('id'));
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Vous êtes inscrit, et connecté.'));
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($id != $this->Auth->user('id')) {
            $this->Flash->error(__('Vous ne pouvez pas modifier ce profil car ce n\'est pas le votre.'));
            $this->redirect('/users');
        }

        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {

                $this->saveLog($this->Auth->user('id'), 2);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $logs = TableRegistry::get('Connects');
        $logs_to_delete = $logs->find('all')->where(['user_id' => $id]);
        foreach ($logs_to_delete as $log)
        {
            $logs->delete($log);
        }
        $this->Auth->logout();
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Vous avez bien supprimé votre compte et toutes les données stockées vous concernant.'));
            $this->redirect('/');
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    /**
     * @param Event $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add', 'login', 'password', 'reset']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->saveLog($this->Auth->user('id'), 1);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * @param $user
     * @return bool
     */
    public function isAuthorized($user)
    {
        return $user != null;
    }

    /**
     *
     */
    public function password()
    {
        if ($this->request->is('post')) {
            $query = $this->Users->findByUsername($this->request->data['username']);
            $user = $query->first();
            if (is_null($user)) {
                $this->Flash->error('L\'adresse email n\'existe pas, essayez en une autre.');
            } else {
                $passkey = uniqid();
                $url = Router::Url(['controller' => 'users', 'action' => 'reset'], true) . '/' . $passkey;
                $timeout = time() + DAY;
                if ($this->Users->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
                    $this->Flash->success($url);
                    $this->saveLog($user->id, 3);
                    $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('Error saving reset passkey/timeout');
                }
            }
        }
    }

    /**
     * @param null $passkey
     * @return \Cake\Http\Response|null
     */
    public function reset($passkey = null) {
        if ($passkey) {
            $query = $this->Users->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]]);
            $user = $query->first();
            if ($user) {
                if (!empty($this->request->getData())) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $this->request->data['modified'] = time();
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($user)) {
                        $this->Flash->set(__('Votre mot de passe est enregistré.'));
                        return $this->redirect(array('action' => 'login'));
                    } else {
                        $this->Flash->error(__('The password could not be updated. Please, try again.'));
                    }
                }
            } else {
                $this->Flash->error('Le lien est expiré, merci de recommencer la procédure de réinitialisation du mot de passe');
                $this->redirect(['action' => 'password']);
            }
            unset($user->password);
            $this->set(compact('user'));
        } else {
            $this->redirect('/');
        }
    }

    /**
     * @param $log_cat
     */
    protected function saveLog($user_id, $log_cat) {

        $logs = TableRegistry::get('Connects');
        $new_log = $logs->newEntity();
        $new_log->set('connexion_time', time());
        $new_log->set('connect_type_id', $log_cat);
        $new_log->set('user_id', $user_id);
        if (!$logs->save($new_log))
            $this->Flash->error(__('Une erreur s\'est produite pendant l\'enregistrement du log..'));
    }
}
