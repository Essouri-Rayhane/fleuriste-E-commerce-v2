<!DOCTYPE html>

<html lang="fr">
<?php include 'includes/header.php'; ?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>À propos - Fleurs Élégance</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
      background: linear-gradient(to bottom right,rgb(237, 200, 219),rgb(248, 198, 215));
      color: #3e3e3e;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem;
      box-sizing: border-box;
    }

    header {
      width: 100%;
      text-align: center;
      margin-bottom: 2rem;
    }

    header h1 {
      font-size: 2.8rem;
      color: #558b2f;
      text-shadow: 1px 1px 2px #c5e1a5;
      animation: fadeIn 1.5s ease-in-out;
    }

    .about-container {
      display: flex;
      flex-wrap: wrap;
      max-width: 1300px;
      background: linear-gradient(to bottom right, #e8f5e9, #fce4ec);
      border-radius: 20px;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      animation: fadeIn 1.2s ease-in;
      margin: 0 auto;
    }

    .sidebar {
      flex: 1 1 300px;
      background-color:rgb(139, 47, 111);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .side-img.full {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .content {
      flex: 2 1 700px;
      padding: 3rem;
      background-color: rgba(255, 255, 255, 0.88);
      animation: slideInRight 1s ease-out;
    }

    .content h2 {
      font-size: 2.3rem;
      color: #ad1457;
      margin-bottom: 1rem;
      animation: pulse 2s infinite;
    }

    .content p {
      line-height: 1.8;
      font-size: 1.15rem;
      margin-bottom: 1.5rem;
    }

    .gallery {
      display: flex;
      flex-wrap: wrap;
      gap: 1.2rem;
      margin-bottom: 2rem;
    }

    .gallery img {
      width: 100%;
      max-width: 220px;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 4px 12px rgba(85, 139, 47, 0.2);
      transition: transform 0.4s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .gallery img:hover {
      transform: scale(1.07);
      box-shadow: 0 6px 15px rgba(85, 139, 47, 0.35);
    }

    .footer-collections {
      padding: 3rem 2rem;
      background: linear-gradient(to right, #fce4ec, #e8f5e9);
      text-align: center;
      border-top: 2px solid #c5e1a5;
      margin-top: 3rem;
      width: 100%;
    }

    .footer-collections h3 {
      font-size: 2rem;
      color: #ad1457;
      margin-bottom: 2rem;
      animation: slideInUp 1s ease-in;
    }

    .collection-gallery {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1.5rem;
    }

    .collection-item {
      position: relative;
      width: 220px;
      overflow: hidden;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(85, 139, 47, 0.2);
      transition: transform 0.4s ease, box-shadow 0.3s ease;
      animation: fadeIn 1.2s ease-in;
    }

    .collection-item img {
      width: 100%;
      height: auto;
      display: block;
      transition: transform 0.4s ease;
    }

    .collection-item .caption {
      position: absolute;
      bottom: -100%;
      left: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.85);
      color:rgb(230, 157, 175);
      padding: 0.8rem;
      font-weight: bold;
      text-align: center;
      transition: bottom 0.4s ease;
    }

    .collection-item:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(85, 139, 47, 0.35);
    }

    .collection-item:hover img {
      transform: scale(1.1);
    }

    .collection-item:hover .caption {
      bottom: 0;
    }
/* --- Animations supplémentaires --- */
/* Inspiration florale */
.inspiration-section {
  padding: 3rem 2rem;
  background: #f1f8e9;
  text-align: center;
  animation: fadeIn 1.5s ease-in;
  border-top: 2px solidrgba(244, 185, 214, 0.76);
  margin-top: 3rem;
}

.inspiration-section h3 {
  font-size: 2rem;
  color:rgb(225, 153, 190);
  margin-bottom: 2rem;
}

.inspiration-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 1rem;
  justify-items: center;
}

.inspiration-gallery img {
  width: 100%;
  max-width: 180px;
  border-radius: 12px;
  object-fit: cover;
  transition: transform 0.4s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.inspiration-gallery img:hover {
  transform: scale(1.06);
  box-shadow: 0 6px 15px rgba(85, 139, 47, 0.25);
}

/* Témoignages clients */
.testimonials-section {
  padding: 3rem 2rem;
  background: linear-gradient(to right, #fce4ec, #f3e5f5);
  text-align: center;
  margin-top: 3rem;
  animation: slideInUp 1.5s ease-in-out;
}

.testimonials-section h3 {
  font-size: 2rem;
  color: #880e4f;
  margin-bottom: 2rem;
}

.testimonial-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 2rem;
}

.testimonial-card {
  background: white;
  padding: 1.5rem;
  max-width: 300px;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(136, 14, 79, 0.15);
  transition: transform 0.3s ease;
  animation: fadeIn 2s ease;
}

.testimonial-card:hover {
  transform: scale(1.05);
}

.testimonial-card p {
  font-style: italic;
  font-size: 1.05rem;
  margin-bottom: 0.8rem;
}

.testimonial-card span {
  color: #4e342e;
  font-weight: bold;
  font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 768px) {
  .testimonial-cards {
    flex-direction: column;
    align-items: center;
  }

  .inspiration-gallery {
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  }
}


/* Animation en fade avec montée douce */
@keyframes fadeUp {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* Animation en cascade pour témoignages */
.testimonial-card {
    
  opacity: 0;
  transform: translateY(30px);
  animation: fadeUp 1s ease forwards;
}

.testimonial-card:nth-child(1) { animation-delay: 0.3s; }
.testimonial-card:nth-child(2) { animation-delay: 0.6s; }
.testimonial-card:nth-child(3) { animation-delay: 0.9s; }

/* Animation progressive des images inspiration */
.inspiration-gallery img {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeUp 0.9s ease forwards;
}

.inspiration-gallery img:nth-child(1) { animation-delay: 0.2s; }
.inspiration-gallery img:nth-child(2) { animation-delay: 0.4s; }
.inspiration-gallery img:nth-child(3) { animation-delay: 0.6s; }
.inspiration-gallery img:nth-child(4) { animation-delay: 0.8s; }
.inspiration-gallery img:nth-child(5) { animation-delay: 1s; }
.inspiration-gallery img:nth-child(6) { animation-delay: 1.2s; }

/* Instagram button */
.instagram-link {
  display: inline-block;
  margin-top: 2rem;
  padding: 0.8rem 1.6rem;
  background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
  color: white;
  border-radius: 30px;
  font-weight: bold;
  text-decoration: none;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.instagram-link:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 15px rgba(0,0,0,0.25);
}



    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInRight {
      from { opacity: 0; transform: translateX(30px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.01); }
      100% { transform: scale(1); }
    }

    @media (max-width: 768px) {
      .about-container {
        flex-direction: column;
      }

      .sidebar, .content {
        flex: 1 1 100%;
        border-radius: 0;
      }

      .gallery {
        justify-content: center;
      }

      header h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>Bienvenue chez Fleurs Élégance</h1>
  </header>

  <div class="about-container">
    <div class="sidebar">
      <img src="images/fleuriste.jpg" alt="Fleurs décoratives" class="side-img full">
    </div>

    <main class="content">
      <h2>Notre Passion pour les Fleurs</h2>
      <p>
        Chez <strong>Petalune</strong>, chaque pétale raconte une histoire. Nous sommes une entreprise familiale
        passionnée par l’art floral, et nous vous offrons les plus belles fleurs soigneusement sélectionnées pour chaque occasion.
      </p>

      <div class="gallery">
        <img src="images/peony.jpg" alt="Fleur rose">
        <img src="images/wax.jpg" alt="Fleur jaune">
        <img src="images/tulips.jpg" alt="Bouquet printanier">
      </div>

      <p>
        Notre mission ? Apporter de la beauté, de la joie et un soupçon de nature dans votre quotidien, avec des compositions florales uniques, respectueuses de l’environnement et livrées avec amour 💚.
      </p>

      <p>
        Rejoignez notre communauté de passionnés et faites entrer la magie des fleurs dans votre vie !
      </p>
    </main>
  </div>

  <footer class="footer-collections">
    <h3>🌸 Nos anciennes collections</h3>
    <div class="collection-gallery">
      <div class="collection-item">
        <img src="images/fleursromantique.jpg" alt="Bouquet 1">
        <div class="caption">Romantique</div>
      </div>
      <div class="collection-item">
        <img src="images/pastel1.jpg" alt="Bouquet 2">
        <div class="caption">Pastel Chic</div>
      </div>
      <div class="collection-item">
        <img src="images/été.jpg" alt="Bouquet 3">
        <div class="caption">Été Frais</div>
      </div>
      <div class="collection-item">
        <img src="images/blanc.jpeg" alt="Bouquet 4">
        <div class="caption">Blanc Pur</div>
      </div>
      <div class="collection-item">
        <img src="images/nature.jpg" alt="Bouquet 5">
        <div class="caption">Nature Émeraude</div>
      </div>
      <div class="collection-item">
        <img src="images/floral.jpeg" alt="Bouquet 6">
        <div class="caption">Fête Florale</div>



      </div>



 

<section class="testimonials-section">
  <h3>💬 Ce que disent nos clients</h3>
  <div class="testimonial-cards">
    <div class="testimonial-card">
      <p>"Des bouquets toujours sublimes et livrés avec soin ! 🌷"</p>
      <span>- Camille D.</span>
    </div>
    <div class="testimonial-card">
      <p>"Un service personnalisé et des compositions originales. J'adore !"</p>
      <span>- Maxime L.</span>
    </div>
    <div class="testimonial-card">
      <p>"Ma boutique florale préférée, tout simplement 💚."</p>
      <span>- Sarah T.</span>
    </div>
  </div>
</section>


    </div>
  </footer>

</body>
</html>
