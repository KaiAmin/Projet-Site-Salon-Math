<?php require("view_debut.php") ?>
		
		<link rel="stylesheet" href="./Content/css/style_contact.css">

		<div class="wrapper">
			<div class="inner">
				<form action="?controller=contact&action=sendMail" method=post>
					<h3>Nous contacter</h3>
					<p>Contacter nous juste en-dessous !</p>
					<label class="form-group">
						<input type="text" name='nom' class="form-control"  required>
						<span>Votre nom</span>
						<span class="border"></span>
					</label>
					<label class="form-group">
						<input type="text" name='mail' class="form-control"  required>
						<span>Votre mail</span>
						<span class="border"></span>
					</label>
					<label class="form-group" >
						<textarea name="message" class="form-control text-break" required></textarea>
						<span>Votre message</span>
						<span class="border"></span>
					</label>
					<input type="submit" value="Envoyer"> 
				</form>
			</div>
		</div>

<?php require("view_fin.php");?>