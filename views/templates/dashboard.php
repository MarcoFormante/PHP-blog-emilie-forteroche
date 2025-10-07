<?php 
    /** 
     * Affichage de la page Tableau de bord : liste des articles avec titre, nombre de vues, nombre de commentaire, 
     * et un bouton pour acceder aux commentaires.
     */
?>


<h2>Tableau de Bord</h2>

<div class="admin-table">
    <table>
        <thead >
            <tr>
                <th>Titre</th>
                <th>Vues</th>
                <th>Nombre de commentaires</th>
                <th>Commentaires</th>
                <th>Date Creation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) { ?>
                <tr>
                    <td><?= $article['title'] ?></td>
                    <td><?= $article['views']?></td>
                    <td><?= $article['comments_count']?></td>
                    <td><a class="submit" href="index?action=showComments&id=<?=$article['id']?>">Commentaires</a></td>
                    <td><?= ucfirst(Utils::convertDateToFrenchFormat(new DateTime($article['date_creation'])))?></td>
                </tr>
            <?php } ?>    
            
        </tbody>
    </table>
    
</div>
