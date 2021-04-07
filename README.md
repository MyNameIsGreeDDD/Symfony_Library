# TestTask
Необходимо написать CRUD сервис для управления библиотекой книг.
<br>
Модель данных книги:
<br>
Название
<br>
Автор (отдельный crud для авторов), может быть несколько авторов 
<br>
Описание
<br>
Обложка (изображение)
<br>
Год публикации
<br>

Основная функциональность:
<br>
Добавление, редактирование, просмотр списка авторов
<br>
Добавление, редактирование книг.
<br>
Список книг. В списке необходимо реализовать inline редактирование всех свойств модели “Книга”
<br>
В список добавить фильтрацию по всем свойствам книг
<br>

Дополнительная функциональность:
<br>
Реализовать тот же CRUD с использованием SonataAdminBundle
<br>
Реализовать аутентификацию и авторизацию в админ панель с использованием FOSUserBundle + SonataUserBundle
<br>
Написать нативный SQL запрос: Получить список книг, которые написаны более 2-мя со-авторами. То есть получить отчет «книга — количество соавторов» и отфильтроватьте, у которых со-авторов меньше 2х.

Тот же самой запрос написать с использование Doctrine ORM.

Сделать генерацию фейковых данных для книг и авторов, чтобы протестить запросы и фильтрацию.

Требования:
<br>
PHP 7.4
<br>
Написать с использованием фреймворка symfony 4.4
<br>
Не использовать любые дополнительные пакеты/бандлы для symfony.
