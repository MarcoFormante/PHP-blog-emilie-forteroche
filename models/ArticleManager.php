<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager 
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles() : array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }


      /**
     * Récupère tous les articles pour la page dashboard avec les nombre vues et commentaires.
     * @return array : un tableau avec id,title,views,date_creation et comments_count de chaque article.
     */
    public function getAllDashboardArticles(string|null $orderBy = null,string|null $orderValue = null) : array
    {
        $param = in_array($orderBy, ['id','title','views','comments_count','date_creation']) ? $orderBy : 'id';
        $paramValue = in_array($orderValue,["ASC","DESC"]) ? $orderValue : 'ASC';

        
        
        $sql = "SELECT a.id, a.title, a.date_creation, views, COUNT(c.id) as comments_count
                FROM article a 
                LEFT JOIN comment c ON c.id_article = a.id
                GROUP BY a.id
                ORDER BY $param $paramValue"
                ;
                
                
        $result = $this->db->query($sql);

        $articles = [];

        while ($data = $result->fetch()) {
            $articles[] = [
                "id" => $data['id'],
                "title" => $data['title'],
                "views" => $data['views'],
                "date_creation" => $data['date_creation'],
                "comments_count" => $data['comments_count']
            ];
        }

        return $articles;
    }




    
    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id) : ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article) : void 
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article) : void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation,date_update) VALUES (:id_user, :title, :content, NOW(),NOW())";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
        ]);
    }
    

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article) : void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id) : void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }


     /**
     * Mise à jour des vues de l'article
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateViews(Article $article) : void
    {
        $sql = "UPDATE article SET views = :views WHERE id = :id";
        $this->db->query($sql, [
            'views' => $article->getViews(),
            'id' => $article->getId()
        ]);
    }
}