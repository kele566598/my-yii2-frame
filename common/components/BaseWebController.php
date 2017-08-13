<?php
namespace app\common\components;

use Yii;
use yii\web\Controller;

class BaseWebController extends Controller
{
    // 关闭yii2自带的csrf验证
    public $enableCsrfValidation = false;

    /**
     * 获取post方式提交的某个字段的 值
     * @param $key              字段名称
     * @param string $default   字段默认值
     * @return array|mixed      字段的值
     */
	public function post($key, $default = "") {
		return \Yii::$app->request->post($key, $default);
	}

    /**
     * 获取get方式提交的某个字段的 值
     * @param $key              字段名称
     * @param string $default   字段默认值
     * @return array|mixed      字段的值
     */
	public function get($key, $default = "") {
		return \Yii::$app->request->get($key, $default);
	}

    /**
     * 设置一条cookie
     * @param $name         cookie名
     * @param $value        cookie值
     * @param int $expire   过期时间
     */
	protected function setCookie($name,$value,$expire = 0){
		$cookies = \Yii::$app->response->cookies;
		$cookies->add( new \yii\web\Cookie([
			'name' => $name,
			'value' => $value,
			'expire' => $expire
		]));
	}

    /**
     * 获得一条cookie的值
     * @param $name                 cookie名
     * @param string $default_val   默认值
     * @return mixed                cookie的值
     */
	protected  function getCookie($name,$default_val=''){
		$cookies = \Yii::$app->request->cookies;
		return $cookies->getValue($name, $default_val);
	}

    /**
     * 删除一条cookie
     * @param $name   cookie名
     */
	protected function removeCookie($name){
		$cookies = \Yii::$app->response->cookies;
		$cookies->remove($name);
	}

    /**
     * json方式返回数据
     * @param array $data
     * @param string $msg
     * @param int $code
     */
	protected function renderJSON($data=[], $msg ="ok", $code = 200)
	{
		header('Content-type: application/json');
		echo json_encode([
			"code" => $code,
			"msg"   =>  $msg,
			"data"  =>  $data,
			"req_id" =>  uniqid()
		]);

		return \Yii::$app->end();
	}

/*	//统一js提醒
	protected  function renderJS($msg,$url = "/")
	{
		return $this->renderPartial("@app/views/common/js", ['msg' => $msg, 'location' => $url]);
	}*/
}


