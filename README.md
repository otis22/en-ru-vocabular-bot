# en-ru-vocabular-bot

Бот для изучения английских слов. Пишем боту слово, получаем варианты перевода и пример использования. Бот запоминает ваши слова и присылает вам их для повторения.

* [telegram](https://t.me/en_ru_vocabulary_bot)
* [vk](https://vk.com/enruvocabularybot)

Пэт-проект для подготовки к докладу [Botman — пишем чатбот на php](https://efko-cr.timepad.ru/event/1700504/)

[Конспект доклада](https://otis22.github.io/botman/%D1%87%D0%B0%D1%82%D0%B1%D0%BE%D1%82%D1%8B/2021/08/24/botman-write-chatbot-on-php.html)

# Contributing

```shell
#собираем докер
make build
# запуск сервера
make serve
# чтобы запустить тесты, запускать в соседнем табе
make all
```

Are you collaborator the heroku app?
```shell
heroku run -aen-ru-vocabulary-bot bash
heroku vim -aen-ru-vocabulary-bot
```