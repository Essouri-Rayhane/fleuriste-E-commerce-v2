<?php
session_start();
require_once '../../config/db.php';

// Vérifier si l'utilisateur est connecté


// Traitement des requêtes AJAX pour le panier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    
    if (!$productId) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'ID produit manquant']);
        exit;
    }

    // Initialiser le panier si inexistant
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Gestion de la quantité
    if ($quantity === null) {
        // Mode incrémentation (pour les boutons + et -)
        if (isset($_SESSION['panier'][$productId])) {
            $_SESSION['panier'][$productId]++;
        } else {
            $_SESSION['panier'][$productId] = 1;
        }
    } else {
        // Mode set direct (pour l'input)
        $quantity = (int)$quantity;
        if ($quantity <= 0) {
            unset($_SESSION['panier'][$productId]);
        } else {
            $_SESSION['panier'][$productId] = $quantity;
        }
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

// Récupérer les produits du panier avec leurs détails
$productsInCart = [];
$total = 0;

if (!empty($_SESSION['panier'])) {
    // Protection contre les injections SQL
    $ids = array_map('intval', array_keys($_SESSION['panier']));
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
    try {
        $stmt = $conn->prepare("SELECT * FROM produit WHERE id_produit IN ($placeholders)");
        $stmt->execute($ids);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($products as $product) {
            $quantity = $_SESSION['panier'][$product['id_produit']];
            $productsInCart[] = [
                'id' => $product['id_produit'],
                'nom' => htmlspecialchars($product['nom']),
                'prix' => (float)$product['prix'],
                'image' => htmlspecialchars($product['image']),
                'quantite' => $quantity,
                'total' => $product['prix'] * $quantity
            ];
            $total += $product['prix'] * $quantity;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur (log, affichage, etc.)
        error_log("Erreur de base de données: " . $e->getMessage());
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - Fleurs Tropicales</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
           /* Variables de couleur */
           :root {
            --cream: #f6f2eb;
            --light-green: #d9e4d1;
            --medium-green: #6d9773;
            --dark-green: #3a5a40;
            --text-dark: #2d2d2d;
            --shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --radius: 16px;
            --transition: 0.3s ease;
            --rose-light: #FDE2E4;
        --rose: #f9c5d1;
        --rose-medium: #f7a1b0;
        --rose-dark: #c97b8d;
        --rose-deep: #8b4d5d;
      
        --rose-gold: #b76e79;
        --blush: #f4acb7;
        --champagne: #fcd5ce;

            --Rosepoudré: #f6f2eb;
      --Rosedragée: #d9e4d1;
      --Roseframboise: #6d9773;
      --Rosefuchsia: #3a5a40;
    

   /* Autres */
  --text-dark: #2d2d2d;
  --shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  --radius: 16px;
  --transition: 0.3s ease;
  --h2-size: clamp(2rem, 5vw, 3rem);
        }

        /* Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
          
            background: linear-gradient(135deg, var(--rose-light), var(--Rosedragée), var(--Roseframboise));
            background-attachment: fixed;
             animation: gradientFlow 8s ease infinite;
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;

        }
        @keyframes gradientFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInLeft {
  from { transform: translateX(-100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

        /* Sidebar */
        .sidebar {
            width: 250px;
            color: white;
  padding: 20px;
  display: flex;
  flex-direction: column;
  
  animation: slideInLeft 0.8s ease;
  background: url('../../images/admin01.jpg') no-repeat;
  background-size: cover; /* ou contain, selon l'effet souhaité */
  background-position: center center; /* centre l'image */
  background-attachment: local; /* évite le défilement fixe */
        }

        .logo {
            text-align: center;
            padding: 20px 0;
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 3em;
  font-weight: bold;
  
  color: var(--Rosepoudré);


        }

        .logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.logo i {
    font-size: 3rem; /* un peu plus grand pour plus d’impact */
    margin-bottom: 5px;
    color: var(--light-green);
    transition: transform 0.3s ease;
}

.logo i:hover {
    transform: scale(1.1) rotate(5deg); /* petit effet au survol */
}

.logo span {
    font-size: 1.5rem; /* légèrement agrandi */
    font-weight: 700;
    color: white    ;
    letter-spacing: 1px;
    text-transform: uppercase;
}


        .menu ul {
            list-style: none;
        }

        .menu li {
            margin-bottom: 5px;
        }

        .menu a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: var(--radius);
            transition: var(--transition);
            gap: 10px;
        }

        .menu a:hover, .menu a.active {
            background: var(--medium-green);
            transform: translateX(5px);
        }

        .menu i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        h1 {
            color: var(--dark-green);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Panier */
        .cart-container {
            display: flex;
            gap: 30px;
        }

        .cart-items {
            flex: 2;
        }

        .cart-summary {
            flex: 1;
            background: white;
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            height: fit-content;
        }

        .cart-item {
            display: flex;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .cart-item-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .cart-item-name {
            font-size: 1.2rem;
            color: var(--dark-green);
            margin-bottom: 10px;
        }

        .cart-item-price {
            color: var(--medium-green);
            font-weight: bold;
            margin-bottom: 15px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: auto;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: none;
            background: var(--light-green);
            color: var(--dark-green);
            border-radius: 50%;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            padding: 5px;
            border: 1px solid var(--light-green);
            border-radius: var(--radius);
        }

        .remove-item {
            color: #ff6b6b;
            cursor: pointer;
            margin-left: auto;
            padding: 5px;
        }

        .summary-title {
            font-size: 1.3rem;
            color: var(--dark-green);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--light-green);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .summary-total {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--light-green);
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            background: var(--medium-green);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .checkout-btn:hover {
            background: var(--dark-green);
            transform: translateY(-3px);
        }

        .empty-cart {
            text-align: center;
            padding: 50px;
        }

        .empty-cart i {
            font-size: 3rem;
            color: var(--medium-green);
            margin-bottom: 20px;
        }

        .continue-shopping {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: var(--medium-green);
            color: white;
            text-decoration: none;
            border-radius: var(--radius);
            transition: var(--transition);
        }

        .continue-shopping:hover {
            background: var(--dark-green);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .cart-container {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .cart-item {
                flex-direction: column;
            }
            
            .cart-item-image {
                width: 100%;
                height: auto;
            }
        }
        .petal {
    position: absolute;
    top: -50px;
    width: 30px;
    height: 30px;
    background: url('../../images/petale.png') no-repeat center/contain;
    animation: fall 10s linear infinite;
    opacity: 0.6;
    z-index: -1; /* ✔️ POUR RESTER EN ARRIÈRE PLAN */
}
.petals-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
    z-index: -1; /* Toujours derrière tout */
}


@keyframes fall {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 0.6;
    }
    100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0.2;
    }
}

    </style>
</head>
<body>
<div class="petals-container"></div>
    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-store"></i><br>
            <span>Bienvenue sur Petalune !</span>
        </div>
        <div class="menu">
            <ul>
                <li><a href="../../index.php"><i class="fa fa-home"></i> Accueil</a></li>
                <li><a href="produits.php"><i class="fa fa-box"></i> Produits</a></li>
                <li><a href="add_to_cart.php" class="active"><i class="fas fa-shopping-basket"></i> Panier</a></li>
                <li><a href="../../logout.php"><i class="fa fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </div>
    </aside>

    <main class="main-content">
        <h1><i class="fas fa-shopping-basket"></i> Mon Panier</h1>
        
        <?php if (!empty($productsInCart)): ?>
            <div class="cart-container">
                <div class="cart-items">
                    <?php foreach ($productsInCart as $item): ?>
                        <div class="cart-item" data-product-id="<?= $item['id'] ?>">
                            <img src="../../images/produits/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['nom']) ?>" class="cart-item-image">
                            <div class="cart-item-details">
                                <h3 class="cart-item-name"><?= htmlspecialchars($item['nom']) ?></h3>
                                <p class="cart-item-price"><?= number_format($item['prix'], 2) ?> €</p>
                                <div class="cart-item-quantity">
                                    <button class="quantity-btn minus" onclick="updateQuantity(<?= $item['id'] ?>, -1)">-</button>
                                    <input type="number" class="quantity-input" value="<?= $item['quantite'] ?>" min="1" 
                                           onchange="updateQuantityInput(<?= $item['id'] ?>, this.value)">
                                    <button class="quantity-btn plus" onclick="updateQuantity(<?= $item['id'] ?>, 1)">+</button>
                                    <span class="remove-item" onclick="removeItem(<?= $item['id'] ?>)">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="cart-summary">
                    <h3 class="summary-title">Récapitulatif</h3>
                    
                    <?php foreach ($productsInCart as $item): ?>
                        <div class="summary-row">
                            <span><?= htmlspecialchars($item['nom']) ?> (x<?= $item['quantite'] ?>)</span>
                            <span><?= number_format($item['total'], 2) ?> €</span>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span><?= number_format($total, 2) ?> €</span>
                    </div>
                    
                    <button class="checkout-btn" onclick="checkout()">
                        <i class="fas fa-credit-card"></i> Passer la commande
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-basket"></i>
                <h3>Votre panier est vide</h3>
                <p>Commencez par ajouter des produits à votre panier</p>
                <a href="produits.php" class="continue-shopping">
                    <i class="fas fa-arrow-left"></i> Continuer vos achats
                </a>
            </div>
        <?php endif; ?>
    </main>

    <script>
        function updateQuantity(productId, change) {
            const input = document.querySelector(`.cart-item[data-product-id="${productId}"] .quantity-input`);
            const newValue = parseInt(input.value) + change;
            
            if (newValue >= 1) {
                updateCart(productId, newValue);
            }
        }
        
        function updateQuantityInput(productId, value) {
            if (value >= 1) {
                updateCart(productId, parseInt(value));
            }
        }
        
        function updateCart(productId, quantity) {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Rafraîchir la page pour voir les changements
                } else {
                    alert('Erreur: ' + data.message);
                }
            });
        }
        
        function removeItem(productId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit de votre panier ?')) {
                updateCart(productId, 0);
            }
        }
        
        function checkout() {
            // Redirection vers la page de commande
            window.location.href = 'simple_checkout.php';
        }
        const container = document.querySelector('.petals-container');


        function createPetal() {
    const petal = document.createElement('div');
    petal.classList.add('petal');
    petal.style.left = Math.random() * 100 + 'vw';
    petal.style.animationDuration = (5 + Math.random() * 5) + 's';
    container.appendChild(petal);

    setTimeout(() => {
        petal.remove();
    }, 10000);
}

setInterval(createPetal, 500); // une pétale toutes les 0.5 secondes
    </script>
</body>
</html>