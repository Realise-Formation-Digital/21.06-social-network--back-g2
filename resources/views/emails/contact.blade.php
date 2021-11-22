<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Prise de contact sur mon beau site</h2>
    <p>Réception d'une prise de contact avec les éléments suivants :</p>
    <ul>
      <li><strong>Nom</strong> : {{ $body['nom'] }}</li>
      <li><strong>Email</strong> : {{ $body['email'] }}</li>
      <li><strong>Message</strong> : {{ $body['message'] }}</li>
    </ul>
  </body>
</html>
