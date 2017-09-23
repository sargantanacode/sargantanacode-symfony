<?php

namespace AppBundle\Repository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCommentsWithRelatedPost($limit = null)
    {
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        if ($limit) {
            $statement = $connection
                ->prepare('
                SELECT title_es, title_en, slug, comment.*
                FROM post INNER JOIN comment on
                post.id = comment.post_id
                ORDER BY comment.date DESC LIMIT :limit
            ');
            $statement->bindValue('limit', $limit, \PDO::PARAM_INT);
        } else {
            $statement = $connection
                ->prepare('
                SELECT title_es, title_en, slug, comment.*
                FROM post INNER JOIN comment on
                post.id = comment.post_id
                ORDER BY comment.date DESC
            ');
        }
        $statement->execute();
        return $statement->fetchAll();
    }
}
