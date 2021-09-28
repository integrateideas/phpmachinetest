<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Http\Client;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Cart Controller
 *
 * @method \App\Model\Entity\Cart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CartController extends AppController
{   
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('ProductsApi');
    }
    
    private function session(){
        return $this->request->session();
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $items = $this->cartItemList(); // fetch items in cart
        $this->set(compact('items'));
    }

    public function cartItemList(){
        $items = []; // products in list
        if($this->session()->check('Cart')){
            // geeting detail of each product in cart using api
            foreach ($this->session()->read('Cart') as $id => $quantity){
                $resp = $this->ProductsApi->getProducts($id);
                if($resp['isOk']){ // if valid product or resposne add to cartlist
                    $items[$id] = $resp['product'];
                    $items[$id]['quantity'] = $quantity;
                }
            }
        }
        return $items;
    }

    /**
     * View method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cart = $this->Cart->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('cart'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
         // validate product from api
        $isValidProduct = True;
        if($id == null) $isValidProduct = False;
        if($isValidProduct){
            $res = $this->ProductsApi->getProducts($id);
            $isValidProduct = $res['isOk'] && array_key_exists('id', $res['product']);
        }

        // add to session card
        if($isValidProduct){
            $items = [$id => 1]; // ['productId' => 'quantity']
            if($this->session()->check('Cart')){
                $items = $this->session()->read('Cart');
                if( array_key_exists($id, $items) ) $items[$id] = $items[$id] + 1;
                else $items[$id] = 1;
            } 
            $this->session()->write('Cart', $items);
            $this->Flash->success('Product Added to cart');
        }else{
            $this->Flash->error('Invalid Product');
        }
        return $this->redirect( $this->referer() );
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cart = $this->Cart->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cart = $this->Cart->patchEntity($cart, $this->request->getData());
            if ($this->Cart->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $this->set(compact('cart'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cart = $this->Cart->get($id);
        if ($this->Cart->delete($cart)) {
            $this->Flash->success(__('The cart has been deleted.'));
        } else {
            $this->Flash->error(__('The cart could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
