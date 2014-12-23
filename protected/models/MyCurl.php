<?php

/**
 * This is the model class for table "sex".
 *
 * The followings are the available columns in table 'sex':
 * @property integer $id
 * @property string $name
 */
class MyCurl {
	private $curl;
	public function __construct(){
		$this->curl=curl_init();

//Настойка опций cookie
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, 'cook.txt');//сохранить куки в файл
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, 'cook.txt');//считать куки из файла
//устанавливаем наш вариат клиента (браузера) и вид ОС
		curl_setopt($this->curl, CURLOPT_USERAGENT, "Opera/10.00 (Windows NT 5.1; U; ru) Presto/2.2.0");
//Установите эту опцию в ненулевое значение, если вы хотите, чтобы PHP завершал работу скрыто, если возвращаемый HTTP-код имеет значение выше 300. По умолчанию страница возвращается нормально с игнорированием кода.
		curl_setopt($this->curl, CURLOPT_FAILONERROR, 1);
//Максимальное время в секундах, которое вы отводите для работы CURL-функций.
		curl_setopt($this->curl, CURLOPT_TIMEOUT, 3);
		curl_setopt($this->curl, CURLOPT_POST, 1); // устанавливаем метод POST
//ответственный момент здесь мы передаем наши переменные
//Установите эту опцию в ненулевое значение, если вы хотите, чтобы шапка/header ответа включалась в вывод.
		curl_setopt($this->curl, CURLOPT_HEADER, 1);
//Внимание, важный момент, сертификатов, естественно, у нас нет, так что все отключаем
		curl_setopt ($this->curl, CURLOPT_SSL_VERIFYPEER, 0);// не проверять SSL сертификат
		curl_setopt ($this->curl, CURLOPT_SSL_VERIFYHOST, 0);// не проверять Host SSL сертификата
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);// разрешаем редиректы
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
	}


	public function goUrl($url,$post=''){
		curl_setopt($this->curl, CURLOPT_URL, $url);
		//Устанавливаем значение referer - адрес последней активной страницы
		curl_setopt($this->curl, CURLOPT_REFERER, $url);
		
		if(!empty($post))
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, $url.'?&'.implode('&',$post));
		return $this->getCurl();
	}

	private function getCurl(){
		$html = curl_exec($this->curl); // выполняем запрос и записываем в переменную
		return $html;
	}
}