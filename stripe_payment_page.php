<!DOCTYPE html>
<html>
<head>
  <title>Stripe Payment Page</title>
  <script src="https://js.stripe.com/v3/"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <h1 class="my-4">Paiement</h1>

  <form id="payment-form">
    <div class="form-group">
      <label for="card-element">
        Informations de carte de crédit
      </label>
      <div id="card-element" class="form-control">
        <!-- Les éléments de la carte seront insérés ici. -->
      </div>

      <!-- Afficher les erreurs ici -->
      <div id="card-errors" role="alert" class="text-danger"></div>

      <button class="btn btn-primary" type="submit">Payer</button>
    </div>
  </form>
</div>

<script>
  var stripe = Stripe('pk_test_51NjlYIBgWL23FWul9vMpVtPFkfwKQXhZI5CR2woKKud8QeGWXKegagRMUciDkkrM0DKvPfKgTQN1R6qeRS9Cm8qx00ledBDTIG');
  var elements = stripe.elements();
  var card = elements.create('card');
  
  card.mount('#card-element');

  var form = document.getElementById('payment-form');
  form.addEventListener('submit', function(event) {
    event.preventDefault();
    stripe.createToken(card).then(function(result) {
      if (result.error) {
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
      } else {
        // Ici, vous envoyez le token au serveur pour effectuer le paiement.
        // Pour cet exemple, nous allons simplement afficher une alerte pour simuler un paiement réussi.
        alert('Paiement effectué avec succès! Votre token est: ' + result.token.id);
      }
    });
  });
</script>
</body>
</html>
