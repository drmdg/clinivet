<?php

namespace app\database\models;

use app\traits\Connection;
use app\traits\Create;
use app\traits\Delete;
use app\traits\Read;
use app\traits\Update;
use PDOException;

abstract class Base{

    use  Read,Connection,Create,Update,Delete;

    

}