<?php include 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Pizza - Free Bootstrap 4 Template by Colorlib</title>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css?family=Josefin+Sans"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do"
    rel="stylesheet" />

  <!--fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;1,400;1,500&display=swap"
    rel="stylesheet" />

  <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v6.3.0/css/all.css" />

  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css" />
  <link rel="stylesheet" href="css/animate.css" />
  <link rel="stylesheet" href="css/owl.carousel.min.css" />
  <link rel="stylesheet" href="css/owl.theme.default.min.css" />
  <link rel="stylesheet" href="css/magnific-popup.css" />
  <link rel="stylesheet" href="css/aos.css" />
  <link rel="stylesheet" href="css/ionicons.min.css" />
  <link rel="stylesheet" href="css/bootstrap-datepicker.css" />
  <link rel="stylesheet" href="css/jquery.timepicker.css" />
  <link rel="stylesheet" href="css/flaticon.css" />
  <link rel="stylesheet" href="css/icomoon.css" />
  <link rel="stylesheet" href="css/style.css" />

  <style>
    .wrapper {
      display: flex;
    }

    /* Sidebar Styling */
    .navbar {
      width: 15%;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 0;

      border-right: 1px solid #e0e0e0;
      position: fixed;
    }

    .navbar-logo-div {
      margin-bottom: 2rem;
    }

    .navbar-logo-link {
      font-size: 2rem;
      color: #084236;
      text-decoration: none;
    }

    .menu-list {
      list-style: none;
      padding: 0;
      width: 100%;
    }

    .menu-item {
      width: 100%;
      margin: 1.5rem 0;
    }

    .ftco-menu {
      width: 70%;
      margin-left: 15%;
      /* Navbar er width er shoman */
      padding-top: 20px;
      /* Optional: Navbar fixed thakle gap maintain korar jonne */
    }
    .ftco-menuu {
      width: 100%;
      margin-left: 15%;
      /* Navbar er width er shoman */
      padding-top: 20px;
      /* Optional: Navbar fixed thakle gap maintain korar jonne */
    }

    @media (max-width: 768px) {
      .navbar {
        display: none;
      }

      .ftco-menu {
        width: 100%;
        margin-left: 0;
      }
      .ftco-menuu {
        width: 100%;
        margin-left: 0;
      }
    }

    .cart-card {
      position: fixed;
      right: 0;
      top: 100px;
      /* Adjust based on header height */
      width: 15%;
      /* Adjust based on your design */
      padding: 10px;
    }

    .order-card {
      color: #fff;
      background-color: #212529;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: 0.3s;
    }

    .order-card .list-group-item {
      background-color: #121618;
    }

    .card-header,
    .card-body {
      padding: 10px;
    }

    .list-group-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .price {
      font-weight: bold;
    }

    .btn-primary {
      width: 100%;
      text-align: center;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .cart-card {
        display: none;
        width: 100%;
        position: relative;
        top: 0;
        right: 0;
      }
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav class="navbar">
      <div class="navbar-container">
        <!--logo div-->
        <div class="navbar-logo-div">
          <a class="navbar-logo-link" href="#">
            <i class="fas fa-shield-dog"></i>
          </a>
          <button class="navbar-toggler">
            <i class="fas fa-solid fa-bars"></i>
          </button>
        </div>
        <!--item list-->
        <ul class="menu-list">
          <li class="menu-item">
            <a class="menu-link" href="#">
              <i class="fas fa-solid fa-table"></i>
              <span class="menu-link-text">Combo Offers</span>
            </a>
          </li>
          <li class="menu-item">
            <a class="menu-link" href="#">
              <i class="fas fa-solid fa-paw"></i>
              <span class="menu-link-text">Classic Pizzas</span>
            </a>
          </li>
          <li class="menu-item">
            <a class="menu-link" class="menu-link" href="#">
              <i class="fas fa-solid fa-user"></i>
              <span class="menu-link-text">Fit Pizzas</span>
            </a>
          </li>
          <li class="menu-item">
            <a class="menu-link" href="#">
              <i class="fas fa-regular fa-stethoscope"></i>
              <span class="menu-link-text">Grand Pizzas</span>
            </a>
          </li>
          <li class="menu-item">
            <a class="menu-link" href="#">
              <i class="fas fa-duotone fa-gear"></i>
              <span class="menu-link-text">Gourment Pizzas</span>
            </a>
          </li>
          <li class="menu-item">
            <a class="menu-link" href="#">
              <i class="fas fa-duotone fa-gear"></i>
              <span class="menu-link-text">Wraps</span>
            </a>
          </li>
          <li class="menu-item">
            <a class="menu-link" href="add-product.php">
              <i class="fas fa-duotone fa-gear"></i>
              <span class="menu-link-text">add product</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>