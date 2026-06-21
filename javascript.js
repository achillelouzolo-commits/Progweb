function showSection(id) {
  document.querySelectorAll('.section').forEach(sec => {
    sec.classList.add('d-none');
  });

  document.getElementById(id).classList.remove('d-none');
}

function afficherEquipe(nom) {
  const data = equipes.find(e => e.nom === nom);
  document.getElementById('detail-equipe').innerHTML = `
    <div class="text-white text-center">
      <img src="https://flagcdn.com/w80/${data.code_pays.toLowerCase()}.png" class="mb-3">
      <h1>${data.nom}</h1>
      <p class="fs-4">${data.surnom ?? ''}</p>
      <table class="table table-dark table-bordered mx-auto" style="max-width:500px">
        <tr><td>Classement FIFA</td><td>#${data.classement_fifa}</td></tr>
        <tr><td>Confédération</td><td>${data.confederation}</td></tr>
        <tr><td>Entraîneur</td><td>${data.entraineur}</td></tr>
        <tr><td>Nombres de CDM gagnées</td><td>${data.nombre_cdm}</td></tr>
      </table>
      <button class="btn btn-secondary mt-3" onclick="showSection('groupes')">← Retour aux groupes</button>
    </div>
  `;
  showSection('equipe');
}
