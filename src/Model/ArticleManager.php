<?php

namespace App\Model;

use PDO;

class ArticleManager extends AbstractManager
{
    public const TABLE = 'articles';

    // Recuperation de l'article et son "tags" 
    public function selectAllArticlesAndTagName(): array
    {
        $query = "SELECT a.*, t.name as 'tag_name'
            FROM articles AS a 
            INNER JOIN articles_tags AS artg ON artg.article_id = a.id
            INNER JOIN tags AS t ON t.id = artg.tags_id 
            WHERE a.id";
         
        $statement = $this->pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll();
    }

    // Insertion en BD
    public function insert(array $item): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $item['title'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    // Mise a jour d'une table
    public function update(array $item): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $item['id'], PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
