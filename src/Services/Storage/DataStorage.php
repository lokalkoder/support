<?php

namespace Lokalkoder\Support\Services\Storage;

use Illuminate\Database\Eloquent\Builder;

class DataStorage
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table;

    /**
     * Connection configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Requested connection manager.
     *
     * @var ConnectionManager
     */
    protected $manager;

    /**
     * DataStorage constructor.
     *
     * @param string $table
     * @param array $config
     */
    public function __construct(string $table, array $config)
    {
        $this->config = $config;

        $this->table = $table;

        $this->manager = (new ConnectionManager($this->config));
    }

    /**
     * Request connection class.
     *
     * @return \Illuminate\Database\MySqlConnection|
     *         \Illuminate\Database\PostgresConnection|
     *         \Illuminate\Database\SQLiteConnection|
     *         \Illuminate\Database\SqlServerConnection
     */
    public function connection()
    {
        return $this->manager->connection();
    }

    /**
     * Get requested query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function builder()
    {
        return $this->connection()->table($this->table);
    }
}
