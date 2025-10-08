<?php
/**
 * Affiche le titre de l'article et ses commentaires
 * On peut supprimer les commentaires
 */
?>

<div>
    <h2 class="commentsTitle">Commentaires de l'article : "<?= $title ?>"</h2>
    
    <?php 
        if (empty($comments)) {
            echo '<p class="info">Aucun commentaire pour cet article.</p>';
        } else {
            echo '<p class="deleteAll-text"><a href="index.php?action=deleteAllComments&id='. Utils::request("id"). '">Supprimer tous les commentaires</a></p>';
            echo '<ul>';
            foreach ($comments as $comment) {
                echo '<li class="comment">';
                echo '<a class="delete" href="index.php?action=deleteComment&commentId='. $comment->getId() .'&title=' . Utils::request('title').'&id='.Utils::request('id') .'">X</a>';
                echo '  <div class="detailComment">';
                echo '      <h3 class="info">Le ' . Utils::convertDateToFrenchFormat($comment->getDateCreation()) . ", " . Utils::format($comment->getPseudo()) . ' a écrit :</h3>';
                echo '      <p class="content">' . Utils::format($comment->getContent()) . '</p>';
                echo '  </div>';
                echo '</li>';
            }               
            echo '</ul>';
        } 
    ?>
</div>