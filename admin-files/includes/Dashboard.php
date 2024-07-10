<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Admin-style.css">
    <link rel="icon" href="../../images/logo.png" type="image/png">
    <title>Dashboard</title>
</head>
<body>
    <style>
        * {
            color: rgb(50, 50, 50);
        }
    </style>
    <div id='back'>
        <a href="admin-menu.php">Go back</a>
    </div>
    <div class="control">
        <button onclick="showEventForm()">Ajouter Un Evenement</button>
        <button onclick="showProductForm()">Ajouter Un Produit</button>
        <button onclick="showEventModificationForm()">Modifier Un Evenement</button>
        <button onclick="showProductModificationForm()">Modifier Un Produit</button>
        <button onclick="showEventDeleteForm()">Supprimer Un Evenement</button>
        <button onclick="showProductDeleteForm()">Supprimer Un Produit</button>
    </div>
    
    <div id="result"></div>

    <?php
    if (isset($_GET['msg'])) {
        $message = htmlspecialchars($_GET['msg']);
        echo "<div class='message'>$message</div>";
    }
    ?>

    <script>
        async function fetchItems(type) {
            const response = await fetch(`fetch_items.php?type=${type}`);
            return await response.json();
        }

        async function showEventForm() {
            const result = document.getElementById('result');
            result.innerHTML = `
                <form action="insert.php" method="POST" enctype="multipart/form-data">
                    <input type='hidden' name='type' value='event'>
                    <label for="eventName">Ajouter un Evenement</label>
                    <input type="text" required placeholder="Nom d'evenement" name="eventName">
                    <textarea name="description" class="desc" placeholder="Description"></textarea>
                    <label for="photo">Ajouter une image (4:3 jpg)</label>
                    <input type="file" name="photo" required>
                    <input type="submit" value="Ajouter l'evennement" class="btn">
                </form>`;
        }

        async function showProductForm() {
            const result = document.getElementById('result');
            result.innerHTML = `
                <form action="insert.php" method="POST" enctype="multipart/form-data">
                    <input type='hidden' name='type' value='product'>
                    <label for="productName">Ajouter un Produit</label>
                    <input type="text" required placeholder="Nom de Produit" name="productName">
                    <textarea name="description" class="desc" placeholder="Description"></textarea>
                    <input type="number" name="quantity" placeholder="Quantité">
                    <input type="number" placeholder="Prix" name="price">
                    <label for="photo">Ajouter une image (4:5 jpg)</label>
                    <input type="file" name="photo" required>
                    <input type="submit" value="Ajouter le produit" class="btn">
                </form>`;
        }

        async function showEventModificationForm() {
            const result = document.getElementById('result');
            const events = await fetchItems('event');
            const eventOptions = events.map(event => `<option value="${event.event_name}">${event.event_name}</option>`).join('');
            
            result.innerHTML = `
                <form action="insert.php" method="POST" enctype="multipart/form-data">
                    <input type='hidden' name='type' value='modif-event'>
                    <label for="eventName">Modifier un evennement</label>
                    <select name="eventName" required>${eventOptions}</select>
                    <input type="text" placeholder="Modifier le Nom d'evennement" name="newEvennementName">
                    <textarea name="description" class="desc" placeholder="Modifier la description"></textarea>
                    <label for="eventName">Modifier l'image (5:4 jpg)</label>
                    <input type="file" name="photo">
                    <input type="submit" value="modifier l'evennement" class="btn">
                </form>`;
        }

        async function showProductModificationForm() {
            const result = document.getElementById('result');
            const products = await fetchItems('product');
            const productOptions = products.map(product => `<option value="${product.produit_name}">${product.produit_name}</option>`).join('');
            
            result.innerHTML = `
                <form action="insert.php" method="POST" enctype="multipart/form-data">
                    <input type='hidden' name='type' value='modif-product'>
                    <label for="productName">Modifier un Produit</label>
                    <select name="productName" required>${productOptions}</select>
                    <input type="text" placeholder="Modifier le Nom du Produit" name="newProductName">
                    <textarea name="description" class="desc" placeholder="Modifier la description"></textarea>
                    <input type="number" name="quantity" placeholder="Quantité">
                    <input type="number" placeholder="Prix" name="price">
                    <label for="photo">Modifier l'image (5:4 jpg)</label>
                    <input type="file" name="photo">
                    <input type="submit" value="Modifier le Produit" class="btn">
                </form>`;
        }

        async function showEventDeleteForm() {
            const result = document.getElementById('result');
            const events = await fetchItems('event');
            const eventOptions = events.map(event => `<option value="${event.event_name}">${event.event_name}</option>`).join('');

            result.innerHTML = `
                <form action="delete.php" method="POST">
                    <input type='hidden' name='type' value='delete-event'>
                    <label for="eventName">Supprimer un Evenement</label>
                    <select name="eventName" required>${eventOptions}</select>
                    <input type="submit" value="Supprimer l'evennement" class="btn">
                </form>`;
        }

        async function showProductDeleteForm() {
            const result = document.getElementById('result');
            const products = await fetchItems('product');
            const productOptions = products.map(product => `<option value="${product.produit_name}">${product.produit_name}</option>`).join('');

            result.innerHTML = `
                <form action="delete.php" method="POST">
                    <input type='hidden' name='type' value='delete-product'>
                    <label for="productName">Supprimer un Produit</label>
                    <select name="productName" required>${productOptions}</select>
                    <input type="submit" value="Supprimer le Produit" class="btn">
                </form>`;
        }
    </script>
</body>
</html>
