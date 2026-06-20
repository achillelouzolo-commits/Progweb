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
      
        <div class="hero">
        <div class="row">
          <div class="col text-white">
            Groupe A
          </div>
          <div class="col text-white">
            Groupe B
          </div>
          <div class="col text-white">
            Groupe C
          </div>
        </div>
        <div class="row">
          <div class="col text-white">
            Groupe D
          </div>
          <div class="col text-white">
            Groupe E
          </div>
          <div class="col text-white">
            Groupe F
          </div>
        </div>
        <div class="row">
          <div class="col text-white">
            Groupe G
          </div>
          <div class="col text-white">
            Groupe H
          </div>
          <div class="col text-white">
            Groupe I
          </div>
        </div>
           <div class="row">
          <div class="col text-white">
            Groupe J
          </div>
          <div class="col text-white">
            Groupe K
          </div>
          <div class="col text-white">
            Groupe L
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
