<?php

namespace Lokalkoder\Support\Services;

use Illuminate\Database\Connectors\SQLiteConnector;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\SQLiteConnection;

class SqLite
{
    /**
     * SQLite connection.
     *
     * @var SQLiteConnection
     */
    private $connection;

    /**
     * Initiate SQLite class
     *
     * @param string $directory
     */
    public function __construct(string $directory)
    {
        $this->connection = new SQLiteConnection(
            (new SQLiteConnector())->connect($this->configs($directory))
        );
    }

    /**
     * Get SQLite Builder instance
     *
     * @param string $table
     *
     * @return Builder
     */
    public function model(string $table): Builder
    {
        return $this->connection->table($table);
    }
    
    /**
     * SQLite connection configs.
     *
     * @param string $directory
     *
     * @return array
     */
    protected function configs(string $directory): array
    {
        return [
            'driver' => 'sqlite',
            'database' => $directory,
            'foreign_key_constraints' => true,
        ];
    }
}
