		<!doctype html>
<html lang="fr" data-bs-theme="auto">
  <head>
    <meta charset="utf-8" />
    <title>Coupe du monde 2026</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    />
    <meta name="theme-color" content="#712cf9" />
    <link href="cdm.css" rel="stylesheet" />
    
  </head>
  <body>
    <div id="accueil" class="section">
      <div class="hero">
      <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
          <div class="navbar-nav ms-auto">
            <a class="nav-link active" href="#" onclick="showSection('accueil')">Accueil</a>
            <a class="nav-link" href="#" onclick="showSection('groupes')">Groupes</a>
            <a class="nav-link" href="#" onclick="showSection('matchs')">Matchs</a>
          </div>
        </div>
      </nav>
      <div class="px-4 py-2 my-3 text-center">
        <img
          class="d-block mx-auto mb-4"
          src="2026_FIFA_World_Cup.svg.png"
          alt=""
          width="192"
          height="296"
        />
        <h1 class="display-5 fw-bold text-white">Coupe du monde 2026</h1>
        <div class="col-lg-6 mx-auto">
          <p class="lead mb-4">
            Les équipes, les groupes et tous les matchs du plus grand Mondial de l'Histoire, réunis dans une seule expérience simple et vivante.  
          </p>
        </div>
        <div class="row text-white text-center mt-5">
          <div class="col-md-4">
            <h2>48</h2>
            <p>Équipes</p>
          </div>
          <div class="col-md-4">
            <h2>12</h2>
            <p>Groupes</p>
          </div>
          <div class="col-md-4">
            <h2>72</h2>
            <p>Matchs</p>
          </div>
        </div>
        <div class="card bg-dark bg-opacity-75 text-white mx-auto mt-4" style="max-width: 420px;">
          <div class="card-body">
            <h5 class="card-title">Match d’ouverture</h5>
            <p class="card-text mb-1">Mexique 🇲🇽 VS Afrique du Sud 🇿🇦</p>
            <p class="card-text">11/06/2026 à 21:00</p>
            <span class="badge text-bg-warning">Estadio Azteca</span>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div id="groupes" class="section d-none">
      <?php
	$pdo = new PDO('mysql:host=localhost;dbname=mondial_2026;charset=utf8mb4', 'root','');

	$sql = "
	SELECT 
	    groupes.lettre AS groupe,
	    equipes.nom AS pays,
	    equipes.code_pays,
	    equipes.classement_fifa
	FROM groupes
	JOIN groupe_equipes ON groupes.id = groupe_equipes.groupe_id
	JOIN equipes ON equipes.id = groupe_equipes.equipe_id
	ORDER BY groupes.lettre, equipes.classement_fifa
	";
	$requete = $pdo->query($sql);
	$equipes = $requete->fetchAll(PDO::FETCH_ASSOC);
	$groupes = [];
	foreach ($equipes as $equipe) {
	    $groupes[$equipe["groupe"]][] = $equipe;
	}
?>
      
        <div class="hero container-fluid px-0">
        <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
          <div class="navbar-nav ms-auto">
            <a class="nav-link active" href="#" onclick="showSection('accueil')">Accueil</a>
            <a class="nav-link" href="#" onclick="showSection('groupes')">Groupes</a>
            <a class="nav-link" href="#" onclick="showSection('matchs')">Matchs</a>
          </div>
          </nav>
        <h1>Les groupe de la coupe du monde 2026 sont :</h1>
        <div class="row g-0">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe A
    <?php foreach ($groupes['A'] as $equipe): ?>
      <div class="  fs-3 d-flex align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe B
    <?php foreach ($groupes['B'] as $equipe): ?>
      <div class="  fs-3 d-flex align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe C
    <?php foreach ($groupes['C'] as $equipe): ?>
      <div class="  fs-3 d-flex align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
</div>
        <div class="row g-0">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe D
    <?php foreach ($groupes['D'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe E
    <?php foreach ($groupes['E'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe F
    <?php foreach ($groupes['F'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
</div>
<div class="row g-0">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe G
    <?php foreach ($groupes['G'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe H
    <?php foreach ($groupes['H'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe I
    <?php foreach ($groupes['I'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
</div>
<div class="row g-0">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe J
    <?php foreach ($groupes['J'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe K
    <?php foreach ($groupes['K'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe L
    <?php foreach ($groupes['L'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span><?= htmlspecialchars($equipe['pays']) ?></span>
        <img src="https://flagcdn.com/24x18/<?= strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
  </div>
  </div>
  </div>
  </div>

<div id="matchs" class="section d-none">
  <?php
  $sqlMatchs = "
    SELECT
      matchs.date_match,
      groupes.lettre AS groupe,
      stades.nom AS stade,
      equipe1.nom AS equipe1,
      equipe1.code_pays AS code_equipe1,
      equipe2.nom AS equipe2,
      equipe2.code_pays AS code_equipe2
    FROM matchs
    JOIN groupes ON groupes.id = matchs.groupe_id
    JOIN stades ON stades.id = matchs.stade_id
    JOIN match_equipes me1 ON me1.match_id = matchs.id
    JOIN match_equipes me2 ON me2.match_id = matchs.id AND me1.equipe_id < me2.equipe_id
    JOIN equipes equipe1 ON equipe1.id = me1.equipe_id
    JOIN equipes equipe2 ON equipe2.id = me2.equipe_id
    ORDER BY matchs.date_match
  ";
  $requeteMatchs = $pdo->query($sqlMatchs);
  $listeMatchs = $requeteMatchs->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <div class="hero">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <div class="navbar-nav ms-auto">
          <a class="nav-link" href="#" onclick="showSection('accueil')">Accueil</a>
          <a class="nav-link" href="#" onclick="showSection('groupes')">Groupes</a>
          <a class="nav-link active" href="#" onclick="showSection('matchs')">Matchs</a>
        </div>
      </div>
    </nav>

    <div class="container py-4">
      <h1 class="text-center text-white mb-4">Les matchs de la Coupe du monde 2026</h1>
      <div class="row g-4">
        <?php foreach ($listeMatchs as $match): ?>
          <?php $date = new DateTime($match['date_match']); ?>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="carte-match">
              <div class="groupe-match">Groupe <?= htmlspecialchars($match['groupe']) ?></div>
              <div class="date-match"><?= $date->format('d/m/Y à H:i') ?></div>
              <div class="equipes-match">
                <!--
                <span><?= htmlspecialchars($match['equipe1']) ?></span>
                <strong>VS</strong>
                <span><?= htmlspecialchars($match['equipe2']) ?></span>
                -->
                <span class="team">
                  <?= htmlspecialchars($match['equipe1']) ?>
                  <img
                    src="https://flagcdn.com/w40/<?= strtolower(htmlspecialchars($match['code_equipe1'])) ?>.png"
                    alt="Drapeau <?= htmlspecialchars($match['equipe1']) ?>"
                    class="team-flag"
                  >
                </span>

                <strong>VS</strong>

                <span class="team">
                  <img
                    src="https://flagcdn.com/w40/<?= strtolower(htmlspecialchars($match['code_equipe2'])) ?>.png"
                    alt="Drapeau <?= htmlspecialchars($match['equipe2']) ?>"
                    class="team-flag"
                  >
                  <?= htmlspecialchars($match['equipe2']) ?>
                </span>
              </div>
              <div class="stade-match"><?= htmlspecialchars($match['stade']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>
    <script src="javascript.js"></script>
  </body>
</html>
