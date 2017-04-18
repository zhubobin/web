<?php

class Domain_Game {
	public function Jinhua() {
    $rs = array();
    $model = new Model_Jinhua();
    $rs = $model->Jinhua();
		return $rs;
  }
	public function record($liveuid,$stream,$token,$name,$time) {
    $rs = array();
    $model = new Model_Game();
    $rs = $model->record($liveuid,$stream,$token,$name,$time);
		return $rs;
  }
	public function endGame($liveuid,$gameid,$type) {
    $rs = array();
    $model = new Model_Game();
    $rs = $model->endGame($liveuid,$gameid,$type);
		return $rs;
  }
	public function JinhuaBet($uid,$gameid,$coin,$name)
	{
		$rs = array();
    $model = new Model_Game();
    $rs = $model->gameBet($uid,$gameid,$coin,$name);
		return $rs;
	}
}