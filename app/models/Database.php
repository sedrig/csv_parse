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

    /**
     * Метод который вытаскивает все поля с таблицы в бд и принимает
     * @param $table таблицу в базе данных
    **/
    public function all($table)
    {
        //Объявление метода Select
        $select = $this->queryFactory->newSelect();
        //Создание запроса в БД
        $select->cols(["*"])
            ->from($table);
        //Подготовк азапроса
        $sth = $this->pdo->prepare($select->getStatement());
        //Выполнение запроса
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Метод отвечает за сохранение данных в бд и принимает
     * @param $table таблицу базы данных
     * @param $data массив данных
    **/
    public function store($table, $data)
    {
        //Правильные поля в csv файле
        $correct=[
            'UID', 'Name', 'Age', 'Email', 'Phone', 'Gender',
        ];

        //Сравнения главных полей в загруженом csv файле с правильными полями для коректной записи в БД
        $comparison=$data[0]===$correct;

        //Создание массива для записи в бд или обновления если поля с таким UID уже существует
        if ($comparison){
            for ($i=1;$i<count($data);$i++){
                $arr[]=$data[$i];
            }
            foreach ($arr as $arrays){
                //Создание запроса в бд
                $sql = "REPLACE INTO $table (id,name,age,email,phone,gender) VALUES (:id,:name,:age,:email,:phone,:gender)";
                //Подготовка запроса
                $statement = $this->pdo->prepare($sql);
                //Установка значений
                $statement->bindValue(":id", $arrays[0]);
                $statement->bindValue(":name", $arrays[1]);
                $statement->bindValue(":age", $arrays[2]);
                $statement->bindValue(":email", $arrays[3]);
                $statement->bindValue(":phone", $arrays[4]);
                $statement->bindValue(":gender", $arrays[5]);
                //Выполнение запроса
                $statement->execute();
            }
            return 'Все хорошо';
        }else{
            return 'Файл не подходит для записи в БД';
        }
    }

    /**
     * Метод предназначен для удаления всех записей в таблице и принимает
     * @param $table таблица базы данных
    **/
    public function delete($table)
    {
        //Объявление метода на удаления
        $delete = $this->queryFactory->newDelete();
        //Создание запроса на удаления с бд
        $delete
            ->from($table);
        //Выполнение запроса
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());

    }
}