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

    public function index(){
        echo $this->view->render('csv/index');
    }

    public function store(){

        if ($_FILES["csv"]["name"]==""){
            $answer = 'Пожалуйста выберите файл';
            echo $this->view->render('csv/index',['answer'=>$answer]);
        }else{
            $filePath = realpath($_FILES["csv"]["tmp_name"]);
            $parse=$this->parse_csv->parse_in_array($filePath);
            $answer=$this->database->store('tu',$parse);
            echo $this->view->render('csv/index', ['answer' => $answer]);
        }

    }

    public function delete(){
        $this->database->delete('tu');
        $answer="База была удалена";
        echo $this->view->render('csv/index',['answer'=>$answer]);
    }

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