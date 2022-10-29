<?php

namespace Lokalkoder\Support\Services\Storage;

use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\Connectors\PostgresConnector;
use Illuminate\Database\Connectors\SQLiteConnector;
use Illuminate\Database\Connectors\SqlServerConnector;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\SqlServerConnection;
use Illuminate\Support\Arr;
use Lokalkoder\Support\Exceptions\InvalidArgument;

class ConnectionManager
{
    /**
     * Connnection configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Connection driver eg: mysql, pgsql, sqlite, sqlsrv
     *
     * @var string
     */
    protected $driver;

    /**
     * ConnectionManager constructor.
     *
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        $this->config = $configs;

        $this->driver = $this->getDriver();
    }

    /**
     * Get DB connection.
     *
     * @return MySqlConnection|PostgresConnection|SQLiteConnection|SqlServerConnection
     */
    public function connection()
    {
        return $this->getConnection();
    }

    /**
     * Get connection used for driver.
     *
     * @return MySqlConnection|PostgresConnection|SQLiteConnection|SqlServerConnection
     */
    protected function getConnection()
    {
        $connector = $this->getConnector()->connect($this->config);

        switch ($this->driver) {
            case 'mysql':
                return new MySqlConnection(
                    $connector,
                    Arr::get($this->config, 'database'),
                    Arr::get($this->config, 'prefix'),
                    $this->config
                );
            case 'pgsql':
                return new PostgresConnection(
                    $connector,
                    Arr::get($this->config, 'database'),
                    Arr::get($this->config, 'prefix'),
                    $this->config
                );
            case 'sqlite':
                return new SQLiteConnection(
                    $connector,
                    Arr::get($this->config, 'database'),
                    Arr::get($this->config, 'prefix'),
                    $this->config
                );
            case 'sqlsrv':
                return new SqlServerConnection(
                    $connector,
                    Arr::get($this->config, 'database'),
                    Arr::get($this->config, 'prefix'),
                    $this->config
                );
        }

        throw new InvalidArgument("Unsupported driver [{$this->driver}].");
    }

    /**
     * Get the driver connector.
     *
     * @return MySqlConnector|PostgresConnector|SQLiteConnector|SqlServerConnector
     */
    protected function getConnector()
    {
        return match ($this->driver) {
            'mysql' => new MySqlConnector(),
            'pgsql' => new PostgresConnector(),
            'sqlsrv' => new SqlServerConnector(),
            default => new SQLiteConnector(),
        };
    }

    /**
     * Get connection driver.
     *
     * @return string
     */
    protected function getDriver(): string
    {
        if (! isset($this->config['driver'])) {
            throw new InvalidArgument('A driver must be specified.');
        }

        return $this->config['driver'];
    }
}
