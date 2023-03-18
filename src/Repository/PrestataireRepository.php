<?php

namespace App\Repository;

use App\Entity\Prestataire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prestataire>
 *
 * @method Prestataire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestataire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestataire[]    findAll()
 * @method Prestataire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestataireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestataire::class);
    }

    public function findPrestatairesPaginated(int $page, int $limit = 8, $filters = null): array
{
    $limit = abs($limit);

    // Calculez l'offset pour la pagination
    $offset = ($page - 1) * $limit;

    // Créez la requête de base avec la jointure
    $queryBuilder = $this->createQueryBuilder('p')
        ->innerJoin('p.promotion', 'pp')
        ->innerJoin('pp.categorie', 'c')
        ->groupBy('p.id')
        ->orderBy('p.id', 'DESC')
        ->setMaxResults($limit)
        ->setFirstResult($offset);

    // Ajoutez la clause WHERE si le paramètre $filters est défini
    if ($filters !== null && $filters !== "all") {
        $queryBuilder->where('c.nom = :category')
            ->setParameter('category', $filters);
    }

    // Obtenez la requête
    $query = $queryBuilder->getQuery();

    // Créez un nouvel objet Paginator avec la requête
    $paginator = new Paginator($query);

    // Obtenez le nombre total d'éléments
    $totalItems = count($paginator);

    // Calculez le nombre total de pages
    $totalPages = ceil($totalItems / $limit);

    // Obtenez les résultats paginés
    $result = $paginator->getQuery()->getResult();

    // Retournez les résultats et les informations de pagination
    return [
        'items' => $result,
        'totalItems' => $totalItems,
        'totalPages' => $totalPages,
        'currentPage' => $page,
    ];
}



    public function save(Prestataire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Prestataire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Prestataire[] Returns an array of Prestataire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Prestataire
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
