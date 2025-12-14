<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PersonAndPhones extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('persons');
        $table->addColumn('name', 'string')
            ->addColumn('surname', 'string')
            ->addColumn('lastname', 'string')
            ->create();

        $table = $this->table('phones');
        $table->addColumn('number', 'string')
            ->addIndex('number', [
                'unique' => true,
                'name' => 'idx_number_unique'
            ])
            ->create();

        $table = $this->table('persons_phones');
        $table->addColumn('person_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('phone_id', 'integer', ['null' => false, 'signed' => false])
            ->addForeignKey('person_id', 'persons', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->addForeignKey('phone_id', 'phones', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->addIndex(['person_id', 'phone_id'], [
                'unique' => true,
                'name' => 'idx_person_phone_unique'
            ])
            ->create();
    }
}
