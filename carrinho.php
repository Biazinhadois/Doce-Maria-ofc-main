<?php
require_once __DIR__ . '/includes/session.php';
?>
<html>

<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/bia.css">
    <link rel="stylesheet" href="./andreicss/carrinho.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'header.php';
    ?>

    <div class="modal-overlay">
    <div class="cart-modal">
      <h2 class="cart-title">Meu carrinho</h2>
      <div class="cart-item">
        <div class="item-img-container">
          <img src="https://via.placeholder.com/100" alt="Doce" class="item-img">
        </div>
        <div class="item-details">
          <div class="item-header">
            <h3 class="item-title">Nome do doce/ Pacote</h3>
            <span class="item-price-small">R$9.99</span>
          </div>
          <p class="item-description">Doces do pacote buffet ou quantidade de doces</p>
        </div>
      </div>

      <div class="quantity-price-row">
        <div class="quantity-control">
          <button class="btn-qty"><i class="fa-regular fa-trash-can"></i></button>
          <span class="qty-number">1</span>
          <button class="btn-qty"><i class="fa-solid fa-plus"></i></button>
        </div>
        <span class="item-price-total">R$9.99</span>
      </div>

      <div class="divider">
        <i class="fa-solid fa-sparkles divider-icon">✦</i>
      </div>

      <h3 class="section-title">Deseja adicionar algo?</h3>
      
      <div class="cross-sell-grid">
        <div class="cross-sell-card">
          <div class="cross-sell-img-wrapper">
            <img src="https://via.placeholder.com/60" alt="Cookie Cutter">
            <button class="add-btn">+</button>
          </div>
          <span class="cross-sell-title">Cookie Cutter</span>
          <span class="cross-sell-price">$4.99</span>
        </div>

        <div class="cross-sell-card">
          <div class="cross-sell-img-wrapper">
            <img src="https://via.placeholder.com/60" alt="Cookie Cutter">
            <button class="add-btn">+</button>
          </div>
          <span class="cross-sell-title">Cookie Cutter</span>
          <span class="cross-sell-price">$4.99</span>
        </div>

        <div class="cross-sell-card">
          <div class="cross-sell-img-wrapper">
            <img src="https://via.placeholder.com/60" alt="Cookie Cutter">
            <button class="add-btn">+</button>
          </div>
          <span class="cross-sell-title">Cookie Cutter</span>
          <span class="cross-sell-price">$4.99</span>
        </div>

        <div class="cross-sell-card">
          <div class="cross-sell-img-wrapper">
            <img src="https://via.placeholder.com/60" alt="Cookie Cutter">
            <button class="add-btn">+</button>
          </div>
          <span class="cross-sell-title">Cookie Cutter</span>
          <span class="cross-sell-price">$4.99</span>
        </div>
      </div>

      <div class="divider">
        <i class="fa-solid fa-sparkles divider-icon">✦</i>
      </div>

      <div class="subtotal-row">
        <span class="subtotal-label">Subtotal</span>
        <span class="subtotal-value">R$ 9.99</span>
      </div>

      <div class="loyalty-banner">
        <i class="fa-solid fa-trophy"></i>
        <span>Registre-se para ganhar pontos de fidelidade</span>
      </div>

      <button class="checkout-btn">Finalizar compra</button>

    </div>
  </div>

</body>
</html>

</html>