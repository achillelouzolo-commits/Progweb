<?php
$pdo = new PDO('mysql:host=localhost;dbname=mondial_2026;charset=utf8mb4', 'root', '');

$sqlProchain = "
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
  WHERE matchs.date_match >= NOW()
  ORDER BY matchs.date_match ASC
  LIMIT 1
";
$requeteProchain = $pdo->query($sqlProchain);
$prochain = $requeteProchain->fetch(PDO::FETCH_ASSOC);

$sqlDetails = "
  SELECT 
    equipes.nom, equipes.code_pays, equipes.classement_fifa, equipes.confederation,
    details_equipes.surnom, details_equipes.nombre_cdm, details_equipes.entraineur
  FROM equipes
  JOIN details_equipes ON equipes.id = details_equipes.equipe_id
";
$requeteDetails = $pdo->query($sqlDetails);
$detailsEquipes = $requeteDetails->fetchAll(PDO::FETCH_ASSOC);
?>
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
            <a class="nav-link" href="#" onclick="showSection('classement')">Classement</a>
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
          <?php if ($prochain) : ?>
<div class="d-flex justify-content-center">
<div style="width: 600px;">
  <div class="carte-match">
    <div class="groupe-match">
      ⚽ Prochain match — Groupe <?php echo htmlspecialchars($prochain['groupe']) ?>
    </div>
    <div class="date-match fs-5">
                <?php echo date('d/m/Y à H:i', strtotime($prochain['date_match'])) ?>
    </div>
    <div class="equipes-match fs-4">
      <span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($prochain['code_equipe1'])) ?>.png">
                <?php echo htmlspecialchars($prochain['equipe1']) ?>
      </span>
      <strong>VS</strong>
      <span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($prochain['code_equipe2'])) ?>.png">
                <?php echo htmlspecialchars($prochain['equipe2']) ?>
      </span>
    </div>
    <div class="stade-match fs-5">
      📍 <?php echo htmlspecialchars($prochain['stade']) ?>
    </div>
  </div>
  </div>
</div>
          <?php endif; ?>
</div>
      </div>
      
      </div>
    </div>
    <script>
  const equipes = <?php echo json_encode($detailsEquipes) ?>;
</script>
    <div id="groupes" class="section d-none">
      <?php
        $pdo = new PDO('mysql:host=localhost;dbname=mondial_2026;charset=utf8mb4', 'root', '');

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
            <a class="nav-link" href="#" onclick="showSection('accueil')">Accueil</a>
            <a class="nav-link active" href="#" onclick="showSection('groupes')">Groupes</a>
            <a class="nav-link" href="#" onclick="showSection('matchs')">Matchs</a>
            <a class="nav-link" href="#" onclick="showSection('classement')">Classement</a>
          </div>
          </nav>
        <h1>Les groupe de la coupe du monde 2026 sont :</h1>
        <div class="row g-4 mb-4">
          <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe A
    <?php foreach ($groupes['A'] as $equipe): ?>
      <div class="  fs-3 d-flex align-items-center">
      <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
    </span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe B
    <?php foreach ($groupes['B'] as $equipe): ?>
      <div class="  fs-3 d-flex align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe C
    <?php foreach ($groupes['C'] as $equipe): ?>
      <div class="  fs-3 d-flex align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
</div>
        <div class="row g-4 mb-4">
          <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe D
    <?php foreach ($groupes['D'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe E
    <?php foreach ($groupes['E'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe F
    <?php foreach ($groupes['F'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
</div>
<div class="row g-4 mb-4">
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe G
    <?php foreach ($groupes['G'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe H
    <?php foreach ($groupes['H'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe I
    <?php foreach ($groupes['I'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
</div>
<div class="row g-4 mb-4">
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe J
    <?php foreach ($groupes['J'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe K
    <?php foreach ($groupes['K'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="col">
  <div class="col text-white p-3   fs-3 carte-match">
    Groupe L
    <?php foreach ($groupes['L'] as $equipe): ?>
      <div class="  fs-3 d-flex   align-items-center">
        <span onclick="afficherEquipe('<?php echo htmlspecialchars($equipe['pays']) ?>')" style="cursor:pointer">
        <?php echo htmlspecialchars($equipe['pays']) ?>
</span>
        <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
      </div>
    <?php endforeach; ?>
    </div>
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
          <a class="nav-link" href="#" onclick="showSection('classement')">Classement</a>
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
              <div class="groupe-match">Groupe <?php echo htmlspecialchars($match['groupe']) ?></div>
              <div class="date-match"><?php echo $date->format('d/m/Y à H:i') ?></div>
              <div class="equipes-match">
                <!--
                <span><?php echo htmlspecialchars($match['equipe1']) ?></span>
                <strong>VS</strong>
                <span><?php echo htmlspecialchars($match['equipe2']) ?></span>
                -->
                <span class="team">
                  <?php echo htmlspecialchars($match['equipe1']) ?>
                  <img
                    src="https://flagcdn.com/w40/<?php echo strtolower(htmlspecialchars($match['code_equipe1'])) ?>.png"
                    alt="Drapeau <?php echo htmlspecialchars($match['equipe1']) ?>"
                    class="team-flag"
                  >
                </span>

                <strong>VS</strong>

                <span class="team">
                  <img
                    src="https://flagcdn.com/w40/<?php echo strtolower(htmlspecialchars($match['code_equipe2'])) ?>.png"
                    alt="Drapeau <?php echo htmlspecialchars($match['equipe2']) ?>"
                    class="team-flag"
                  >
                  <?php echo htmlspecialchars($match['equipe2']) ?>
                </span>
              </div>
              <div class="stade-match"><?php echo htmlspecialchars($match['stade']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div><div id="classement" class="section d-none">
    <div class="hero">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <div class="navbar-nav ms-auto">
          <a class="nav-link" href="#" onclick="showSection('accueil')">Accueil</a>
          <a class="nav-link" href="#" onclick="showSection('groupes')">Groupes</a>
          <a class="nav-link" href="#" onclick="showSection('matchs')">Matchs</a>
          <a class="nav-link active" href="#" onclick="showSection('classement')">Classement</a>
        </div>
      </div>
    </nav>
    <?php
    $sqlClassement = "
	  SELECT 
	    equipes.nom AS pays,
	    equipes.code_pays,
	    equipes.classement_fifa,
	    equipes.confederation
	  FROM equipes
	  ORDER BY equipes.classement_fifa ASC
	";

    $requeteClassement = $pdo->query($sqlClassement);
    $classement = $requeteClassement->fetchAll(PDO::FETCH_ASSOC);
    ?>
<div class="container py-4">
      <h1 class="text-center text-white mb-4">Classement FIFA</h1>
      <table class="table table-dark table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Drapeau</th>
            <th>Pays</th>
            <th>Confédération</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($classement as $equipe): ?>
          <tr>
            <td><?php echo $equipe['classement_fifa'] ?></td>
            <td>
              <img src="https://flagcdn.com/24x18/<?php echo strtolower(htmlspecialchars($equipe['code_pays'])) ?>.png">
            </td>
            <td><?php echo htmlspecialchars($equipe['pays']) ?></td>
            <td><?php echo htmlspecialchars($equipe['confederation']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>    
    <div id="equipe" class="section d-none">
  <div class="hero">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <div class="navbar-nav ms-auto">
          <a class="nav-link" href="#" onclick="showSection('accueil')">Accueil</a>
          <a class="nav-link" href="#" onclick="showSection('groupes')">Groupes</a>
          <a class="nav-link" href="#" onclick="showSection('matchs')">Matchs</a>
          <a class="nav-link" href="#" onclick="showSection('classement')">Classement</a>
        </div>
      </div>
    </nav>
    <div class="container py-4" id="detail-equipe"></div>
  </div>
</div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>
    <script src="javascript.js"></script>
  </body>
</html>
