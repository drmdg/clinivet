<?php

namespace app\controllers\site;

use app\controllers\Controller;
use app\models\site\Animais;
use app\models\site\Musicas;
use app\models\site\Post;
use app\src\Validate;

class HomeController extends Controller {

	public function index() {

		$musica = new Musicas;
        $musicas = $musica->musicas();

		$this->view('site.home', [
			'title' => 'CliniVet',
            'musicas' => $musicas,
			
		]);
	}

    
	public function musicaId($request,$response,$args) {

		$musica = new Musicas;
        $musicas = $musica->findBy('id',$args['id']);

		$this->view('site.musica', [
			'title' => 'CliniVet',
            'musicas' => $musicas,
			
		]);
	}

    public function cadastroMusica() {

		$this->view('site.cadastroMusica', [
			'title' => 'Cadastro Musica',
		]);
	}

    public function store() {
        $validate = new Validate;
        $musicas = new Musicas;
		$data = $validate->validate([
			'nomemusica' => 'required',
			'banda' => 'required',
			'dificuldade' => 'required',
			'instrumento' => 'required',
			'link' => 'required',
		]);

		if ($validate->hasErrors()) {
			return back();
		}

		$created = $musicas->create([
			'nomemusica' => $data->nomemusica,
			'banda' => $data->banda,
			'dificuldade' => $data->dificuldade,
			'instrumento' => $data->instrumento,
			'link' => $data->link,

		]);

		if ($created) {
			flash('message','Cadastrado com sucesso');

			return back();
		}

		flash('message', 'Erro ao cadastrar, tente novamente');
		return back();
	}
    public function guitarra(){
        $musica = new Musicas;
        $musicas = $musica->findByInst('instrumento','guitarra')->get();


		$this->view('site.home', [
			'title' => 'CliniVet',
            'musicas' => $musicas,
			
		]);
    }

    public function bateria(){
        $musica = new Musicas;
        $musicas = $musica->findByInst('instrumento','bateria')->get();
        
		$this->view('site.home', [
			'title' => 'CliniVet',
            'musicas' => $musicas,
			
		]);
    }

    public function violao(){
        $musica = new Musicas;
        $musicas = $musica->findByInst('instrumento','violao')->get();

		$this->view('site.home', [
			'title' => 'CliniVet',
            'musicas' => $musicas,
			
		]);
    }

    public function update($request,$response,$args) {

		$musica = new Musicas;
        $musicas = $musica->findBy('id',$args['id']);

		$this->view('site.update', [
			'title' => 'Update musica',
            'musicas' => $musicas,
			
		]);
	}

    
    public function updatemusica($request,$response,$args) {
        $validate = new Validate;
        $musicas = new Musicas;
		$data = $validate->validate([
			'nomemusica' => 'required',
			'banda' => 'required',
			'dificuldade' => 'required',
			'instrumento' => 'required',
			'link' => 'required',
		]);

		if ($validate->hasErrors()) {
			return back();
		}

		$updated = $musicas->find('id',$args['id'])->update([
			'nomemusica' => $data->nomemusica,
			'banda' => $data->banda,
			'dificuldade' => $data->dificuldade,
			'instrumento' => $data->instrumento,
			'link' => $data->link,

		]);

		if ($updated) {
			flash('message','Atualizado com sucesso');

			return back();
		}

		flash('message', 'Erro ao atualizar, tente novamente');
		return back();
	}

    
    public function delete($request,$response,$args) {
        
        $musicas = new Musicas;
		

		$musicaEncontrada = $musicas->find('id',$args['id'])->delete();

		return back();
	}


}