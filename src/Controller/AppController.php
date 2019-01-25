<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadModel('Users');
        $this->loadComponent('Auth', ['storage'              => (Configure::read('debug') ? "Session" : "Memory"),
            'authenticate'         => [
                'Form'              => ['fields' => ['username' => 'username',
                    'password' => 'password']],
                'ADmad/JwtAuth.Jwt' => ['userModel'       => 'Users',
                    'fields'          => ['username' => 'id'],
                    'parameter'       => 'token',
                    'queryDatasource' => TRUE],
            ],
            'unauthorizedRedirect' => FALSE,
            'checkAuthIn'          => 'Controller.initialize',
            'loginRedirect'        => FALSE,
            'logoutRedirect'       => FALSE,
            'loginAction'          => FALSE]);
        $this->Auth->allow(['token', 'add', 'password', 'reset']);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'display']);
        $this->Auth->setConfig('authorize', ['Controller']);
    }

    public function beforeRender(Event $event)
    {
        $this->set('userData', $this->Auth->user());
        $this->set('token', $this->request->getQuery('page'));
    }

    public function token()
    {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }

        $this->set(['success'    => TRUE,
            'data'       => ['token' => $token = JWT::encode(['id'  => $user['id'],
                'sub' => $user['id'],
                'exp' => time() + 604800], Security::salt())],
            '_serialize' => ['success',
                'data']]);
        $this->redirect(['controller' => 'Users', 'action' => 'index', '?' => ['token' => $token]]);
    }


}
