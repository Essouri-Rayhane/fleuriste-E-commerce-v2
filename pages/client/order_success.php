<?php
session_start();
if (!isset($_SESSION['last_order_id'])) {
    header('Location: produits.php');
    exit;
}
$orderId = $_SESSION['last_order_id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de commande - Fleurs Tropicales</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --rose-light: #FDE2E4;
            --rose-medium: #f7a1b0;
            --rose-dark: #c97b8d;
            --dark-green: #3a5a40;
            --radius: 16px;
            --transition: 0.3s ease;
        }
        
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--rose-light), #f6f2eb, #d9e4d1);
            background-attachment: fixed;
            color: #2d2d2d;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            animation: gradientFlow 8s ease infinite;
        }
        
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .confirmation-container {
            background: white;
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px;
            animation: fadeInUp 0.8s ease;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        h1 {
            color: var(--dark-green);
            margin-bottom: 20px;
            font-size: 2rem;
        }
        
        .order-number {
            font-size: 1.5rem;
            color: var(--rose-dark);
            margin: 20px 0;
            font-weight: bold;
        }
        
        .icon-success {
            color: #6d9773;
            font-size: 4rem;
            margin-bottom: 20px;
            animation: bounce 1s;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }
        
        .btn-continue {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background: var(--rose-medium);
            color: white;
            text-decoration: none;
            border-radius: var(--radius);
            transition: var(--transition);
            font-weight: bold;
        }
        
        .btn-continue:hover {
            background: var(--rose-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .petals-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .petal {
            position: absolute;
            width: 30px;
            height: 30px;
            background: url('../../images/petale.png') no-repeat center/contain;
            animation: fall 10s linear infinite;
            opacity: 0.6;
        }
        
        @keyframes fall {
            0% { transform: translateY(-50px) rotate(0deg); }
            100% { transform: translateY(100vh) rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="petals-container" id="petals"></div>
    
    <div class="confirmation-container">
        <i class="fas fa-check-circle icon-success"></i>
        <h1>Merci pour votre commande</h1>
        <p>Votre paiement a été accepté et votre commande est confirmée.</p>
        
        <div class="order-number">
            Numéro de commande: #<?= htmlspecialchars($orderId) ?>
        </div>
        
        <p>Nous avons envoyé un email de confirmation à votre adresse.</p>
        <p>Votre colis sera expédié dans les 24 heures.</p>
        
        <a href="produits.php" class="btn-continue">
            <i class="fas fa-arrow-left"></i> Retour aux produits
        </a>
    </div>

    <script>
        // Animation des pétales
        function createPetal() {
            const petal = document.createElement('div');
            petal.className = 'petal';
            petal.style.left = Math.random() * 100 + 'vw';
            petal.style.animationDuration = (5 + Math.random() * 5) + 's';
            document.getElementById('petals').appendChild(petal);
            
            setTimeout(() => {
                petal.remove();
            }, 10000);
        }
        
        setInterval(createPetal, 300);
    </script>
</body>
</html>