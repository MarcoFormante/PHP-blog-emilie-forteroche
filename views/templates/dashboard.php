<?php 
    /** 
     * Affichage de la page Tableau de bord : liste des articles avec titre, nombre de vues, nombre de commentaires, 
     * et un bouton pour acceder aux commentaires.
     */

    $tableHeadings = 
    [
        "title" => "Titre",
        "views" => "Vues",
        "comments_count" => "Nombre de <br/> commentaire",
        "date_creation" => "Date Creation"
    ];
?>


<h2>Tableau de Bord</h2>

<div class="admin-table">
    <table>
        <thead >
            <tr>
                <?php foreach($tableHeadings as $name => $heading) { ?>
                    <th>
                        <div class="admin-table-col-heading">
                            <span><?= $heading ?></span>
                            <a  
                                class="filter-arrow <?=($orderBy === $name ? "filter-arrow__on" :"") ?> <?php 
                                    if($orderBy === $name &&  $orderValue === "DESC"){
                                        echo "arrow-down";
                                    }elseif($orderBy === $name &&  $orderValue === "ASC"){
                                        echo "arrow-up";
                                    }else{
                                        echo "arrow";
                                    }
                                    ?>
                                " 
                                href="index.php?action=dashboard&orderBy=<?= $name ?>&orderValue=<?php 
                                if($orderBy === $name &&  $orderValue === "DESC"){
                                        echo "ASC";
                                    }elseif($orderBy === $name &&  $orderValue === "ASC"){
                                        echo "DESC";
                                    }else{
                                        echo "ASC";
                                    }
                                    ?>
                                "
                            >
                                >
                            </a>
                        </div>
                    </th> 
                <?php } ?>
                <th>Commentaires</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $key => $article) { ?>
                <tr class=<?= $key % 2 === 1 ? 'darken' : '' ?>>
                    <td><?= $article['title'] ?></td>
                    <td><?= $article['views']?></td>
                    <td><?= $article['comments_count']?></td>
                    <td><?= ucfirst(Utils::convertDateToFrenchFormat(new DateTime($article['date_creation'])))?></td>
                    <td><a class="submit" href="index.php?action=showComments&id=<?=$article['id']?>&title=<?= $article['title']?>">Commentaires</a></td>
                </tr>
            <?php } ?>    
            
        </tbody>
    </table>
    
</div>
