<?php
// открываем сессию
session_start();
 // присваиваем PHP переменной captchastring строку символов
$captchastring = '123456789';
// получаем первые 6 символов после их перемешивания с помощью функции str_shuffle
$captchastring = substr(str_shuffle($captchastring), 0, 6);
// инициализация переменной сессии с помощью сгенерированной подстроки captchastring,
// содержащей 6 символов
$_SESSION["code"] = $captchastring;
// генерируем CAPTCHA
// создаем новое изображение из файла background.png 
$image = imagecreatefrompng(dirname(__FILE__).'/background.png');
// устанавливаем цвет (R-200, G-240, B-240) изображению, хранящемуся в $image
$colour = imagecolorallocate($image, 255, 255, 255);
// присваиваем переменной font название шрифта
$font = dirname(__FILE__).'/Roboto-Light.ttf';
// устанавливаем случайное число между -10 и 10 градусов для поворота текста 
$rotate = rand(0, 0);
// рисуем текст на изображении шрифтом TrueType (1 параметр - изображение ($image), 
// 2 - размер шрифта (18), 3 - угол поворота текста ($rotate), 
// 4, 5 - начальные координаты x и y для текста (18,30), 6 - индекс цвета ($colour),
// 7 - путь к файлу шрифта ($font), 8 - текст ($captchastring) 
imagettftext($image, 16, $rotate, 28, 32, $colour, $font, $captchastring);
// передавать изображение будем в формате png
header('Content-type: image/png');
// выводим изображение
imagepng($image);
?>