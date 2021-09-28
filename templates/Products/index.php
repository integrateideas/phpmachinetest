<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="products index content">
    <div class="container py-3">
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center row-eq-height">
          <?php foreach ($products as $product): ?>
          <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
              <div class="card-header py-3">
                <h4 class="my-0 fw-normal"><?= $product->title ?></h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">$<?= $product->price ?></h1>
                <img class="img-fluid" style="width: 200px; height:250px" src="<?= $product['image'] ?>">
                <?= $this->Html->link('Add to Cart',['controller' => 'Cart','action' => 'add', $product->id], ["class" => "w-100 mt-5 btn btn-lg btn-outline-primary"]) ?> 
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
    </div>

</div>