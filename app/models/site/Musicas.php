<?php

namespace app\models\site;

use app\models\Model;

class Musicas extends Model {
	protected $table = 'musica';

	public function musicas() {
		$this->sql = "select * from {$this->table}";
		$this->busca('nomemusica,banda,instrumento,dificuldade');
		return $this->get();
	}

}
