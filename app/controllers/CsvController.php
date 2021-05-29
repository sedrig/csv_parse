<?php


namespace App\controllers;

use App\models\Database;
use App\components\ParseCsv;
use League\Plates\Engine;

class CsvController
{
    private $view;
    private $parse_csv;
    private $database;

    public function __construct(Engine $view, ParseCsv $parse_csv, Database $database)
    {
        $this->database=$database;
        $this->parse_csv=$parse_csv;
        $this->view=$view;

    }

    /**
     * Метод, который перенаправляет на главную страницу
    **/

    public function index(){
        echo $this->view->render('csv/index');
    }

    /**
     * Метод предназначен для сохранения в бд csv файла
    **/

    public function store(){
        //Если csv файл не был выбран перенаправит обратно на главную страницу с просьбой выбрать его
        if ($_FILES["csv"]["name"]==""){
            $answer = 'Пожалуйста выберите файл';
            echo $this->view->render('csv/index',['answer'=>$answer]);
        }else{
            //Находит полный путь к файлу csv и сохраняет его с помощью метода store()
            $filePath = realpath($_FILES["csv"]["tmp_name"]);
            $parse=$this->parse_csv->parse_in_array($filePath);
            $answer=$this->database->store('tu',$parse);
            //Возращение на главную страницу с ответом были загружены данные в бд или нет
            echo $this->view->render('csv/index', ['answer' => $answer]);
        }

    }

    /**
     * Метод предназначен для удаления всех записей с бд
    **/
    public function delete(){
        $this->database->delete('tu');
        $answer="База была удалена";
        //Перенаправление на гланую страницу с ответом
        echo $this->view->render('csv/index',['answer'=>$answer]);
    }

    /**
     * Метод предназначен для вытаскивания всех записей с бд если они там имеются
     * или ответом что их там нет
    **/
    public function table(){
        $table=$this->database->all('tu');
        $answer='Таблица в БД является пустой';
        if (empty($table)){
            echo $this->view->render('csv/empty_database',['answer'=>$answer]);
        }else{
            echo $this->view->render('csv/table',['tables'=>$table]);
        }

    }
}