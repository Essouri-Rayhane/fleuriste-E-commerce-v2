<?php
session_start();
require_once '../../config/db.php';

// 1. Vérification de connexion avec la bonne clé de session
if (!isset($_SESSION['client'])) {
    die("Erreur : Connectez-vous d'abord (clé 'client' manquante)");
}

// 2. Récupération de l'ID client
$id_client = (int)$_SESSION['client']; // Utilisez 'client' au lieu de 'user_id'

// 3. Vérification du panier
if (empty($_SESSION['panier'])) {
    die("Votre panier est vide");
}

try {
    // 4. Calcul du total
    $total = 0;
    $productIds = array_keys($_SESSION['panier']);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    
    $stmt = $conn->prepare("SELECT id_produit, prix FROM produit WHERE id_produit IN ($placeholders)");
    $stmt->execute($productIds);
    
    while ($product = $stmt->fetch()) {
        $total += $product['prix'] * $_SESSION['panier'][$product['id_produit']];
    }

    // 5. Insertion de la commande
    $stmt = $conn->prepare("INSERT INTO commande (id_client, date_commande, statut, totale) 
                          VALUES (?, NOW(), 'En attente', ?)");
    $stmt->execute([$id_client, $total]);
    $commandeId = $conn->lastInsertId();

    // 6. Insertion des produits
    $stmt = $conn->prepare("INSERT INTO commande_produit (id_commande, id_produit, quantite) 
                          VALUES (?, ?, ?)");
    
    foreach ($_SESSION['panier'] as $productId => $quantity) {
        $stmt->execute([$commandeId, $productId, $quantity]);
    }

    // 7. Nettoyage et redirection
    unset($_SESSION['panier']);
    $_SESSION['last_order_id'] = $commandeId;
    header("Location: order_success.php");
    exit;

} catch (PDOException $e) {
    die("Erreur de base de données: " . $e->getMessage());
}
?>