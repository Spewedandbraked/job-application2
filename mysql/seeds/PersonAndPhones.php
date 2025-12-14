<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PersonAndPhones extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        // Отключаем проверку внешних ключей для очистки таблиц
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');

        // Очищаем таблицы в правильном порядке (сначала дочерние, потом родительские)
        $this->table('persons_phones')->truncate();
        $this->table('persons')->truncate();
        $this->table('phones')->truncate();

        // Включаем проверку внешних ключей обратно
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');

        // Данные для таблицы persons (ФИО)
        $personsData = [
            [
                'name' => 'Иван',
                'surname' => 'Иванов',
                'lastname' => 'Иванович'
            ],
            [
                'name' => 'Петр',
                'surname' => 'Петров',
                'lastname' => 'Петрович'
            ],
            [
                'name' => 'Мария',
                'surname' => 'Сидорова',
                'lastname' => 'Ивановна'
            ],
            [
                'name' => 'Анна',
                'surname' => 'Кузнецова',
                'lastname' => 'Сергеевна'
            ],
            [
                'name' => 'Сергей',
                'surname' => 'Смирнов',
                'lastname' => 'Александрович'
            ]
        ];

        // Вставляем данные в таблицу persons
        $personsTable = $this->table('persons');
        $personsTable->insert($personsData)->saveData();

        // Данные для таблицы phones (номера телефонов)
        $phonesData = [
            ['number' => '+7 (495) 123-45-67'],
            ['number' => '+7 (495) 234-56-78'],
            ['number' => '+7 (495) 345-67-89'],
            ['number' => '+7 (495) 456-78-90'],
            ['number' => '+7 (495) 567-89-01'],
            ['number' => '+7 (495) 678-90-12'],
            ['number' => '+7 (916) 123-45-67'],
            ['number' => '+7 (916) 234-56-78'],
            ['number' => '+7 (903) 123-45-67'],
            ['number' => '+7 (903) 234-56-78']
        ];

        // Вставляем данные в таблицу phones
        $phonesTable = $this->table('phones');
        $phonesTable->insert($phonesData)->saveData();

        // Получаем ID всех добавленных записей
        $personIds = $this->fetchAll('SELECT id FROM persons ORDER BY id');
        $phoneIds = $this->fetchAll('SELECT id FROM phones ORDER BY id');

        // Создаем связи многие-ко-многим между persons и phones
        $personsPhonesData = [
            // У Иванова несколько номеров
            ['person_id' => $personIds[0]['id'], 'phone_id' => $phoneIds[0]['id']], // домашний
            ['person_id' => $personIds[0]['id'], 'phone_id' => $phoneIds[6]['id']], // мобильный

            // У Петрова несколько номеров
            ['person_id' => $personIds[1]['id'], 'phone_id' => $phoneIds[1]['id']], // домашний
            ['person_id' => $personIds[1]['id'], 'phone_id' => $phoneIds[7]['id']], // мобильный
            ['person_id' => $personIds[1]['id'], 'phone_id' => $phoneIds[8]['id']], // рабочий

            // У Сидоровой один номер
            ['person_id' => $personIds[2]['id'], 'phone_id' => $phoneIds[2]['id']],

            // У Кузнецовой несколько номеров
            ['person_id' => $personIds[3]['id'], 'phone_id' => $phoneIds[3]['id']], // домашний
            ['person_id' => $personIds[3]['id'], 'phone_id' => $phoneIds[9]['id']], // мобильный

            // У Смирнова один номер
            ['person_id' => $personIds[4]['id'], 'phone_id' => $phoneIds[4]['id']],

            // Общий домашний телефон у нескольких людей
            ['person_id' => $personIds[0]['id'], 'phone_id' => $phoneIds[5]['id']], // Иванов
            ['person_id' => $personIds[1]['id'], 'phone_id' => $phoneIds[5]['id']], // Петров
            ['person_id' => $personIds[2]['id'], 'phone_id' => $phoneIds[5]['id']]  // Сидорова
        ];

        // Вставляем данные в таблицу связей
        $personsPhonesTable = $this->table('persons_phones');
        $personsPhonesTable->insert($personsPhonesData)->saveData();

        // Выводим информационное сообщение
        echo "Данные успешно заполнены:\n";
        echo "- Добавлено " . count($personsData) . " записей в таблицу persons\n";
        echo "- Добавлено " . count($phonesData) . " записей в таблицу phones\n";
        echo "- Добавлено " . count($personsPhonesData) . " связей в таблицу persons_phones\n";
    }
}
