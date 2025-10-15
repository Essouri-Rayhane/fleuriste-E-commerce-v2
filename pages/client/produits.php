
<?php 
session_start();
require_once '../../config/db.php';

// Récupération des catégories pour le filtre
$categories = $conn->query("SELECT * FROM categorie");

// Récupération des paramètres de filtre
$search = $_GET['search'] ?? '';
$categorie = $_GET['categorie'] ?? '';
$tri = $_GET['tri'] ?? '';

// Construction de la requête
$sql = "SELECT * FROM produit WHERE 1=1";

if ($search !== '') {
    $search = htmlspecialchars($search);
    $sql .= " AND nom LIKE '%$search%'";
}

if ($categorie !== '') {
    $categorie = intval($categorie);
    $sql .= " AND id_categorie = $categorie";
}

if ($tri === 'asc') {
    $sql .= " ORDER BY prix ASC";
} elseif ($tri === 'desc') {
    $sql .= " ORDER BY prix DESC";
}

$produits = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits - Fleurs tropicales</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* [Vos styles CSS existants...] */
       
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
            
  animation: fadeInUp 1s ease;
        }

        /* Header */
        h1 {
            color: var(--dark-green);
            margin-bottom: 20px;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .subtitle {
            color: var(--medium-green);
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Filtres */
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filters input[type="text"],
        .filters select {
            padding: 10px 15px;
            border: 1px solid var(--light-green);
            border-radius: var(--radius);
            background: white;
            font-size: 1rem;
            min-width: 200px;
            transition: var(--transition);
        }

        .filters input[type="text"]:focus,
        .filters select:focus {
            outline: none;
            border-color: var(--medium-green);
            box-shadow: 0 0 0 2px rgba(109, 151, 115, 0.2);
        }

        .filters button {
            padding: 10px 20px;
            background: var(--dark-green);
            color: white;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .filters button:hover {
            background: var(--medium-green);
            transform: translateY(-2px);
        }

        /* Grille de produits */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }

        .product-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-info {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-size: 1.1rem;
            color: var(--dark-green);
            margin-bottom: 8px;
        }

        .product-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 12px;
            line-height: 1.4;
            flex: 1;
        }

        .product-price {
            font-weight: bold;
            color: var(--medium-green);
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .add-to-cart {
            padding: 10px;
            background: var(--medium-green);
            color: white;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: var(--transition);
            margin-top: auto;
        }

        .add-to-cart:hover {
            background: var(--dark-green);
            transform: translateY(-2px);
        }

        /* Message quand aucun produit */
        .no-products {
            text-align: center;
            grid-column: 1 / -1;
            padding: 40px;
            color: #666;
            font-size: 1.1rem;
        }
        .cart-count {
    background: var(--medium-green);
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 0.8rem;
    margin-left: 5px;
    vertical-align: top;
}

        /* Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                padding: 15px;
            }
            
            .menu ul {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .menu li {
                flex: 1;
                min-width: 120px;
            }
            
            .menu a {
                justify-content: center;
                padding: 10px;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .filters {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filters input[type="text"],
            .filters select,
            .filters button {
                width: 100%;
            }
        }
   










        /* Ajouts pour le panier */
        .cart-count {
            background: var(--medium-green);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8rem;
            margin-left: 5px;
            vertical-align: top;
        }

        .cart-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--rose-dark);
    color: white;
    padding: 20px 35px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 1000;

    font-size: 18px;
    font-weight: bold;
}

        .cart-notification.show {
            transform: translateY(0);
            opacity: 1;
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
                <li><a href="produits.php" class="active"><i class="fa fa-box"></i> Produits</a></li>
                <li>
                    <a href="add_to_cart.php">
                        <i class="fa fa-shopping-cart"></i> Panier
                        <span id="cart-count" class="cart-count"><?= array_sum($_SESSION['panier'] ?? []) ?></span>
                    </a>
                </li>
                <li><a href="../../logout.php"><i class="fa fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </div>
    </aside>

    <main class="main-content">
        <h1><i class="fas fa-leaf"></i>Produits disponibles</h1>
        <p class="subtitle"></p>

        <form method="get" class="filters">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Rechercher un produit..." />
            
            <select name="categorie">
                <option value="">Toutes les catégories</option>
                <?php while($cat = $categories->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?= $cat['id_categorie'] ?>" <?= ($cat['id_categorie'] == $categorie) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nom_categorie']) ?>
                    </option>
                <?php } ?>
            </select>
            
            <select name="tri">
                <option value="">Trier par</option>
                <option value="asc" <?= ($tri == 'asc') ? 'selected' : '' ?>>Prix croissant</option>
                <option value="desc" <?= ($tri == 'desc') ? 'selected' : '' ?>>Prix décroissant</option>
            </select>
            
            <button type="submit"><i class="fas fa-filter"></i> Filtrer</button>
        </form>

        <div class="product-grid">
            <?php if ($produits->rowCount() > 0) { ?>
                <?php while ($produit = $produits->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="product-card">
                        <img src="../../images/produits/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" class="product-image">
                        <div class="product-info">
                            <h3 class="product-name"><?= htmlspecialchars($produit['nom']) ?></h3>
                            <p class="product-description"><?= htmlspecialchars($produit['description']) ?></p>
                            <p class="product-price"><?= number_format($produit['prix'], 2) ?> €</p>
                            <button class="add-to-cart" onclick="addToCart(<?= $produit['id_produit'] ?>)">
                                <i class="fas fa-cart-plus"></i> Ajouter au panier
                            </button>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="no-products">
                    <p>Aucun produit trouvé.</p>
                </div>
            <?php } ?>
        </div>
    </main>

    <script>
        // Fonction pour ajouter au panier
        function addToCart(productId) {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + productId
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    updateCartCounter();
                    showCartNotification('Produit ajouté au panier !');
                } else {
                    showCartNotification('Erreur: ' + data.message, true);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCartNotification('Une erreur est survenue', true);
            });
        }

        // Mettre à jour le compteur du panier
        function updateCartCounter() {
            fetch('get_cart_count.php')
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('cart-count').textContent = data.count;
                }
            });
        }

        // Afficher une notification
        function showCartNotification(message, isError = false) {
            const notif = document.createElement('div');
            notif.className = 'cart-notification';
            notif.textContent = message;
            
            if(isError) {
                notif.style.backgroundColor = '#ff6b6b';
            }
            
            document.body.appendChild(notif);
            
            setTimeout(() => {
                notif.classList.add('show');
            }, 10);
            
            setTimeout(() => {
                notif.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notif);
                }, 300);
            }, 3000);
        }

        // Actualiser le compteur au chargement
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCounter();
        });

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