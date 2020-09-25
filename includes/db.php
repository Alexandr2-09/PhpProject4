<?php

class WishDB extends mysqli {
    // один экземпляр self, общий для всех экземпляров
    private static $instance = null;
    // подключение дб
    private $user = "sano";
    private $pass = "sanow";
    private $dbName = "регистратура2";
    private $dbHost = "localhost";

    //Этот метод должен быть статическим и должен возвращать экземпляр объекта, если объект
   //уже не существует.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    // Методы clone и wakeup предотвращают внешнее создание экземпляров Одноэлементного класса,
   // таким образом, исключается возможность дублирования объектов.
    public function __clone() {
        trigger_error('клонирование не допускается.', E_USER_ERROR);
    }
    public function __wakeup() {
        trigger_error('десериализация не разрешена.', E_USER_ERROR);
    }
    // приватный конструктор
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }
     //для получения идентификатора пациента на основе имени пациента
    public function get_пациент_id_by_ФИО($ФИО) {
        $ФИО = $this->real_escape_string($ФИО);
        $пациен = $this->query("SELECT id FROM пациент WHERE ФИО = '"
                        . $ФИО . "'");
        if ($пациен->num_rows > 0){
            $row = $пациен->fetch_row();
            return $row[0];
        } else
            return null;
    }
     // получение данных о пациенте по индефекатору
    public function get_данныеОПациенте_by_пациент_id($пациентID) {
        return $this->query("SELECT id, возраст, пол, адрес, телефон, болезнь FROM данныеОПациенте WHERE пациент_id=" . $пациентID);
    }
     // добавление записи в пациент
    public function create_пациен($ФИО) {
        $ФИО = $this->real_escape_string($ФИО);
        
        $this->query("INSERT INTO пациент (ФИО) VALUES ('" . $ФИО
                . "')");
    }    
    public function verify_wisher_credentials($ФИО) {
        $ФИО = $this->real_escape_string($ФИО);
        $result = $this->query("SELECT 1 FROM пациент WHERE ФИО = '"
                        . $ФИО . "'");
        return $result->data_seek(0);
    }
        function insert_wish($пациентID, $данные, $пол,$адрес,$телефон,$болезнь) {  
        $данные = $this->real_escape_string($данные);
        $пол = $this->real_escape_string($пол);
        $адрес = $this->real_escape_string($адрес);
        $телефон = $this->real_escape_string($телефон);
        $болезнь = $this->real_escape_string($болезнь);
        
           $this->query("INSERT INTO данныеОПациенте (пациент_id,возраст,пол,адрес,телефон,болезнь)" .
                " VALUES (" . $пациентID . ", '" . $данные . "'" . $пол . "," . $адрес . "," . $телефон . "," . $болезнь . ")");           
        }
}
?>