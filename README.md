<h1>Библиотека для аутентификации через социальные сети посредством протокола OAuth</h1>
<p>Библиотека реализует авторизацию через OAuth 1-й и 2-й версий</p>
<p><a href="http://oauth.phorm.ru" target="_blank">Демонстрация</a></p>
<h2>Поддерживаемые адаптеры</h2>
<ul>
	<li>Google</li>
	<li>Яндекс (Мой круг)</li>
	<li>Mail.ru (Мой мир)</li>
	<li>Одноклассники</li>
	<li>Twitter</li>
	<li>Facebook</li>
	<li>Vk.com (ВКонтакте)</li>
	<li>GitHub</li>
	<li>LinkedIn</li>
	<li>Instagram</li>
</ul>
<h2>Установка и настройка</h2>
<p>1. Скопируйте файлы дистрибутива в директорию вашего виртуального сервера. Структура папок дистрибутива соответствует проекту "по умолчанию" ZendFramework.</p>
<p>2. Установите файлы ZendFramework 1.12 в директорию /library/Zend</p>
<p>3. Внесите изменения в файл /application/configs/application.xml в секцию ouath.</p>
<p>Необходимо зарегистрировать свое приложение и получить ключи для авторизации на сайтах подсети и на основании полученных данных сконфигурировать адаптеры.
В качестве callback_uri/redirect_url по умолчанию используется адрес вида http(s)://адрес_сайта/callback/идентификатор_сети.</p>
<h3>Конфигурация адаптеров</h3>
<table>
	<tr>
		<th>Сеть</th>
		<th>Идентификатор</th>
		<th>Url регистрации приложения</th>
		<th>Подсекция key</th>
		<th>Подсекция secret</th>
		<th>Подсекция appkey</th>
	</tr>
	<tr>
		<td>Google+</td>
		<td>google</td>
		<td><a href="https://code.google.com/apis/console/" target="_blank">Click me<br>(API Access tab)</a></td>
		<td>Client ID</td>
		<td>Client secret</td>
		<td>&mdash;</td>
	</tr>
	<tr>
		<td>Яндекс</td>
		<td>yandex</td>
		<td><a href="https://oauth.yandex.ru/client/new" target="_blank">Click me</a></td>
		<td>Id приложения</td>
		<td>Пароль приложения</td>
		<td>&mdash;</td>
	</tr>
	<tr>
		<td>Mail.ru</td>
		<td>mailru</td>
		<td><a href="http://api.mail.ru/sites/my/add" target="_blank">Click me</a></td>
		<td>ID</td>
		<td>Секретный ключ</td>
		<td>&mdash;</td>
	</tr>
	<tr>
		<td>VK.com</td>
		<td>vk</td>
		<td><a href="http://vk.com/editapp?act=create" target="_blank">Click me</a></td>
		<td>ID приложения</td>
		<td>Защищенный ключ</td>
		<td>&mdash;</td>
	</tr>
	<tr>
		<td>Twitter</td>
		<td>twitter</td>
		<td><a href="https://dev.twitter.com/apps/new" target="_blank">Click me</a></td>
		<td>Consumer key</td>
		<td>Consumer secret</td>
		<td>&mdash;</td>
	</tr>
	<tr>
		<td>GitHub</td>
		<td>github</td>
		<td><a href="https://github.com/settings/applications/new" target="_blank">Click me</a></td>
		<td>Client ID</td>
		<td>Client secret</td>
		<td>&mdash;</td>
	</tr>
	<tr>
		<td>LinkedIn</td>
		<td>linkedin</td>
		<td><a href="https://www.linkedin.com/secure/developer?newapp=" target="_blank">Click me</a></td>
		<td>Ключ API</td>
		<td>Секретный ключ</td>
		<td>&mdash;</td>
	</tr>
	<tr>
		<td>Одноклассники</td>
		<td>odnoklassniki</td>
		<td><a href="http://dev.odnoklassniki.ru/wiki/pages/viewpage.action?pageId=13992188" target="_blank">Click me</a></td>
		<td>Application ID</td>
		<td>Секретный ключ приложения</td>
		<td>Публичный ключ приложения</td>
	</tr>
	<tr>
		<td>Facebook</td>
		<td>facebook</td>
		<td><a href="https://developers.facebook.com/apps" target="_blank">Click me</a></td>
		<td>App ID/API Key</td>
		<td>Секрет приложения</td>
		<td>&mdash;</td>
	</tr>
	<tr>
		<td>Instagram</td>
		<td>instagram</td>
		<td><a href="https://www.instagram.com/developer/clients/manage/" target="_blank">Click me</a></td>
		<td>CLIENT ID</td>
		<td>CLIENT SECRET</td>
		<td>&mdash;</td>
	</tr>
</table>
<h3>Логика работы приложения</h3>
<p>Основным контроллером работы приложения является IndexController, вы можете использовать любой другой контроллер или вообще любой PHP-скрипт. 
Важно регистрировать в соцсетях правильный callback_uri.</p>
<p>При запроса requestAction происходит формирование Url и передаресация на сервер социальной сети. 
Пользователь авторизуется на сайте соцсети и разрешает вашему приложению получить свои пользовательские данные.
Социальная сеть возвращает пользователя по callback_uri на ваш callbackAction, в котором уже по предоставленным ключам запрашивается информация о пользователе с сервера соцсети.
Полученные данные заносятся в сессию и происходит переадресация на indexAction.</p>
<h3>Получение данных о пользователе</h3>
<p>Данные об аутентифицированном пользователе доступны в контроллере в indexAction в виде массива в объекте пользовательской сессии $this->_session->userinfo
и представляют собой следующую структуру:</p>
<pre>
Array
(
    [provider] => название сервиса (google, yandex и пр.)
    [userid] => id пользователя в сервисе
    [username] => имя пользователя в сервисе
    [gender] => пол (male,female) (по умолчанию null)
    [email] => основной email пользователя (если неизвестно, то userid@домен_сервиса)
    [locale] => локаль пользователя (по умолчанию null)
    [firstname] => имя пользователя (по умолчанию null)
    [lastname] => фамилия пользователя (по умолчанию null)
    [link] => ссылка на профиль пользователя на сервере сервиса (по умолчанию null)
    [avatar] => адрес аватара на сервере сервиса (по умолчанию null)
)
</pre>
<h3>Работа с адаптерами напрямую</h3>
<p>Пример работы с конкретным адаптером напрямую из PHP-приложения без использования MVC-компонент ZendFramework приведен в файле public/facebook.php</p>
