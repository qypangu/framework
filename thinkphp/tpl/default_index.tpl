<?php
namespace {$app}\{$module}{layer};
use app\common\controller\AdminAuth;
class Index{$suffix} extends AdminAuth{
	protected function init(){
        $this->model_name="{%model_name%}";
    }
    public function index(){
		return view();
	}
}//end class