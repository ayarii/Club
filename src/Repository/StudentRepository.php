<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    // /**
    //  * @return Student[] Returns an array of Student objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Student
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

      public function listStudent(){
          return $this->createQueryBuilder('s')
              ->where('s.nsc LIKE ?1')
              ->andWhere('s.email LIKE ?2')
             ->setParameter('1', 'L%')
             ->setParameter('2', '%V%')
              ->getQuery()
              ->getResult();
      }


    /**
     * Requête QueryBuilder
     * */
    public function orderByMail()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.email', 'ASC')
            ->getQuery()->getResult();
    }

    public function searchStudent($nsc)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.nsc LIKE :nsc')
            ->setParameter('nsc', '%'.$nsc.'%')
            ->getQuery()
            ->execute();
    }

    public function listStudentByClass($id)
    {
        return $this->createQueryBuilder('s')
            ->join('s.classroom', 'c')
            ->addSelect('c')
            ->where('c.id=:id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();
    }
}
