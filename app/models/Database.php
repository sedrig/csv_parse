<?php
namespace App\models;

use PDO;
use Aura\SqlQuery\QueryFactory;

class Database
{
    private $queryFactory;
    private $pdo;

    public function __construct(QueryFactory $queryFactory, PDO $pdo)
    {
        $this->queryFactory = $queryFactory;
        $this->pdo = $pdo;
    }

    public function all($table)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from($table);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function store($table, $data)
    {
        $correct=[
            'UID', 'Name', 'Age', 'Email', 'Phone', 'Gender',
        ];
        echo '<br>';
        $comparison=$data[0]===$correct;

        if ($comparison){
            for ($i=1;$i<count($data);$i++){
                $arr[]=$data[$i];
            }
            foreach ($arr as $arrays){
                $sql = "REPLACE INTO $table (id,name,age,email,phone,gender) VALUES (:id,:name,:age,:email,:phone,:gender)";
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(":id", $arrays[0]);
                $statement->bindValue(":name", $arrays[1]);
                $statement->bindValue(":age", $arrays[2]);
                $statement->bindValue(":email", $arrays[3]);
                $statement->bindValue(":phone", $arrays[4]);
                $statement->bindValue(":gender", $arrays[5]);
                $statement->execute();
            }
            return 'Все хорошо';
        }else{
            return 'Файл не подходит для записи в БД';
        }
    }

    public function delete($table)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table);
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());

    }
}