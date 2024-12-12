<?php include('header.php');
?>

<!-- Your existing content -->
<section class="ftco-menu">
  <div class="container-fluid">
    <div class="row d-md-flex">
      <div class="col-lg-12 ftco-animate p-md-5">
        <div class="row">
          <div class="col-md-12 nav-link-wrap mb-5">
            <div
              class="nav ftco-animate nav-pills"
              id="v-pills-tab"
              role="tablist"
              aria-orientation="vertical">
              <a
                class="nav-link active"
                id="v-pills-1-tab"
                data-toggle="pill"
                href="#v-pills-1"
                role="tab"
                aria-controls="v-pills-1"
                aria-selected="true">All Categories</a>

              <a
                class="nav-link"
                id="v-pills-2-tab"
                data-toggle="pill"
                href="#v-pills-2"
                role="tab"
                aria-controls="v-pills-2"
                aria-selected="false">Small</a>

              <a
                class="nav-link"
                id="v-pills-3-tab"
                data-toggle="pill"
                href="#v-pills-3"
                role="tab"
                aria-controls="v-pills-3"
                aria-selected="false">Medium</a>

              <a
                class="nav-link"
                id="v-pills-4-tab"
                data-toggle="pill"
                href="#v-pills-4"
                role="tab"
                aria-controls="v-pills-4"
                aria-selected="false">Pasta</a>

              <div class="nav-item dropdown" style="position: relative; z-index: 1000;">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  More
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 d-flex align-items-center">
            <div class="tab-content ftco-animate" id="v-pills-tabContent">
              <div
                class="tab-pane fade show active"
                id="v-pills-1"
                role="tabpanel"
                aria-labelledby="v-pills-1-tab">
                <div class="row">
                  <?php
                  $products = getProducts();
                  displayProducts($products);
                  ?>
                </div>
              </div>

              <div
                class="tab-pane fade"
                id="v-pills-2"
                role="tabpanel"
                aria-labelledby="v-pills-2-tab">
                <div class="row">
                  <?php
                  $smallProducts = array_filter($products, function($product) {
                    return $product['category_name'] == 'small';
                  });
                  displayProducts($smallProducts);
                  ?>
                </div>
              </div>

              <div
                class="tab-pane fade"
                id="v-pills-3"
                role="tabpanel"
                aria-labelledby="v-pills-3-tab">
                <div class="row">
                  <?php
                  $mediumProducts = array_filter($products, function($product) {
                    return $product['category_name'] == 'medium pizza';
                  });
                  displayProducts($mediumProducts);
                  ?>
                </div>
              </div>

              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php 
function displayProducts($productsToDisplay) {
  foreach ($productsToDisplay as $product) {
    echo '<div class="col-md-4 col-sm-6 text-center ">
            <div class="menu-wrap">
              <a href="#" class="menu-img img mb-4" style="background-image: url(upload/product-image/' . $product['product_thumbnail_image'] . ')"></a>
              <div class="text">
                <h3><a href="#">' . $product['product_name'] . '</a></h3>
                <p>Category: ' . $product['category_name'] . '</p>
                <p>' . $product['product_short_description'] . '</p>
                <p class="price"><span>$' . $product['product_sale_price'] . '</span></p>
                <p><a href="#" class="btn btn-white btn-outline-white">ADD TO CARD</a></p>
              </div>
            </div>
          </div>';
  }
}

include('order_card.php');
include('footer.php');
?>